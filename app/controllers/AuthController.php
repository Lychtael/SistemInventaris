<?php

class AuthController extends Controller {
    public function index() {
        $data['judul'] = 'Login';
        $this->view('auth/login', $data); // Kita tidak pakai header/footer di sini
    }

    public function prosesLogin() {
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        $user = $this->model('Auth_model')->getUserByUsername($username);
    
        if ($user && password_verify($password, $user['password'])) {
            // ... (bagian login berhasil tidak berubah) ...
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_login'] = true;
    
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        } else {
            // Login gagal, BUAT NOTIFIKASI
            Flasher::setFlash('Login Gagal', 'Username atau password salah.', 'danger');
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASEURL . '/auth');
        exit;
    }
}