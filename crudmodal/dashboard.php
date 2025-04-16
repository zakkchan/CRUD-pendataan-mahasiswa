<?php
    session_start();
    include "koneksi.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Mahasiwa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
          crossorigin="anonymous">
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success flex-column vh-100 p-3" style="width: 240px;">
        <a class="navbar-brand text-white" href="dashboard.php">Dashboard</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav flex-column">
                <li class="nav-item"><a class="nav-link text-white" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Konten -->
    <div class="content p-4" style="flex-grow: 1;">
        <div class="container">
            <h3 class="text-center">Selamat Datang</h3>
            <h5 class="text-center">Pendataan Mahasiswa Universitas Negeri Tangerang</h5>
            <h5 class="text-center">2025 - 2026</h5>

            <div class="row mt-4">
    <div class="col-md-4 mx-auto">
        <div class="card bg-primary text-white text-center mb-3">
            <div class="card-body">
                <h4>Jumlah Mahasiswa</h4>
                <?php
                    $result = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM tmhs");
                    $row = mysqli_fetch_assoc($result);
                    echo "<h2>" . $row['total'] . "</h2>";
                ?>
            </div>
        </div>
        <div class="card bg-warning text-white text-center">
            <div class="card-body">
                <h4>Jumlah Program Studi</h4>
                <?php
                    $result = mysqli_query($koneksi, "SELECT COUNT(DISTINCT Prodi) AS total FROM tmhs");
                    $row = mysqli_fetch_assoc($result);
                    echo "<h2>" . $row['total'] . "</h2>";
                ?>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>