<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="flex justify-center items-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <h2 class="text-2xl font-bold mb-6 text-center">Register User</h2>

     
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="bg-red-500 text-white p-3 mb-4 text-center">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="bg-green-500 text-white p-3 mb-4 text-center">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form action="/register" method="POST" class="space-y-4">
            <input type="text" name="username" placeholder="Username" class="w-full p-3 border rounded" required>
            <input type="email" name="email" placeholder="Email" class="w-full p-3 border rounded" required>
            <input type="password" name="password" placeholder="Password" class="w-full p-3 border rounded" required>
            
            <select name="role" class="w-full p-3 border rounded" required>
                <option value="">Pilih Role</option>
                <option value="member">Member</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit" class="w-full p-3 bg-blue-600 text-white font-bold rounded">Register</button>
        </form>
    </div>
</div>

</body>
</html>
