<?php
include 'koneksi.php'; // Pastikan koneksi database benar

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Query untuk menghapus data
    $query = "DELETE FROM tmhs WHERE id_mhs = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_stmt_execute($stmt);
    
    if ($result) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.location='index.php';</script>";
    }
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location='index.php';</script>";
}
?>