<?php
include 'config.php';

if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $sql = "SELECT * FROM mahasiswa WHERE email = '$email'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $email_baru = $_POST['email'];
    $umur = $_POST['umur'];

    $sql = "UPDATE mahasiswa SET nama='$nama', email='$email_baru', umur='$umur' WHERE email='$email'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Data berhasil diperbarui!');
                window.location.href = 'tampil.php';
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Mahasiswa</title>
    <style>
        /* Reset margin dan padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Mengatur body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Menata form */
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        /* Menata label dan input */
        label {
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        /* Menata tombol */
        button {
            width: 100%;
            padding: 10px;
            background-color: #41cae2;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #38afc4;
        }
    </style>
</head>
<body>
    <form method="post">
        <h2>Edit Data Mahasiswa</h2>
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
        
        <label for="umur">Umur:</label>
        <input type="number" id="umur" name="umur" value="<?php echo $row['umur']; ?>" required>
        
        <button type="submit" name="update">Update</button>
    </form>
</body>
</html>