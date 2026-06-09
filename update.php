<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: view.php");
    exit;
}

$id_pinjam = $_GET['id'];
$query_transaksi = mysqli_query($koneksi, "SELECT * FROM riwayat_peminjaman WHERE id_pinjam = '$id_pinjam'");
$data_lama = mysqli_fetch_assoc($query_transaksi);

if (!$data_lama) {
    die("Data transaksi tidak ditemukan.");
}

$data_alat = mysqli_query($koneksi, "SELECT id_alat, nama_alat FROM alat");
$data_peminjam = mysqli_query($koneksi, "SELECT id_peminjam, nama_peminjam FROM peminjam");

if (isset($_POST['update'])) {
    $id_alat         = mysqli_real_escape_string($koneksi, $_POST['id_alat']);
    $id_peminjam     = mysqli_real_escape_string($koneksi, $_POST['id_peminjam']);
    $tanggal_pinjam  = mysqli_real_escape_string($koneksi, $_POST['tanggal_pinjam']);
    $tanggal_kembali = mysqli_real_escape_string($koneksi, $_POST['tanggal_kembali']);

    $tgl_kembali_val = empty($tanggal_kembali) ? "NULL" : "'$tanggal_kembali'";

    $update = "UPDATE riwayat_peminjaman SET 
               id_alat = '$id_alat', 
               id_peminjam = '$id_peminjam', 
               tanggal_pinjam = '$tanggal_pinjam', 
               tanggal_kembali = $tgl_kembali_val 
               WHERE id_pinjam = '$id_pinjam'";

    if (mysqli_query($koneksi, $update)) {
        if (!empty($tanggal_kembali)) {
            mysqli_query($koneksi, "UPDATE alat SET status = 'Tersedia' WHERE id_alat = '$id_alat'");
        }
        echo "<script>alert('Data berhasil diperbarui!'); window.location='view.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal memperbarui data: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Peminjaman</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; width: 300px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group select { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn-update { background-color: #ffc107; color: black; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>

    <h2>Edit Transaksi Peminjaman</h2>
    <a href="view.php">Kembali ke Daftar</a><br><br>

    <form action="" method="POST">
        <div class="form-group">
            <label>ID Transaksi:</label>
            <input type="text" value="<?= htmlspecialchars($data_lama['id_pinjam']) ?>" disabled style="background-color: #e9ecef;">
        </div>
        <div class="form-group">
            <label>Pilih Alat:</label>
            <select name="id_alat" required>
                <?php while($alat = mysqli_fetch_assoc($data_alat)): ?>
                    <option value="<?= $alat['id_alat'] ?>" <?= $alat['id_alat'] == $data_lama['id_alat'] ? 'selected' : '' ?>>
                        <?= $alat['nama_alat'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Pilih Peminjam:</label>
            <select name="id_peminjam" required>
                <?php while($pemp = mysqli_fetch_assoc($data_peminjam)): ?>
                    <option value="<?= $pemp['id_peminjam'] ?>" <?= $pemp['id_peminjam'] == $data_lama['id_peminjam'] ? 'selected' : '' ?>>
                        <?= $pemp['nama_peminjam'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Tanggal Pinjam:</label>
            <input type="date" name="tanggal_pinjam" value="<?= $data_lama['tanggal_pinjam'] ?>" required>
        </div>
        <div class="form-group">
            <label>Tanggal Kembali:</label>
            <input type="date" name="tanggal_kembali" value="<?= $data_lama['tanggal_kembali'] ?>">
        </div>
        
        <button type="submit" name="update" class="btn-update">Perbarui Data</button>
    </form>

</body>
</html>