<?php
session_start();
if (isset($_POST['confirm_logout'])) {
    session_unset(); // Hapus semua variabel sesi
    session_destroy(); // Hancurkan sesi
    header("Location: login.php"); // Arahkan kembali ke halaman login
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Logout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script>
        function confirmLogout() {
            if (confirm("Apakah Anda yakin ingin logout?")) {
                document.getElementById("logoutForm").submit();
            }
        }
    </script>
</head>
<body>
<div class="container text-center mt-5">
    <h3>Apakah Anda yakin ingin logout?</h3>
    <form id="logoutForm" method="POST">
        <input type="hidden" name="confirm_logout" value="1">
        <button type="button" class="btn btn-danger mt-3" onclick="confirmLogout()">Logout</button>
        <a href="index.php" class="btn btn-secondary mt-3">Batal</a>
    </form>
</div>

<script>
function confirmLogout() {
    if (confirm("Anda yakin ingin logout?")) {
        document.getElementById("logoutForm").submit();
    }
}
</script>
    </div>
</body>
</html>
