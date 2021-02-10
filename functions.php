<?php 


require 'connection.php';

// buat function yang mengambil data dari database sesuai dengan jenis query nya

function query($query){
    global $conn;
    $result = mysqli_query($conn, $query); //ambil semua data dari database 
    $rows = [];  //siapkan  array buffer
    while($row = mysqli_fetch_assoc($result)){ //mengambil data dari database dalam bentuk array associative
        $rows [] = $row; //mengisi array buffer dengan data

    }
    return $rows;
}


function tambah($data){
    global $conn;

    $nim = htmlspecialchars($data["nim"]);  
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);

    // upload gambar, nama file yang berupa text masuk ke database
    $gambar = upload();
    if(!$gambar){
        return false;
    }


    // query insert data
    $queryInsert = "INSERT INTO mahasiswa (nim, nama, email, jurusan, gambar) VALUES 
                        ('$nim', '$nama', '$email', '$jurusan', '$gambar')";

    mysqli_query($conn, $queryInsert);

    return mysqli_affected_rows($conn);
}


function upload(){
    // ambil data dari $_FILES, kemudian simpan di variable
    $namaFile = $_FILES['gambar']['name'];  
    $ukuranFile = $_FILES['gambar']['size'];  
    $error = $_FILES['gambar']['error'];  
    $tmpName = $_FILES['gambar']['tmp_name'];  

    // cek apakah tidak ada gambar yang diupload
    // error = 4 adalah tidak adagambar yang dipilih
    if($error === 4){
        echo "<script>
            alert ('choose an image file !');
            </script>";
        return false; 
    }

    // cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png']; //mendaftarkan list ekstension yang boleh diupload
    $ekstensiGambar = explode('.', $namaFile); //command explode memisahkan kata dengan key tertentu (delimit), dalma hal ini dengan titik.
    $ekstensiGambar = strtolower(end($ekstensiGambar)); //command end memastikan untuk memilih element array ayng paling akhir, karena mau diambil ekstensinya saja
    if(!in_array($ekstensiGambar, $ekstensiGambarValid)){ //akan menghasilkan true jika ada, 
        echo "<script>
            alert ('please upload .jpg or .png filetype only !');
            </script>";
        return false;
    }

    // cek jika ukuran file terlalu besar  
    if($ukuranFile > 1000000) {   //ukuran file dalam satuan byte
        echo "<script>
            alert ('filesize too large !');
            </script>";
        return false;
    }

    // lolos pengecekan, gambar siap diupload, dikopi ke folder tujuan di server
    // generate namafile baru, nama file dari random+ekstension file yg diupload
    $namaFileBaru = uniqid(); //command uniqid ini men-generate random string/angka 
    $namaFileBaru .= ".";
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'images/'. $namaFileBaru);

    return $namaFileBaru;

}


function hapus($data){
    global $conn;

    $id = $data["id"];

    // query hapus data
    $queryDelete = "DELETE FROM mahasiswa WHERE id = $id ";

    mysqli_query($conn, $queryDelete);

    // baris ini memgambalikan nilai affected rows saat terjadi operasi database, bila berhasil 1, bila gagal -1 
    return mysqli_affected_rows($conn);


}


function ubah($data){
    global $conn;

    $id = $data["id"];
    $nim = htmlspecialchars($data["nim"]);  
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $gambarLama = ($data["gambarLama"]);

    // var_dump($_FILES['gambar']['error']); die;
    // var_dump($gambarLama); die;
    // cek apakah user pilih gambar baru atau tidak
    if($_FILES['gambar']['error'] === 4){  //error 4 adalah tidak ada gambar , berarti pada $_FILES gak ada gambar baru yg dipilih user, kalo error 0 ada gambar
        $gambar = $gambarLama;
    }else {

        $gambar = upload();
    }


    // query ubah data
    $queryInsert = "UPDATE mahasiswa SET 
                        nim = '$nim',
                        nama = '$nama',
                        email = '$email',
                        jurusan = '$jurusan',
                        gambar = '$gambar'
                    WHERE id = $id
                        ";

    mysqli_query($conn, $queryInsert);

    // baris ini memgambalikan nilai affected rows saat terjadi operasi database, bila berhasil 1, bila gagal -1 
    return mysqli_affected_rows($conn);
   

}


function cari($keyword){

    // tanda persen % berarti apapun kata didepan atau dibelakang keyword akan tetap ditampilkan
    // command LIKE pada SQL supaya keyword pencarian bisa tidak harus sama persis dengan data yang akan dicari
    $query = "SELECT * FROM mahasiswa WHERE 
                nama LIKE '%$keyword%' OR
                nim LIKE '%$keyword%' OR
                jurusan LIKE '%$keyword%' OR
                email LIKE '%$keyword%'
                
                ";

    $hasil = query($query);

    return $hasil;
}


function registrasi($data){
    global $conn;

    // var_dump($data);

    // ambil data dari $_POST ke variable
    $username = strtolower(stripslashes($data["username"])); //dibersihkan dari karakter slash, dan dijadikan huruf kecil
    $password = mysqli_real_escape_string($conn, $data["password"]); //untuk memungkinkan user memasukkan password berupa karakter spesial
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    //cek username sudah ada atau belum di database
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username' " );
    // $cekUsername = mysqli_fetch_assoc($result);

    // cara 1
    // if ($cekUsername["username"] == $username) {  //cek apakah isi element $userName["username" sama dengan isi variable $username]
    //     echo "<script>
    //             alert('user sudah terdaftar !'); 
    //         </script>" ;
    //     return false;
    // }

    // cara2
    if (mysqli_fetch_assoc($result)) {     //cek apakah fungsi ini memiliki nilai true
        echo "<script>
                alert('username not available, pick another username !'); 
            </script>" ;
        return false;
    }    


    // var_dump($result); 
    // var_dump($cekUsername); die;


    // cek konfirmasi password
    if ($password !== $password2) {
        // echo "salah";
        echo "<script>
                    alert('password confirmation didn't matched !');
                 </script>";
        return false; 
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan user baru kedalam database
    mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')"); //field id selalu dikosongkan karena sifatnya increment otomatis oleh databasenya
    
    return mysqli_affected_rows($conn);

}



?>
