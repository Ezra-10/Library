<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}


if (!defined('SECURE_ACCESS')) {
    die('Direct access not permitted');
}

class LoanController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

   
    public function index()
    {
        $sql = "SELECT books.id, books.title, books.author FROM books";
        $stmt = $this->db->query($sql);
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require 'views/loan.php';
    }

  
    public function borrow()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id']; 
            $book_id = $_POST['book_id']; 
            $duration = isset($_POST['duration']) ? (int)$_POST['duration'] : 7; 
            
            if ($duration < 1) {
                $duration = 1; // Minimal 1 hari
            } elseif ($duration > 30) {
                $duration = 30; // Maksimal 30 hari
            }

            $borrow_date = date('Y-m-d');
            $due_date = date('Y-m-d', strtotime("+$duration days")); 

            try {
                $sql = "INSERT INTO loans (user_id, book_id, borrow_date, due_date) 
                        VALUES (:user_id, :book_id, :borrow_date, :due_date)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    'user_id' => $user_id,
                    'book_id' => $book_id,
                    'borrow_date' => $borrow_date,
                    'due_date' => $due_date
                ]);

                $_SESSION['success'] = 'Buku berhasil dipinjam hingga ' . $due_date . '!';
                header('Location: /loan');
            } catch (PDOException $e) {
                $_SESSION['error'] = 'Gagal meminjam buku: ' . $e->getMessage();
                header('Location: /loan');
            }
        }
    }

    
    public function returnBook($loan_id)
    {
        try {
            $return_date = date('Y-m-d');
            // pemeriksaan
            $sql = "SELECT due_date FROM loans WHERE id = :loan_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':loan_id', $loan_id);
            $stmt->execute();
            $loan = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $late_days = (strtotime($return_date) - strtotime($loan['due_date'])) / (60 * 60 * 24);
            $fine = $late_days > 0 ? $late_days * 10000 : 0; 
            $status = $fine > 0 ? 'late' : 'returned';
            
            $sql = "UPDATE loans 
                    SET return_date = :return_date, status = :status, fine = :fine 
                    WHERE id = :loan_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'return_date' => $return_date,
                'status' => $status,
                'fine' => $fine,
                'loan_id' => $loan_id
            ]);

            $_SESSION['success'] = 'Buku berhasil dikembalikan!';
            header('Location: /loan');
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Gagal mengembalikan buku: ' . $e->getMessage();
            header('Location: /loan');
        }
    }
}
