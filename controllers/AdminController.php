<?php

class AdminController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

   
    public function index()
    {
        require 'views/admin/dashboard.php';
    }

    public function payFine()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $peminjamanId = $_POST['peminjaman_id'];

    
        if (empty($peminjamanId)) {
            $_SESSION['error'] = 'ID Peminjaman tidak valid.';
            header('Location: /admin/fines');
            exit();
        }

     
        $sql = "UPDATE denda SET status_pembayaran = 'lunas' WHERE peminjaman_id = :peminjaman_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':peminjaman_id', $peminjamanId);
        $stmt->execute();

        $_SESSION['success'] = 'Denda berhasil dilunasi.';
        header('Location: /admin/fines');
        exit();
    }
}

    
     
    public function manageUsers()
    {
      
        $sql = "SELECT id, username, email, role, created_at FROM user";
        $stmt = $this->db->query($sql);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require 'views/admin/users.php';
    }

   
    public function createUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $role = trim($_POST['role']);

            if (empty($username) || empty($email) || empty($password) || empty($role)) {
                $_SESSION['error'] = 'Semua kolom harus diisi!';
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

            $_SESSION['success'] = 'User berhasil dibuat!';
            header('Location: /admin/users');
        }
    }

    
    public function manageBooks()
    {
     
        require 'views/admin/books.php';
    }

    public function manageLoans()
    {
        $sql = "
            SELECT 
                l.id AS loan_id, 
                u.username, 
                b.title, 
                l.borrow_date, 
                l.due_date, 
                l.return_date, 
                l.status, 
                l.fine 
            FROM 
                loans l
            JOIN 
                user u ON l.user_id = u.id
            JOIN 
                books b ON l.book_id = b.id
        ";
        $stmt = $this->db->query($sql);
        $loans = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require 'views/admin_member.php';
    }

    public function viewMemberLoans()
    {
        $sql = "
            SELECT 
                u.username, 
                b.title, 
                l.borrow_date, 
                l.due_date 
            FROM 
                loans l
            JOIN 
                user u ON l.user_id = u.id
            JOIN 
                books b ON l.book_id = b.id
            WHERE 
                l.return_date IS NULL
        ";
        $stmt = $this->db->query($sql);
        $memberLoans = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require 'views/member_loans.php';
    }

    
    public function viewMemberFines()
    {
        $sql = "
            SELECT 
                u.username, 
                COALESCE(SUM(d.jumlah_denda), 0) AS total_fine 
            FROM 
                user u 
            LEFT JOIN 
                denda d ON d.peminjaman_id IN (SELECT id FROM loans WHERE loans.user_id = u.id) 
                AND d.status_pembayaran = 'belum lunas' -- Hanya hitung denda yang belum lunas
            GROUP BY 
                u.id, u.username
        ";
        $stmt = $this->db->query($sql);
        $fines = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        require 'views/admin_member.php';
    }
    
}
