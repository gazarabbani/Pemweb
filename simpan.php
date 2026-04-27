<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "../config/db.php";

$nama = isset($_POST["nama"]) ? trim($_POST["nama"]) : "";
$nim  = isset($_POST["nim"])  ? trim($_POST["nim"])  : "";

if ($nama === "" || $nim === "") {
    echo json_encode([
        "status"  => "error",
        "message" => "Nama dan NIM tidak boleh kosong!"
    ]);
    exit;
}

// Cek apakah NIM sudah ada (NIM = PRIMARY KEY)
$cek = $conn->prepare("SELECT nim FROM mahasiswa WHERE nim = ?");
$cek->bind_param("s", $nim);
$cek->execute();
$cek->store_result();

if ($cek->num_rows > 0) {
    // UPDATE jika NIM sudah ada
    $stmt = $conn->prepare("UPDATE mahasiswa SET nama = ? WHERE nim = ?");
    $stmt->bind_param("ss", $nama, $nim);
    $aksi = "diperbarui";
} else {
    // INSERT jika NIM baru
    $stmt = $conn->prepare("INSERT INTO mahasiswa (nim, nama) VALUES (?, ?)");
    $stmt->bind_param("ss", $nim, $nama);
    $aksi = "disimpan";
}

if ($stmt->execute()) {
    echo json_encode([
        "status"  => "success",
        "message" => "Data berhasil $aksi!",
        "data"    => ["nama" => $nama, "nim" => $nim]
    ]);
} else {
    echo json_encode([
        "status"  => "error",
        "message" => "Gagal: " . $conn->error
    ]);
}

$cek->close();
$stmt->close();
$conn->close();
?>