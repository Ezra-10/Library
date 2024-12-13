<?php

if (!defined('SECURE_ACCESS')) {
    die('Direct access not permitted');
}

class LoginController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function index()
    {
 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->login(); 
        } 


        require 'views/login.php';
    }

    private function login()
    {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Email dan password wajib diisi!';
            header('Location: /login');
            exit();
        }

        $sql = "SELECT * FROM user WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header('Location: /home'); 
            exit();
        } else {
            $_SESSION['error'] = 'Email atau password salah!';
            header('Location: /login');
            exit();
            
        }
    }
}
