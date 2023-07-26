<?php
include '../auth/db.php';

// Cek jika request nya itu POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_tabungan = abs((int)$_GET['id_tabungan']); // Mengambil nilai 'id_tabungan' dari parameter GET dan mengonversi menjadi integer positif

    // Menghapus data dari tbl_tabungan_pelajar
    $stmt = $conn->prepare("DELETE FROM tbl_tabungan_pelajar WHERE id_tabungan = :id_tabungan");
    $stmt->bindParam(':id_tabungan', $id_tabungan);
    $stmt->execute();

    tutupKoneksi($conn); // Menutup koneksi database dengan memanggil fungsi 'tutupKoneksi'
} else {
    header('HTTP/1.1 404 Not found'); // Mengirimkan header respons HTTP 404 jika permintaan bukan metode POST
}
