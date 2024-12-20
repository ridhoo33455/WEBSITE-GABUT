<?php
// Koneksi ke database
include 'koneksi.php';

$login_success = false; // Default status login

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil password dan role dari database
    $query = "SELECT password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password, $role);
    $stmt->fetch();
    $stmt->close();

    if ($hashed_password) {
        // Verifikasi password
        if (password_verify($password, $hashed_password)) {
            // Password cocok
            error_log("Login Berhasil untuk username: $username");
            $login_success = true;

            // Mulai session untuk menyimpan data user
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            // Redirect URL berdasarkan role
            switch (strtolower($role)) {
                case 'mahasiswa':
                    $redirect_url = 'Dasbboard-mahasiswa.php';
                    break;
                case 'dosen':
                    $redirect_url = 'dashboard-dosen.php';
                    break;
                case 'admin':
                    $redirect_url = 'dashboard-admin.php';
                    break;
                default:
                    $redirect_url = 'Dasbboard.php';
            }
        } else {
            // Password salah
            error_log("Password Salah untuk username: $username");
        }
    } else {
        // Username tidak ditemukan
        error_log("Username tidak ditemukan: $username");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Login Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="style-login.css" rel="stylesheet" />
</head>

<body>
    <div class="overlay">
        <div class="login-container">
            <img src="Logo MBKM-login.png" alt="Logo MBKM" class="img-fluid" />
            <h3 class="text-center">Login</h3>

            <!-- Form Login -->
            <form method="POST" action="">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required />
                </div>

                <div class="mb-3 position-relative">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password"
                        required />
                    <i class="fa fa-eye toggle-password" id="togglePassword"></i>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="OTP-email.php" class="text-decoration-none text-primary">Lupa Password? </a>
                </div>

                <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                <a href="registrasi (2).php" class="d-block text-center mt-3 text-decoration-none text-primary">Belum
                    Punya Akun? Daftar</a>
            </form>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script-login.js"></script>

    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
    <script>
    <?php if ($login_success): ?>
    Swal.fire({
        title: "Hallo!",
        text: "Selamat Datang Di Website Kami",
        imageUrl: "kami.jpg",
        imageWidth: 400,
        imageHeight: 200,
        imagesrc: "kami.jpg"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= $redirect_url ?>'; // Redirect ke dashboard berdasarkan role
        }
    });
    <?php else: ?>
    Swal.fire({
        title: 'Error!',
        text: 'Username atau password salah.',
        icon: 'error',
        confirmButtonText: 'Coba Lagi'
    });
    <?php endif; ?>
    </script>
    <?php endif; ?>

</body>

</html>