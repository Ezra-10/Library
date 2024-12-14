<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  
    <?php require 'assets/header.php'; ?>

    <div class="container mx-auto mt-10">
        <h1 class="text-4xl font-bold text-center mb-10">Tambah Buku Baru</h1>


        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-500 text-white p-4 rounded-md mb-4">
                <?= $_SESSION['success']; ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

       
        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-500 text-white p-4 rounded-md mb-4">
                <?= $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="/upload/addBook" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-md shadow-md">
        
            <div class="mb-6">
                <label for="title" class="block text-gray-700 font-bold mb-2">Judul Buku</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="Masukkan judul buku" 
                    required
                >
            </div>

           
            <div class="mb-6">
                <label for="author" class="block text-gray-700 font-bold mb-2">Penulis</label>
                <input 
                    type="text" 
                    id="author" 
                    name="author" 
                    class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="Masukkan nama penulis" 
                    required
                >
            </div>

          
            <div class="mb-6">
                <label for="image" class="block text-gray-700 font-bold mb-2">Gambar Buku</label>
                <input 
                    type="file" 
                    id="image" 
                    name="image" 
                    accept="image/*"
                    class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
            </div>

           
            <div class="flex justify-end">
                <button 
                    type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-md transition-all duration-300"
                >
                    Tambah Buku
                </button>
            </div>
        </form>
    </div>

</body>
</html>
