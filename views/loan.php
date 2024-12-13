<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <?php require 'assets/header.php'; ?>

    <header class="bg-blue-600 text-white text-center py-6">
        <h1 class="text-3xl font-bold">Daftar Buku</h1>
    </header>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="max-w-3xl mx-auto mt-6">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline"><?= $_SESSION['success'] ?></span>
                <?php unset($_SESSION['success']); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="max-w-6xl mx-auto mt-10">
        <table class="table-auto w-full bg-white shadow-md rounded-lg">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-6 py-4">Gambar</th>
                    <th class="px-6 py-4">Judul</th>
                    <th class="px-6 py-4">Pengarang</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($books)): ?>
                    <?php foreach ($books as $book): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <?php 
                                $imagePath = '/oop-mvc/uploads/' . $book['image']; 
                                if (file_exists('uploads/' . $book['image']) && !empty($book['image'])): 
                                ?>
                                    <img src="<?= $imagePath ?>" alt="Cover Buku <?= $book['title'] ?>" 
                                         class="w-20 h-28 object-cover rounded-md">
                                <?php else: ?>
                                    <p>Gambar tidak ditemukan</p>
                                <?php endif; ?>
                            </td>

                            <td class="px-6 py-4"> <?= $book['title'] ?> </td>
                            <td class="px-6 py-4"> <?= $book['author'] ?> </td>
                            <td class="px-6 py-4">
                                <form action="/loan/borrow" method="POST" class="flex flex-col items-start">
                                    <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                                    <label for="duration" class="mb-2 text-sm font-medium text-gray-700">Durasi Pinjam (hari)</label>
                                    <input type="number" name="duration" id="duration" min="1" max="30" value="7" 
                                           class="w-16 border border-gray-300 rounded-md p-1 text-center mb-3" 
                                           required>
                                    <button type="submit" 
                                            class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-all">
                                        Pinjam
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-600">Tidak ada buku yang tersedia.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>

</html>
