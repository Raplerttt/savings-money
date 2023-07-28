<?php
session_start();
include "../auth/db.php";

// Mendapatkan informasi gambar yang akan di tampilkan berdasarkan email
$stmtSelect = $conn->prepare("SELECT foto_profile FROM tbl_profiles WHERE email = :email");
$stmtSelect->bindParam(':email', $_SESSION['email']);
$stmtSelect->execute();
$rowImage = $stmtSelect->fetch(PDO::FETCH_ASSOC);
$image = $rowImage['foto_profile'];

?>

<img src="img/<?php echo $image; ?>" class="rounded mx-auto d-block mb-1 mt-4 rounded-circle" style="background-color: white;" height="75px;">
