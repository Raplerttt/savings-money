<?php
session_start();

// Cek jika sudah login paksa pengguna ke halaman utama sesuai role masing masing
if (isset($_SESSION['login']) && isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    die();
} else if (isset($_SESSION['login']) && isset($_SESSION['user'])) {
    header("Location: ../user.php");
    die();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo (basename($_SERVER['PHP_SELF']) == 'login.php') ? 'Login' : 'Register'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: white;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1 text-white"><i class="bi bi-person-badge-fill"></i> <?php echo (basename($_SERVER['PHP_SELF']) == 'login.php') ? 'Login' : 'Register'; ?></span>
        </div>
    </nav>