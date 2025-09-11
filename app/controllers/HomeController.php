<?php

class HomeController extends Controller {
    public function index() {
        // Arahkan ke halaman dashboard sebagai default
        header('Location: ' . BASEURL . '/dashboard');
        exit;
    }
}