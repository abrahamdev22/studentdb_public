<?php 
usleep(500000);  // fungsi sleep dalam micro detik cuma simulasi supaya tanda loader berfungsi muter selama setengah detik

require '../functions.php';

$keyword = $_GET["keyword"];

$query =  "SELECT * FROM mahasiswa WHERE 
            nama LIKE '%$keyword%' OR
            nim LIKE '%$keyword%' OR
            jurusan LIKE '%$keyword%' OR
            email LIKE '%$keyword%'
            ";

$mahasiswa = query($query);



?>

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
            <a href="hapus.php?id=<?php echo $mhs["id"]; ?> "onclick="return confirm('yakin hapus data ?'); ">Delete</a>  
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