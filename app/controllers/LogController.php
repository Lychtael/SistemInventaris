<?php

class LogController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['is_login'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index() {
        $data['judul'] = 'Riwayat Aktivitas';
        $data['log'] = $this->model('Log_model')->getAllLog();
        $this->view('templates/header', $data);
        $this->view('log/index', $data);
        $this->view('templates/footer');
    }
}