<?php 


require 'functions.php';

if(isset($_POST["register"])){

    
    if(registrasi($_POST) > 0){     //menggunakan pengecekan mysqli_affected_row nantinya
        echo "<script>
        alert('congratulations! new user has been registered');
        document.location.href = 'index.php';
        </script>";
        setcookie('daftar', 'true', time()+60);  //parameter pertama adalah nama cookienya, paramater berikutny adalah valuenya
        
    }else {
        echo mysqli_error($conn);
    }
    
}
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reg.css">
    <title>Registration</title>
    <style>
        label{
            display: block;
        }
    </style>
</head>
<body>

<nav>
    <div class="sidenav">
        <div class="container">
            <div class="side-menu">
                <ul>
                    <a href="login.php"><li>Kembali</li></a>
                </ul>
            </div>
        </div>
    </div>
</nav>

<main>
    <div class="main-site">
        <div class="container">
            <h2>New User Registration</h2>
            <form action="" method="post" autocomplete="off" >
                <ul>
                    <li>
                        <label for="username">Choose Username :</label>
                        <span><input type="text" name="username" id="username"></span>
                    </li>
                    <li>
                        <label for="password">Set Password :</label>
                        <span><input type="password" name="password" id="password"></span>
                    </li>
                    <li>
                        <label for="password2">Password Confirmation :</label>
                        <span><input type="password" name="password2" id="password2"></span>
                    </li>
                    <li>
                        <button type="submit" name="register">Register!</button>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</main>


</body>
</html>