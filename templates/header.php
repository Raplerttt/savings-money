<?php
session_start();

// Cek jika belum login redirect ke halaman login
if (!isset($_SESSION['login'])) {
    header("Location: auth/login.php");
    die();

    // Cek jika role admin sudah login dan berusaha masuk ke halaman user tanpa authentication itu valid
} else if (isset($_SESSION['admin']) && basename($_SERVER['PHP_SELF']) == 'user.php') {

    // Paksa ke halaman index
    header("Location: index.php");
    die();

    // Cek jika role user sudah login dan berusaha masuk ke halaman admin tanpa authentication itu valid
} else if (isset($_SESSION['user']) && basename($_SERVER['PHP_SELF']) == 'index.php') {

    // Paksa ke halaman user
    header("Location: user.php");
    die();

    // Jika berhasil masuk beri session regenerate id
} else {
    session_regenerate_id();
}

// FUnction judul dinamis
function DynamicTitle()
{
    // Cek jika saat ini file nya adalah index.php atau user.php
    if (basename($_SERVER['PHP_SELF']) == 'index.php' || basename($_SERVER['PHP_SELF']) == 'user.php') {

        // Berikan judul home
        echo "Home";

        // Cek jika saat ini file nya adalah tabungan_pelajar.php
    } else if (basename($_SERVER['PHP_SELF']) == 'tabungan_pelajar.php') {

        // Berikan judul tabungan pelajar
        echo "Tabungan Pelajar";

        // Cek jika saat ini file nya adalah pelajar_aktif.php
    } else if (basename($_SERVER['PHP_SELF']) == 'pelajar_aktif.php') {

        // Berikan judul pelajar aktif
        echo "Pelajar Aktif";

        // Cek jika saat ini file nya adalah pelajar_tidak_aktif.php
    } else if (basename($_SERVER['PHP_SELF']) == 'pelajar_tidak_aktif.php') {

        // Berikan judul pelajar tidak aktif
        echo "Pelajar Tidak Aktif";

        // Cek jika saat ini file nya adalah cetak_rekening.php
    } else if (basename($_SERVER['PHP_SELF']) == 'cetak_rekening.php') {

        // Berikan judul cetak rekening
        echo "Cetak Rekening";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?php DynamicTitle(); ?></title>
    <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Layout untuk cetak rekening */
        @media print {

            @page {
                margin-top: 0;
                margin-bottom: 0;
            }

            body,
            html,
            #wrapper {
                width: 100%;
            }

            #layoutSidenav_nav,
            .navbar-brand,
            .cetakRekening {
                display: none;
            }
        }

        div.dataTables_length,
        div.dataTables_filter {
            padding: 10px;
        }
    </style>
</head>

<body class="sb-nav-fixed">

    <!-- Navbar-->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3 fw-semibold" href="#"> <i class="bi bi-wallet2"></i> Mari Menabung </a>

        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <div class="d-none d-md-inline-block ms-auto me-0 me-md-3 my-2 my-md-0"> </div>
        <!-- </Akhir sidebar toggle -->

        <!-- Dropdown -->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                    <li><a class="dropdown-item" href="auth/logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
        <!-- </Akhir dropdown -->
    </nav>

    <!-- </Akhir navbar -->