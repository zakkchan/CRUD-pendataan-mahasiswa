<?php
include 'koneksi.php'; 

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

$query = "SELECT INTO prodi FROM prodi_tmhs "; 
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Prodi</title>
    <link rel="stylesheet" href="style.css"> <!-- Sesuaikan dengan CSS kamu -->
</head>
<body>
    <div class="container">
        <h2>Data Program Studi</h2>
        <table border="1">
            <tr>
                <th>Program Studi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['prodi_tmhs']) ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
