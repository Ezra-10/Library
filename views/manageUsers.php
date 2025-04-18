<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <?php require 'assets/header.php'; ?>

    <h1 class="text-3xl font-bold text-center mt-10">Manage Users</h1>

 
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="bg-green-500 text-white p-3 text-center my-4">
            <?= $_SESSION['success'];
            unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div class="container mx-auto mt-10">
   
        <table class="min-w-full bg-white border-collapse border border-gray-200">
            <thead>
                <tr>
                    <th class="border border-gray-200 p-4">ID</th>
                    <th class="border border-gray-200 p-4">Username</th>
                    <th class="border border-gray-200 p-4">Email</th>
                    <th class="border border-gray-200 p-4">Role</th>
                    <th class="border border-gray-200 p-4">Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="border border-gray-200 p-4"><?= $user['id'] ?></td>
                        <td class="border border-gray-200 p-4"><?= $user['username'] ?></td>
                        <td class="border border-gray-200 p-4"><?= $user['email'] ?></td>
                        <td class="border border-gray-200 p-4"><?= $user['role'] ?></td>
                        <td class="border border-gray-200 p-4"><?= $user['created_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    
        <h2 class="text-2xl font-bold mt-10">Add New User</h2>
        <form action="/admin/users/create" method="POST" class="mt-6 space-y-4">
            <input type="text" name="username" placeholder="Username" class="w-full p-3 border rounded">
            <input type="email" name="email" placeholder="Email" class="w-full p-3 border rounded">
            <input type="password" name="password" placeholder="Password" class="w-full p-3 border rounded">
            <select name="role" class="w-full p-3 border rounded">
                <option value="member">Member</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit" class="w-full p-3 bg-blue-600 text-white font-bold rounded">Create New User</button>
        </form>
    </div>

</body>

</html>