<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kampus Merdeka - Lupa Password</title>
    <link rel="stylesheet" href="style-lupapassword.css">
    
</head>

<body>
    <div class="back-button">
        <i class="fas fa-arrow-left"></i>
    </div>
    <div class="container">
        <form method="post" action="send_resetpass.php">
        <div class="logo">
            <img src="Logo MBKM-lupapassword.png" height="100" width="300" />
        </div>  
        <div class="description">Silahkan masukkan email yang Anda daftarkan pada saat registrasi:</div>
        <div class="input-container">
            <input id="email" placeholder="Email" type="email" required />
        </div>
        <button class="button">Selanjutnya</button>
        </form>
    </div>
</body>
</html>