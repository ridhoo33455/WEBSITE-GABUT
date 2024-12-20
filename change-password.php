<?php
session_start();
include 'koneksi.php'; // Koneksi ke database

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pastikan sesi sudah diatur dengan benar
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu.');
        window.location.href = 'login.php'; // Redirect ke login.php
    </script>";
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
$error_message = ""; // Variabel untuk menyimpan pesan kesalahan

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi kesesuaian password baru dan konfirmasi
    if ($new_password !== $confirm_password) {
        $error_message = "Kata sandi baru dan konfirmasi tidak cocok.";
    } else {
        try {
            // Ambil password lama dari database
            $query = "SELECT password FROM users WHERE username = ? AND role = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $username, $role);
            $stmt->execute();
            $stmt->bind_result($hashed_password);

            if (!$stmt->fetch()) {
                throw new Exception("Pengguna tidak ditemukan dalam database.");
            }
            $stmt->close();

            // Verifikasi password lama
            if (!password_verify($old_password, $hashed_password)) {
                $error_message = "Kata sandi lama tidak cocok.";
            } else {
                // Hash password baru
                $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

                // Update password di database
                $update_query = "UPDATE users SET password = ? WHERE username = ? AND role = ?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("sss", $new_hashed_password, $username, $role);

                if ($stmt->execute()) {
                    // Redirect ke login.php setelah sukses
                    echo "<script>
                        alert('Kata sandi berhasil diperbarui. Silakan login kembali.');
                        window.location.href = 'login.php'; // Redirect ke login.php
                    </script>";
                    exit();
                } else {
                    throw new Exception("Terjadi kesalahan saat memperbarui kata sandi.");
                }
            }
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage()); // Logging error ke file log server
            $error_message = "Terjadi kesalahan. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password</title>
    <link rel="stylesheet" href="style-change-password.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
        function togglePassword(id, iconId) {
            const passwordField = document.getElementById(id);
            const toggleIcon = document.getElementById(iconId);
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</head>
<body>
    <form id="password-form" action="" method="POST">
        <div class="container">
            <h2>Ganti Password</h2>

            <?php if ($error_message): ?>
                <div style="color: red; margin-bottom: 10px;"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <div class="form-group">
                <label for="old-password">Password Lama:</label>
                <div style="position: relative;">
                    <input type="password" name="old_password" id="old-password" placeholder="Password lama" required>
                    <i class="fas fa-eye" id="toggle-old-password" onclick="togglePassword('old-password', 'toggle-old-password')" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="new-password">Password Baru:</label>
                <div style="position: relative;">
                    <input type="password" name="new_password" id="new-password" placeholder="Password baru" required>
                    <i class="fas fa-eye" id="toggle-new-password" onclick="togglePassword('new-password', 'toggle-new-password')" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="confirm-password">Konfirmasi Password Baru:</label>
                <div style="position: relative;">
                    <input type="password" name="confirm_password" id="confirm-password" placeholder="Ulangi password baru" required>
                    <i class="fas fa-eye" id="toggle-confirm-password" onclick="togglePassword('confirm-password', 'toggle-confirm-password')" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                </div>
            </div>
            <button type="submit" class="btn">Simpan Perubahan</button>
        </div>
    </form>
</body>
</html>
