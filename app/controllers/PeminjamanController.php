<?php

class PeminjamanController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['is_login'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index() {
        $data['judul'] = 'Data Peminjaman';
        $data['peminjaman'] = $this->model('Peminjaman_model')->getAllPeminjaman();
        $this->view('templates/header', $data);
        $this->view('peminjaman/index', $data);
        $this->view('templates/footer');
    }

    public function create() {
        $data['judul'] = 'Catat Peminjaman';
        $data['barang'] = $this->model('Barang_model')->getAllBarang(); // Ambil data barang untuk dropdown
        $this->view('templates/header', $data);
        $this->view('peminjaman/create', $data);
        $this->view('templates/footer');
    }

    public function store() {
        $barang = $this->model('Barang_model')->getBarangById($_POST['barang_id']);
        
        if ($barang['qty'] < $_POST['qty_dipinjam']) {
            Flasher::setFlash('Peminjaman Gagal', 'Stok barang tidak mencukupi.', 'danger');
            header('Location: ' . BASEURL . '/peminjaman/create'); // Kembali ke form
            exit;
        }
    
        if ($this->model('Peminjaman_model')->tambahDataPeminjaman($_POST) > 0) {
            $keterangan = "Mencatat peminjaman '" . htmlspecialchars($barang['nama_barang']) . "' oleh " . htmlspecialchars($_POST['peminjam']);
            $this->model('Log_model')->catatLog('PINJAM', 'peminjaman', $keterangan);
            Flasher::setFlash('Peminjaman', 'berhasil dicatat.', 'success');
        } else {
            Flasher::setFlash('Peminjaman', 'gagal dicatat.', 'danger');
        }
        header('Location: ' . BASEURL . '/peminjaman');
        exit;
    }
    
    public function kembali($id) {
        $peminjaman = $this->model('Peminjaman_model')->getPeminjamanById($id);
        $barang = $this->model('Barang_model')->getBarangById($peminjaman['barang_id']);
    
        if ($this->model('Peminjaman_model')->kembalikanBarang($id) > 0) {
            $keterangan = "Mencatat pengembalian '" . htmlspecialchars($barang['nama_barang']) . "' oleh " . htmlspecialchars($peminjaman['peminjam']);
            $this->model('Log_model')->catatLog('KEMBALI', 'peminjaman', $keterangan);
            Flasher::setFlash('Pengembalian', 'berhasil dicatat.', 'success');
        } else {
            Flasher::setFlash('Pengembalian', 'gagal dicatat.', 'danger');
        }
        header('Location: ' . BASEURL . '/peminjaman');
        exit;
    }
}