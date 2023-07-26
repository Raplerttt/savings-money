<?php

// cek apakah tombol login telah diklik
if (isset($_POST['login'])) {

    // mendapatkan nilai input dari form login
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Melakukan dan mengambil data admin atau user yang login dari tabel database
    $sql = "SELECT * FROM tbl_auth a 
    INNER JOIN tbl_roles b ON a.id_role = b.id_role
    INNER JOIN tbl_profiles c ON a.email = c.email
    WHERE a.email = :email AND a.nama_lengkap = :nama_lengkap";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":nama_lengkap", $nama_lengkap);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // memeriksa apakah email dan nama lengkap valid
    if ($result) {

        // memeriksa apakah password yang dimasukkan sesuai dengan password di database
        if (password_verify($password, $result['password'])) {

            // menyimpan nilai pada session untuk mengidentifikasi admin dan user yang telah login
            $_SESSION['email'] = $result['email'];
            $_SESSION['nama_lengkap'] = $result['nama_lengkap'];
            $_SESSION['role'] = $result['role'];
            $_SESSION['login'] = true;
            $_SESSION['success_login'] = true;

            // mengatur waktu kadaluarsa cookie 2 hari
            $expire = time() + (2 * 24 * 60 * 60);
            setcookie('tasek_', hash('sha512', 'app_tasek'), $expire, '/');

            // Cek jika yang login itu role nya adalah admin 
            if ($result["role"] === "admin") {

                // Berikan session admin
                $_SESSION['foto_profile'] = $result['foto_profile'];
                $_SESSION['admin'] = 'admin';

                // tutup koneksi database
                tutupKoneksi($conn);

                // Alihkan ke halaman aplikasi untuk admin
                header("Location: ../index.php");

                // Cek jika yang login itu role nya adalah user
            } else if ($result["role"] === "user") {

                // Berikan session user
                $_SESSION['foto_profile'] = $result['foto_profile'];
                $_SESSION['user'] = 'user';

                // tutup koneksi database
                tutupKoneksi($conn);

                // Alihkan ke halaman aplikasi untuk user
                header("Location: ../user.php");
            }

            // Memeriksa dan cek jika password salah 
        } else {

            // tutup koneksi database
            tutupKoneksi($conn);

            // menampilkan pesan error jika password yang dimasukkan salah
            echo "<script>
        Swal.fire(
            'GAGAL',
            'Maaf password yang Anda masukkan salah. Silakan coba lagi.',
            'error'
        )
        </script>";
        }

        // Cek jika email dan nama lengkap tidak valid maupun tidak terdaftar di database
    } else {

        // tutup koneksi database
        tutupKoneksi($conn);

        // tampilkan pesan error 
        echo "<script>
        Swal.fire(
            'GAGAL',
            'Maaf login Anda tidak valid. Silakan coba lagi.',
            'error'
        )
        </script>";
    }
}

// cek jika register berhasil
if (isset($_SESSION['success'])) {

    // beri pesan ke pengguna
    echo "<script>
    Swal.fire(
        'BERHASIL!',
        'Proses register berhasil. Silakan login terlebih dahulu.',
        'success'
    )
    </script>";

    // hapus session success register
    unset($_SESSION['success']);
}
?>

<!-- Section -->
<section class="vh-100">

    <!-- Container -->
    <div class="container h-100">

        <!-- Row -->
        <div class="row d-flex justify-content-center align-items-center h-100">

            <!-- Col -->
            <div class="col-12 col-md-8 col-lg-6 col-xl-5 mt-4">

                <!-- Card -->
                <div class="card shadow-lg p-3 mb-5 bg-body rounded" style="border: 2px solid white;">

                    <!-- Card body -->
                    <div class="card-body p-5">

                        <!-- Icon login -->
                        <div class="mb-5 text-center"><i class="bi bi-person-circle" style="font-size: 40px;"></i></div>
                        <!-- </Akhir icon login -->

                        <!-- Form -->
                        <form method="post" action="">

                            <!-- Nama Lengkap -->
                            <div class="mb-4">
                                <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
                                <input type="text" id="nama_lengkap" class="form-control" name="nama_lengkap" autocomplete="off" value="<?php echo (isset($_SESSION['nama_lengkap'])) ? $_SESSION['nama_lengkap'] : ''; ?>" required />
                            </div>
                            <!-- </Akhir nama lengkap -->

                            <!-- Email -->
                            <div class="mb-4">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" id="email" class="form-control" name="email" autocomplete="off" value="<?php echo (isset($_SESSION['email_register'])) ? $_SESSION['email_register'] : ''; ?>" required />
                            </div>
                            <!-- </Akhir email -->

                            <!-- Password -->
                            <div class="mb-4">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" id="password" class="form-control" name="password" value="<?php echo (isset($_SESSION['password_register'])) ? $_SESSION['password_register'] : ''; ?>" required />
                            </div>
                            <!-- </Akhir password -->

                            <!-- Tombol login -->
                            <div class="text-center">
                                <button class="btn btn-dark w-75 text-center rounded-pill" type="submit" name="login">Login</button>
                            </div>
                            <!-- </Akhir tombol login -->

                        </form>
                        <!-- </Akhir form -->

                        <!-- Garis -->
                        <hr class="my-4">
                        <!-- </Akhir garis -->

                        <!-- Belum registrasi -->
                        <div class="text-center">
                            <a href="register.php">Register</a>
                        </div>
                        <!-- </Akhir belum registrasi -->

                    </div>
                    <!-- </Akhir card body -->

                </div>
                <!-- </Akhir card -->

            </div>
            <!-- </Akhir col -->

        </div>
        <!-- </Akhir row -->

    </div>
    <!-- </Akhir container -->

</section>
<!-- </Akhir section -->