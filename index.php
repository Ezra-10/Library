<?php

session_start();  // Pastikan session dimulai

// Definisikan keamanan akses
define('SECURE_ACCESS', true);

// Ambil URL path tanpa query string
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// Ambil query string jika ada
$query_string = $_SERVER["QUERY_STRING"] ?? null;

// Inisialisasi koneksi ke database
try {
    $db = new PDO('mysql:host=localhost;dbname=library', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi ke database gagal: " . $e->getMessage());
}

// Halaman yang perlu proteksi (hanya bisa diakses jika login)
$protectedRoutes = ['/', '/book', '/admin_dashboard.php', '/member_dashboard.php'];

if (in_array($uri, $protectedRoutes) && !isset($_SESSION['user_id'])) {
    // Jika user belum login dan mencoba akses halaman dilindungi
    header('Location: /login');
    exit();
}

// Routing menggunakan switch case
switch ($uri) {
    case '/home':
        session_start();
        require 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index($db);
        break;

    case '/book':
        require 'controllers/BookController.php';
        break;

    case '/login':
        require 'controllers/LoginController.php';
        $controller = new LoginController($db);
        $controller->index();
        break;

    case '/admin/users':
        if ($_SESSION['role'] !== 'admin') {
            die('Access denied');
        }
        require 'controllers/UserManagementController.php';
        $controller = new UserManagementController($db);
        $controller->index();
        break;

    case '/admin/users/create':
        if ($_SESSION['role'] !== 'admin') {
            die('Access denied');
        }
        require 'controllers/UserManagementController.php';
        $controller = new UserManagementController($db);
        $controller->createUser();
        break;

    case '/admin/fines':
        require 'controllers/AdminController.php';
        $controller = new AdminController($db);
        $controller->viewMemberFines();
        break;

    case '/register':
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /login');
            exit();
        }
        require 'controllers/RegisterController.php';
        $controller = new RegisterController();
        $controller->index($db);
        break;


    case '/loan':
        require 'controllers/LoanController.php';
        $controller = new LoanController($db);
        $controller->index();
        break;

    case '/loan/borrow':
        require 'controllers/LoanController.php';
        $controller = new LoanController($db);
        $controller->borrow();
        break;

    case '/loan/return':
        require 'controllers/LoanController.php';
        $loan_id = $_POST['loan_id']; // Ambil ID pinjaman
        $controller = new LoanController($db);
        $controller->returnBook($loan_id);
        break;

    case '/admin/loans':
        require 'controllers/AdminController.php';
        $controller = new AdminController($db);
        $controller->viewMemberLoans();
        break;


    case '/return':
        require 'controllers/ReturnController.php';
        $controller = new ReturnController($db);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->returnBook($_POST['loan_id']);
        } else {
            $controller->index();
        }
        break;

    case '/return/returnBook':
        require 'controllers/ReturnController.php';
        $controller = new ReturnController($db);
        $controller->returnBook($_GET['id']);
        break;

    case '/borrowed':
        require 'controllers/BorrowedBooksController.php';
        $controller = new BorrowedBooksController();
        $controller->index($db, $_SESSION['user_id']);
        break;

    case '/book/add':
        require 'controllers/UploadController.php';
        $controller = new UploadController($db);
        $controller->addBook();
        break;


 
case '/admin/fines':
    require 'controllers/AdminController.php';
    $controller = new AdminController($db);
    $controller->viewMemberFines();
    break;


case '/admin/pay-fine':
    require 'controllers/AdminController.php';
    $controller = new AdminController($db);
    $controller->payFine();
    break;



    case '/logout':
        session_start();
        session_destroy();
        header('Location: /login');
        exit();




    default:
        require 'views/notFoundPage.php';
        break;
}
