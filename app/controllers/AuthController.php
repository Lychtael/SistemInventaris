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
    
        // Memeriksa kolom `kata_sandi` dari tabel `pengguna`
        if ($user && password_verify($password, $user['kata_sandi'])) {
            // Simpan data pengguna ke session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['nama_pengguna']; // Menggunakan `nama_pengguna`
            $_SESSION['is_login'] = true;

            // Panggil model log untuk mencatat aktivitas
            $this->model('Log_model')->catatLog('LOGIN', 'auth', 'Pengguna ' . $username . ' berhasil login.');
            
            // Beri notifikasi dan arahkan ke dashboard
            Flasher::setFlash('Login Berhasil', 'Selamat datang, ' . $username . '!', 'success');
            
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        } else {
            // Jika login gagal
            Flasher::setFlash('Login Gagal', 'Nama pengguna atau kata sandi salah.', 'danger');
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function logout() {
        if (isset($_SESSION['is_login'])) {
            // Catat aktivitas logout SEBELUM session dihancurkan
            $this->model('Log_model')->catatLog('LOGOUT', 'auth', 'Pengguna ' . $_SESSION['username'] . ' telah logout.');
        }

        // Hancurkan session
        session_destroy();
        
        // Beri notifikasi dan arahkan ke halaman login
        Flasher::setFlash('Logout', 'Anda telah berhasil keluar.', 'success');
        header('Location: ' . BASEURL . '/auth');
        exit;
    }
}