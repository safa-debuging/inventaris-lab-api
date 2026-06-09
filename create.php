<?php
header("Content-Type: application/json");
include 'koneksi.php';

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['id_alat'], $input['nama_alat'], $input['asal_lab'], $input['status'])) {
$id_alat = $input['id_alat'];
$nama_alat = $input['nama_alat'];
$asal_lab = $input['asal_lab'];
$status = $input['status'];

$query = mysqli_query($koneksi, "INSERT INTO tb_alat (id_alat, nama_alat, asal_lab, status) VALUES ('$id_alat', '$nama_alat', '$asal_lab', '$status')");

if ($query) {
echo json_encode(["status" => "success", "message" => "Data alat berhasil ditambah"]);
} else {
echo json_encode(["status" => "error", "message" => "Gagal menambah data alat"]);
}
} else {
echo json_encode(["status" => "error", "message" => "Data tidak lengkap"]);
}
?>