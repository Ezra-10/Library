<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <?php require 'assets/header.php'; ?>

    <div class="container mx-auto mt-10">
        <h1 class="text-4xl font-bold text-center mb-10">Admin Dashboard</h1>

        <div class="grid grid-cols-3 gap-10">
            <div class="bg-white p-8 shadow-md rounded-md">
                <h2 class="text-xl font-semibold mb-4">User Management</h2>
                <p>Manage users and roles in the system.</p>
                <a href="/admin/users" class="block mt-4 text-blue-600">Manage Users</a>
            </div>

            <div class="bg-white p-8 shadow-md rounded-md">
                <h2 class="text-xl font-semibold mb-4">Book Management</h2>
                <p>View and manage the book collection in the library.</p>
                <a href="/admin/books" class="block mt-4 text-blue-600">Manage Books</a>
            </div>

            <div class="bg-white p-8 shadow-md rounded-md">
                <h2 class="text-xl font-semibold mb-4">Loan Management</h2>
                <p>View and manage book loans, including tracking overdue loans and fines.</p>
                <a href="/admin/fines" class="block mt-4 text-blue-600">Manage Loans</a>
            </div>
        </div>
    </div>

</body>
</html>
