<?php
$host = 'localhost';
$user = 'root';
$pass = '';

$db = 'library';

$conn = new mysqli($host, $user, $pass, $db);

if($conn->connect_error){
    die("connection failed: ". $conn->connect_error);
}
?>