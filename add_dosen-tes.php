<?php
// Koneksi database
$host = "localhost";
$user = "root";
$password = "";
$dbname = "mbkm";

$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses penyimpanan data
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama_lengkap = $conn->real_escape_string($_POST['nama_lengkap']);
    $nim_nik = $conn->real_escape_string($_POST['nim_nik']);
    $id_prodi = isset($_POST['id_prodi']) ? $conn->real_escape_string($_POST['id_prodi']) : null;
    $email = $conn->real_escape_string($_POST['email']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    $no_handphone = $conn->real_escape_string($_POST['no_handphone']);
    $role = "dosen"; // Tetapkan role sebagai dosen
    $username = $conn->real_escape_string($_POST['username'] ?? $nim_nik); // Username default ke nim_nik jika tidak diisi

    // Validasi apakah id_prodi dipilih
    if (empty($id_prodi)) {
        echo "<script>alert('Prodi harus dipilih!'); window.history.back();</script>";
        exit;
    }

    // Validasi apakah username tidak kosong
    if (empty($username)) {
        echo "<script>alert('Username tidak boleh kosong!'); window.history.back();</script>";
        exit;
    }

    // Query untuk menyimpan data
    $sql = "INSERT INTO users (nama_lengkap, nim_nik, id_prodi, email, alamat, no_handphone, role, username) 
            VALUES ('$nama_lengkap', '$nim_nik', '$id_prodi', '$email', '$alamat', '$no_handphone', '$role', '$username')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil disimpan!'); window.location.href='Daftar_Dosen1.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            height: 100vh;
            background-color: #2c3e50;
            color: white;
            padding: 15px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            margin: 10px 0;
        }
        .sidebar a:hover {
            background-color: #34495e;
            padding-left: 10px;
            transition: 0.3s;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: #ecf0f1;
            border-bottom: 1px solid #bdc3c7;
        }
        .container {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Kampus Merdeka</h2>
            <p>INDONESIA JAYA</p>
            <a href="#">Dashboard</a>
            <a href="#">Manajemen User</a>
        </div>

        <!-- Main Content -->
        <div class="w-100">
            <div class="header">
                <h4>Add Dosen</h4>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Dicky Dwi Hardana Putra
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Change Password</a></li>
                        <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
                    </ul>
                </div>
            </div>

            <div class="container">
                <h1 class="text-center">Tambah Dosen</h1>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="nim_nik" class="form-label">NIM/NIK</label>
                        <input type="text" name="nim_nik" id="nim_nik" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_prodi" class="form-label">Prodi</label>
                        <select name="id_prodi" id="id_prodi" class="form-control" required>
                            <option value="">Pilih Prodi</option>
                            <?php
                            // Query untuk mengambil data dari tabel prodi
                            $sql_prodi = "SELECT id_prodi, nama_prodi FROM prodi";
                            $result_prodi = $conn->query($sql_prodi);
                            if ($result_prodi->num_rows > 0) {
                                while ($row_prodi = $result_prodi->fetch_assoc()) {
                                    echo '<option value="' . $row_prodi['id_prodi'] . '">' . $row_prodi['nama_prodi'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_handphone" class="form-label">No. Handphone</label>
                        <input type="text" name="no_handphone" id="no_handphone" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                    <a href="Daftar_Dosen1.php" class="btn btn-secondary w-100 mt-2">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
