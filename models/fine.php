<?php

class Fine
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Mendapatkan semua denda milik user tertentu
    public function getUserFines($userId)
    {
        $sql = "
            SELECT d.id AS denda_id, l.id AS peminjaman_id, b.title, d.jumlah_denda, d.status_pembayaran 
            FROM denda d
            JOIN loans l ON d.peminjaman_id = l.id
            JOIN books b ON l.book_id = b.id
            WHERE l.user_id = :user_id
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengubah status pembayaran denda menjadi 'lunas'
    public function payFine($fineId)
    {
        $sql = "UPDATE denda SET status_pembayaran = 'lunas' WHERE id = :fine_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':fine_id', $fineId, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
