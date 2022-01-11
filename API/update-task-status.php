<?php
    require_once ('connection.php');
    header('Content-Type: application/json');

    if (empty($_POST['id']) || empty($_POST['status'])) {
        die(json_encode(array('status' => false, 'code' => 1, 'data' => 'Parameters not valid')));
    }
    
    $stmt = $conn->prepare("UPDATE task SET trangthai = ?, updatetime = NOW() WHERE ID = ?;");
    $stmt->bind_param("si", $_POST['status'] , $_POST['id']);
    
    if (!$stmt->execute()) {
        die(json_encode(array('status' => false, 'code' => 2, 'data' => $stmt->error)));
    }
    else if ($stmt->affected_rows == 0) {
        die(json_encode(array('status' => false, 'code' => 3, 'data' => "Không có task nào được cập nhật")));
    }

    else {
        die(json_encode(array('status' => true, 'code' => 0, 'data' => "Cập nhật task thành công")));
    }
?>

