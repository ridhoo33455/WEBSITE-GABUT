<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Kampus Merdeka</title>
    <link rel="stylesheet" href="style-registrasi (3).css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="form-container">
        <!-- Logo Kampus Merdeka -->
        <img src="Logo MBKM-registrasi.png" alt="logo mbkm.jpeg" class="logo">

        <!-- Form Registrasi -->
        <form action="" method="POST" onsubmit="return validatePasswords();">
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="number" class="form-control" name="nim_nik" id="nim" placeholder="Masukkan NIM" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username :</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan Username" required>
            </div>
            <div class="mb-3">
                <label for="namaLengkap" class="form-label">Nama Lengkap :</label>
                <input type="text" class="form-control" name="namaLengkap" id="namaLengkap" placeholder="Masukkan Nama Lengkap" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">No. Handphone</label>
                <input type="number" class="form-control" name="phone" id="phone" placeholder="Masukkan No. Handphone" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email :</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan Email" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat :</label>
                <textarea class="form-control" name="alamat" id="alamat" rows="2" placeholder="Masukkan Alamat" required></textarea>
            </div>
            <div class="mb-3">
                <label for="prodi" class="form-label">Prodi :</label>
                <select class="form-select" name="prodi" id="prodi" required>
                    <option selected disabled>Pilih Program Studi</option>
                    <?php
                    include 'koneksi.php';
                    $query_prodi = "SELECT id_prodi, nama_prodi FROM prodi";
                    $result_prodi = mysqli_query($conn, $query_prodi);

                    if (mysqli_num_rows($result_prodi) > 0) {
                        while ($row = mysqli_fetch_assoc($result_prodi)) {
                            echo '<option value="' . $row['id_prodi'] . '">' . $row['nama_prodi'] . '</option>';
                        }
                    } else {
                        echo '<option disabled>Tidak ada data prodi</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required>
                    <span class="input-group-text password-icon" onclick="togglePassword('password', this)">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>
            </div>

            <div class="mb-3">
                <label for="confirm-password" class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="confirm-password" placeholder="Konfirmasi Password" required>
                    <span class="input-group-text password-icon" onclick="togglePassword('confirm-password', this)">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>
            </div>

            <div id="password-error" class="text-danger mb-3" style="display: none;">
                Password dan Konfirmasi Password tidak sesuai.
            </div>
            <button type="submit" name="submit" class="btn btn-primary w-100">Daftar</button>
        </form>
    </div>

    <script>
        function togglePassword(inputId, icon) {
            const inputField = document.getElementById(inputId);
            const isPasswordVisible = inputField.type === "password";
            inputField.type = isPasswordVisible ? "text" : "password";

            // Ganti ikon mata
            const eyeIcon = icon.querySelector("i");
            eyeIcon.classList.toggle("bi-eye");
            eyeIcon.classList.toggle("bi-eye-slash");
        }

        function validatePasswords() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            const errorDiv = document.getElementById('password-error');

            if (password !== confirmPassword) {
                errorDiv.style.display = 'block';
                return false;
            }

            errorDiv.style.display = 'none';
            return true;
        }
    </script>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        include 'koneksi.php';

        $nim_nik = $_POST['nim_nik'];
        $username = $_POST['username'];
        $nama_lengkap = $_POST['namaLengkap'];
        $email = $_POST['email'];
        $no_handphone = $_POST['phone'];
        $alamat = $_POST['alamat'];
        $id_prodi = $_POST['prodi'];
        $password = $_POST['password'];
        $role = "Mahasiswa";

        $password_hashed = password_hash($password, PASSWORD_BCRYPT);

        $sql_check = "SELECT nim_nik, username FROM users WHERE nim_nik = ? OR username = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("ss", $nim_nik, $username);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'NIM/NIK atau Username sudah terdaftar!'
                    }).then(() => {
                        window.history.back();
                    });
                </script>";
            exit();
        }

        $sql = "INSERT INTO users (nim_nik, username, nama_lengkap, email, no_handphone, alamat, id_prodi, password, role) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $nim_nik, $username, $nama_lengkap, $email, $no_handphone, $alamat, $id_prodi, $password_hashed, $role);

        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Registrasi Berhasil!',
                        text: 'Akun Anda berhasil didaftarkan.'
                    }).then(() => {
                        location.href = 'login.php';
                    });
                </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat registrasi. Silakan coba lagi!'
                    }).then(() => {
                        window.history.back();
                    });
                </script>";
        }

        $stmt_check->close();
        $stmt->close();
        $conn->close();
    }
    ?>
