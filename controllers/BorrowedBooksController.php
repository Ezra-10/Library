<?php

class BorrowedBooksController
{
    public function index($db, $user_id)
    {
    
        $query = "SELECT loans.id, books.title, loans.borrow_date, loans.due_date 
                  FROM loans 
                  JOIN books ON loans.book_id = books.id 
                  WHERE loans.user_id = :user_id AND loans.return_date IS NULL";

        $stmt = $db->prepare($query);
        $stmt->execute(['user_id' => $user_id]);
        $borrowedBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);

     
        require 'views/borrowed_books.php';
    }
}
