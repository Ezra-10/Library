<?php

require 'config/database.php';

class UserManagementController
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function index()
    {
        // Menampilkan daftar semua user
        $sql = "SELECT id, username, email, role, created_at FROM user";
        $stmt = $this->db->query($sql);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require 'views/manageUsers.php';
    }

    public function createUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $role = trim($_POST['role']);

            if (empty($username) || empty($email) || empty($password) || empty($role)) {
                $_SESSION['error'] = 'All fields are required!';
                header('Location: /admin/users');
                exit();
            }

            $sql = "INSERT INTO user (username, email, password, role, created_at) VALUES (:username, :email, :password, :role, NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role', $role);
            $stmt->execute();

            $_SESSION['success'] = 'User successfully created!';
            header('Location: /admin/users');
        }
    }
}
