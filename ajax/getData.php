<?php
session_start();
include "../auth/db.php";

// Jika peran pengguna adalah 'admin', ambil semua data dari tabel tbl_tabungan_pelajar.
if ($_SESSION['role'] == 'admin') {
    $sql = "SELECT id_tabungan, email, nama_lengkap, jenis_kelamin, kelas, angkatan, status, saldo 
    FROM tbl_tabungan_pelajar";

    // Jika peran pengguna adalah 'user', ambil data dari tabel tbl_tabungan_pelajar, 
    // berdasarkan kondisi email tertentu.
} else if ($_SESSION['role'] == 'user') {
    $sql = "SELECT id_tabungan, email, nama_lengkap, jenis_kelamin, kelas, angkatan, status, saldo 
     FROM tbl_tabungan_pelajar WHERE email = :email";
}

$stmt = $conn->prepare($sql); // Persiapkan pernyataan SQL menggunakan koneksi $conn.

// Jika peran pengguna adalah 'user', ikat parameter :email dengan nilai $_SESSION['email'].
if ($_SESSION['role'] == 'user') {
    $stmt->bindParam(':email', $_SESSION['email']);
}

$stmt->execute(); // Jalankan pernyataan SQL yang sudah disiapkan.
$results = $stmt->fetchAll(PDO::FETCH_ASSOC); // Ambil semua hasil dari pernyataan SQL dan simpan dalam $results dengan format asosiatif array.

?>

<div class="container-fluid px-4">

    <div class="card mb-4 mt-5">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            DataTable Tabungan Pelajar
        </div>

        <div class="card-body">
            <?php echo $_SESSION['role'] == 'admin' ? '<button type="button" class="btn btn-success mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#tambahPelajar"><i class="bi bi-plus-circle"></i> Tambah Data</button>' : ''; ?>
            <div class="table-responsive">
                <table class="dataTable text-center table table-bordered w-100">
                    <thead>
                        <tr>

                            <th class="d-none">-</th>
                            <th class="border-start flex-fill">No</th>
                            <th>Email</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Kelas</th>
                            <th>Angkatan</th>
                            <th>Status</th>
                            <th>Saldo</th>
                            <?php echo $_SESSION['role'] == 'admin' ? '<th>Aksi</th>' : ''; ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($results as $data) : ?>

                            <tr>
                                <td class="d-none"><?php echo $data['id_tabungan']; ?></td>
                                <td class="border-start"><?php echo $no++; ?></td>
                                <td><?php echo $data['email']; ?></td>
                                <td><?php echo $data['nama_lengkap']; ?></td>
                                <td><?php echo $data['jenis_kelamin']; ?></td>
                                <td><?php echo $data['kelas']; ?></td>
                                <td><?php echo $data['angkatan']; ?></td>
                                <td><span class="badge <?php echo $data['status'] == 'aktif' ? 'text-bg-success' : 'text-bg-danger'; ?>">
                                        <?php echo $data['status']; ?>
                                    </span></td>
                                <td><?php echo $data['saldo']; ?></td>
                                <?php if ($_SESSION['role'] == 'admin') { ?>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <?php
                                            // Variabel tombol delete dan update
                                            $button_delete = "<a class='btn btn-danger mb-1 mr-1 me-2 mt-3 deleteData' href='deleteData.php?id_tabungan=" . $data['id_tabungan'] . "'><i class='bi bi-trash'></i></a>";
                                            $button_update = "<a class='btn btn-warning text-white mb-1 mt-3 updateData' data-bs-toggle='modal' data-bs-target='#updatePelajar' href='updateData.php?id_tabungan=" . $data['id_tabungan'] . "'><i class='bi bi-pencil'></i></a>";
                                            ?>
                                            <?php echo "$button_delete $button_update"; ?>
                                        </div>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.dataTable').DataTable();
    });
</script>
</body>

</html>