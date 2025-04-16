<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = trim($_POST['tnim']);
    $nama = trim($_POST['tnama']);
    $alamat = trim($_POST['talamat']);
    $prodi = trim($_POST['tprodi']);
    $telepon = trim($_POST['tno_telepon']);
    $email = trim($_POST['temail']);

    // Cek apakah NIM sudah terdaftar
    $cek = mysqli_prepare($koneksi, "SELECT NIM FROM tmhs WHERE NIM = ?");
    mysqli_stmt_bind_param($cek, "s", $nim);
    mysqli_stmt_execute($cek);
    mysqli_stmt_store_result($cek);

    if (mysqli_stmt_num_rows($cek) > 0) {
        echo "<script>alert('NIM sudah terdaftar!'); window.location='index.php';</script>";
        exit;
    }
    mysqli_stmt_close($cek);

    // Insert data dengan prepared statement untuk menghindari SQL Injection
    $query = "INSERT INTO tmhs (NIM, Nama, Alamat, Prodi, no_telepon, email) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssss", $nim, $nama, $alamat, $prodi, $telepon, $email);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script>alert('Data berhasil ditambahkan!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan data!'); window.location='index.php';</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Kesalahan dalam query!'); window.location='index.php';</script>";
    }
}
?>