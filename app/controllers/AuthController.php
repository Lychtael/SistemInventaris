<?php

class AuthController extends Controller {
    public function index() {
        $data['judul'] = 'Login';
        $this->view('auth/login', $data);
    }

    public function prosesLogin() {
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        $user = $this->model('Auth_model')->getUserByUsername($username);
    
        if ($user && password_verify($password, $user['password'])) {
            // Langkah 1: Simpan data user ke session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_login'] = true;

            // Langkah 2: Panggil model log untuk mencatat aktivitas
            $this->model('Log_model')->catatLog('LOGIN', 'auth', 'User ' . $username . ' berhasil login.');
            
            // Langkah 3: Beri notifikasi dan arahkan ke dashboard
            Flasher::setFlash('Login Berhasil', 'Selamat datang, ' . $username . '!', 'success');
            
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        } else {
            // Jika login gagal
            Flasher::setFlash('Login Gagal', 'Username atau password salah.', 'danger');
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function logout() {
        if (isset($_SESSION['is_login'])) {
            // Langkah 1: Catat aktivitas logout SEBELUM session dihancurkan
            $this->model('Log_model')->catatLog('LOGOUT', 'auth', 'User ' . $_SESSION['username'] . ' telah logout.');
        }

        // Langkah 2: Hancurkan session
        session_destroy();
        
        // Langkah 3: Beri notifikasi dan arahkan ke halaman login
        Flasher::setFlash('Logout', 'Anda telah berhasil keluar.', 'success');
        header('Location: ' . BASEURL . '/auth');
        exit;
    }
}