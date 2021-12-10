<?php
    require_once ('connection.php');
    header('Content-Type: application/json');

    if (empty($_POST['employeeid']) || empty($_POST['departmentid'])) {
        die(json_encode(array('status' => false, 'code' => 1, 'data' => 'Parameters not valid')));
    }

    $employeeid = $_POST['employeeid'];
    $departmentid = $_POST['departmentid'];
    

    $stmt = $conn->prepare("UPDATE phongban SET matruongphong = ? WHERE phongban.ID = ?;");
    $stmt->bind_param("si", $employeeid, $departmentid);
    
    if (!$stmt->execute()) {
        die(json_encode(array('status' => false, 'code' => 2, 'data' => $stmt->error)));
    }
    else if ($stmt->affected_rows == 0) {
        die(json_encode(array('status' => false, 'code' => 3, 'data' => "Không có phòng ban nào được cập nhật")));
    }

    else {
        die(json_encode(array('status' => true, 'code' => 0, 'data' => "Cập nhật phòng ban thành công")));
    }
?>

