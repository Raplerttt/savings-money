<?php

// Cek jika role user sudah login dan berusaha masuk ke halaman pelajar aktif ataupun tidak aktif 
// Yang seharusnya hanya di ijinkan oleh role admin
if (
    isset($_SESSION['user']) && basename($_SERVER['PHP_SELF']) == 'pelajar_aktif.php'
    || isset($_SESSION['user']) && basename($_SERVER['PHP_SELF']) == 'pelajar_tidak_aktif.php'
) {

    // Paksa ke halaman user
    header("Location: user.php");
    die();
}

// Function layout apps
function layoutApps()
{
    // Jika file saat ini adalah 'index.php'
    if (basename($_SERVER['PHP_SELF']) == 'index.php') {
        // Memasukkan file 'layout_home.php'
        include "layouts/layout_home.php";

        // Jika file saat ini adalah 'user.php'
    } else if (basename($_SERVER['PHP_SELF']) == 'user.php') {
        // Memasukkan file 'layout_home.php'
        include "layouts/layout_home.php";

        // Jika file saat ini adalah 'tabungan_pelajar.php'
    } else if (basename($_SERVER['PHP_SELF']) == 'tabungan_pelajar.php') {

        // Memasukkan file 'layout_tabungan_pelajar.php'
        include "layouts/layout_tabungan_pelajar.php";

        // Jika file saat ini adalah 'pelajar_aktif.php'
    } else if (basename($_SERVER['PHP_SELF']) == 'pelajar_aktif.php') {
        // Memasukkan file 'layout_pelajar_aktif.php'
        include "layouts/layout_pelajar_aktif.php";

        // Jika file saat ini adalah 'pelajar_tidak_aktif.php'
    } else if (basename($_SERVER['PHP_SELF']) == 'pelajar_tidak_aktif.php') {

        // Memasukkan file 'layout_pelajar_tidak_aktif.php'
        include "layouts/layout_pelajar_tidak_aktif.php";

        // Jika file saat ini adalah 'cetak_rekening.php'
    } else if (basename($_SERVER['PHP_SELF']) == 'cetak_rekening.php') {

        // Memasukkan file 'layout_cetak_rekening.php'
        include "layouts/layout_cetak_rekening.php";
    }
}

?>

<!-- Sidebar -->
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">

                    <!-- Foto profile saat ini -->
                    <?php if ($_SESSION['role'] == 'admin') { ?>
                        <img src="<?php echo $_SESSION['foto_profile']; ?>" class="rounded mx-auto d-block mb-1 mt-4 rounded-circle" style="background-color: white;" height="75px;">
                    <?php } else if ($_SESSION['role'] == 'user') { ?>

                        <div id="fotoProfile"></div>

                    <?php } ?>

                    <!-- Informasi login -->
                    <div class="sb-sidenav-menu-heading">Informasi Login</div>
                    <a class="nav-link" href="<?php echo $_SESSION['role'] == 'admin' ? 'index.php' : 'user.php'; ?>">
                        <div class="sb-nav-link-icon"><i class="bi bi-person-vcard-fill"></i></div>
                        <?php echo $_SESSION['role'] == 'admin' ? 'Admin' : 'User'; ?>
                    </a>
                    <!-- </Akhir informasi login -->

                    <!-- Role admin-->
                    <?php if ($_SESSION['role'] == 'admin') { ?>

                        <!-- Menu data pelajar untuk role admin-->
                        <div class="sb-sidenav-menu-heading">Data Pelajar</div>
                        <a class="nav-link" href="tabungan_pelajar.php">
                            <div class="sb-nav-link-icon"><i class="bi bi-file-person-fill"></i></div>
                            Tabungan Pelajar
                        </a>
                        <a class="nav-link" href="pelajar_aktif.php">
                            <div class="sb-nav-link-icon"><i class="bi bi-person-check-fill"></i></div>
                            Pelajar Aktif
                        </a>
                        <a class="nav-link" href="pelajar_tidak_aktif.php">
                            <div class="sb-nav-link-icon"><i class="bi bi-person-fill-dash"></i></div>
                            Pelajar Tidak Aktif
                        </a>
                        <!-- </Akhir menu data pelajar -->

                        <!-- Menu Laporan -->
                        <div class="sb-sidenav-menu-heading">Laporan</div>
                        <a class="nav-link" href="cetak_rekening.php">
                            <div class="sb-nav-link-icon"><i class="bi bi-printer-fill"></i></div>
                            Cetak Saldo Pelajar
                        </a>
                        <!-- </Akhir menu laporan -->
                    <?php } ?>
                    <!-- </Akhir role admin-->

                    <!-- Role user-->
                    <?php if ($_SESSION['role'] == 'user') { ?>

                        <!-- Menu data pelajar untuk role user-->
                        <div class="sb-sidenav-menu-heading">Data Pelajar</div>

                        <a class="nav-link" href="tabungan_pelajar.php">
                            <div class="sb-nav-link-icon"><i class="bi bi-file-person-fill"></i></div>
                            Tabungan Anda
                        </a>
                        <!-- </Akhir menu data pelajar untuk role user-->

                        <!-- Menu Laporan -->
                        <div class="sb-sidenav-menu-heading">Laporan</div>
                        <a class="nav-link" href="cetak_rekening.php">
                            <div class="sb-nav-link-icon"><i class="bi bi-printer-fill"></i></div>
                            Cetak Saldo Anda
                        </a>
                        <!-- </Akhir menu laporan -->

                    <?php } ?>
                    <!-- </Akhir role user-->

                </div>
            </div>
        </nav>
    </div>
    <?php

    // Panggil function layout apps
    layoutApps();
    ?>
</div>
<!-- </Akhir sidebar -->