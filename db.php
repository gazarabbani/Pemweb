<?php
$host     = "localhost";
$user     = "root";
$password = ""; 
$database = "student_card";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die(json_encode([
        "status"  => "error",
        "message" => "Koneksi gagal: " . $conn->connect_error
    ]));
}
?>