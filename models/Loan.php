<?php

class Loan
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    
    public function createLoan($userId, $bookId, $borrowDate, $dueDate)
    {
        $sql = "INSERT INTO loans (user_id, book_id, borrow_date, due_date, status) 
                VALUES (:user_id, :book_id, :borrow_date, :due_date, 'dipinjam')";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->bindParam(':borrow_date', $borrowDate);
        $stmt->bindParam(':due_date', $dueDate);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

 
    public function getLoansByUserId($userId)
    {
        $sql = "SELECT loans.id, books.title, loans.borrow_date, loans.due_date, loans.return_date 
                FROM loans 
                JOIN books ON loans.book_id = books.id 
                WHERE loans.user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function returnBook($loanId)
    {
        $sql = "UPDATE loans 
                SET return_date = :return_date, status = 'dikembalikan' 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':return_date', date('Y-m-d'));
        $stmt->bindParam(':id', $loanId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
