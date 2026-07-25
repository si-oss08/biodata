<?php
$gaji = 1000000;
$pajak = 0.05;
$thp = $gaji - ($gaji*$pajak);

echo "<h1>Cara Menghitung Gaji Bersih</h1>";
echo "<b>gaji pokok kurang pajak</b><br><br>";
echo "Gaji belum pajak = Rp. $gaji <br>";
echo "Gaji yang dibawa pulang = Rp. $thp";
?>