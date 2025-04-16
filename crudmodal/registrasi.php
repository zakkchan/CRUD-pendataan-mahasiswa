<?php
require_once "database.php"; // Pastikan koneksi ke database sudah benar

$namaLengkap = "";
$email = "";
$errors = array();

if (isset($_POST["submit"])) {
    $namaLengkap = trim($_POST["namalengkap"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $ulangiPassword = $_POST["ulangi_password"];

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Validasi input
    if (empty($namaLengkap) || empty($email) || empty($password) || empty($ulangiPassword)) {
        array_push($errors, "Semua kolom wajib diisi");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email tidak valid");
    }
    if (strlen($password) < 8) {
        array_push($errors, "Kata sandi harus minimal 8 karakter");
    }
    if ($password !== $ulangiPassword) {
        array_push($errors, "Kata sandi tidak cocok");
    }

    // Periksa apakah email sudah terdaftar
    $query = "SELECT email FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        array_push($errors, "Email sudah terdaftar, silakan gunakan email lain");
    }
    mysqli_stmt_close($stmt);

    // Jika tidak ada error, simpan ke database
    if (count($errors) === 0) {
        $query = "INSERT INTO users (namalengkap, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $namaLengkap, $email, $passwordHash);
            if (mysqli_stmt_execute($stmt)) {
                echo "<div class='alert alert-success'>Registrasi berhasil! Silakan <a href='login.php'>login</a>.</div>";
                // Reset nilai input setelah berhasil registrasi
                $namaLengkap = "";
                $email = "";
            } else {
                echo "<div class='alert alert-danger'>Gagal menyimpan data: " . mysqli_error($conn) . "</div>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='alert alert-danger'>Terjadi kesalahan dalam persiapan query.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Form Registrasi</h2>

        <!-- Menampilkan error -->
        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="namalengkap">Nama Lengkap</label>
                <input type="text" class="form-control" name="namalengkap" id="namalengkap" value="<?php echo htmlspecialchars($namaLengkap); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="mb-3">
                <label for="ulangi_password">Ulangi Password</label>
                <input type="password" class="form-control" name="ulangi_password" id="ulangi_password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="submit">Daftar</button>
            <p class="mt-3 text-center">
                Sudah punya akun? <a href="login.php">Masuk di sini</a>
            </p>
        </form>
    </div>
</body>
</html>