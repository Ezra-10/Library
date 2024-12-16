<?php

class ReturnModel 
{
    private $db;

    public function __construct($db) 
    {
        $this->db = $db;
    }

    public function getUserLoans($userId) 
    {
        $stmt = $this->db->prepare("
            SELECT loans.id, books.title, loans.borrow_date, loans.due_date 
            FROM loans 
            JOIN books ON loans.book_id = books.id 
            WHERE loans.user_id = :user_id AND loans.return_date IS NULL
        ");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function returnBook($loanId) 
    {
        try {
            $this->db->beginTransaction();


            $stmt = $this->db->prepare("SELECT due_date, return_date FROM loans WHERE id = :id");
            $stmt->bindParam(':id', $loanId, PDO::PARAM_INT);
            $stmt->execute();
            $loan = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$loan) {
                throw new Exception('Data peminjaman tidak ditemukan.');
            }

            if (!empty($loan['return_date'])) {
                throw new Exception('Buku ini sudah dikembalikan sebelumnya.');
            }


            $dueDate = new DateTime($loan['due_date']);
            $returnDate = new DateTime(date('Y-m-d'));
            $lateDays = ($returnDate > $dueDate) ? $returnDate->diff($dueDate)->days : 0;

            $finePerDay = 10000; 
            $totalFine = $lateDays * $finePerDay;


            $stmt = $this->db->prepare("UPDATE loans SET return_date = :return_date WHERE id = :id");
            $stmt->bindParam(':return_date', date('Y-m-d'));
            $stmt->bindParam(':id', $loanId, PDO::PARAM_INT);
            $stmt->execute();

            if ($totalFine > 0) {
                $stmt = $this->db->prepare("
                    INSERT INTO denda (peminjaman_id, jumlah_denda, status_pembayaran) 
                    VALUES (:peminjaman_id, :jumlah_denda, 'belum lunas')
                ");
                $stmt->execute([
                    'peminjaman_id' => $loanId,
                    'jumlah_denda' => $totalFine
                ]);
            }

            $this->db->commit();
            return $totalFine;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
