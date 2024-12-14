<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Denda Member</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <?php require 'assets/header.php'; ?>

    <div class="container mx-auto mt-10">
        <h1 class="text-4xl font-bold text-center mb-10">Data Denda Member</h1>

        <table class="table-auto w-full bg-white shadow-md rounded-lg">
            <thead class="bg-red-600 text-white">
                <tr>
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Username</th>
                    <th class="px-6 py-4">Total Denda</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (!empty($fines)): 
                    $no = 1;
                    foreach ($fines as $fine): 
                ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 text-center"><?= $no++; ?></td>
                        <td class="px-6 py-4 text-center"><?= htmlspecialchars($fine['username']); ?></td>
                        <td class="px-6 py-4 text-center text-red-600 font-bold">
                            Rp. <?= number_format($fine['total_fine'], 0, ',', '.'); ?>
                        </td>
                    </tr>
                <?php 
                    endforeach; 
                else: 
                ?>
                    <tr>
                        <td colspan="3" class="text-center py-4 text-gray-600">Tidak ada member dengan denda.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
