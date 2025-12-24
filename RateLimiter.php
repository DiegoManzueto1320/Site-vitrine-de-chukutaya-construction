<?php

class RateLimiter {
    private $conn;
    private $config;
    
    // Limites par défaut
    const LIMITS = [
        'contact' => [
            'max_attempts' => 3,        // 3 tentatives max
            'time_window' => 3600,      // par heure (3600 secondes)
            'block_duration' => 7200    // blocage 2h si dépassé
        ],
        'devis' => [
            'max_attempts' => 2,        // 2 tentatives max
            'time_window' => 3600,      // par heure
            'block_duration' => 7200    // blocage 2h si dépassé
        ]
    ];
    
    public function __construct($database_connection, $config) {
        $this->conn = $database_connection;
        $this->config = $config;
    }
    
    /**
     * Vérifie si l'IP peut soumettre le formulaire
     */
    public function canSubmit($form_type) {
        $ip = $this->getClientIP();
        
        // 1. Vérifier si l'IP est blacklistée
        if ($this->isBlacklisted($ip)) {
            return [
                'allowed' => false,
                'reason' => 'IP blacklistée',
                'retry_after' => null
            ];
        }
        
        // 2. Compter les tentatives récentes
        $attempts = $this->getRecentAttempts($ip, $form_type);
        $limit = self::LIMITS[$form_type];
        
        if ($attempts >= $limit['max_attempts']) {
            // Calculer quand l'utilisateur peut réessayer
            $last_attempt = $this->getLastAttemptTime($ip, $form_type);
            $retry_after = $last_attempt + $limit['time_window'];
            
            return [
                'allowed' => false,
                'reason' => 'Trop de tentatives',
                'retry_after' => $retry_after,
                'attempts' => $attempts,
                'max_attempts' => $limit['max_attempts']
            ];
        }
        
        return [
            'allowed' => true,
            'attempts' => $attempts,
            'max_attempts' => $limit['max_attempts']
        ];
    }
    
    /**
     * Enregistre une tentative de soumission
     */
    public function recordAttempt($form_type, $success = false) {
        $ip = $this->getClientIP();
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $success_int = $success ? 1 : 0;
        
        $stmt = $this->conn->prepare("
            INSERT INTO form_submissions (ip_address, form_type, success, user_agent)
            VALUES (?, ?, ?, ?)
        ");
        
        $stmt->bind_param('ssis', $ip, $form_type, $success_int, $user_agent);
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }
    
    /**
     * Ajoute une IP à la blacklist
     */
    public function blacklistIP($ip, $reason, $duration_hours = 24) {
        $expires_at = date('Y-m-d H:i:s', time() + ($duration_hours * 3600));
        
        $stmt = $this->conn->prepare("
            INSERT INTO ip_blacklist (ip_address, reason, expires_at)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE
            reason = VALUES(reason),
            expires_at = VALUES(expires_at),
            active = 1
        ");
        
        $stmt->bind_param('sss', $ip, $reason, $expires_at);
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }
    
    /**
     * Compte les tentatives récentes pour une IP
     */
    private function getRecentAttempts($ip, $form_type) {
        $time_limit = time() - self::LIMITS[$form_type]['time_window'];
        
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) 
            FROM form_submissions 
            WHERE ip_address = ? 
            AND form_type = ? 
            AND submission_time >= FROM_UNIXTIME(?)
        ");
        
        $stmt->bind_param('ssi', $ip, $form_type, $time_limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_row();
        $stmt->close();
        
        return $row[0];
    }
    
    /**
     * Obtient le timestamp de la dernière tentative
     */
    private function getLastAttemptTime($ip, $form_type) {
        $stmt = $this->conn->prepare("
            SELECT UNIX_TIMESTAMP(submission_time)
            FROM form_submissions 
            WHERE ip_address = ? AND form_type = ?
            ORDER BY submission_time DESC 
            LIMIT 1
        ");
        
        $stmt->bind_param('ss', $ip, $form_type);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_row();
        $stmt->close();
        
        return $row ? $row[0] : 0;
    }
    
    /**
     * Vérifie si l'IP est blacklistée
     */
    private function isBlacklisted($ip) {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) 
            FROM ip_blacklist 
            WHERE ip_address = ? 
            AND active = 1 
            AND (expires_at IS NULL OR expires_at > NOW())
        ");
        
        $stmt->bind_param('s', $ip);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_row();
        $stmt->close();
        
        return $row[0] > 0;
    }
    
    /**
     * Obtient l'IP réelle du client (même derrière proxy/CDN)
     */
    private function getClientIP() {
        $ip_keys = ['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'REMOTE_ADDR'];
        
        foreach ($ip_keys as $key) {
            if (!empty($_SERVER[$key])) {
                $ip = trim(explode(',', $_SERVER[$key])[0]);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }
        
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
    
    /**
     * Nettoie les anciennes entrées (à appeler périodiquement)
     */
    public function cleanup() {
        // Supprimer les tentatives anciennes (plus de 24h)
        $this->conn->query("
            DELETE FROM form_submissions 
            WHERE submission_time < DATE_SUB(NOW(), INTERVAL 24 HOUR)
        ");
        
        // Désactiver les blacklist expirées
        $this->conn->query("
            UPDATE ip_blacklist 
            SET active = 0 
            WHERE expires_at IS NOT NULL AND expires_at < NOW()
        ");
    }
}