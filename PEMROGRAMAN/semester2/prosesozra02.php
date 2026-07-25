<?php
if (isset($_POST['masukkan'])) {
    $nama = $_POST['nama'];
    $npm = $_POST['npm'];
    $no = $_POST['no'];
    $tgl = $_POST['tgl'];
    $jenis = $_POST['jenis'];
    echo "Nama Anda : <b>$nama</b><br>";
    echo "NPM : <b>$npm</b><br>";
    echo "no hp : <b>$no</b><br>";
    echo "Tanggal Lahir : <b>$tgl</b><br>";
    echo "Jenis Kelamin : <b>$jenis</b><br>";
}
?>