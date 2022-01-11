<?php
    require_once ('connection.php');
    header('Content-Type: application/json');

    if (empty($_POST['id']) || empty($_POST['username']) || empty($_POST['rating'])) {
        die(json_encode(array('status' => false, 'code' => 1, 'data' => 'Parameters not valid')));
    }
    
    $stmt = $conn->prepare("CALL response_task(?, ?,'','')");
    $stmt->bind_param("ss", $_POST['id'] , $_POST['username']);
    
    if (!$stmt->execute()) {
        die(json_encode(array('status' => false, 'code' => 2, 'data' => $stmt->error)));
    }
    else if ($stmt->affected_rows == 0) {
        die(json_encode(array('status' => false, 'code' => 3, 'data' => "Không có task nào được duyệt")));
    }

    $stmt = $conn->prepare("UPDATE task SET rating = ? WHERE ID = ?;");
    $stmt->bind_param("ss", $_POST['rating'] , $_POST['id']);
    if (!$stmt->execute()) {
        die(json_encode(array('status' => false, 'code' => 2, 'data' => $stmt->error)));
    }


    die(json_encode(array('status' => true, 'code' => 0, 'data' => "Duyệt task thành công")));
?>

