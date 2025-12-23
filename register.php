<?php
header('Content-Type: application/json');
include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
    exit;
}

// บันทึก runner
$first_name = $conn->real_escape_string($data['firstName']);
$last_name = $conn->real_escape_string($data['lastName']);
$dob = $conn->real_escape_string($data['dob']);
$gender = $conn->real_escape_string($data['gender']);
$phone = $conn->real_escape_string($data['phone']);
$email = $conn->real_escape_string($data['email']);
$address = $conn->real_escape_string($data['address']);
$is_disabled = $data['isDisabled'] ? 1 : 0;

$sql_runner = "INSERT INTO runner (first_name,last_name,date_of_birth,gender,phone,email,address,is_disabled)
VALUES ('$first_name','$last_name','$dob','$gender','$phone','$email','$address','$is_disabled')";

if ($conn->query($sql_runner) === TRUE) {
    $runner_id = $conn->insert_id;

    $category_id = intval($data['raceCategory']);
    $age_group = $conn->real_escape_string($data['ageGroup']);
    $shirt_size = $conn->real_escape_string($data['shirtSize']);
    $shipping_option = intval($data['shippingOption']);

    $sql_reg = "INSERT INTO registration (runner_id,race_category,age_group,shirt_size,shipping_option)
                VALUES ($runner_id,$category_id,'$age_group','$shirt_size',$shipping_option)";

    if ($conn->query($sql_reg) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'สมัครแข่งขันสำเร็จ']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}

$conn->close();
?>