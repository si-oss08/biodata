<!DOCTYPE html>
<html lang="en">
<head>
    <title>Aplikasi Input Data</title>
    <style>
        body {
            font-family: Arial, sans-serif; /* Menentukan jenis huruf */
            background-image: url(hacker-binary-5184x3456-13679.jpg);/* Warna latar belakang halaman */
            background-repeat: no-repeat;/*gambar tidak diulang atau double*/
            background-position: center;/*posisi di tengah*/
            background-size: cover;/*ukuran penuh*/
            background-attachment: fixed;/*membuat gambar tidak berubah*/
            margin: 40px; /* Jarak dari tepi browser */
            color: #333; /* Warna teks */
        }
        div{
            width: 350px; /* Lebar form */
            margin: 0 auto; /* Menengahkan form di halaman */
            background: rgba(0, 0, 0, 0,); /* Latar belakang form */
            color: #ffffff; /* Warna teks judul */
            padding: 25px; /* Ruang dalam form */
            border-radius: 10px; /* Membuat sudut melengkung */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Bayangan lembut */
        }

        /* Tombol kirim (submit) */
        button{
            background-color: #3498db; /* Warna tombol */
            color: #fff; /* Warna teks tombol */
            border: none; /* Menghilangkan garis tepi */
            padding: 10px 20px; /* Ukuran tombol */
            border-radius: 5px; /* Sudut melengkung */
            cursor: pointer; /* Ubah kursor jadi tangan */
            font-size: 15px; /* Ukuran teks */
            transition: background-color 0.3s; /* Efek animasi saat hover */
        }
    </style>
</head>

<body>
    <?php
    include 'penghubung.php';
    //mengecek apakah form telah di submit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // mengambil data yang dikirimkan dari form
        $Nama = $_POST["Nama"];
        $Alamat = $_POST["Alamat"];
        $NPM = $_POST["NPM"];
        $Fakultas = $_POST["Fakultas"];
        $Tgl = $_POST["Tgl"];

        // Query Simpan ke Database
        $sql = "INSERT INTO siswa (Nama, Alamat, NPM, Fakultas, Tgl)
                VALUES ('$Nama', '$Alamat', '$NPM', '$Fakultas', '$Tgl')";

        $conn->query($sql);

        echo "<div class='container'><form>";
        echo "<center>";
        //menampilkan data yang diterima dari form
        echo "<h3>data yang dimasukkan</h3>";
        echo "<h3>Nama: $Nama <br>";
        echo "Alamat : $Alamat<br>";
        echo "NPM : $NPM<br>";
        echo "Fakultas : $Fakultas<br>";
        echo "Tgl : $Tgl</h3><br>";
        echo '<button><a href="index.html">kembali</a></button></div>';

    }   else {
        //jika form belum di submit
        echo "form belum disubmit";
    }
    ?>
</body>
</html>