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
        // Menggunakan nama kolom dan tabel baru
        $query = "SELECT p.*, b.nama_barang 
                  FROM peminjaman p 
                  JOIN barang b ON p.id_barang = b.id 
                  ORDER BY p.tanggal_pinjam DESC, p.status ASC";
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambahDataPeminjaman($data) {
        // Menggunakan nama kolom baru
        $query = "INSERT INTO peminjaman (id_barang, peminjam, jumlah_dipinjam, tanggal_pinjam, keterangan) 
                  VALUES (:id_barang, :peminjam, :jumlah_dipinjam, :tanggal_pinjam, :keterangan)";
        
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->bindValue(':id_barang', $data['id_barang']);
        $this->stmt->bindValue(':peminjam', $data['peminjam']);
        $this->stmt->bindValue(':jumlah_dipinjam', $data['jumlah_dipinjam']);
        $this->stmt->bindValue(':tanggal_pinjam', $data['tanggal_pinjam']);
        $this->stmt->bindValue(':keterangan', $data['keterangan']);
        $this->stmt->execute();

        // Mengurangi stok barang di tabel barang
        $this->updateStokBarang($data['id_barang'], $data['jumlah_dipinjam'], 'kurang');

        return $this->stmt->rowCount();
    }

    public function updateStokBarang($id_barang, $jumlah, $aksi = 'kurang') {
        $operator = ($aksi == 'kurang') ? '-' : '+';
        // Menggunakan kolom `jumlah` di tabel `barang`
        $query = "UPDATE barang SET jumlah = jumlah $operator :jumlah WHERE id = :id_barang";
        
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->bindValue(':jumlah', $jumlah);
        $this->stmt->bindValue(':id_barang', $id_barang);
        $this->stmt->execute();
    }

    public function getPeminjamanById($id) {
        $this->stmt = $this->dbh->prepare('SELECT * FROM peminjaman WHERE id=:id');
        $this->stmt->bindValue(':id', $id);
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function kembalikanBarang($id) {
        $peminjaman = $this->getPeminjamanById($id);
        $id_barang = $peminjaman['id_barang'];
        $jumlah_dipinjam = $peminjaman['jumlah_dipinjam'];
    
        $query = "UPDATE peminjaman SET status = 'dikembalikan', tanggal_kembali = :tanggal_kembali WHERE id = :id";
        $this->stmt = $this->dbh->prepare($query);
        $this->stmt->bindValue(':tanggal_kembali', date('Y-m-d'));
        $this->stmt->bindValue(':id', $id);
        $this->stmt->execute();
    
        // Mengembalikan stok barang
        $this->updateStokBarang($id_barang, $jumlah_dipinjam, 'tambah');
    
        return $this->stmt->rowCount();
    }
}