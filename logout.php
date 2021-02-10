<?php 


// clear session
session_start();

$_SESSION = [];
session_unset();
session_destroy();

// clear cookie
setcookie('id', '', time()-3600); //caranya dengan mengisi cookie yang sudah ada dengan value kosong
setcookie('key', '', time()-3600); //dan fungsi waktu yang sudah lampau, atau minus

header("Location: login.php");
exit;


?>