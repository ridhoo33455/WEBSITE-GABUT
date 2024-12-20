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

// Ambil data dosen dari database
$sql = "SELECT * FROM users WHERE role = 'dosen'";
$result = $conn->query($sql);

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Daftar Dosen</h1>
        <a href="add_dosen.php" class="btn btn-success mb-3">Tambah Dosen</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>NIM/NIK</th>
                    <th>Prodi</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>No. Handphone</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $no++ . "</td>
                                <td>" . htmlspecialchars($row['nama_lengkap']) . "</td>
                                <td>" . htmlspecialchars($row['nim_nik']) . "</td>
                                <td>" . htmlspecialchars($row['prodi'] ?? 'Tidak Ada') . "</td>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                                <td>" . htmlspecialchars($row['alamat']) . "</td>
                                <td>" . htmlspecialchars($row['no_handphone']) . "</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data dosen</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
