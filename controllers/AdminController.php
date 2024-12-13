<?php

class AdminController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Halaman utama Admin Dashboard
     */
    public function index()
    {
        require 'views/admin/dashboard.php';
    }

    /**
     * Halaman pengelolaan pengguna
     */
    public function manageUsers()
    {
        // Logika untuk pengelolaan user
        require 'views/admin/users.php';
    }

    /**
     * Halaman pengelolaan buku
     */
    public function manageBooks()
    {
        // Logika untuk pengelolaan buku
        require 'views/admin/books.php';
    }

    /**
     * Halaman pengelolaan pinjaman buku
     */
    // public function manageLoans()
    // {
    //     $sql = "SELECT loans.id, user.username, books.title, loans.borrow_date, loans.due_date, loans.return_date, loans.status, loans.fine 
    //             FROM loans 
    //             JOIN user ON loans.user_id = users.id 
    //             JOIN books ON loans.book_id = books.id";
                
    //     $stmt = $this->db->query($sql);
    //     $loans = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    //     require 'views/admin/loans.php';
    // }

    /**
     * Halaman daftar member dengan denda
     */
    public function viewMemberFines()
    {
        $sql = "SELECT u.username, SUM(l.fine) as total_fine 
                FROM loans l 
                JOIN user u ON l.user_id = u.id 
                WHERE l.fine > 0 
                GROUP BY u.id";
        $stmt = $this->db->query($sql);
        $fines = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require 'views/admin_member.php';
    }
    
}
