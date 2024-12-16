<?php
require 'models/ReturnModel.php';

class ReturnController 
{
    private $db;
    private $model;

    public function __construct($db) 
    {
        $this->db = $db;
        $this->model = new ReturnModel($db);
    }

    public function index() 
    {
      
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        
        $borrowings = $this->model->getUserLoans($_SESSION['user_id']);
        require 'views/return.php'; 
    }

    public function returnBook($id) 
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        try {
           
            $totalFine = $this->model->returnBook($id);
            
            $_SESSION['success'] = "Buku berhasil dikembalikan.";
            if ($totalFine > 0) {
                $_SESSION['fine'] = "Denda keterlambatan: Rp. " . number_format($totalFine, 0, ',', '.');
            }

            header('Location: /return');
            exit();
        } catch (Exception $e) {
            $_SESSION['error'] = 'Terjadi kesalahan: ' . $e->getMessage();
            header('Location: /return');
            exit();
        }
    }
}
