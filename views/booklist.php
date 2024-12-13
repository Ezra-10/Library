<?php require 'assets/header.php';?>

    <!-- Book List Section -->
    <section class="py-20">
        <div class="container mx-auto">
            <h1 class="text-4xl font-bold text-gray-800 mb-10 text-center">Pilih Buku</h1>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
                <?php
                // Array dummy data buku
                $books = [
                    ['title' => 'Black Clover', 'author' => 'Yuuki Tabata', 'cover' => 'photo/BC.jpg', 'id' => 1],
                    ['title' => 'One Piece', 'author' => '', 'cover' => 'photo/One.jpg', 'id' => 2],
                    ['title' => 'Book Three', 'author' => 'Author Three', 'cover' => 'https://via.placeholder.com/200x300', 'id' => 3],
                    ['title' => 'Book Four', 'author' => 'Author Four', 'cover' => 'https://via.placeholder.com/200x300', 'id' => 4],
                    ['title' => 'Book Five', 'author' => 'Author Five', 'cover' => 'https://via.placeholder.com/200x300', 'id' => 5],
                    ['title' => 'Book Five', 'author' => 'Author Five', 'cover' => 'https://via.placeholder.com/200x300', 'id' => 6],
                    ['title' => 'Book Five', 'author' => 'Author Five', 'cover' => 'https://via.placeholder.com/200x300', 'id' => 7],
                    ['title' => 'Book Five', 'author' => 'Author Five', 'cover' => 'https://via.placeholder.com/200x300', 'id' => 8],
                    // Tambah lebih banyak data buku di sini
                ];

                // Menampilkan buku dalam kartu
                foreach ($books as $book) {
                    echo "
                    <div class='bg-white rounded-lg shadow-md overflow-hidden'>
                        <img src='{$book['cover']}' alt='Book Cover' class='w-full h-64 object-cover'>
                        <div class='p-4'>
                            <h3 class='text-xl font-bold text-gray-800'>{$book['title']}</h3>
                            <p class='text-gray-600'>by {$book['author']}</p>
                            <a href='book-detail.php?id={$book['id']}' class='block bg-blue-600 text-white mt-4 text-center py-2 rounded-lg hover:bg-blue-700'>View Details</a>
                        </div>
                    </div>
                    ";
                }
                ?>
            </div>
        </div>
    </section>

<?php require 'assets/footer.php'; ?>