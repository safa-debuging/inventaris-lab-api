<?php
include 'koneksi.php';

$query = "SELECT r.*, a.nama_alat, p.nama_peminjam 
          FROM riwayat_peminjaman r
          JOIN alat a ON r.id_alat = a.id_alat
          JOIN peminjam p ON r.id_peminjam = p.id_peminjam";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Peminjaman Alat Lab</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .btn { padding: 6px 12px; text-decoration: none; border-radius: 4px; display: inline-block; }
        .btn-tambah { background-color: #28a745; color: white; margin-bottom: 10px; }
        .btn-edit { background-color: #ffc107; color: black; }
        .btn-hapus { background-color: #dc3545; color: white; }
    </style>
</head>
<body>

    <h2>Daftar Riwayat Peminjaman Alat (Versi Tampilan)</h2>
    <a href="create.php" class="btn btn-tambah">+ Tambah Transaksi Peminjaman</a>

    <table>
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Nama Alat</th>
                <th>Nama Peminjam</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($row['id_pinjam']) ?></strong></td>
                        <td><?= htmlspecialchars($row['nama_alat']) ?></td>
                        <td><?= htmlspecialchars($row['nama_peminjam']) ?></td>
                        <td><?= (!empty($row['tanggal_pinjam']) && $row['tanggal_pinjam'] != '0000-00-00') ? date('d-m-Y', strtotime($row['tanggal_pinjam'])) : '-' ?></td>
                        <td><?= (!empty($row['tanggal_kembali']) && $row['tanggal_kembali'] != '0000-00-00') ? date('d-m-Y', strtotime($row['tanggal_kembali'])) : '-' ?></td>
                        <td>
                            <a href="update.php?id=<?= $row['id_pinjam'] ?>" class="btn btn-edit">Edit</a>
                            <a href="delete.php?id=<?= $row['id_pinjam'] ?>" class="btn btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Belum ada riwayat peminjaman.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>