<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "../config/db.php";

// Ambil data terakhir berdasarkan created_at
$result = $conn->query(
    "SELECT nama, nim FROM mahasiswa ORDER BY created_at DESC LIMIT 1"
);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        "status" => "success",
        "data"   => $row
    ]);
} else {
    echo json_encode([
        "status"  => "empty",
        "message" => "Belum ada data"
    ]);
}

$conn->close();
?>