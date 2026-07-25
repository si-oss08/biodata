<?php
// panggil koneksi database
include 'koneksi.php';

// cek apakah parameter id ada
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // query hapus data
    $sql = "DELETE FROM data_mahasiswa WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        // jika berhasil, kembali ke halaman tabel
        header("Location: tabel.php"); // ganti sesuai nama file tabel kamu
        exit();
    } else {
        echo "Error menghapus data: " . $conn->error;
    }
} else {
    echo "ID tidak ditemukan!";
}
// tutup koneksi
$conn->close();
?>