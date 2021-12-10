<?php 
    require_once "connection.php";
    header('Content-Type: application/json');

    
    $sql = "SELECT ID, tenphongban, account.hoten as 'tentruongphong', mota, sophong
            FROM phongban
            LEFT JOIN account
            ON phongban.matruongphong = account.username;";

    $result = $conn->query($sql);

    if (!$result) {
        die(json_encode(array('status' => false, 'code' => 1, 'data' => $conn->error)));
    }

    if ($result->num_rows == 0) {
        die(json_encode(array('status' => false, 'code' => 2, 'data' => 'no rows')));
    }

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    die(json_encode(array('status' => true, 'code' => 0, 'data' => $data)));
?>