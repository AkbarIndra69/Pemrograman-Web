<?php
include 'config.php';

if (isset($_GET['hapus_email'])) {
    $email = $_GET['hapus_email'];
    $sql = "DELETE FROM mahasiswa WHERE email = '$email'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Data berhasil dihapus!');
                window.location.href = 'tampil.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data.');
                window.location.href = 'tampil.php';
              </script>";
    }
}

$sql = "SELECT * FROM mahasiswa";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 80%;
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color:rgb(65, 202, 226);
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .button-container {
            margin-top: 20px;
        }

        .button {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color:rgb(65, 202, 226);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
            margin: 5px;
        }

        .button:hover {
            background-color:rgb(56, 175, 196);
        }

        .delete-btn, .edit-btn {
            padding: 10px;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            display: inline-block;
            width: 100px;
            text-align: center;
            text-decoration: none;
            margin: 2px;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        .edit-btn {
            background-color: #007bff;
        }

        .edit-btn:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function confirmDelete(email) {
            var confirmAction = confirm("Apakah Anda yakin ingin menghapus data ini?");
            if (confirmAction) {
                window.location.href = "tampil.php?hapus_email=" + email;
            }
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Daftar Mahasiswa</h2>
    <?php if ($result->num_rows > 0) { ?>
        <table>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Umur</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row["nama"]; ?></td>
                    <td><?php echo $row["email"]; ?></td>
                    <td><?php echo $row["umur"]; ?></td>
                    <td>
                        <a href="edit.php?email=<?php echo $row['email']; ?>" class="edit-btn">Edit</a>
                        <button class="delete-btn" onclick="confirmDelete('<?php echo $row['email']; ?>')">Hapus</button>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else {
        echo "<p>Tidak ada data.</p>";
    } ?>
    
    <div class="button-container">
        <a href="form.html" class="button">Tambah Data</a>
    </div>
</div>

</body>
</html>

<?php
$conn->close();
?>