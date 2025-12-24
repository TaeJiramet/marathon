<?php
$host = "sql303.infinityfree.com";
$user = "if0_40745176";
$pass = "4w8EkyBqbK";
$db   = "if0_40745176_XXX";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    // ห้าม echo JSON หรือ HTML ในไฟล์นี้
    die("DB_CONNECTION_FAILED");
}
