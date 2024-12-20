<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo "<script>
            alert('Silakan login terlebih dahulu.');
            location.href = 'login.php';
        </script>";
    exit();
}

include 'koneksi.php'; // Koneksi database

$username = $_SESSION['username'];

// Ambil data user berdasarkan username
$query = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$data = $result->fetch_assoc();

// Ambil data prodi jika ada relasi
$prodi = "Tidak Diketahui";
if (isset($data['prodi_id'])) {
    $prodi_query = "SELECT nama_prodi FROM prodi WHERE id = ?";
    $prodi_stmt = $conn->prepare($prodi_query);
    $prodi_stmt->bind_param("i", $data['prodi_id']);
    $prodi_stmt->execute();
    $prodi_result = $prodi_stmt->get_result();
    $prodi = $prodi_result->fetch_assoc()['nama_prodi'] ?? "Tidak Diketahui";
}

// Tampilkan data
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
</head>
<body>
    <h1>Profil Pengguna</h1>
    <p>NIM: <?= isset($data['nim']) ? htmlspecialchars($data['nim']) : 'Data tidak tersedia'; ?></p>
    <p>Username: <?= isset($data['username']) ? htmlspecialchars($data['username']) : 'Data tidak tersedia'; ?></p>
    <p>Nama Lengkap: <?= isset($data['nama_lengkap']) ? htmlspecialchars($data['nama_lengkap']) : 'Data tidak tersedia'; ?></p>
    <p>Email: <?= isset($data['email']) ? htmlspecialchars($data['email']) : 'Data tidak tersedia'; ?></p>
    <p>No. Handphone: <?= isset($data['no_hp']) ? htmlspecialchars($data['no_hp']) : 'Data tidak tersedia'; ?></p>
    <p>Alamat: <?= isset($data['alamat']) ? htmlspecialchars($data['alamat']) : 'Data tidak tersedia'; ?></p>
    <p>Prodi: <?= htmlspecialchars($prodi); ?></p>
    <p>Role: <?= isset($data['role']) ? htmlspecialchars($data['role']) : 'Data tidak tersedia'; ?></p>

    <h2>Debug Data</h2>
    <pre>
        <?php print_r($data); ?>
    </pre>
</body>
</html>
