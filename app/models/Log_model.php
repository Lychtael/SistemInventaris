<?php

class Log_model {
    private $dbh;
    private $stmt;
    private $table = 'log_aktivitas';

    public function __construct() {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        try {
            $this->dbh = new PDO($dsn, DB_USER, DB_PASS);
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    public function catatLog($aksi, $tabel, $keterangan) {
        $query = "INSERT INTO " . $this->table . " (user_id, aksi, tabel, keterangan) 
                  VALUES (:user_id, :aksi, :tabel, :keterangan)";
        
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->execute([
            'user_id' => $_SESSION['user_id'], // Ambil dari session
            'aksi' => $aksi,
            'tabel' => $tabel,
            'keterangan' => $keterangan
        ]);
    }

    public function getAllLog() {
        $query = "SELECT l.*, u.username 
                  FROM log_aktivitas l 
                  JOIN users u ON l.user_id = u.id 
                  ORDER BY l.created_at DESC";
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}