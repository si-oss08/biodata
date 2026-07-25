<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Inputan Data</title>
    <style>
        body {
            font-family: Arial, sans-serif; /* Menentukan jenis huruf */
            background-image: url(gambar.jpeg);/* Warna latar belakang halaman */
            background-repeat: no-repeat;/*gambar tidak diulang atau double*/
            background-position: center;/*posisi di tengah*/
            background-size: cover;/*ukuran penuh*/
            background-attachment: fixed;/*membuat gambar tidak berubah*/
            margin: 40px; /* Jarak dari tepi browser */
            color: #333; /* Warna teks */
            position: absolute; /* Mengatur posisi elemen secara absolut terhadap elemen induk terdekat yang memiliki position selain static */
            top: 50%; /* Menggeser elemen ke 50% dari tinggi elemen induk */
            left: 45%; /* Menggeser elemen ke 45% dari lebar elemen induk */
            transform: translate(-50%, -50%); /* Menggeser kembali elemen sebesar 50% dari lebar dan tinggi elemen itu sendiri, sehingga posisi elemen benar-benar berada di tengah */

        }
        div{
            width: 350px; /* Lebar form */
            margin: 0 auto; /* Menengahkan form di halaman */
            background: rgba(230, 44, 44, 0); /* Latar belakang form */
            color: #ffffff; /* Warna teks judul */
            padding: 25px; /* Ruang dalam form */
            border-radius: 10px; /* Membuat sudut melengkung */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Bayangan lembut */
        }

        a {
            display: inline-block;/* Mengubah elemen <a> menjadi inline-block agar bisa diberi margin, padding, dan ukuran */
            margin-top: 8px;/* Memberi jarak bagian atas antar elemen */
            text-decoration: none;/* Menghilangkan garis bawah default pada link */
            color: white;/* Mengatur warna teks menjadi putih */
            padding: 8px 14px;/* Memberi ruang di dalam elemen (atas-bawah 8px, kiri-kanan 14px) */
            border-radius: 7px;/* Membuat sudut elemen menjadi membulat */
            background-color: #3498db;/* Memberi warna latar belakang biru pada link */
            box-shadow: 0 0 15px rgb(2, 2, 248);/* Memberi efek bayangan/glow berwarna biru */
        }
        
        a:hover {
            color: white;/* Mengubah warna teks menjadi putih saat kursor diarahkan ke link */
            background-color: rgb(2, 2, 248);/* Mengubah warna latar belakang menjadi biru tua saat hover */
        }
    </style>
</head>
<body>
    <?php
    include 'koneksi.php';
    //mengecek apakah form telah di submit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // mengambil data yang dikirimkan dari form
        $Nama   = strtoupper($_POST["Nama"]);//strtoupper → memastikan semua huruf besar
        $Alamat = ucwords(strtolower($_POST["Alamat"]));//ucwords() → membuat huruf besar di awal setiap kata, strtolower() → memastikan semua huruf kecil
        $NPM = $_POST["NPM"];
        $Nilai = $_POST["Nilai"];
        $Tgl = $_POST["Tgl"];

        if ($Nilai >= 80) {
            $Status="Selamat Anda Lulus";
            } 
            else {
            $Status="Anda Tidak Lulus";
            }

        // Query Simpan ke Database
        $sql = "INSERT INTO Data_Mahasiswa (Nama, Alamat, NPM, Nilai, Tgl)
                VALUES ('$Nama', '$Alamat', '$NPM', '$Nilai', '$Tgl')";

        $conn->query($sql);

        echo "<div class='container'>";
        echo "<center>";
        //menampilkan data yang diterima dari form
        echo "<h3>Data Yang Dimasukkan</h3>";
        echo "<h3>Nama: $Nama <br>";
        echo "Alamat : $Alamat<br>";
        echo "NPM : $NPM<br>";
        echo "Tanggal Lahir : $Tgl<br>";
        echo "Nilai : $Nilai<br>";
        echo "Status : $Status<br></h3>";
        echo '<a href="index.html">Masukkan Data Lain</a><br><br>';
        echo '<a href="landingpage.html">Kembali ke Beranda</a>';
        echo  "</div>";
        echo "</center>";
    }   else {
        //jika form belum di submit
        echo "form belum disubmit";
        echo "<center>";
        echo '<a href="index.html">Masukkan Data Lain</a><br><br>';
        echo '<a href="landingpage.html">Kembali ke Beranda</a>';
        echo "</center>";
    }
    ?>
</body>
</html>