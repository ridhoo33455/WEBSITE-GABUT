<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Polibatam Student Information System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="style-dashboard-dosen.css" />
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo">
      <img src="../mbkm/assets/img/Logo MBKM.png" alt="Logo" />
    </div>
    <nav>
      <a href="#" class="dashboard active" onclick="activateMenu(this)">
        <span class="icon"><i class="fas fa-home-alt"></i></span>
        <span class="text">DASHBOARD</span>
      </a>
      <a href="add_dosen.php" class="pengajuan" onclick="activateMenu(this)">
        <span class="icon"><i class="fas fa-file-alt"></i></span>
        <span class="text">MENAJEMEN USER</span>
    </a>
    <a href="Daftar_Dosen1.php" class="pengajuan" onclick="activateMenu(this)">
        <span class="icon"><i class="fas fa-file-alt"></i></span>
        <span class="text">Add Dosen</span>
    </a>
    </nav>
  </div>

  <!-- Main Content -->
  <div class="content">
    <div class="header">
      <h1>Selamat Datang Di Sistem Informasi Dan Layanan Mahasiswa Polibatam</h1>
      <div class="user-menu">
        <div class="profile-icon" onclick="toggleDropdown()">
          <img src="../mbkm/assets/img/icon.jpg" alt="Profile Icon" />
        </div>
        <div class="dropdown" id="dropdownMenu">
          <span>Muhammad Ridho Syahputra<br />NIM: 4342411088</span>
          <button onclick="location.href='Profile.php'"><i class="fas fa-user"></i> Profile</button>
          <button onclick="location.href='change-password.php'"><i class="fas fa-user"></i> Change Password</button>
          <button onclick="location.href='login.php'"><i class="fas fa-user"></i> Logout</button>
        </div>
      </div>
    </div>

    <div class="welcome">Anda dapat menikmati layanan secara online</div>
    <div class="info">
      Silahkan lakukan update data diri terlebih dahulu di menu PROFILE atau
      <a href="Edit Profile.php">KLIK DISINI</a> sebelum melakukan pengajuan. Terima Kasih
    </div>
    <div class="student-data">
      <img src="../mbkm/assets/img/stickman.jpeg" alt="Student Photo" />
      <div class="student-details">
        <h2>DATA DIRI DOSEN</h2>
        <div class="details-row">
          <span class="label">NIDN</span><span class="separator">:</span><span class="value">4342411088</span>
        </div>
        <div class="details-row">
          <span class="label">Nama</span><span class="separator">:</span><span class="value">Muhammad Ridho Syahputra</span>
        </div>
        <div class="details-row">
          <span class="label">No. Handphone</span><span class="separator">:</span><span class="value">082182407100</span>
        </div>
        <div class="details-row">
          <span class="label">Email</span><span class="separator">:</span><span class="value">ridho123@gmail.com</span>
        </div>
        <div class="details-row">
          <span class="label">Alamat</span><span class="separator">:</span><span class="value">Batu Besar, Nongsa, Arira Garden, Blok L.</span>
        </div>
        <div class="details-row">
          <span class="label">Unit Kerja</span><span class="separator">:</span><span class="value">Teknologi Rekayasa Perangkat Lunak</span>
        </div>
        <div class="details-row">
          <span class="label">Bagian</span><span class="separator">:</span><span class="value">Dosen</span>
        </div>
        <div class="details-row">
          <span class="label">Pendidikan Terakhir</span><span class="separator">:</span><span class="value">S2 INFORMATIKA</span>
        </div>
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