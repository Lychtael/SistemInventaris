<?php

class DashboardController extends Controller {
    public function __construct()
    {
        // Cek jika user belum login
        if (!isset($_SESSION['is_login'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }
    public function index()
    {
        $data['judul'] = 'Dashboard';
        
        $barang_model = $this->model('Barang_model');
        
        // Mengambil data ringkasan dari model
        $data['total_barang'] = $barang_model->getTotalBarang();
        $data['barang_habis'] = $barang_model->getZeroStockCount(); // <-- TAMBAHKAN INI
        $data['barang_by_jenis'] = $barang_model->getBarangCountByJenis();
        $data['barang_by_sumber'] = $barang_model->getBarangCountBySumber();

        $this->view('templates/header', $data);
        $this->view('dashboard/index', $data);
        $this->view('templates/footer');
    }
}