<?php
include "auth/db.php";

// Jika peran pengguna adalah 'admin', ambil beberapa data dari tabel tbl_tabungan_pelajar.
if ($_SESSION['role'] == 'admin') {
    $sql = "SELECT email, nama_lengkap, saldo, created_at, updated_at FROM tbl_tabungan_pelajar";

    // Jika peran pengguna adalah 'user', ambil beberapa data dari tabel tbl_tabungan_pelajar, 
    // berdasarkan kondisi email tertentu.
} else if ($_SESSION['role'] == 'user') {
    $sql = "SELECT email, nama_lengkap, saldo, created_at, updated_at FROM tbl_tabungan_pelajar WHERE email = :email";
}

$stmt = $conn->prepare($sql); // Persiapkan pernyataan SQL menggunakan koneksi $conn.

// Jika peran pengguna adalah 'user', ikat parameter :email dengan nilai $_SESSION['email'].
if ($_SESSION['role'] == 'user') {
    $stmt->bindParam(':email', $_SESSION['email']);
}

$stmt->execute(); // Jalankan pernyataan SQL yang sudah disiapkan.
$results = $stmt->fetchAll(PDO::FETCH_ASSOC); // Ambil semua hasil dari pernyataan SQL dan simpan dalam $results dengan format asosiatif array.

?>

<!-- Layout untuk tabungan pelajar -->

<div id="layoutSidenav_content">
    <main>

        <div class="container-fluid px-4">

            <div class="card mb-4 mt-5" id="printTableArea">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    <?php echo $_SESSION['role'] == 'user' ? 'Saldo Anda' : 'Saldo Semua Pelajar'; ?>
                </div>

                <div class="card-body">
                    <button type="button" class="btn btn-success mt-3 mb-3 cetakRekening"><i class="bi bi-printer-fill"></i> Cetak</button>
                    <div class="table-responsive">
                        <table class="dataTable text-center table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Email</th>
                                    <th>Saldo</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Tanggal Update</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($results as $data) : ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $data['email']; ?></td>
                                        <td><?php echo $data['saldo']; ?></td>
                                        <td><?php echo $data['created_at']; ?></td>
                                        <td><?php echo $data['updated_at']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- </Akhir layout tabungan pelajar -->