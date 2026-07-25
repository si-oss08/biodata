<?php
echo "<marquee>BIODATA MAHASISWA";//<marquee> untuk membuat teks berjalan dari kanan ke kiri
echo "<H1>BIODATA MAHASISWA</H1>";//<h1> untuk tulisan besar
echo "nama : ozra ferdian<br>";//<br> untuk enter
echo "npm : <b>24105111054<br></b>";//<b>
echo "alamat : p. tiji<br>";
echo "<i>no. hp : 081234567899</i><br>";//<i> tulisan mriring

//penggunaan variabel untuk mengolah dan menampilkan data
$nama ="ozra ferdian";
$npm =96269842;

echo "nama saya : $nama<br>";
echo "npm saya : $npm<br>";

//mengolah data dengan variabel
$angka = 3;
$angka1 = 2;
$angka2 = 1;
$hitung = $angka + $angka1 - $angka2 * $angka;

echo "hasil dari $angka + $angka1 - $angka2 * $angka adalah : $hitung </marquee>";
?>