<?php
// mulai session
session_start();

// hapus session
session_unset();
session_destroy();

// hapus cookie
setcookie("tasek_", "", time() - 3600, "/");

// redirect ke halaman login 
header("Location: login.php");
