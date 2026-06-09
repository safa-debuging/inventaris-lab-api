<?php
header("Content-Type: application/json");
include 'koneksi.php';

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['id_alat'])) {
$id_alat = $input['id_alat'];

$query = mysqli_query($koneksi, "DELETE FROM tb_alat WHERE id_alat='$id_alat'");

if ($query) {
echo json_encode(["status" => "success", "message" => "Data alat berhasil dihapus"]);
} else {
echo json_encode(["status" => "error", "message" => "Gagal menghapus data alat"]);
}
} else {
echo json_encode(["status" => "error", "message" => "Data tidak lengkap"]);
}
?>