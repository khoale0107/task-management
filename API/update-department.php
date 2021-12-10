<?php
    require_once ('connection.php');
    header('Content-Type: application/json');

    if (empty($_POST['departmentid']) || empty($_POST['departmentName']) || empty($_POST['description']) || empty($_POST['numberOfRooms'])) {
        die(json_encode(array('status' => false, 'code' => 1, 'data' => 'Parameters not valid')));
    }

    $id = $_POST['departmentid'];
    $tenphongban = $_POST['departmentName'];
    $mota = $_POST['description'];
    $sophong = $_POST['numberOfRooms'];

    if (!is_numeric($sophong)) {
        die(json_encode(array('status' => false, 'code' => 2, 'data' => 'Chỉ được nhập số nguyên vào số phòng')));
    }

    if ($sophong < 1) {
        die(json_encode(array('status' => false, 'code' => 3, 'data' => 'Hãy nhập số nguyên dương vào số phòng')));
    }

    if ($sophong - floor($sophong) != 0) {
        die(json_encode(array('status' => false, 'code' => 4, 'data' => 'Chỉ được nhập số nguyên dương vào số phòng')));
    }

    $stmt = $conn->prepare('UPDATE phongban set tenphongban = ?, mota = ?, sophong = ? WHERE ID = ?');
    $stmt->bind_param("ssii", $tenphongban, $mota, $sophong, $id);
    
    if (!$stmt->execute()) {
        die(json_encode(array('status' => false, 'code' => 5, 'data' => $stmt->error)));
    }
    // else if ($stmt->affected_rows == 0) {
    //     die(json_encode(array('status' => false, 'code' => 6, 'data' => "Không có phòng ban nào được cập nhật")));
    // }
    else {
        die(json_encode(array('status' => true, 'code' => 0, 'data' => "Cập nhật phòng ban thành công")));
    }
?>

