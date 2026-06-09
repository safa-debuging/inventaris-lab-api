<?php
header("Content-Type: application/json");
include 'koneksi.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
$query = mysqli_query($koneksi, "SELECT * FROM tb_alat");
$data = [];
while ($row = mysqli_fetch_assoc($query)) {
$data[] = $row;
}
echo json_encode($data);
} else {
echo json_encode(["status" => "error", "message" => "Method tidak diizinkan"]);
}
?>