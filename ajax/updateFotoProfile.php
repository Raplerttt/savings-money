<?php
session_start();

include "../auth/db.php";

//Cek jika request nya itu POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    // Mendapatkan informasi gambar yang akan dihapus sebagai gambar lama berdasarkan email
    $stmtSelect = $conn->prepare("SELECT foto_profile FROM tbl_profiles WHERE email = :email");
    $stmtSelect->bindParam(':email', $_SESSION['email']);
    $stmtSelect->execute();
    $rowImage = $stmtSelect->fetch(PDO::FETCH_ASSOC);
    $imageLegacy = $rowImage['foto_profile'];

    // Lokasi penyimpanan file yang diunggah
    $targetDir = '../img/';

    // Mendapatkan informasi file yang diunggah
    $fileName = $_FILES['foto_profile']['name'];
    $fileTmpName = $_FILES['foto_profile']['tmp_name'];
    $fileSize = $_FILES['foto_profile']['size'];
    $fileType = $_FILES['foto_profile']['type'];

    // Mengecek ukuran file (maksimal 1 MB)
    $maxFileSize = 1024 * 1024; // 1 MB dalam bytes

    // Mendapatkan ekstensi file
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Mengecek ekstensi file yang diunggah
    $allowedExtensions = ['jpg', 'jpeg', 'png'];

    // Mengecek tipe MIME file yang diunggah
    $allowedMimeTypes = ['image/jpeg', 'image/png'];

    // Cek jika file yang di unggah bukan ektensi jpg, jpeg , png
    if (!in_array($fileExtension, $allowedExtensions)) {

        // Beri response
        $response = array(
            'success' => false,
            'message' => 'Hanya file JPG dan PNG yang diizinkan.'
        );
        echo json_encode($response);

        // Cek jika file yang di unggah lebih besar dari 1 MB
    } else if ($fileSize > $maxFileSize) {

        // Beri response
        $response = array(
            'success' => false,
            'message' => 'Ukuran file terlalu besar. Maksimal 1 MB.'
        );
        echo json_encode($response);

        // Cek jika MIME nya bukan image/jpeg, image/png
    } else if (!in_array($fileType, $allowedMimeTypes)) {

        // Beri response
        $response = array(
            'success' => false,
            'message' => 'Tipe file yang diunggah tidak valid.'
        );
        echo json_encode($response);
    } else {

        // Generate nama file unik
        $uniqueFileName = uniqid() . '.' . $fileExtension;

        // Cek dan hapus gambar lama berdasarkan email pada statement select query
        if (unlink($imageLegacy)) {

            //  Perbaharui gambar yang telah terupload dan pindahkan folder img
            $targetPath =  $targetDir . $uniqueFileName;
            if (move_uploaded_file($fileTmpName, $targetPath)) {

                // Menyiapkan pernyataan SQL update dengan menggunakan parameter placeholder
                $stmt = $conn->prepare("UPDATE tbl_profiles SET foto_profile = :foto_profile WHERE email = :email");

                // Mengikat nilai-nilai ke parameter-placeholder
                $stmt->bindParam(':foto_profile', $targetPath);
                $stmt->bindParam(':email', $_SESSION['email']);


                if ($stmt->execute()) {
                    $response = array(
                        'success' => true,
                        'message' => 'Foto profile Anda berhasil di ganti.'
                    );
                    echo json_encode($response);
                } else {
                    $response = array(
                        'success' => false,
                        'message' => 'Terjadi kesalahan saat mengganti foto profile.'
                    );
                    echo json_encode($response);
                }
            }
        }

        // Tutup koneksi
        tutupKoneksi($conn);
    }
}
