
    <html>
    <head>
        <title>Kampus Merdeka OTP</title>
        <link rel="stylesheet" href="style-OTP.css">
    </head>
    <body onload="onTimer();">
        <div class="back-button">
            <i class="fas fa-arrow-left"></i>
        </div>
        <div class="container">
            <img src="Logo MBKM-OTP.png" height="100" width="200">
            <form action="/verify-otp" method="POST">
                <div class="instruction">Silahkan Masukkan Kode OTP yang dikirim lewat email Anda:</div>
                <div>
                    <input type="text" class="otp-input" maxlength="1" name="otp1">
                    <input type="text" class="otp-input" maxlength="1" name="otp2">
                    <input type="text" class="otp-input" maxlength="1" name="otp3">
                    <input type="text" class="otp-input" maxlength="1" name="otp4">
                </div>
                <div class="resend">Kirim ulang kode OTP dalam <div id="mycounter"></div>
                <script>
                    let i = 60;
                    function onTimer() {
                        document.getElementById('mycounter').innerHTML = i;
                        i--;
                        if (i < 0) {
                            alert('Kode OTP telah kedaluwarsa.');
                        } else {
                            setTimeout(onTimer, 1000);
                        }
                    }
                </script></div>

                <div class="resend">Untuk meminta ulang kode <a href="/request-reset-password">Klik disini</a></div>
                <button class="confirm-button" type="submit">Konfirmasi</button>
            </form>
        </div>
    </body>
    </html>

