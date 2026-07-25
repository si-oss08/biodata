<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('gambar.jpeg'); /* ganti dengan gambar kamu */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 40px;
        }

        table {
            width: 70%;
            margin: auto;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 7px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        th {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
        }

        td {
            padding: 8px;
            text-align: center;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e0f7fa;
        }

        a {
            width: 60px;
            text-align: center;
            display: inline-block;
            text-decoration: none;
            color: #d6d6d6ff;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #3498db;
            box-shadow: 0 0 2px rgb(2, 2, 248);
            font-weight: bold;
        }

        a:hover {
            color: #0056b3;
        }

        .pp {
            display: inline-block;/* Mengubah elemen <a> menjadi inline-block agar bisa diberi margin, padding, dan ukuran */
            margin-top: 8px;/* Memberi jarak bagian atas antar elemen */
            text-decoration: none;/* Menghilangkan garis bawah default pada link */
            color: white;/* Mengatur warna teks menjadi putih */
            padding: 8px 14px;/* Memberi ruang di dalam elemen (atas-bawah 8px, kiri-kanan 14px) */
            border-radius: 7px;/* Membuat sudut elemen menjadi membulat */
            background-color: #3498db;/* Memberi warna latar belakang biru pada link */
            box-shadow: 0 0 15px rgb(2, 2, 248);/* Memberi efek bayangan/glow berwarna biru */
        }
        
        .pp:hover {
            color: white;/* Mengubah warna teks menjadi putih saat kursor diarahkan ke link */
            background-color: rgb(2, 2, 248);/* Mengubah warna latar belakang menjadi biru tua saat hover */
        }

        .parent {
            display: flex;
            justify-content: center; /* tengah horizontal */
            align-items: center;     /* tengah vertikal */
        }

        h2{
            text-align:center;
            color: white;
        }

        @media print {
            .btn-print {
                display: none; /* sembunyikan tombol saat print */
            }
        }
    </style>
</head>
<body>
    <?php
    include 'koneksi.php';

    // membuat query SQL untuk mengambil data dari tabel data_mahasiswa
    $sql = "SELECT * FROM data_mahasiswa";

    // membuat query dan menyimpan hasilnya pada variabel
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        // membuat baris header tabel dengan nama kolom
        echo"<tr>
                <th>id</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>NPM</th>
                <th>Tanggal Lahir</th>
                <th>Nilai</th>
                <th>Status</th>
                <th colspan='2'>Action</th>
            </tr>";
            
            // melakukan perulangan untuk sertiap baris data mahasiswa yang ddidapat dari query
        while($row = $result->fetch_assoc()) {
        echo "<tr>";
        // Menampilkan data setiap kolom pada tabel
        echo "<td>".$row['id']."</td>";
        echo "<td>".$row['Nama']."</td>";
        echo "<td>".$row['Alamat']."</td>";
        echo "<td>".$row['NPM']."</td>";
        echo "<td>".$row['Tgl']."</td>";
        echo "<td>".$row['Nilai']."</td>";
        echo "<td>" . ($row['Nilai'] >= 80 ? "Lulus" : "Tidak Lulus") . "</td>";
        //menambahkan link edit dan hapus
        echo "<td><a href='edit.php?id=".$row['id']."'>Edit</a></td>";
        echo "<td><a href='hapus.php?id=".$row['id']."' onclick='return confirm(\"yakin ingin menghapus data?\")'>Hapus</a></td>";
        echo "</tr>";
        }
        echo "</table>";
        echo "<br>";
        echo '<div class="parent"><a class="pp" href="landingpage.html">Beranda</a></div><br>';
        echo "<div class='parent'><a class='pp' type='button' onclick='window.print()'>Print</a></div>";

    // jika form belum di submit 
    }   else {
        echo "<h2>Data Tidak Ada.</h2>";
        echo '<div class="parent"><a class="pp" href="landingpage.html">Beranda</a></div>';
    }
    // menutup koneksi database setelah proses selesai
    $conn->close();
    ?>
</body>
</html>
<div class="parent"></div>