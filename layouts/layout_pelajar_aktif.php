<?php
include "auth/db.php";
$sql = "SELECT * FROM tbl_tabungan_pelajar WHERE status = 'aktif'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Layout untuk tabungan pelajar aktif -->

<div id="layoutSidenav_content">
    <main>

        <div class="container-fluid px-4">

            <div class="card mb-4 mt-5">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    DataTable User Aktif
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="dataTable text-center table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Email</th>
                                    <th>Nama Lengkap</th>
                                    <th>Status</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($results as $data) : ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $data['email']; ?></td>
                                        <td><?php echo $data['nama_lengkap']; ?></td>
                                        <td><span class="badge text-bg-success">
                                                <?php echo $data['status']; ?>
                                            </span></td>
                                        <td><?php echo $data['saldo']; ?></td>
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

<!-- </Akhir layout tabungan pelajar aktif -->