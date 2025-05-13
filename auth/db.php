<?php

$host = 'ep-lingering-hill-a4roc2ic-pooler.us-east-1.aws.neon.tech';
$dbname = 'neondb';
$user = 'neondb_owner';
$password = 'npg_JIAYCFwR0G4o';
$sslmode = 'require';

try {
    $dsn = "pgsql:host=$host;port=5432;dbname=$dbname;sslmode=$sslmode";
    $conn = new PDO($dsn, $user, $password);
    // Aktifkan error mode
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}

function tutupKoneksi($conn)
{
    $conn = null;
}
