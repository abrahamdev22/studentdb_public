<?php

session_start();

if (!isset($_SESSION["login"])) {       //cek apakah variable session sudah di set
    header("Location: login.php");
    exit;
}

require 'functions.php'; //menggunakan halaman php lain


$mahasiswa = query("SELECT * FROM mahasiswa");  //menggunakan fungsi buatan sendiri, bernama query, dengan argumen string yang merupakan command query SQL

// var_dump($mahasiswa);

// cek apakah tombol cari ditekan
if(isset($_POST["keyword"])){
    $mahasiswa = cari($_POST["keyword"]);
}

?>


<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Student DB</title>

</head>
<body>

<nav id="index">
    <div class="sidenav">
        <div class="container">
            <div class="side-menu">
                <ul>
                    <!-- <a href="tambah.php"><li>Tambah Data</li></a> -->
                    <a href="tambah.php"><li>Add Data</li></a>
                        <a href="logout.php"><li>Logout</li></a>
                </ul>
            </div>
        </div>
    </div>
</nav>

<main>
    <div class="main-site">
        <div class="container">
            
            <!-- <h1>Daftar Mahasiswa</h1> -->
            <h2>Students List</h2>
            
            <br>
            
            <br><br>
            
            <form action="" method="post" id="searchbar">
                
                <input type="text" name="keyword" size="40" autofocus placeholder="type search keyword here..."
                autocomplete="off" id="keyword">
                <button type="submit" name="cari" id="tombol-cari">Cari !</button>
                <span><img src="images/ajaxloader2.gif" class="loader"></span>
                
            </form>
            <br>
            
            <div id="container">
                
                
                <table border="1" cellpadding="10" cellspaceing="0">
                    
                    <tr>
                        <th>No.</th>
                        <th>Action</th>
                        <th>Avatar</th>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Majors</th>
                    </tr>
                    
                    <?php $i = 1; //variabel i digunakan untuk menampilkan nomor urut ?>  
                    
                    <?php  foreach ($mahasiswa as $mhs) { ?>
                        
                        <tr>
                            <td><?php echo $i ?></td>
                <td>
                    <!-- pad url hapus, kita memberikan data id , supaya tombol hapus tau id mana yang akan dihapus -->
                    <a href="ubah.php?id=<?php echo $mhs["id"]; ?>">Edit</a> |
                    <!-- pada url hapus, terdapat javascript untuk konfirmasi apakah yakin menghapus  -->
                    <a href="hapus.php?id=<?php echo $mhs["id"]; ?> "onclick="return confirm('sure you want delete ?'); ">Delete</a>  
                </td>
                <td><img src="images/<?php echo $mhs["gambar"] ?>" width="50"></td>
                <td><?php echo $mhs["nim"] ?></td>
                <td><?php echo $mhs["nama"] ?></td>
                <td><?php echo $mhs["email"] ?></td>
                <td><?php echo $mhs["jurusan"] ?></td>
            </tr>
            <?php $i++; ?> 
            <?php } ?>
            <?php // }?>
            <!-- <tr>
                <td><?php echo $m ?></td>
                
            </tr> -->
            
            
            </table>
        </div>
    </div>
</main>

<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>
