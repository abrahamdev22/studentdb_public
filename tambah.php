<?php  

session_start();

if (!isset($_SESSION["login"])) {       //cek apakah variable session sudah di set
    header("Location: login.php");
    exit;
}

// koneksi ke DBMS
require 'functions.php';   


if(isset($_POST["submit"])){
    
        // cek keberhasilan tambah data
    if (tambah($_POST) > 0) {
        // algoritmannya adalah, setelah berhasil/tidak berhasil menambahkan data maka user akan dikembalikan ke halaman utama
        // yang dipake adalah javascript alert, dan command document.location.href (ini adalah redirect versi java script)
        echo "
        
        <script>
            alert('Data has been successfully added!');
            document.location.href = 'index.php';
        </script>
        
        ";
    } else {
        // var_dump(tambah($_POST)); die;
        echo "
        
        <script>
            alert('Failed to add data!');
            document.location.href = 'index.php';
        </script>
        
        ";
    }

}


// var_dump($mahasiswa);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/tambah.css">
    <title>Add New Student</title>
</head>

<body>

<nav>
    <div class="sidenav">
        <div class="container">
            <div class="side-menu">
                <ul>
                    <a href="index.php"><li>&laquo; Back</li></a>
                    <a href="logout.php"><li>Logout</li></a>
                </ul>
            </div>
        </div>
    </div>
</nav>

<main>
    <div class="main-site">
        <div class="container">
            <h1>Add New Student</h1>
            <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
                <ul>
                    <li>
                        <label for="nim">Student ID :</label>
                        <span><input type="text" name="nim" id="nim" required></span>
                    </li>
                    <li>
                        <label for="nama">Name :</label>
                        <span><input type="text" name="nama" id="nama" required></span>
                    </li>
                    <li>
                        <label for="email">Email :</label>
                        <span><input type="text" name="email" id="email" required></span>
                    </li>
                    <li>
                        <label for="jurusan">Majors :</label>
                        <span><input type="text" name="jurusan" id="jurusan" required></span>
                    </li>
                    <li>
                        <label for="gambar">Avatar :</label>
                        <input type="file" name="gambar" id="gambar">
                    </li>
                    <br>
                    <li>
                        <button type="submit" name="submit">Add Data!</button>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</main>

</body>
</html>

<?php  



// var_dump($_POST);
?>

