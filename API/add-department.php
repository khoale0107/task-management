<?php
    require_once ('connection.php');
    header('Content-Type: application/json');


    if (empty($_POST['departmentName']) || empty($_POST['description']) || empty($_POST['numberOfRooms'])) {
        die(json_encode(array('status' => false, 'code' => 1, 'data' => 'Parameters not valid')));
    }

    $tenphongban = $_POST['departmentName'];
    $mota = $_POST['description'];
    $sophong = $_POST['numberOfRooms'];

    if (!is_numeric($sophong)) {
        die(json_encode(array('status' => false, 'code' => 3, 'data' => 'Chỉ được nhập số nguyên vào số phòng')));
    }

    if ($sophong < 1) {
        die(json_encode(array('status' => false, 'code' => 4, 'data' => 'Hãy nhập số nguyên dương vào số phòng')));
    }

    if ($sophong - floor($sophong) != 0) {
        die(json_encode(array('status' => false, 'code' => 5, 'data' => 'Chỉ được nhập số nguyên vào số phòng')));
    }

    $stmt = $conn->prepare('INSERT INTO phongban(tenphongban,mota,sophong) VALUES(?,?,?)');
    $stmt->bind_param("ssi", $tenphongban, $mota, $sophong);

    if (!$stmt->execute()) {
        die(json_encode(array('status' => false, 'code' => 2, 'data' => $stmt->error)));
    }
    
    die(json_encode(array('status' => true, 'code' => 0, 'data' => 'Thêm phòng ban thành công')));

?>