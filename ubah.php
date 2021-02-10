<?php  

session_start();

if (!isset($_SESSION["login"])) {       //cek apakah variable session sudah di set
    header("Location: login.php");
    exit;
}

// koneksi ke DBMS
require 'functions.php';   

$id = $_GET["id"];

$mahasiswa = query("SELECT * FROM mahasiswa WHERE id = $id");

// $queryUpdate = mysqli_query ($conn, "SELECT * FROM mahasiswa WHERE id = $id");
// $rows = [];
// while ($row = mysqli_fetch_assoc($queryUpdate)) {
//     $rows [] = $row; 
// }

// cek apakah tombol submit sudah ditekan atau belum
if(isset($_POST["submit"])){

    // cek apkah data berhasil diubah atau tidak
    if (ubah($_POST) > 0) {
        // algoritmannya adalah, setelah berhasil/tidak berhasil menambahkan data maka user akan dikembalikan ke halaman utama
        // yang dipake adalah javascript alert, dan command document.location.href (ini adalah redirect versi java script)
        echo "
        
        <script>
            alert('Student data has been updated successfully!');
            document.location.href = 'index.php';
        </script>
        
        ";
    } else {
        echo "
        
        <script>
            alert('Student data update has been failed!');
            document.location.href = 'index.php';
        </script>
        
        ";
    }

}

// foreach ($rows as $row) {
//     # code...
//     var_dump($row["nama"]);
// }
// var_dump($id);


// var_dump($mahasiswa);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/ubah.css">
    <title>Edit Student Info</title>
</head>

<body>

<nav>
    <div class="sidenav">
        <div class="container">
            <div class="side-menu">
                <ul>
                    <a href="index.php"><li>Back</li></a>
                    <a href="logout.php"><li>Logout</li></a>
                </ul>
            </div>
        </div>
    </div>
</nav>

<main>
    <div class="main-site">
        <div class="container">
            <h2>Edit Student Info</h2>
            <?php  foreach ($mahasiswa as $mhs) {?>
                <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
                    <input type="hidden" name="id" value="<?php echo $mhs["id"] ?>">        <!-- script ini berfungsi untuk mengirimkan data id dari row yang akan diubah-->
                    <input type="hidden" name="gambarLama" value="<?php echo $mhs["gambar"] ?>">    <!-- script ini berfungsi untuk mengirimkan data gambarLama dari row yang akan diubah-->
                    <ul>
                        <li>
                            <label for="nim">Student ID :</label>
                            <span><input type="text" name="nim" id="nim" required value="<?php echo $mhs["nim"]?>"></span>
                        </li>
                        <li>
                            <label for="nama">Name :</label>
                            <span><input type="text" name="nama" id="nama" required value="<?php echo $mhs["nama"]?>"></span>
                        </li>
                        <li>
                            <label for="email">Email :</label>
                            <span><input type="text" name="email" id="email" required value="<?php echo $mhs["email"]?>"></span>
                        </li>
                        <li>
                            <label for="jurusan">Majors :</label>
                            <span><input type="text" name="jurusan" id="jurusan" required value="<?php echo $mhs["jurusan"]?>"></span>
                        </li>
                        <li>
                            <label for="gambar">Avatar :</label><br>
                            <img src="images/<?php echo $mhs["gambar"]?>" width="50"> <br>
                            <input type="file" name="gambar" id="gambar" >
                        </li>
                        <br>
                        <li>
                            <button type="submit" name="submit">Submit!</button>
                        </li>
                    </ul>
                    </form>
            <?php  }?>
        </div>
    </div>
</main>

<!-- <h1>Ubah Data Mahasiswa</h1> -->

</body>
</html>

<?php  

// "<br>";

// var_dump($_POST);
?>

