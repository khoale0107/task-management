<?php
session_start();

require_once 'connection.php';
header('Content-Type: application/json');


//new password must be different from :
//-username
//-current password

//check input
if (empty($_POST['current-password']) || empty($_POST['new-password']) || empty($_POST['confirm-password'])) {
    die(json_encode(array('status' => false, 'data' => 'Parameters not valid.')));
}

//check if current password is correct
$current_password = $_POST['current-password'];
if (!password_verify($current_password, $_SESSION['hashed-password'])) {
    die(json_encode(array('status' => false, 'data' => 'Mật khẩu hiện tại không đúng.')));
}

//check if new password is equal to username
$new_password = $_POST['new-password'];
$confirm_password = $_POST['confirm-password'];
if ($new_password === $_SESSION['user']) {
    die(json_encode(array('status' => false, 'data' => 'Mật khẩu không được trùng với tên đăng nhập')));
}

//check if new password is equal to old password
if (password_verify($new_password, $_SESSION['hashed-password'])) {
    die(json_encode(array('status' => false, 'data' => 'Mật khẩu mới không được trùng với mật khẩu cũ')));
}

//check confirm password
if ($new_password !== $confirm_password) {
    die(json_encode(array('status' => false, 'data' => 'Mật khẩu xác nhận không đúng.')));
}

$new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

$stmt = $conn->prepare('UPDATE account SET password = ? WHERE username = ?');
$stmt->bind_param("ss", $new_hashed_password, $_SESSION['user']);

if (!$stmt->execute()) {
    die(json_encode(array('status' => false, 'data' => $stmt->error)));
}
else if ($stmt->affected_rows == 0) {
    die(json_encode(array('status' => false, 'data' => '0 row affected')));
}
else {
    $_SESSION['hashed-password'] = $new_hashed_password;
    die(json_encode(array('status' => true, 'data' => 'Đổi mật khẩu thành công!')));
}
?>