<?php  

session_start();

if (!isset($_SESSION["login"])) {       //cek apakah variable session sudah di set
    header("Location: login.php");
    exit;
}

require 'functions.php';

// $id = $_GET["id"];

if (hapus($_GET) > 0) {        
    echo "
        
    <script>
        alert('data berhasil dihapus!');
        document.location.href = 'index.php';
    </script>
    
    ";
}else {
    echo "
        
    <script>
        alert('data gagal dihapus!');
        document.location.href = 'index.php';
    </script>
    
    ";
}




?>