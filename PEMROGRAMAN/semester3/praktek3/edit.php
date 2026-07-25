<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit data</title>
    <style>
        /* Mengatur gaya umum pada seluruh halaman */
        body {
            font-family: Arial, sans-serif; /* Menentukan jenis huruf */
            background-image: url(gambar.jpeg); /* Warna latar belakang halaman */
            background-repeat: no-repeat; /*gambar tidak diulang atau double*/
            background-position: center; /*posisi di tengah*/
            background-size: cover; /*ukuran penuh*/
            background-attachment: fixed; /*membuat gambar tidak berubah*/
            margin: 40px; /* Jarak dari tepi browser */
            color: #333; /* Warna teks */
        }

        /* Judul halaman */
        h3 {
            text-align: center; /* Menengahkan teks */
            color: #ffffff; /* Warna teks judul */
            justify-content: center;
            align-items: center;
            margin-bottom: 30px; /* Jarak bawah antara judul dan form */
        }

        /* Desain utama form */
        form {
            width: 350px; /* Lebar form */
            margin: 0 auto; /* Menengahkan form di halaman */
            background: rgba(0, 0, 0, 0); /* Latar belakang form */
            color: #eadcdc; /* Warna teks judul */
            padding: 25px; /* Ruang dalam form */
            border-radius: 10px; /* Membuat sudut melengkung */
        }

        /* Label input */
        label {
            display: block; /* Menampilkan label di baris baru */
            margin-bottom: 8px; /* Jarak bawah antara label dan input */
            font-weight: bold; /* Membuat teks label tebal */
        }

        /* Mengatur tampilan untuk input bertipe text dab date*/
        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%; /* Lebar kotak input */
            padding: 10px; /* Jarak antara teks dan tepi kotak */
            border: none; /* Menghapus garis tepi bawaan browser */
            border-radius: 10px; /* Membuat sudut kotak melengkung */
            background-color: rgba(0, 0, 0, 0.7); /* Warna latar belakang hitam transparan (70%) */
            color: rgb(255, 255, 255); /* Warna teks putih agar kontras */
            font-size: 14px; /* Ukuran huruf di dalam input */
            outline: none; /* Menghilangkan garis fokus default */
            box-shadow: 0 0 15px rgb(2, 2, 248); /* Efek cahaya lembut warna cyan di sekitar kotak */
        }

        /* Efek saat input aktif (fokus) */
        input[type="text"]:focus {
            border-color: #f50000; /* Garis tepi berubah jadi biru */
            outline: none; /* Menghilangkan outline bawaan browser */
        }

        input[type="submit"] {
            display: block; /* Supaya bisa diatur posisinya */
            margin: 20px auto; /* Otomatis tengah secara horizontal */
            width: 100px; /* Sedikit lebih lebar agar seimbang */
            padding: 10px; /* Jarak antara teks dan tepi kotak */
            border: none; /* Menghilangkan garis fokus default */
            border-radius: 10px; /* Membuat sudut kotak melengkung */
            background-color: rgba(0, 0, 0, 0.7); /* Warna cyan transparan */
            color: rgb(255, 255, 255); /* Warna teks putih agar kontras */
            font-size: 14px; /* Ukuran huruf di dalam input */
            font-weight: bold; /* Menebalkan teks pada tombol agar lebih terlihat jelas dan menonjol */
            cursor: pointer; /* Ubah kursor jadi tangan saat diarahkan */
            box-shadow: 0 0 20px rgb(2, 2, 248); /* Efek cahaya serupa dengan input lainnya */
            transition: 0.3s; /* Transisi halus saat hover */
        }

        /* Efek hover pada tombol */
        input[type="submit"]:hover {
            background-color: #3490f9; /* Warna tombol berubah saat diarahkan */
        }
    </style>
</head>
    <?php
    include 'koneksi.php';

    if(isset($_GET['id'])) { 
        $id = $_GET['id'];

        // Ambil data berdasarkan ID
        $sql = "SELECT * FROM data_mahasiswa WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "Data tidak ditemukan!";
            exit;
        }
    }

    if(isset($_POST['submit'])) {
        // Ambil data dari form
        $Nama = $_POST['Nama'];
        $Alamat = $_POST['Alamat'];
        $NPM = $_POST['NPM'];
        $Nilai = $_POST['Nilai'];
        $Tgl = $_POST['Tgl'];

        // Query update
        $update_sql = "UPDATE data_mahasiswa 
                    SET 
                    Nama='$Nama',
                    Alamat='$Alamat',
                    NPM='$NPM', 
                    Nilai='$Nilai', 
                    Tgl='$Tgl' WHERE id=$id";
                            
        if ($conn->query($update_sql) === TRUE) {
            header('Location: tabel.php');
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    }
    ?>
<body>
    <form method="post" action="">
        <label for="Nama">Nama:</label>
        <input type="text" name="Nama" value="<?php echo $row['Nama']; ?>"><br><br>
    
        <label for="Alamat">Alamat:</label>
        <input type="text" name="Alamat" value="<?php echo $row['Alamat']; ?>"><br><br>
    
        <label for="NPM">NPM:</label>
        <input type="text" name="NPM" value="<?php echo $row['NPM']; ?>"><br><br>
        
        <label for="Tgl">Tgl:</label>
        <input type="date" name="Tgl" value="<?php echo $row['Tgl']; ?>"><br><br>

        <label for="Nilai">Nilai:</label>
        <input type="number" name="Nilai" value="<?php echo $row['Nilai']; ?>"><br><br>
    
        <input type="submit" name="submit" value="Update">
    </form>
</body>
</html>
<?php
$conn->close();
?>