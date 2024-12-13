<?php
class AuthController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $user = $this->userModel->login($username, $password);
            if ($user) {
                $_SESSION['user'] = $user;
                if ($user['role'] === 'admin') {
                    header('Location: /dashboard_admin');
                } else {
                    header('Location: /dashboard_member');
                }
            } else {
                echo "Login gagal!";
            }
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            if ($this->userModel->register($username, $email, $password)) {
                echo "Registrasi berhasil!";
            } else {
                echo "Registrasi gagal!";
            }
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /login');
    }
}
