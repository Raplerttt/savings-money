<?php
include '../auth/db.php';

// Cek jika request nya itu POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Function security input
    function securityInput($data)
    {
        $data = trim($data); // Menghapus spasi di awal dan akhir string
        $data = stripslashes($data); // Menghapus karakter backslash (\)
        $data = htmlspecialchars($data); // Mengonversi karakter khusus menjadi entitas HTML agar mencegah serangan XSS
        $data = strip_tags($data); // Mengonversi karakter khusus menjadi entitas HTML agar mencegah serangan html injection
        return $data;
    }

    // Memanggil fungsi security input untuk membersihkan, mengamankan input pada variabel email, nama lengkap, jenis kelamin, kelas
    $email = securityInput($_POST['email']);
    $nama_lengkap = securityInput($_POST['nama_lengkap']);

    // Variabel status
    $status = $_POST['status'];

    // Variabel saldo dari form input tabungan pelajar
    $saldo = $_POST['saldo'];

    // Format saldo
    $formatSaldo = number_format($saldo, 0, ".", ".");

    // Tanggal saat ini
    $currentDate = date("Y-m-d");

    // Menyiapkan pernyataan SQL dengan menggunakan parameter placeholder
    $sql = "INSERT INTO tbl_tabungan_pelajar (email, nama_lengkap, status, saldo, created_at, updated_at) 
    VALUES (:email, :nama_lengkap, :status, :saldo, :created_at, :updated_at)";
    $stmt = $conn->prepare($sql);

    // Mengikat nilai-nilai ke parameter-placeholder
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':nama_lengkap', $nama_lengkap);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':saldo', $formatSaldo);
    $stmt->bindParam(':created_at', $currentDate);
    $stmt->bindParam(':updated_at', $currentDate);

    // Cek jika berhasil di eksekusi
    if ($stmt->execute()) {

        // Beri response
        $response = array(
            'success' => true,
            'message' => 'Data pelajar berhasil disimpan.'
        );
        echo json_encode($response);

        // Mengecek jika ada kesalahan pada backend web aplikasi
    } else {

        // Beri response
        $response = array(
            'success' => false,
            'message' => 'Terjadi kesalahan saat menyimpan data pelajar.'
        );
        echo json_encode($response);
    }

    // Tutup koneksi
    tutupKoneksi($conn);
} else {
    header('HTTP/1.1 404 Not found'); // Mengirimkan header respons HTTP 404 jika permintaan bukan metode POST
}
