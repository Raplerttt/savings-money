  <?php

    // Mengecek apakah variabel $_POST['register'] sudah di-set atau belum
    if (isset($_POST['register'])) {

        function securityInput($data)
        {
            $data = trim($data); // Menghapus spasi di awal dan akhir string
            $data = strip_tags($data); // Mengonversi karakter khusus menjadi entitas HTML untuk mencegah serangan HTMl injection
            $data = strtolower($data); // Mengonversi string menjadi kecil semua
            $data = stripslashes($data); // Menghapus karakter backslash (\)
            $data = htmlspecialchars($data); // Mengonversi karakter khusus menjadi entitas HTML untuk mencegah serangan XSS
            return $data;
        }

        // Mengambil data nama lengkap, email dan password dari form register
        $nama_lengkap = securityInput($_POST['nama_lengkap']);
        $email = $_POST['email'];
        $password = htmlspecialchars($_POST['password']);

        // Id role untuk user
        $id_role = 1;

        // Meng-hash password dengan algoritma default
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Query untuk mencari apakah email sudah ada di database
        $sql = "SELECT * FROM tbl_auth WHERE email = :email";
        $stmt_check = $conn->prepare($sql);
        $stmt_check->bindParam(":email", $email);
        $stmt_check->execute();
        $result = $stmt_check->fetchAll(PDO::FETCH_ASSOC);

        // Jika hasil query menghasilkan lebih dari 0 baris, artinya email sudah ada di database
        if ($stmt_check->rowCount() > 0) {

            // Panggil fungsi tutupKoneksi() untuk menutup koneksi ke database, dan tampilkan pesan error dengan menggunakan library Swal
            tutupKoneksi($conn);
            echo "<script>
        Swal.fire(
            'GAGAL',
            'Maaf proses register Anda gagal di lakukan.',
            'error'
        )
        </script>";

            // Jika email dan password belum ada di database
        } else {

            $conn->beginTransaction(); // Memulai transaction

            // Lakukan query insert pada tbl_auth
            $stmt_insert = $conn->prepare("INSERT INTO tbl_auth (nama_lengkap, email, password, id_role) VALUES 
                        (:nama_lengkap, :email, :password, :id_role)");
            $stmt_insert->bindParam(":nama_lengkap", $nama_lengkap);
            $stmt_insert->bindParam(":email", $email);
            $stmt_insert->bindParam(":password", $password_hash);
            $stmt_insert->bindParam(":id_role", $id_role);

            // Cek jika berhasil di eksekusi
            if ($stmt_insert->execute()) {
                $last_inserted_id = $conn->lastInsertId(); // Mendapatkan ID terakhir yang di-generate

                // Insert tabel kedua pada tbl_profiles
                $stmt_profile = $conn->prepare("INSERT INTO tbl_profiles (id_profile, email, foto_profile) 
                        VALUES(:id_profile, :email, 'user.jpg')");
                $stmt_profile->bindParam(":id_profile", $last_inserted_id);
                $stmt_profile->bindParam(":email", $email);
                $stmt_profile->execute();

                $conn->commit(); // Commit transaction jika semua pernyataan berhasil dieksekusi

                // Tutup koneksi
                tutupKoneksi($conn);

                // Gunakan session
                $_SESSION['success'] = true;
                $_SESSION['nama_lengkap'] = $nama_lengkap;
                $_SESSION['email_register'] = $email;
                $_SESSION['password_register'] = $password;
                header('Location: login.php');
            } else {
                $conn->rollBack(); // Rollback transaction jika ada pernyataan yang gagal dieksekusi
            } 
        }
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

                          <!-- Icon register -->
                          <div class="mb-5 text-center"><i class="bi bi-person-circle" style="font-size: 40px;"></i></div>
                          <!-- </Akhir icon register -->

                          <!-- Form -->
                          <form method="post" action="">

                              <!-- Nama lengkap -->
                              <div class="mb-4">
                                  <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
                                  <input type="text" id="nama_lengkap" class="form-control" name="nama_lengkap" maxlength="50" autocomplete="off" required />
                              </div>
                              <!-- </Akhir nama lengkap -->

                              <!-- Email -->
                              <div class="mb-4">
                                  <label class="form-label" for="email">Email</label>
                                  <input type="email" id="email" class="form-control" name="email" autocomplete="off" required />

                              </div>
                              <!-- </Akhir email -->

                              <!-- Password -->
                              <div class="mb-4">
                                  <label class="form-label" for="password">Password</label>
                                  <input type="password" id="password" class="form-control" name="password" required />
                              </div>
                              <!-- </Akhir password -->

                              <!-- Tombol register -->
                              <div class="text-center">
                                  <button class="btn btn-dark w-75 text-center rounded-pill" type="submit" name="register">Register</button>
                              </div>
                              <!-- </Akhir tombol register -->

                          </form>
                          <!-- </Akhir form -->

                          <!-- Garis -->
                          <hr class="my-4">
                          <!-- </Akhir garis -->

                          <!-- Kembali ke login -->
                          <div class="text-center">
                              <a href="login.php">Kembali</a>
                          </div>
                          <!-- </Akhir kembali ke login -->

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