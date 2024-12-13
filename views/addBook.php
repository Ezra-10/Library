<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
</head>
<body>

<h1>Tambah Buku</h1>

<?php if (isset($_SESSION['success'])): ?>
    <p style="color: green;"><?php echo $_SESSION['success']; ?></p>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<form action="/book/add" method="POST" enctype="multipart/form-data">
    <label for="title">Judul Buku</label><br>
    <input type="text" name="title" id="title" required><br><br>

    <label for="author">Pengarang</label><br>
    <input type="text" name="author" id="author" required><br><br>

    <label for="image">Upload Gambar Buku</label><br>
    <input type="file" name="image" id="image" accept="image/*"><br><br>

    <button type="submit">Tambah Buku</button>
</form>

</body>
</html>
