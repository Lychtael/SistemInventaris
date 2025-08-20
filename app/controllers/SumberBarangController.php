<?php

class SumberBarangController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['is_login'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index() {
        $data['judul'] = 'Sumber Barang';
        $data['sumber_barang'] = $this->model('SumberBarang_model')->getAllSumberBarang();
        $this->view('templates/header', $data);
        $this->view('sumber_barang/index', $data);
        $this->view('templates/footer');
    }

    public function tambah() {
        if ($this->model('SumberBarang_model')->tambahDataSumberBarang($_POST) > 0) {
            $this->model('Log_model')->catatLog('TAMBAH', 'sumber_barang', "Menambah sumber baru: " . htmlspecialchars($_POST['nama_sumber']));
            Flasher::setFlash('Sumber Barang', 'berhasil ditambahkan.', 'success');
        } else {
            Flasher::setFlash('Sumber Barang', 'gagal ditambahkan.', 'danger');
        }
        header('Location: ' . BASEURL . '/sumberbarang');
        exit;
    }
    
    public function ubah() {
        if ($this->model('SumberBarang_model')->updateDataSumberBarang($_POST) > 0) {
            $this->model('Log_model')->catatLog('UBAH', 'sumber_barang', "Mengubah sumber: " . htmlspecialchars($_POST['nama_sumber']));
            Flasher::setFlash('Sumber Barang', 'berhasil diubah.', 'success');
        } else {
            Flasher::setFlash('Sumber Barang', 'gagal diubah.', 'danger');
        }
        header('Location: ' . BASEURL . '/sumberbarang');
        exit;
    }
    
    public function hapus($id) {
        $sumber = $this->model('SumberBarang_model')->getSumberBarangById($id);
        if ($this->model('SumberBarang_model')->hapusDataSumberBarang($id) > 0) {
            $this->model('Log_model')->catatLog('HAPUS', 'sumber_barang', "Menghapus sumber: " . htmlspecialchars($sumber['nama_sumber']));
            Flasher::setFlash('Sumber Barang', 'berhasil dihapus.', 'success');
        } else {
            Flasher::setFlash('Sumber Barang', 'gagal dihapus.', 'danger');
        }
        header('Location: ' . BASEURL . '/sumberbarang');
        exit;
    }
    public function getUbah() {
        echo json_encode($this->model('SumberBarang_model')->getSumberBarangById($_POST['id']));
    }
}