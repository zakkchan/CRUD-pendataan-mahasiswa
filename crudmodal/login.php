<?php
session_start();
require_once "database.php"; // Pastikan koneksi database sudah benar

$email = "";
$errors = array();

if (isset($_POST["login"])) {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Validasi input kosong
    if (empty($email) || empty($password)) {
        array_push($errors, "Email dan Password wajib diisi!");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Format email tidak valid!");
    }

    if (count($errors) === 0) {
        // Cek apakah email ada di database
        $query = "SELECT id, namalengkap, password FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $id, $namalengkap, $hashedPassword);
        mysqli_stmt_fetch($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            // Verifikasi password
            if (password_verify($password, $hashedPassword)) {
                $_SESSION["id"] = $id;
                $_SESSION["namalengkap"] = $namalengkap;
                $_SESSION["email"] = $email;
                header("Location: dashboard.php"); // Redirect ke halaman utama
                exit;
            } else {
                array_push($errors, "Password salah!");
            }
        } else {
            array_push($errors, "Email tidak ditemukan!");
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Akun</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Login</h2>

        <!-- Menampilkan pesan error -->
        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="login">Login</button>
        </form>
        <p class="mt-3 text-center">Belum punya akun? <a href="registrasi.php">Daftar di sini</a></p>
    </div>
</body>
</html>