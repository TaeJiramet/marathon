<?php
header('Content-Type: application/json; charset=utf-8');

// ปิด error output (InfinityFree แพ้มาก)
error_reporting(E_ALL);
ini_set('display_errors', 0);

include 'db.php';

// อ่าน JSON จาก fetch
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

// ถ้าไม่ได้ JSON → จบ
if (!is_array($data)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid JSON data'
    ]);
    exit;
}

// ป้องกัน undefined index
$first_name  = $conn->real_escape_string($data['firstName'] ?? '');
$last_name   = $conn->real_escape_string($data['lastName'] ?? '');
$dob         = $conn->real_escape_string($data['dob'] ?? '');
$gender      = $conn->real_escape_string($data['gender'] ?? '');
$phone       = $conn->real_escape_string($data['phone'] ?? '');
$email       = $conn->real_escape_string($data['email'] ?? '');
$address     = $conn->real_escape_string($data['address'] ?? '');
$is_disabled = !empty($data['isDisabled']) ? 1 : 0;

// insert runner
$sql_runner = "
INSERT INTO runner
(first_name,last_name,date_of_birth,gender,phone,email,address,is_disabled)
VALUES
('$first_name','$last_name','$dob','$gender','$phone','$email','$address',$is_disabled)
";

if (!$conn->query($sql_runner)) {
    echo json_encode([
        'status' => 'error',
        'message' => $conn->error
    ]);
    exit;
}

$runner_id = $conn->insert_id;

// registration
$category_id = intval($data['raceCategory']);
$age_group   = $conn->real_escape_string($data['ageGroup']);
$shirt_size  = $conn->real_escape_string($data['shirtSize']);
$shipping    = intval($data['shippingOption']);

$sql_reg = "
INSERT INTO registration
(runner_id,race_category,age_group,shirt_size,shipping_option)
VALUES
($runner_id,$category_id,'$age_group','$shirt_size',$shipping)
";

if ($conn->query($sql_reg)) {
    echo json_encode([
        'status' => 'success',
        'message' => 'สมัครแข่งขันสำเร็จ'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => $conn->error
    ]);
}

$conn->close();
