<?php
// Pastikan user sudah login dan memiliki role mahasiswa
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'mahasiswa') {
    header('Location: login.php');
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
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Polibatam Student Information System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="style-Dasboard-mahasiswa.css">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="kampus merdeka.png.jpeg" height="100" />
        </div>
        <nav>
            <a href="#" class="dashboard active" onclick="activateMenu(this)">
                <span class="icon"><i class="fas fa-home-alt"></i></span>
                <span class="text">DASHBOARD</span>
            </a>
            <a href="#" class="persetujuan pengajuan" onclick="activateMenu(this)">
                <span class="icon"><i class="fas fa-clipboard-check"></i></span>
                <span class="text">PERSETUJUAN PENGAJUAN</span>
            </a>
            <a href="#" class="rekap pengajuan" onclick="activateMenu(this)">
                <span class="icon"><i class="fas fa-file-signature"></i></span>
                <span class="text">REKAP PENGAJUAN</span>
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="header">
            <h1>Selamat datang <?php echo $_SESSION['username']; ?></h1>
            <h1>Selamat Datang Di Sistem Informasi Dan Layanan Mahasiswa Polibatam</h1>
            <div class="user-menu">
                <div class="profile-icon" onclick="toggleDropdown()">
                    <img src="ikon profil..jpeg" alt="Profile Icon" />
                </div>
                <div class="dropdown" id="dropdownMenu">
                    <span>Muhammad Ridho Syahputra<br />NIM: 4342411088</span>
                    <button onclick="location.href='profile.php'"><i class="fas fa-key"></i>Profile</button>
                    <button onclick="location.href='change-password.php'"><i class="fas fa-key"></i>Change Password</button>
                    <button onclick="location.href='login.php'"><i class="fas fa-key"></i>Logout</button>
                </div>
            </div>
        </div>

        <div class="welcome">Anda dapat menikmati layanan secara online</div>
        <div class="info">
            Silahkan lakukan update data diri terlebih dahulu di menu PROFILE atau
            <a href="profile.php">KLIK DISINI</a> sebelum melakukan pengajuan. Terima Kasih
        </div>
        <div class="student-data">
            <img src="foto ridho.jpeg" alt="Student Photo" />
            <div class="student-details">
                <h2>DATA DIRI DOSEN</h2>
                <div class="details-row">
    <span class="label">nim_nik</span><span class="separator">:</span>
    <span class="value">
        <?php echo isset($data['nim']) ? htmlspecialchars($data['nim']) : 'Belum Diisi'; ?>
    </span>
</div>

                <div class="details-row">
                    <span class="label">nama_lengkap</span><span class="separator">:</span><span class="value">Muhammad Ridho
                        Syahputra</span>
                </div>
                <div class="details-row">
                    <span class="label">no_handphone</span><span class="separator">:</span><span
                        class="value">082182407100</span>
                </div>
                <div class="details-row">
                    <span class="label">email</span><span class="separator">:</span><span
                        class="value">ridho123@gmail.com</span>
                </div>
                <div class="details-row">
                    <span class="label">alamat</span><span class="separator">:</span><span class="value">Batu Besar,
                        Nongsa, Arira Garden, Blok L.</span>
                </div>
                <div class="details-row">
                    <span class="label">id_prodi</span><span class="separator">:</span><span class="value">Teknologi
                        Rekayasa Perangkat Lunak</span>
                </div>
        </div>
    </div>

    <script>
    function toggleDropdown() {
        const dropdown = document.getElementById("dropdownMenu");
        dropdown.classList.toggle("show");
    }

    window.onclick = function(event) {
        if (!event.target.matches(".profile-icon img")) {
            const dropdown = document.getElementById("dropdownMenu");
            if (dropdown.classList.contains("show")) {
                dropdown.classList.remove("show");
            }
        }
    };

    function activateMenu(element) {
        document.querySelectorAll(".sidebar nav a").forEach((menu) => {
            menu.classList.remove("active");
        });
        element.classList.add("active");
    }
    </script>
</body>

</html>