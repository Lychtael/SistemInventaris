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
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_login'] = true;

            // Log aktivitas login
            $this->model('Log_model')->catatLog('LOGIN', 'auth', 'User ' . $username . ' berhasil login.');
            Flasher::setFlash('Login Berhasil', 'Selamat datang, ' . $username, 'success');

            header('Location: ' . BASEURL . '/dashboard');
            exit;
        } else {
            Flasher::setFlash('Login Gagal', 'Username atau password salah.', 'danger');
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function logout() {
        // Log aktivitas logout
        $this->model('Log_model')->catatLog('LOGOUT', 'auth', 'User ' . $_SESSION['username'] . ' telah logout.');

        session_destroy();
        Flasher::setFlash('Logout Berhasil', 'Anda telah berhasil logout.', 'success');
        header('Location: ' . BASEURL . '/auth');
        exit;
    }
}