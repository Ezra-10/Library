<?php

session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

// Cegah akses langsung ke file
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

    /**
     * Halaman daftar buku untuk dipinjam
     */
    public function index()
    {
        try {
            $sql = "SELECT id, title, author FROM books";
            $stmt = $this->db->query($sql);
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Gagal memuat daftar buku: ' . $e->getMessage();
            $books = [];
        }

        require 'views/loan.php';
    }


    public function borrow()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id']; 
            $book_id = $_POST['book_id']; 
            $duration = isset($_POST['duration']) ? (int)$_POST['duration'] : 7; 
            
          
            $duration = $this->validateDuration($duration);

            $borrow_date = date('Y-m-d');
            $due_date = date('Y-m-d', strtotime("+$duration days")); 

            try {
                $this->createLoan($user_id, $book_id, $borrow_date, $due_date);
                $_SESSION['success'] = 'Buku berhasil dipinjam hingga ' . $due_date . '!';
            } catch (PDOException $e) {
                $_SESSION['error'] = 'Gagal meminjam buku: ' . $e->getMessage();
            }

            header('Location: /loan');
            exit();
        }
    }

    public function returnBook($loan_id)
    {
        try {
            $loan = $this->getLoanById($loan_id);
            if (!$loan) {
                $_SESSION['error'] = 'Data peminjaman tidak ditemukan.';
                header('Location: /loan');
                exit();
            }

            $return_date = date('Y-m-d');
            $late_days = $this->calculateLateDays($loan['due_date'], $return_date);
            $fine = $this->calculateFine($late_days);
            $status = $fine > 0 ? 'late' : 'returned';

            $this->updateLoan($loan_id, $return_date, $status, $fine);

            $_SESSION['success'] = 'Buku berhasil dikembalikan!';
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Gagal mengembalikan buku: ' . $e->getMessage();
        }

        header('Location: /loan');
        exit();
    }

    
    private function createLoan($user_id, $book_id, $borrow_date, $due_date)
    {
        $sql = "INSERT INTO loans (user_id, book_id, borrow_date, due_date) 
                VALUES (:user_id, :book_id, :borrow_date, :due_date)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'user_id' => $user_id,
            'book_id' => $book_id,
            'borrow_date' => $borrow_date,
            'due_date' => $due_date
        ]);
    }

    
    private function getLoanById($loan_id)
    {
        $sql = "SELECT id, due_date FROM loans WHERE id = :loan_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':loan_id', $loan_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    private function calculateLateDays($due_date, $return_date)
    {
        $late_days = (strtotime($return_date) - strtotime($due_date)) / (60 * 60 * 24);
        return max(0, $late_days); 
    }

   
    private function calculateFine($late_days)
    {
        $fine_per_day = 10000; // Denda per hari
        return $late_days > 0 ? $late_days * $fine_per_day : 0;
    }

  
    private function updateLoan($loan_id, $return_date, $status, $fine)
    {
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
    }

    /**
     * Validasi durasi peminjaman
     */
    private function validateDuration($duration)
    {
        if ($duration < 1) {
            $duration = 1; 
        } elseif ($duration > 7) {
            $duration = 7; 
        }
        return $duration;
    }
}
