<?php

class SumberBarang_model {
    private $dbh;
    private $stmt;
    private $table = 'sumber_barang';

    public function __construct() {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        try {
            $this->dbh = new PDO($dsn, DB_USER, DB_PASS);
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getAllSumberBarang() {
        $this->stmt = $this->dbh->prepare('SELECT * FROM ' . $this->table);
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSumberBarangById($id) {
        $this->stmt = $this->dbh->prepare('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->stmt->bindValue(':id', $id);
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function tambahDataSumberBarang($data) {
        $query = "INSERT INTO " . $this->table . " (nama_sumber) VALUES (:nama_sumber)";
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->bindValue(':nama_sumber', $data['nama_sumber']);
        $this->stmt->execute();
        return $this->stmt->rowCount();
    }

    public function updateDataSumberBarang($data) {
        $query = "UPDATE " . $this->table . " SET nama_sumber = :nama_sumber WHERE id = :id";
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->bindValue(':nama_sumber', $data['nama_sumber']);
        $this->stmt->bindValue(':id', $data['id']);
        $this->stmt->execute();
        return $this->stmt->rowCount();
    }

    public function hapusDataSumberBarang($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->bindValue(':id', $id);
        $this->stmt->execute();
        return $this->stmt->rowCount();
    }
}