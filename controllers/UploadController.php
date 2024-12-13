<?php

class UploadController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addBook() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $author = $_POST['author'];

            // Proses upload gambar
            $image = $_FILES['image']['name'];
            $targetDir = 'uploads/';
            $targetFile = $targetDir . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);

            $sql = "INSERT INTO books (title, author, image) VALUES (:title, :author, :image)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':author', $author);
            $stmt->bindParam(':image', $image);
            $stmt->execute();

            $_SESSION['success'] = 'Buku berhasil ditambahkan!';
            header('Location: /book');
            exit();
        }

        require 'views/addBook.php';
    }
}
