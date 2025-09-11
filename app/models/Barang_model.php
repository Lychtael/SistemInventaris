<?php

class Barang_model {
    private $dbh; // database handler
    private $stmt;

    public function __construct() {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        try {
            $this->dbh = new PDO($dsn, DB_USER, DB_PASS);
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getAllBarang($params = [])
    {
        $query = "SELECT b.*, j.nama_jenis, s.nama_sumber
                  FROM barang b
                  LEFT JOIN jenis_barang j ON b.jenis_id = j.id
                  LEFT JOIN sumber_barang s ON b.sumber_id = s.id";
    
        $where = [];
        if (!empty($params['jenis_id'])) {
            $where[] = "b.jenis_id = :jenis_id";
        }
        if (!empty($params['sumber_id'])) {
            $where[] = "b.sumber_id = :sumber_id";
        }
        if (!empty($where)) {
            $query .= " WHERE " . implode(" AND ", $where);
        }
        
        $orderBy = 'b.id DESC';
        if (!empty($params['sort']) && in_array($params['sort'], ['nama_barang', 'qty'])) {
            $direction = (!empty($params['direction']) && in_array(strtoupper($params['direction']), ['ASC', 'DESC'])) ? $params['direction'] : 'ASC';
            $orderBy = "b." . $params['sort'] . " " . $direction;
        }
        $query .= " ORDER BY " . $orderBy;
    
        $limit = $params['limit'] ?? 25;
        $offset = $params['offset'] ?? 0;
        $query .= " LIMIT :limit OFFSET :offset";
    
        $this->stmt = $this->dbh->prepare($query);
    
        if (!empty($params['jenis_id'])) {
            $this->stmt->bindValue(':jenis_id', $params['jenis_id']);
        }
        if (!empty($params['sumber_id'])) {
            $this->stmt->bindValue(':sumber_id', $params['sumber_id']);
        }
        $this->stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $this->stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function countAllBarang($params = [])
    {
        $query = "SELECT COUNT(*) as total
                  FROM barang b
                  LEFT JOIN jenis_barang j ON b.jenis_id = j.id
                  LEFT JOIN sumber_barang s ON b.sumber_id = s.id";
    
        $where = [];
        if (!empty($params['jenis_id'])) {
            $where[] = "b.jenis_id = :jenis_id";
        }
        if (!empty($params['sumber_id'])) {
            $where[] = "b.sumber_id = :sumber_id";
        }
        if (!empty($where)) {
            $query .= " WHERE " . implode(" AND ", $where);
        }
    
        $this->stmt = $this->dbh->prepare($query);
    
        if (!empty($params['jenis_id'])) {
            $this->stmt->bindValue(':jenis_id', $params['jenis_id']);
        }
        if (!empty($params['sumber_id'])) {
            $this->stmt->bindValue(':sumber_id', $params['sumber_id']);
        }
        
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    public function getAllJenis() {
        $this->stmt = $this->dbh->prepare('SELECT * FROM jenis_barang');
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllSumber() {
        $this->stmt = $this->dbh->prepare('SELECT * FROM sumber_barang');
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function tambahDataBarang($data)
    {
        $query = "INSERT INTO barang (nama_barang, qty, satuan, jenis_id, sumber_id, keterangan) 
                VALUES (:nama_barang, :qty, :satuan, :jenis_id, :sumber_id, :keterangan)";

        $this->stmt = $this->dbh->prepare($query);

        $this->stmt->bindValue(':nama_barang', $data['nama_barang']);
        $this->stmt->bindValue(':qty', $data['qty']);
        $this->stmt->bindValue(':satuan', $data['satuan']);
        $this->stmt->bindValue(':jenis_id', $data['jenis_id']);
        $this->stmt->bindValue(':sumber_id', $data['sumber_id']);
        $this->stmt->bindValue(':keterangan', $data['keterangan']);

        $this->stmt->execute();

        return $this->stmt->rowCount();
    }
    public function getBarangById($id)
    {
        $this->stmt = $this->dbh->prepare('SELECT * FROM barang WHERE id=:id');
        $this->stmt->bindValue(':id', $id);
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updateDataBarang($data)
    {
        $query = "UPDATE barang SET 
                    nama_barang = :nama_barang,
                    qty = :qty,
                    satuan = :satuan,
                    jenis_id = :jenis_id,
                    sumber_id = :sumber_id,
                    keterangan = :keterangan
                WHERE id = :id";

        $this->stmt = $this->dbh->prepare($query);

        $this->stmt->bindValue(':nama_barang', $data['nama_barang']);
        $this->stmt->bindValue(':qty', $data['qty']);
        $this->stmt->bindValue(':satuan', $data['satuan']);
        $this->stmt->bindValue(':jenis_id', $data['jenis_id']);
        $this->stmt->bindValue(':sumber_id', $data['sumber_id']);
        $this->stmt->bindValue(':keterangan', $data['keterangan']);
        $this->stmt->bindValue(':id', $data['id']); // ID untuk klausa WHERE

        $this->stmt->execute();

        return $this->stmt->rowCount();
    }
    public function hapusDataBarang($id)
    {
        $query = "DELETE FROM barang WHERE id = :id";
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->bindValue(':id', $id);
        $this->stmt->execute();

        return $this->stmt->rowCount();
    }
    public function getTotalBarang()
    {
        // Menghitung total semua record barang
        $this->stmt = $this->dbh->prepare('SELECT count(*) as total FROM barang');
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getBarangCountByJenis()
    {
        // Menghitung jumlah barang untuk setiap jenis
        $query = "SELECT j.nama_jenis, COUNT(b.id) as jumlah 
                FROM barang b 
                JOIN jenis_barang j ON b.jenis_id = j.id 
                GROUP BY j.nama_jenis";
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBarangCountBySumber()
    {
        // Menghitung jumlah barang untuk setiap sumber
        $query = "SELECT s.nama_sumber, COUNT(b.id) as jumlah 
                FROM barang b 
                JOIN sumber_barang s ON b.sumber_id = s.id 
                GROUP BY s.nama_sumber";
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getDetailBarangById($id)
    {
        $query = "SELECT b.*, j.nama_jenis, s.nama_sumber 
                FROM barang b
                LEFT JOIN jenis_barang j ON b.jenis_id = j.id
                LEFT JOIN sumber_barang s ON b.sumber_id = s.id
                WHERE b.id=:id";
                
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->bindValue(':id', $id);
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getAllBarangWithDetails()
    {
        $query = "SELECT b.nama_barang, b.qty, b.satuan, j.nama_jenis, s.nama_sumber, b.keterangan 
                FROM barang b
                LEFT JOIN jenis_barang j ON b.jenis_id = j.id
                LEFT JOIN sumber_barang s ON b.sumber_id = s.id
                ORDER BY b.id DESC";
                
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function importFromCsv($data) {
        // Helper untuk mencari ID atau membuat baru
        $get_or_create_id = function($table, $column, $value) {
            $this->stmt = $this->dbh->prepare("SELECT id FROM $table WHERE $column = :value");
            $this->stmt->execute(['value' => $value]);
            $result = $this->stmt->fetch();
            if ($result) {
                return $result['id'];
            } else {
                $this->stmt = $this->dbh->prepare("INSERT INTO $table ($column) VALUES (:value)");
                $this->stmt->execute(['value' => $value]);
                return $this->dbh->lastInsertId();
            }
        };
    
        $jenis_id = $get_or_create_id('jenis_barang', 'nama_jenis', $data[3]); // Kolom ke-4
        $sumber_id = $get_or_create_id('sumber_barang', 'nama_sumber', $data[4]); // Kolom ke-5
    
        // Insert data barang
        $query = "INSERT INTO barang (nama_barang, qty, satuan, jenis_id, sumber_id, keterangan) 
                  VALUES (:nama, :qty, :satuan, :jenis_id, :sumber_id, :ket)";
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->execute([
            'nama' => $data[0], // Kolom ke-1
            'qty' => $data[1], // Kolom ke-2
            'satuan' => $data[2], // Kolom ke-3
            'jenis_id' => $jenis_id,
            'sumber_id' => $sumber_id,
            'ket' => $data[5] // Kolom ke-6
        ]);
        return $this->stmt->rowCount();
    }
    public function cariDataBarang()
    {
        $keyword = $_POST['keyword'];
        $query = "SELECT b.*, j.nama_jenis, s.nama_sumber
                FROM barang b
                LEFT JOIN jenis_barang j ON b.jenis_id = j.id
                LEFT JOIN sumber_barang s ON b.sumber_id = s.id
                WHERE b.nama_barang LIKE :keyword
                ORDER BY b.id DESC";
                
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->bindValue(':keyword', "%$keyword%");
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getZeroStockCount()
    {
        $this->stmt = $this->dbh->prepare('SELECT COUNT(*) as total FROM barang WHERE qty = 0');
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
}