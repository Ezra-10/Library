<?php

require 'models/Fine.php';

class UserController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Menampilkan daftar denda user
    public function viewFines()
    {
        session_start();

        // Pastikan user sudah login
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $userId = $_SESSION['user_id'];

        // Ambil data denda melalui model
        $fineModel = new Fine($this->db);
        $fines = $fineModel->getUserFines($userId);

        require 'views/user_fines.php';
    }

    // Proses pembayaran denda
    public function payFine()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fineId = $_POST['denda_id'];

            $fineModel = new Fine($this->db);
            $success = $fineModel->payFine($fineId);

            if ($success) {
                $_SESSION['success'] = 'Denda berhasil dibayar!';
            } else {
                $_SESSION['error'] = 'Terjadi kesalahan, silakan coba lagi.';
            }

            header('Location: /user/fines');
            exit();
        }
    }
}
