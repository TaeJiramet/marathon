<?php
$host = "sql303.infinityfree.com"; // หรือค่าที่ Hosting กำหนด
$user = "if0_40745176"; // ไม่ใช่ root
$pass = "4w8EkyBqbK";
$db = "if0_40745176_XXX";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}
?>