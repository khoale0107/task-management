<?php
    require_once ('connection.php');
    header('Content-Type: application/json');


    if (empty($_POST['employeeid']) || empty($_POST['fullname']) || empty($_POST['departmentid'])) {
        die(json_encode(array('status' => false, 'code' => 1, 'data' => 'Parameters not valid')));
    }   

    $username = $_POST['employeeid'];
    $password = password_hash($_POST['employeeid'], PASSWORD_DEFAULT);
    $hoten = $_POST['fullname'];
    $maphongban = $_POST['departmentid'];

    $stmt = $conn->prepare('INSERT INTO account(username,password,hoten,maphongban) VALUES(?,?,?,?)');
    $stmt->bind_param("sssi", $username, $password, $hoten, $maphongban);

    if (!$stmt->execute()) {
        die(json_encode(array('status' => false, 'code' => 2, 'data' => $stmt->error)));
    }
    
    die(json_encode(array('status' => true, 'code' => 0, 'data' => 'Thêm nhân viên thành công')));

?>