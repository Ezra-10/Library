<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library App - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow-md py-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/home" class="text-2xl font-bold text-blue-600">Perpustakaan App</a>
            <ul class="flex space-x-6">
                <li><a href="/home" class="hover:text-blue-600">Home</a></li>

                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li><a href="/admin/users" class="hover:text-blue-600">Manage Users</a></li>
                    <li><a href="/admin/books" class="hover:text-blue-600">Manage Books</a></li>
                <?php else: ?>
                    <li><a href="/catalog" class="hover:text-blue-600">Catalog</a></li>
                    <li><a href="/borrowed" class="hover:text-blue-600">My Borrowed Books</a></li>
                    <li><a href="/loan" class="hover:text-blue-600">Loan</a></li>
                    <li><a href="/return" class="hover:text-blue-600">Return</a></li>
                <?php endif; ?>

                <li><a href="/logout" class="hover:text-blue-600">Logout</a></li>
            </ul>
        </div>
    </nav>

</body>
</html>
