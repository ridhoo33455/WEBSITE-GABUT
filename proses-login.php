<?php
// Koneksi ke database
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mendapatkan data user berdasarkan username
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);  // Bind username ke query
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Debugging: Print user and role value
    // echo "<pre>"; var_dump($user); echo "</pre>";

    // Cek apakah user ditemukan dan password cocok
    if ($user && password_verify($password, $user['password'])) {
        // Mulai session
        session_start();
        
        // Simpan data ke dalam session
        $_SESSION['username'] = $username;  // Simpan username
        $_SESSION['role'] = $user['role'];  // Simpan role (admin, mahasiswa, dosen)

        // Debugging: Print role value
        // echo $_SESSION['role'];

        // Cek role user dan arahkan ke halaman yang sesuai
        switch (strtolower($user['role'])) { // Use strtolower to avoid case sensitivity issues
            case 'mahasiswa':
                header('Location: Dasbboard-mahasiswa.php');
                exit();
            case 'dosen':
                header('Location: dashboard-dosen.php');
                exit();
            case 'admin':
                header('Location: dashboard-admin.php');
                exit();
            default:
                $error = "Jenis user tidak valid.";  // Invalid role error
        }
    } else {
        $error = "Username atau password salah.";  // Incorrect username or password
    }
}
?>