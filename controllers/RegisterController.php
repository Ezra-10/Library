<?php
session_start();

class RegisterController {

    public function index($db) {
        // Cek apakah user login dan memiliki role admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /login');
            exit();
        }

        // Proses form register
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $role = trim($_POST['role']);

            if (empty($username) || empty($email) || empty($password) || empty($role)) {
                $_SESSION['error'] = 'Semua field harus diisi!';
                header('Location: /register');
                exit();
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $sql = "INSERT INTO user (username, email, password, role, created_at) 
                    VALUES (:username, :email, :password, :role, NOW())";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $role);

            if ($stmt->execute()) {
                $_SESSION['success'] = 'User berhasil dibuat!';
                header('Location: /admin/users');
            } else {
                $_SESSION['error'] = 'Terjadi kesalahan saat membuat user.';
                header('Location: /register');
            }

            exit();
        }

        require 'views/register.php';
    }
}
