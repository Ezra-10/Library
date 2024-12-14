<?php
session_start();

class HomeController {

    public function index($db) {
   
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }


        $role = $_SESSION['role'];


        if ($role === 'admin') {
            require 'views/home_admin.php';
        } else {
            require 'views/home.php';
        }
    }
}
