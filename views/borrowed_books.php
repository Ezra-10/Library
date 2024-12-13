<?php

session_start();


if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

require 'assets/header.php'; 

?>

<section class="container mx-auto py-10">
    <h2 class="text-3xl font-bold text-center mb-6">Your Borrowed Books</h2>
    
    <?php if (empty($borrowedBooks)): ?>
        <p class="text-center text-lg text-gray-700">You have not borrowed any books yet.</p>
    <?php else: ?>
        <table class="min-w-full table-auto bg-white shadow-md rounded-lg">
            <thead>
                <tr class="bg-blue-600 text-white">
                    <th class="py-2 px-4">Title</th>
                    <th class="py-2 px-4">Author</th>
                    <th class="py-2 px-4">Borrow Date</th>
                    <th class="py-2 px-4">Due Date</th>
                    <th class="py-2 px-4">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($borrowedBooks as $book): ?>
                    <tr class="text-gray-700">
                        <td class="py-2 px-4"><?php echo $book['title']; ?></td>
                        <td class="py-2 px-4"><?php echo $book['author']; ?></td>
                        <td class="py-2 px-4"><?php echo $book['borrow_date']; ?></td>
                        <td class="py-2 px-4"><?php echo $book['due_date']; ?></td>
                        <td class="py-2 px-4"><?php echo ucfirst($book['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>

<?php require 'assets/footer.php'; ?>
