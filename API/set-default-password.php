<?php
    require_once ('connection.php');
    header('Content-Type: application/json');

    if (empty($_POST['employeeid'])) {
        die(json_encode(array('status' => false, 'code' => 1, 'data' => 'Parameters not valid')));
    }

    $username = $_POST['employeeid'];
    $default_hashed_password = password_hash($username, PASSWORD_DEFAULT);

    $stmt = $conn->prepare('UPDATE account SET password = ? WHERE username = ?');
    $stmt->bind_param("ss", $default_hashed_password, $username);
    
    if (!$stmt->execute()) {
        die(json_encode(array('status' => false, 'code' => 2, 'data' => $stmt->error)));
    }
    else if ($stmt->affected_rows == 0) {
        die(json_encode(array('status' => false, 'code' => 3, 'data' => '0 row affected')));
    }
    else {
        die(json_encode(array('status' => true, 'code' => 0, 'data' => 'Đặt mật khẩu về mặc định thành công.')));
    }
?>

