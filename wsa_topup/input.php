<?php
include 'config.php'; // Koneksi database

// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$error_msg = "";
$success_msg = "";
$show_popup = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['Nama'], $_POST['No_Handphone'], $_POST['Email'], $_POST['Password'], $_POST['confirm_password'])) {
        $error_msg = "Error: Semua data harus diisi.";
    } else {
        // Ambil data dari form
        $Nama = trim($_POST['Nama']);
        $No_Handphone = trim($_POST['No_Handphone']);
        $Email = trim($_POST['Email']);
        $Password = $_POST['Password'];
        $confirm_password = $_POST['confirm_password'];

        // Cek apakah password cocok
        if ($Password !== $confirm_password) {
            $error_msg = "Error: Password dan Konfirmasi Password tidak cocok!";
        } else {
            // Hash password
            $hashed_password = password_hash($Password, PASSWORD_DEFAULT);

            // Query insert data dengan backtick di "No Handphone"
            $stmt = $conn->prepare("INSERT INTO akun (Nama, `No Handphone`, Email, Password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $Nama, $No_Handphone, $Email, $hashed_password);

            if ($stmt->execute()) {
                $success_msg = "Registrasi berhasil!";
                $show_popup = true; // Aktifkan popup
            } else {
                $error_msg = "Error: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WSA TOPUP - Daftar Akun</title>
    <link rel="stylesheet" type="text/css" href="register-style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 14px;
        }
        .alert-danger {
            background-color: rgba(220, 53, 69, 0.2);
            color: #ff6b6b;
        }
        .alert-success {
            background-color: rgba(40, 167, 69, 0.2);
            color: #75b798;
        }
        
        /* Popup Styles */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .popup-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .popup-content {
            background-color: #222;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
            transform: scale(0.8);
            transition: all 0.3s ease;
        }
        
        .popup-overlay.active .popup-content {
            transform: scale(1);
        }
        
        .popup-icon {
            font-size: 60px;
            color: #ff7700;
            margin-bottom: 15px;
        }
        
        .popup-title {
            font-size: 24px;
            color: #fff;
            margin-bottom: 10px;
        }
        
        .popup-message {
            color: #ddd;
            margin-bottom: 20px;
        }
        
        .popup-button {
            background: #ff7700;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: opacity 0.15s;
        }
        
        .popup-button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <!-- Popup Notification -->
    <div class="popup-overlay" id="successPopup" style="<?php echo $show_popup ? 'opacity:1; visibility:visible;' : 'opacity:0; visibility:hidden;'; ?>">
        <div class="popup-content">
            <div class="popup-icon">✓</div>
            <h3 class="popup-title">Pendaftaran Berhasil!</h3>
            <p class="popup-message">Akun Anda telah berhasil terdaftar. Silakan login untuk melanjutkan.</p>
            <button class="popup-button" onclick="closePopup()">Login Sekarang</button>
        </div>
    </div>
    
    <div class="register-container">
        <div class="register-card">
            <div class="register-title">
                <h3>Daftar Akun</h3>
                <p>Daftar akun dengan mengisi form di bawah</p>
            </div>
            
            <?php if (!empty($error_msg)): ?>
                <div class="alert alert-danger"> <?php echo $error_msg; ?> </div>
            <?php endif; ?>
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-group">
                    <label for="Nama">Nama</label>
                    <input type="text" name="Nama" id="Nama" required>
                </div>
                <div class="input-group">
                    <label for="No_Handphone">No Handphone</label>
                    <input type="text" name="No_Handphone" id="No_Handphone" required>
                </div>
                <div class="input-group">
                    <label for="Email">Email</label>
                    <input type="email" name="Email" id="Email" required>
                </div>
                <div class="input-group password-container">
                    <label for="Password">Password</label>
                    <input type="password" name="Password" id="Password" required>
                </div>
                <div class="input-group password-container">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" required>
                </div>
                <button type="submit" class="btn-register">Daftar Sekarang</button>
            </form>
        </div>
    </div>
    
    <script>
        function closePopup() {
            document.getElementById('successPopup').style.opacity = '0';
            document.getElementById('successPopup').style.visibility = 'hidden';
            window.location.href = 'Login.html';
        }
    </script>
</body>
</html>
