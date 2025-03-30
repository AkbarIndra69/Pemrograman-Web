<?php
include 'config.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $umur = $_POST['umur'];

    $check_sql = "SELECT * FROM mahasiswa WHERE email = '$email'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        $message = "Email sudah terdaftar! Gunakan email lain.";
    } else {
        $sql = "INSERT INTO mahasiswa (nama, email, umur) VALUES ('$nama', '$email', '$umur')";

        if ($conn->query($sql) === TRUE) {
            $message = "Data berhasil disimpan.";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tersimpan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 50%;
        }

        h2 {
            color: #333;
        }

        .button-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .button {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: rgb(65, 202, 226);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
        }

        .button:hover {
            background-color: rgb(56, 175, 196);
        }
    </style>
    <script>
        window.onload = function() {
            var message = "<?php echo $message; ?>";
            if (message !== "") {
                alert(message);
            }
        }
    </script>
</head>
<body>

<div class="container">
    <h2><?php echo $message; ?></h2>
    <div class="button-container">
        <a href="tampil.php" class="button">Tampilkan Data</a>
        <a href="form.html" class="button">Tambahkan Data</a>
    </div>
</div>

</body>
</html>
