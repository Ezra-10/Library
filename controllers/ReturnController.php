<?php
session_start();

class ReturnController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        // 1️⃣ Cek apakah user sudah login
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        // 2️⃣ Ambil daftar peminjaman yang belum dikembalikan
        $stmt = $this->db->prepare("
            SELECT loans.id, books.title, loans.borrow_date, loans.due_date 
            FROM loans 
            JOIN books ON loans.book_id = books.id 
            WHERE loans.user_id = :user_id AND loans.return_date IS NULL
        ");
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();
        $borrowings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require 'views/return.php';
    }

    public function returnBook($id) {
        try {
            if (empty($id)) {
                throw new Exception('ID peminjaman tidak ditemukan.');
            }
    
            // 1️⃣ Cek apakah peminjaman valid
            $stmt = $this->db->prepare("SELECT due_date, return_date FROM loans WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $loan = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$loan) {
                throw new Exception('Data peminjaman tidak ditemukan.');
            }
    
            if (!empty($loan['return_date'])) {
                throw new Exception('Buku ini sudah dikembalikan sebelumnya.');
            }
    
            // 2️⃣ Hitung denda
            $dueDate = new DateTime($loan['due_date']);
            $returnDate = new DateTime(date('Y-m-d'));
            $lateDays = ($returnDate > $dueDate) ? $returnDate->diff($dueDate)->days : 0;
    
            $finePerDay = 10000; // denda per hari
            $totalFine = $lateDays * $finePerDay;
    
            // 3️⃣ Perbarui status pengembalian buku
            $stmt = $this->db->prepare("UPDATE loans SET return_date = :return_date WHERE id = :id");
            $stmt->bindParam(':return_date', date('Y-m-d'));
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
    
            // 4️⃣ Jika ada denda, masukkan ke tabel `denda`
            if ($totalFine > 0) {
                $stmt = $this->db->prepare("
                    INSERT INTO denda (peminjaman_id, jumlah_denda, status_pembayaran) 
                    VALUES (:peminjaman_id, :jumlah_denda, 'belum lunas')
                ");
                $stmt->execute([
                    'peminjaman_id' => $id,
                    'jumlah_denda' => $totalFine
                ]);
            }
    
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
