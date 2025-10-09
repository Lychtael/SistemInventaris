<?php

class Barang_model {
    private $dbh;
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
        // Menggunakan nama kolom baru: id_jenis, id_sumber
        $query = "SELECT b.*, j.nama_jenis, s.nama_sumber
                  FROM barang b
                  LEFT JOIN jenis_barang j ON b.id_jenis = j.id
                  LEFT JOIN sumber_barang s ON b.id_sumber = s.id";
    
        $where = [];
        if (!empty($params['jenis_id'])) {
            $where[] = "b.id_jenis = :jenis_id";
        }
        if (!empty($params['sumber_id'])) {
            $where[] = "b.id_sumber = :sumber_id";
        }
        if (!empty($where)) {
            $query .= " WHERE " . implode(" AND ", $where);
        }
        
        // Menggunakan nama kolom baru untuk sorting: jumlah
        $orderBy = 'b.id DESC';
        if (!empty($params['sort']) && in_array($params['sort'], ['nama_barang', 'jumlah'])) {
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
        // Menggunakan nama kolom baru: id_jenis, id_sumber
        $query = "SELECT COUNT(*) as total
                  FROM barang b
                  LEFT JOIN jenis_barang j ON b.id_jenis = j.id
                  LEFT JOIN sumber_barang s ON b.id_sumber = s.id";
    
        $where = [];
        if (!empty($params['jenis_id'])) {
            $where[] = "b.id_jenis = :jenis_id";
        }
        if (!empty($params['sumber_id'])) {
            $where[] = "b.id_sumber = :sumber_id";
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
        $query = "INSERT INTO barang (nama_barang, jumlah, satuan, id_jenis, id_sumber, keterangan) 
                VALUES (:nama_barang, :jumlah, :satuan, :id_jenis, :id_sumber, :keterangan)";

        $this->stmt = $this->dbh->prepare($query);

        $this->stmt->bindValue(':nama_barang', $data['nama_barang']);
        $this->stmt->bindValue(':jumlah', $data['qty']); 
        $this->stmt->bindValue(':satuan', $data['satuan']);
        $this->stmt->bindValue(':id_jenis', $data['jenis_id']); 
        $this->stmt->bindValue(':id_sumber', $data['sumber_id']); 
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
                    jumlah = :jumlah,
                    satuan = :satuan,
                    id_jenis = :id_jenis,
                    id_sumber = :id_sumber,
                    keterangan = :keterangan
                WHERE id = :id";

        $this->stmt = $this->dbh->prepare($query);

        $this->stmt->bindValue(':nama_barang', $data['nama_barang']);
        $this->stmt->bindValue(':jumlah', $data['qty']); 
        $this->stmt->bindValue(':satuan', $data['satuan']);
        $this->stmt->bindValue(':id_jenis', $data['jenis_id']); 
        $this->stmt->bindValue(':id_sumber', $data['sumber_id']); 
        $this->stmt->bindValue(':keterangan', $data['keterangan']);
        $this->stmt->bindValue(':id', $data['id']);

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
        $this->stmt = $this->dbh->prepare('SELECT count(*) as total FROM barang');
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getBarangCountByJenis()
    {
        $query = "SELECT j.nama_jenis, COUNT(b.id) as jumlah 
                FROM barang b 
                JOIN jenis_barang j ON b.id_jenis = j.id 
                GROUP BY j.nama_jenis";
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBarangCountBySumber()
    {
        $query = "SELECT s.nama_sumber, COUNT(b.id) as jumlah 
                FROM barang b 
                JOIN sumber_barang s ON b.id_sumber = s.id 
                GROUP BY s.nama_sumber";
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetailBarangById($id)
    {
        $query = "SELECT b.*, j.nama_jenis, s.nama_sumber 
                FROM barang b
                LEFT JOIN jenis_barang j ON b.id_jenis = j.id
                LEFT JOIN sumber_barang s ON b.id_sumber = s.id
                WHERE b.id=:id";
                
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->bindValue(':id', $id);
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllBarangWithDetails()
    {
        $query = "SELECT b.nama_barang, b.jumlah, b.satuan, j.nama_jenis, s.nama_sumber, b.keterangan 
                FROM barang b
                LEFT JOIN jenis_barang j ON b.id_jenis = j.id
                LEFT JOIN sumber_barang s ON b.id_sumber = s.id
                ORDER BY b.id DESC";
                
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function importFromCsv($data) {
        $normalized = [];
        foreach ($data as $key => $value) {
            $key = strtolower(trim($key));
            $key = str_replace(' ', '_', $key);
            $normalized[$key] = $value;
        }
    
        $get_or_create_id = function($table, $column, $value) {
            if (empty($value)) return null;
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
    
        $jenis_id  = $get_or_create_id('jenis_barang', 'nama_jenis', $normalized['jenis'] ?? null);
        $sumber_id = $get_or_create_id('sumber_barang', 'nama_sumber', $normalized['sumber'] ?? null);
    
        $query = "INSERT INTO barang (nama_barang, jumlah, satuan, id_jenis, id_sumber, keterangan) 
                  VALUES (:nama, :jumlah, :satuan, :id_jenis, :id_sumber, :ket)";
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->execute([
            'nama'     => $normalized['nama_barang'] ?? null,
            'jumlah'   => $normalized['qty'] ?? 0,
            'satuan'   => $normalized['satuan'] ?? null,
            'id_jenis' => $jenis_id,
            'id_sumber'=> $sumber_id,
            'ket'      => $normalized['keterangan'] ?? null
        ]);
    
        return $this->stmt->rowCount();
    }
    
    public function cariDataBarang()
    {
        $keyword = $_POST['keyword'];
        $query = "SELECT b.*, j.nama_jenis, s.nama_sumber
                FROM barang b
                LEFT JOIN jenis_barang j ON b.id_jenis = j.id
                LEFT JOIN sumber_barang s ON b.id_sumber = s.id
                WHERE b.nama_barang LIKE :keyword
                ORDER BY b.id DESC";
                
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->bindValue(':keyword', "%$keyword%");
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getZeroStockCount()
    {
        $this->stmt = $this->dbh->prepare('SELECT COUNT(*) as total FROM barang WHERE jumlah = 0');
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
}