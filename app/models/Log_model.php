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
        $query = "INSERT INTO " . $this->table . " (id_pengguna, aksi, tabel, keterangan) 
                  VALUES (:id_pengguna, :aksi, :tabel, :keterangan)";
        
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->bindValue(':id_pengguna', $_SESSION['user_id']);
        $this->stmt->bindValue(':aksi', $aksi);
        $this->stmt->bindValue(':tabel', $tabel);
        $this->stmt->bindValue(':keterangan', $keterangan);

        $this->stmt->execute();

        return $this->stmt->rowCount();
    }

    public function getAllLog() {
        $query = "SELECT l.*, p.nama_pengguna 
                  FROM log_aktivitas l 
                  JOIN pengguna p ON l.id_pengguna = p.id 
                  ORDER BY l.dibuat_pada DESC";
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}