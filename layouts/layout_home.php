<?php

// cek jika berhasil setelah login
if (isset($_SESSION['success_login'])) {

    // beri pesan 
    echo "<script>
    Swal.fire(
        'BERHASIL LOGIN',
        'Selamat datang pada aplikasi tabungan sekolah.',
        'success'
    )
    </script>";

    // hapus session success login
    unset($_SESSION['success_login']);
}
?>

<!-- Layout untuk home admin dan user -->

<?php if ($_SESSION['role'] == 'user') { ?>

    <!-- Modal ganti password untuk role user-->
    <div class="modal fade" id="gantiPassword" tabindex="-1" aria-labelledby="gantiPassword" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="gantiPassword">Ganti Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <!-- Form ganti password -->
                    <form method="post" id="form_ganti_password">

                        <div class="mb-3">
                            <label for="password_baru" class="form-label">Password Baru</label>
                            <input type="text" class="form-control" id="password_baru" name="password_baru" autocomplete="off" required />
                        </div>

                        <div class="mb-3">
                            <label for="konfirmasi_password" class="form-label">Konfirmasi Password Baru</label>
                            <input type="text" class="form-control" id="konfirmasi_password" name="konfirmasi_password" autocomplete="off" required />
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success" name="submit_password">Ganti</button>
                        </div>
                    </form>
                    <!-- Akhir form ganti password-->

                </div>
            </div>
        </div>
    </div>
    <!-- </Akhir modal ganti password untuk role user-->

    <!-- Modal ganti foto profile untuk role user-->
    <div class="modal fade hidden-profile-pelajar" id="gantiFoto" tabindex="-1" aria-labelledby="gantiFoto" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="gantiFoto">Ganti Foto Profile</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <!-- Form ganti foto profile -->
                    <form method="post" id="form_ganti_foto_profile" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label class="form-label" for="foto_profile">Upload</label>
                            <input type="file" class="form-control" id="foto_profile" name="foto_profile" accept="image/jpeg, image/png" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success" name="ganti_foto_profile">Ganti</button>
                        </div>
                    </form>
                    <!-- Akhir form ganti foto profile-->

                </div>
            </div>
        </div>
    </div>
    <!-- </Akhir modal ganti foto profile untuk role user-->

<?php } ?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4 mb-3">
            <div class="row mt-5">
                <div class="col-lg-8 order-md-1 mx-auto">

                    <!-- Form info login -->
                    <form method="post">
                        <div class="card mb-4 border-dark bg-opacity-75 ">

                            <!-- Body admin dan user card -->
                            <div class="card-body bg-dark bg-opacity-75 text-white">Info Login</div>
                            <div class="card-footer align-items-center justify-content-between bg-white">

                                <!--  Email  -->
                                <div class="mb-3 mt-4">
                                    <label class="form-label ms-3 mt-2">Email :</label>
                                    <input type="email" class="form-control w-75 float-end me-5 mt-2" value="<?php echo (isset($_SESSION['email'])) ? $_SESSION['email'] : ''; ?>" disabled />
                                </div>
                                <!-- </Akhir email -->

                                <!--  Nama  -->
                                <div class="mb-3 mt-4">
                                    <label class="form-label ms-3 mt-2">Nama :</label>
                                    <input type="text" class="form-control w-75 float-end me-5 mt-2" value="<?php echo (isset($_SESSION['nama_lengkap'])) ? $_SESSION['nama_lengkap'] : ''; ?>" disabled />
                                </div>
                                <!-- </Akhir nama -->

                            </div>
                            <!-- </Akhir body dokter dan user card -->

                            <!-- Role user -->
                            <?php if ($_SESSION['role'] == 'user') { ?>
                                <div class="mt-3 mb-3 ms-3 d-flex">
                                    <!-- Button ganti password untuk role user -->
                                    <div class="me-auto">
                                        <button type="button" class="btn btn-danger fw-bold text-white" data-bs-toggle="modal" data-bs-target="#gantiPassword"><i class="bi bi-shield-lock"></i> Ganti Password</button>
                                    </div>
                                    <!-- Akhir button ganti password untuk role user -->

                                    <!-- Button foto profile untuk role user -->
                                    <div class="ms-auto me-3">
                                        <button type="button" class="btn btn-primary fw-bold text-white" data-bs-toggle="modal" data-bs-target="#gantiFoto"><i class="bi bi-person-bounding-box"></i> Ganti Foto Profile</button>
                                    </div>
                                    <!-- Akhir button foto profile untuk role user -->
                                </div>

                            <?php } ?>
                            <!-- </Akhir role user -->

                        </div>
                    </form>
                    <!-- </Akhir form info login -->

                </div>
            </div>
        </div>
    </main>
</div>

<!-- </Akhir layout home admin dan user -->

<!-- Php Script -->
<?php

// Memeriksa apakah form telah disubmit, metode permintaan adalah POST, dan peran pengguna adalah 'user' sebelum melanjutkan dengan proses penggantian password.
if (isset($_POST['submit_password']) && $_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['role'] == 'user') {

    // Mengambil nilai password baru dan konfirmasi password dari data yang dikirimkan melalui form.
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    // Meng-hash password baru menggunakan fungsi `password_hash()` dengan algoritma default yang disediakan oleh PHP.
    $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);

    // Menampilkan pesan error jika konfirmasi password tidak sesuai dengan password baru yang dimasukkan.
    if ($password_baru !== $konfirmasi_password) {

        echo "
        <script>
        Swal.fire(
            'GAGAL',
            'Konfirmasi password tidak sesuai. Password gagal di ganti.',
            'error'
          )
          </script>";
    } else {

        include "auth/db.php";

        // Menyiapkan pernyataan SQL untuk melakukan pembaruan password berdasarkan email pengguna yang sedang aktif.
        $sql = "UPDATE tbl_auth SET password = :password WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':email', $_SESSION['email']);

        // Execute query dan menampilkan pesan sukses jika pembaruan password berhasil dilakukan lalu tutup koneksi.
        if ($stmt->execute()) {

            tutupKoneksi($conn);
            echo "
            <script>
            Swal.fire(
                'BERHASIL',
                'Password berhasil di ganti.',
                'success'
              )
              </script>";

            // Menampilkan pesan error jika pembaruan password gagal dilakukan dan tutup koneksi.
        } else {

            tutupKoneksi($conn);
            echo "
            <script>
            Swal.fire(
                'GAGAL',
                'Password gagal di ganti. Silakan coba lagi.',
                'error'
              )
              </script>";
        }
    }
}
?>
<!-- </Akhir php script -->