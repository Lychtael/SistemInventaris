<?php

class JenisBarang_model {
    private $dbh; // database handler
    private $stmt;
    private $table = 'jenis_barang';

    public function __construct() {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        try {
            $this->dbh = new PDO($dsn, DB_USER, DB_PASS);
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getAllJenisBarang() {
        $this->stmt = $this->dbh->prepare('SELECT * FROM ' . $this->table);
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getJenisBarangById($id) {
        $this->stmt = $this->dbh->prepare('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->stmt->bindValue(':id', $id);
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function tambahDataJenisBarang($data) {
        $query = "INSERT INTO " . $this->table . " (nama_jenis) VALUES (:nama_jenis)";
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->bindValue(':nama_jenis', $data['nama_jenis']);
        $this->stmt->execute();
        return $this->stmt->rowCount();
    }

    public function updateDataJenisBarang($data) {
        $query = "UPDATE " . $this->table . " SET nama_jenis = :nama_jenis WHERE id = :id";
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->bindValue(':nama_jenis', $data['nama_jenis']);
        $this->stmt->bindValue(':id', $data['id']);
        $this->stmt->execute();
        return $this->stmt->rowCount();
    }

    public function hapusDataJenisBarang($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->bindValue(':id', $id);
        $this->stmt->execute();
        return $this->stmt->rowCount();
    }
}