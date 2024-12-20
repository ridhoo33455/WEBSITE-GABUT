<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Polibatam Student Information System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
  <link rel="stylesheet" href="style-dashboard-admin.css" />
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
      <a href="#" class="pengajuan" onclick="activateMenu(this)">
        <span class="icon"><i class="fas fa-file-alt"></i></span>
        <span class="text">MANAJEMEN USER</span>
      </a>
    </nav>
  </div>

  <!-- Main Content -->
  <div class="content">
    <!-- Header -->
    <div class="header">
      <h1>
        Selamat Datang Di Sistem Informasi Dan Layanan Mahasiswa Polibatam
      </h1>
      <div class="user-menu">
        <!-- Profile Icon -->
        <div class="profile-icon" onclick="toggleDropdown()">
          <img src="../mbkm/assets/img/icon.jpg" alt="Profile Icon" />
        </div>
        <!-- Dropdown Menu -->
        <div class="dropdown" id="dropdownMenu">
          <span><br />NIM: </span>
          <button onclick="location.href='profile.php'"><i class="fas fa-key"></i>Profile</button>
          <button onclick="location.href='change-password.php'"><i class="fas fa-key"></i> Change Password</button>
          <button onclick="location.href='login.php'"><i class="fas fa-key"></i> Logout</button>
        </div>
      </div>
    </div>

    <!-- Welcome Message -->
    <div class="welcome">Anda dapat menikmati layanan secara online</div>

    <!-- Information Box -->
    <div class="info">
      Silahkan lakukan update data diri terlebih dahulu di menu PROFILE atau
      <a href="profile.php">KLIK DISINI</a> sebelum melakukan pengajuan, sebagai
      pemutakhiran data untuk berbagai kebutuhan. Terima Kasih
    </div>

    <!-- Student Data -->
    <div class="student-data">
      <img src="../mbkm/assets/img/stickman.jpeg" alt="Student Photo" />
      <div class="student-details">
        <h2>DATA MAHASISWA</h2>
        <div class="details-row">
          <span class="label">NIM</span>
          <span class="separator">:</span>
          <span class="value"></span>
        </div>
        <div class="details-row">
          <span class="label">Username</span>
          <span class="separator">:</span>
          <span class="value"></span>
        </div>
        <div class="details-row">
          <span class="label">Nama Lengkap</span>
          <span class="separator">:</span>
          <span class="value"></span>
        </div>
        <div class="details-row">
          <span class="label">Email</span>
          <span class="separator">:</span>
          <span class="value"></span>
        </div>
        <div class="details-row">
          <span class="label">No. Handphone</span>
          <span class="separator">:</span>
          <span class="value"></span>
        </div>
        <div class="details-row">
          <span class="label">Alamat</span>
          <span class="separator">:</span>
          <span class="value"></span>
        </div>
        <div class="details-row">
          <span class="label">Prodi</span>
          <span class="separator">:</span>
          <span class="value"></span>
        </div>
        <div class="details-row">
          <span class="label">Role</span>
          <span class="separator">:</span>
          <span class="value"></span>
        </div>
      </div>
    </div>
  </div>

  <script>
    function toggleDropdown() {
      const dropdown = document.getElementById("dropdownMenu");
      dropdown.classList.toggle("show");
    }

    window.onclick = function (event) {
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
