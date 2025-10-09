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
        // Validasi server-side: pastikan kolom wajib tidak kosong
        if (empty($_POST['barang_id']) || empty(trim($_POST['peminjam'])) || empty(trim($_POST['qty_dipinjam']))) {
            Flasher::setFlash('Gagal', 'Data tidak lengkap. Semua kolom wajib diisi.', 'danger');
            header('Location: ' . BASEURL . '/peminjaman/create');
            exit;
        }

        $barang = $this->model('Barang_model')->getBarangById($_POST['barang_id']);
        $qty_dipinjam = (int)$_POST['qty_dipinjam'];

        if ($qty_dipinjam <= 0) {
            Flasher::setFlash('Gagal', 'Jumlah pinjam tidak valid.', 'danger');
            header('Location: ' . BASEURL . '/peminjaman/create');
            exit;
        }

        if ($barang['qty'] < $qty_dipinjam) {
            Flasher::setFlash('Gagal', 'Stok barang tidak mencukupi.', 'danger');
            header('Location: ' . BASEURL . '/peminjaman/create');
            exit;
        }

        if ($this->model('Peminjaman_model')->tambahDataPeminjaman($_POST) > 0) {
            $keterangan = "Mencatat peminjaman '" . htmlspecialchars($barang['nama_barang']) . "' oleh " . htmlspecialchars($_POST['peminjam']);
            $this->model('Log_model')->catatLog('PINJAM', 'peminjaman', $keterangan);
            Flasher::setFlash('Data Peminjaman', 'berhasil dicatat.', 'success');
        } else {
            Flasher::setFlash('Data Peminjaman', 'gagal dicatat.', 'danger');
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
            Flasher::setFlash('Data Pengembalian', 'berhasil dicatat.', 'success');
        } else {
            Flasher::setFlash('Data Pengembalian', 'gagal dicatat.', 'danger');
        }
        header('Location: ' . BASEURL . '/peminjaman');
        exit;
    }
}