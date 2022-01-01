<?php
    require_once ('connection.php');
    header('Content-Type: application/json');

    if (empty($_POST['ID'])) {
        die(json_encode(array('status' => false, 'code' => 1, 'data' => 'Parameters not valid')));
    }

    $stmt = $conn->prepare("UPDATE nghiphep SET trangthai = 'approved' WHERE ID = ?");
    $stmt->bind_param("s", $_POST['ID']);
    
    if (!$stmt->execute()) {
        die(json_encode(array('status' => false, 'code' => 2, 'data' => $stmt->error)));
    }
    else if ($stmt->affected_rows == 0) {
        die(json_encode(array('status' => false, 'code' => 3, 'data' => "Không có record nào được cập nhật")));
    }

    else {
        die(json_encode(array('status' => true, 'code' => 0, 'data' => "Đã đồng ý yêu cầu nghỉ phép")));
    }


?>