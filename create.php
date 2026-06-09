<?php
include 'koneksi.php';

$data_alat = mysqli_query($koneksi, "SELECT id_alat, nama_alat, status FROM alat");
$data_peminjam = mysqli_query($koneksi, "SELECT id_peminjam, nama_peminjam FROM peminjam");

if (isset($_POST['submit'])) {
    $id_pinjam       = mysqli_real_escape_string($koneksi, $_POST['id_pinjam']);
    $id_alat         = mysqli_real_escape_string($koneksi, $_POST['id_alat']);
    $id_peminjam     = mysqli_real_escape_string($koneksi, $_POST['id_peminjam']);
    $tanggal_pinjam  = mysqli_real_escape_string($koneksi, $_POST['tanggal_pinjam']);
    $tanggal_kembali = mysqli_real_escape_string($koneksi, $_POST['tanggal_kembali']);

    $cek_alat = mysqli_query($koneksi, "SELECT status FROM alat WHERE id_alat = '$id_alat'");
    $status_alat = mysqli_fetch_assoc($cek_alat);

    if ($status_alat['status'] == 'Dipinjam') {
        echo "<script>alert('Gagal: Alat tersebut sedang dipinjam!'); window.location='create.php';</script>";
        exit;
    }

    $tgl_kembali_val = empty($tanggal_kembali) ? "NULL" : "'$tanggal_kembali'";

    $insert = "INSERT INTO riwayat_peminjaman (id_pinjam, id_alat, id_peminjam, tanggal_pinjam, tanggal_kembali) 
               VALUES ('$id_pinjam', '$id_alat', '$id_peminjam', '$tanggal_pinjam', $tgl_kembali_val)";

    if (mysqli_query($koneksi, $insert)) {
        mysqli_query($koneksi, "UPDATE alat SET status = 'Dipinjam' WHERE id_alat = '$id_alat'");
        echo "<script>alert('Data berhasil ditambahkan!'); window.location='view.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menambahkan data: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Peminjaman</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; width: 300px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group select { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn-simpan { background-color: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>

    <h2>Tambah Transaksi Peminjaman</h2>
    <a href="view.php">Kembali ke Daftar</a><br><br>

    <form action="" method="POST">
        <div class="form-group">
            <label>ID Transaksi (ID Pinjam):</label>
            <input type="text" name="id_pinjam" placeholder="Contoh: TRX-002" required>
        </div>
        <div class="form-group">
            <label>Pilih Alat:</label>
            <select name="id_alat" required>
                <option value="">-- Pilih Alat --</option>
                <?php while($alat = mysqli_fetch_assoc($data_alat)): ?>
                    <option value="<?= $alat['id_alat'] ?>"><?= $alat['nama_alat'] ?> (<?= $alat['status'] ?>)</option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Pilih Peminjam:</label>
            <select name="id_peminjam" required>
                <option value="">-- Pilih Peminjam --</option>
                <?php while($pemp = mysqli_fetch_assoc($data_peminjam)): ?>
                    <option value="<?= $pemp['id_peminjam'] ?>"><?= $pemp['nama_peminjam'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Tanggal Pinjam:</label>
            <input type="date" name="tanggal_pinjam" required>
        </div>
        <div class="form-group">
            <label>Tanggal Kembali:</label>
            <input type="date" name="tanggal_kembali">
        </div>
        
        <button type="submit" name="submit" class="btn-simpan">Simpan Transaksi</button>
    </form>

</body>
</html>