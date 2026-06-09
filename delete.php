
<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_pinjam = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    $cari = mysqli_query($koneksi, "SELECT id_alat FROM riwayat_peminjaman WHERE id_pinjam = '$id_pinjam'");
    $data = mysqli_fetch_assoc($cari);
    
    if ($data) {
        $id_alat = $data['id_alat'];
        if (mysqli_query($koneksi, "DELETE FROM riwayat_peminjaman WHERE id_pinjam = '$id_pinjam'")) {
            mysqli_query($koneksi, "UPDATE alat SET status = 'Tersedia' WHERE id_alat = '$id_alat'");
            echo "<script>alert('Data berhasil dihapus!'); window.location='view.php';</script>";
        } else {
            echo "<script>alert('Gagal: " . mysqli_error($koneksi) . "'); window.location='view.php';</script>";
        }
    }
} else {
    header("Location: view.php");
    exit;
}
?>