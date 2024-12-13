<?php
session_start();

class HomeController {

    public function index($db) {
        // Pastikan user sudah login
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        // Cek role user dari session
        $role = $_SESSION['role'];

        // Arahkan ke halaman yang sesuai dengan role
        if ($role === 'admin') {
            require 'views/home_admin.php';
        } else {
            require 'views/home.php';
        }
    }
}
