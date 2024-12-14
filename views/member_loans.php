<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peminjaman Member</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <?php require 'assets/header.php'; ?>

    <div class="container mx-auto mt-10">
        <h1 class="text-4xl font-bold text-center mb-10">Daftar Peminjaman Member</h1>

        <table class="table-auto w-full bg-white shadow-md rounded-lg">
            <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Username</th>
                    <th class="px-6 py-4">Buku</th>
                    <th class="px-6 py-4">Tanggal Pinjam</th>
                    <th class="px-6 py-4">Jatuh Tempo</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($memberLoans)): ?>
                    <?php foreach ($memberLoans as $index => $loan): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-center"><?= $index + 1 ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($loan['username']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($loan['title']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($loan['borrow_date']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($loan['due_date']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-600">Tidak ada data peminjaman saat ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
