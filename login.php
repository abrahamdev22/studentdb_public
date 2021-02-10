<?php  

session_start(); //syarat supaya variable global $_SESSION() bisa dipake

require 'functions.php';

// cek apakah user mengklik button daftar baru, bila ya maka arahkan ke page registrasi.php
if(isset($_POST["daftarbaru"])){
    header("Location: registrasi.php");
}

// cek apakah ada cookie, bile ada dan isinya true, maka set variable session menjadi true sehingga status langsung sudah login 
if(isset($_COOKIE['id']) && isset($_COOKIE['key'])){ //cek apakah cookie id dan key ada isinya
    $id = $_COOKIE['id'];       //masukkan ke variable
    $key = $_COOKIE['key'];

    //cek apakah benar cookie tersebut valid dan bukan dari hacker
    // ambil username dari database berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = '$id'");
    $row = mysqli_fetch_assoc($result); //simpan dalam variable $row
    // var_dump($row); die;

    // cek cookie dan username
    if ( $key === hash('sha256', $row['username'])) {  //bandingkan isi variable $key (username yang telah di enkrip), dengan username dari database yang di enkrip juga
        $_SESSION['login'] = true;
    }

}


// cek cookie versi sederhana
// if(isset($_COOKIE["login"])){
//     if ($_COOKIE["login"] == 'true') {
//         $_SESSION["login"] = true;      
//     }
// }


//cek apakah variable session sudah di set, kalo sudah maka kembalikan ke halaman index
if (isset($_SESSION["login"])) {       //cek apakah variable session sudah di set, kalo sudah maka kembalikan ke halaman index
    header("Location: index.php");      //ini artinya kalo user sudah login, tidak akan bisa login lagi, langsung diarahkan ke halaman index 
    exit;
}


if (isset($_POST["login"])) {
    
    // pindahkan isi2 variable global ke variabel lokal
     $username = $_POST["username"];
     $password = $_POST["password"];

    // query database apakah ada username yang diinput oleh user, simpan hasilnya dalam variable $result
    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
     
    //  cek username, dengan command ini, yang dicek adalah jumlah baris, bila hasilnya 1, berarti query ada nilainya, username ada didalam database
    if ( mysqli_num_rows($result) === 1) {

        // cek password
        $row = mysqli_fetch_assoc($result); //simpan query database ke dalam bentuk array associative
        if( password_verify($password, $row["password"])) { //fungsi ini membandingkan string password yang diinput user (dalam variable $password), dengan nilai acak password yang telah dienkrip di database
            // set session                                  //bila hasilnya sama maka password yang user inputkan valid.
            $_SESSION["login"] = true ; // ini yang menjadi tanda bahwa variable session sudah di set
            
            // cek remember me
            if(isset($_POST["remember"])){
                // buat cookie
                // setcookie('login', 'true', time()+60); //contoh cookie yang sederhana tanpa enkripsi
                setcookie('id', $row['id'], time()+60);
                setcookie('key', hash('sha256', $row['username']), time()+60); //membuat cookie dengan nama key, dengan value mengambil username dari database yang dienkrip dengan fungsi hash, algoritma sha256


            }

            
            header("Location: index.php"); //bila cek password berhasil maka halaman diarahkan ke index.php
            exit;
        }
    }

    // logic buat pesan error bila username / password salah
    $error = true ;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    
    <title>Login Page</title>
</head>
<body>

    <div class="login-head">
    <span> 
        <h1>Welcome to StudentDB v1.0</h1>
        <h3>This is a website with CRUD functionalities</h3>
    </span>
    </div>

<?php if ( isset($_COOKIE["daftar"]) ) { ?>
    <div class="register-success">
        <!-- <p>Silahkan login dengan username dan password anda !</p> -->
        <p>Please login using your new username & password</p>
    </div>
<?php } ?>
    
<?php if ( isset($error) ) { ?>
    <div class="login-error">
        <!-- <p>Username / Password yang anda masukkan salah</p> -->
        <p>Wrong username or password !</p>
    </div>
<?php } ?>

    <div class="login-body">
        <!-- <span><h2>Login</h2></span> -->
        <div class="login-title">
            <h2>Login</h2>
        </div>
        <div class="container">
            <form action="" method="post">
                <ul>
                    <li>
                        <label for="username" >Username:</label>
                        <input type="text" name="username" id="username" autocomplete="off">
                    </li>
                    <li>
                        <label for="password">Password :</label>
                        <input type="password" name="password" id="password"> 
                    </li>
                    <li>
                        <input type="checkbox" name="remember" id="remember"> 
                        <label for="remember">Remember Me</label>
                    </li>  
                    <li>
                        <button type="submit" name="login">Login</button>
                    </li>
                    <li>
                        <label for="daftarbaru">New user ?</label>
                        <button type="daftarbaru" name="daftarbaru">Register !</button>
                    </li>            
                </ul>
            </form>
        </div>
    </div>


</body>
</html>

