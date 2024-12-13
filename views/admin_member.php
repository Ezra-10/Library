<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Member dengan Denda</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <?php require 'assets/header.php'; ?>

    <div class="container mx-auto mt-10">
        <h1 class="text-4xl font-bold text-center mb-10">Daftar Member dengan Denda</h1>

        <table class="table-auto w-full bg-white shadow-md rounded-lg">
            <thead class="bg-red-600 text-white">
                <tr>
                    <th class="px-6 py-4">Username</th>
                    <th class="px-6 py-4">Buku</th>
                    <th class="px-6 py-4">Tanggal Pinjam</th>
                    <th class="px-6 py-4">Jatuh Tempo</th>
                    <th class="px-6 py-4">Tanggal Pengembalian</th>
                    <th class="px-6 py-4">Denda</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($memberFines)): ?>
                    <?php foreach ($memberFines as $fine): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4"><?= $fine['username'] ?></td>
                            <td class="px-6 py-4"><?= $fine['title'] ?></td>
                            <td class="px-6 py-4"><?= $fine['borrow_date'] ?></td>
                            <td class="px-6 py-4"><?= $fine['due_date'] ?></td>
                            <td class="px-6 py-4"><?= $fine['return_date'] ?? 'Belum Dikembalikan' ?></td>
                            <td class="px-6 py-4 text-red-600"><?= 'Rp ' . number_format($fine['fine'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-600">Tidak ada member dengan denda.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
