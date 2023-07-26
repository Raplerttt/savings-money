<?php

// Koneksi database menggunakan PDO PHP
$servername = "localhost";
$username = "root";
$password = "";

$conn = new PDO("mysql:host=$servername;dbname=db_tasek", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


function tutupKoneksi($conn)
{
    $conn = null;
}
