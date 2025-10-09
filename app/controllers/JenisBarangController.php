<?php

class JenisBarangController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['is_login'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index() {
        $data['judul'] = 'Jenis Barang';
        $data['jenis_barang'] = $this->model('JenisBarang_model')->getAllJenisBarang();
        $this->view('templates/header', $data);
        $this->view('jenis_barang/index', $data);
        $this->view('templates/footer');
    }

    public function tambah() {
        // Validasi server-side
        if (empty(trim($_POST['nama_jenis']))) {
            Flasher::setFlash('Gagal', 'Nama jenis barang tidak boleh kosong.', 'danger');
            header('Location: ' . BASEURL . '/jenisbarang');
            exit;
        }

        if ($this->model('JenisBarang_model')->tambahDataJenisBarang($_POST) > 0) {
            $this->model('Log_model')->catatLog('TAMBAH', 'jenis_barang', "Menambah jenis baru: " . htmlspecialchars($_POST['nama_jenis']));
            Flasher::setFlash('Jenis Barang', 'berhasil ditambahkan.', 'success');
        } else {
            Flasher::setFlash('Jenis Barang', 'gagal ditambahkan.', 'danger');
        }
        header('Location: ' . BASEURL . '/jenisbarang');
        exit;
    }
    
    public function ubah() {
        if ($this->model('JenisBarang_model')->updateDataJenisBarang($_POST) > 0) {
            $this->model('Log_model')->catatLog('UBAH', 'jenis_barang', "Mengubah jenis: " . htmlspecialchars($_POST['nama_jenis']));
            Flasher::setFlash('Jenis Barang', 'berhasil diubah.', 'success');
        } else {
            Flasher::setFlash('Jenis Barang', 'gagal diubah.', 'danger');
        }
        header('Location: ' . BASEURL . '/jenisbarang');
        exit;
    }
    
    public function hapus($id) {
        $jenis = $this->model('JenisBarang_model')->getJenisBarangById($id);
        if ($this->model('JenisBarang_model')->hapusDataJenisBarang($id) > 0) {
            $this->model('Log_model')->catatLog('HAPUS', 'jenis_barang', "Menghapus jenis: " . htmlspecialchars($jenis['nama_jenis']));
            Flasher::setFlash('Jenis Barang', 'berhasil dihapus.', 'success');
        } else {
            Flasher::setFlash('Jenis Barang', 'gagal dihapus.', 'danger');
        }
        header('Location: ' . BASEURL . '/jenisbarang');
        exit;
    }
    
    public function getUbah() {
        echo json_encode($this->model('JenisBarang_model')->getJenisBarangById($_POST['id']));
    }
}