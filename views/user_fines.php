<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Denda Anda</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Header -->
    <?php require 'assets/header.php'; ?>

    <div class="container mx-auto mt-10">
        <h1 class="text-4xl font-bold text-center mb-10">Daftar Denda Anda</h1>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="bg-green-200 text-green-700 p-4 mb-4 rounded-md">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="bg-red-200 text-red-700 p-4 mb-4 rounded-md">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <table class="table-auto w-full bg-white shadow-md rounded-lg">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-6 py-4 text-left">No</th>
                    <th class="px-6 py-4 text-left">Judul Buku</th>
                    <th class="px-6 py-4 text-left">Jumlah Denda</th>
                    <th class="px-6 py-4 text-left">Status Pembayaran</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($fines)): ?>
                    <?php foreach ($fines as $index => $fine): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4"><?= $index + 1 ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($fine['title']) ?></td>
                            <td class="px-6 py-4 text-red-600"><?= 'Rp ' . number_format($fine['jumlah_denda'], 0, ',', '.') ?></td>
                            <td class="px-6 py-4"><?= ucfirst($fine['status_pembayaran']) ?></td>
                            <td class="px-6 py-4 text-center">
                                <?php if ($fine['status_pembayaran'] === 'belum lunas'): ?>
                                    <form method="POST" action="/user/pay-fine">
                                        <input type="hidden" name="denda_id" value="<?= $fine['denda_id'] ?>">
                                        <button type="submit" class="bg-green-600 hover:bg-green-500 text-white py-1 px-4 rounded-md">
                                            Bayar
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-gray-600">Sudah Lunas</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-600">Anda tidak memiliki denda saat ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
