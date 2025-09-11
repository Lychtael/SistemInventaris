<?php

class Peminjaman_model {
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

    public function getAllPeminjaman() {
        // Mengambil semua data peminjaman beserta nama barangnya
        $query = "SELECT p.*, b.nama_barang 
                  FROM peminjaman p 
                  JOIN barang b ON p.barang_id = b.id 
                  ORDER BY p.tanggal_pinjam DESC, p.status ASC";
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambahDataPeminjaman($data) {
        // 1. Masukkan data ke tabel peminjaman
        $query = "INSERT INTO peminjaman (barang_id, peminjam, qty_dipinjam, tanggal_pinjam, keterangan) 
                  VALUES (:barang_id, :peminjam, :qty_dipinjam, :tanggal_pinjam, :keterangan)";
        
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->bindValue(':barang_id', $data['barang_id']);
        $this->stmt->bindValue(':peminjam', $data['peminjam']);
        $this->stmt->bindValue(':qty_dipinjam', $data['qty_dipinjam']);
        $this->stmt->bindValue(':tanggal_pinjam', $data['tanggal_pinjam']);
        $this->stmt->bindValue(':keterangan', $data['keterangan']);
        $this->stmt->execute();

        // 2. Kurangi stok barang di tabel barang
        $this->updateStokBarang($data['barang_id'], $data['qty_dipinjam'], 'kurang');

        return $this->stmt->rowCount();
    }

    // Method helper untuk update stok
    public function updateStokBarang($barang_id, $qty, $aksi = 'kurang') {
        $operator = ($aksi == 'kurang') ? '-' : '+';
        $query = "UPDATE barang SET qty = qty $operator :qty WHERE id = :barang_id";
        
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->bindValue(':qty', $qty);
        $this->stmt->bindValue(':barang_id', $barang_id);
        $this->stmt->execute();
    }
    public function getPeminjamanById($id) {
        $this->stmt = $this->dbh->prepare('SELECT * FROM peminjaman WHERE id=:id');
        $this->stmt->bindValue(':id', $id);
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function kembalikanBarang($id) {
        // 1. Ambil data peminjaman untuk tahu barang apa & berapa qty yang dikembalikan
        $peminjaman = $this->getPeminjamanById($id);
        $barang_id = $peminjaman['barang_id'];
        $qty_dipinjam = $peminjaman['qty_dipinjam'];
    
        // 2. Update status & tanggal kembali di tabel peminjaman
        $query = "UPDATE peminjaman SET status = 'dikembalikan', tanggal_kembali = :tanggal_kembali WHERE id = :id";
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->bindValue(':tanggal_kembali', date('Y-m-d'));
        $this->stmt->bindValue(':id', $id);
        $this->stmt->execute();
    
        // 3. Panggil method untuk mengembalikan (menambah) stok barang
        $this->updateStokBarang($barang_id, $qty_dipinjam, 'tambah');
    
        return $this->stmt->rowCount();
    }
}