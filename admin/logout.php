<?php

//di website tidak pakai session start
// session_start();
$_SESSION = [];
session_unset();
session_destroy();

$_SESSION['pesan'] = 'Berhasil logout.';
// di website nya pake js
echo "<script>window.location.href = 'login.php';</script>";
// header("Location: login.php");
exit;
