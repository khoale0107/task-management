<?php 
    require_once "connection.php";
    header('Content-Type: application/json');

    if (empty($_POST['departmentid']) || empty($_POST['chucvu']) || empty($_POST['username'])) {
        die(json_encode(array('status' => false, 'code' => 1, 'data' => 'Parameters not valid')));
    }

    $stmt;
    
    if ($_POST['chucvu'] == 'Trưởng phòng') {
        $stmt = $conn->prepare("SELECT task.*, hoten FROM task, account WHERE task.username = account.username AND maphongban = ? ORDER by updatetime DESC;");         
        $stmt->bind_param("i", $_POST['departmentid']);
    }
    else {
        $stmt = $conn->prepare("SELECT task.*, hoten FROM task, account WHERE task.username = account.username AND task.username = ?  ORDER by updatetime DESC;");         
        $stmt->bind_param("s", $_POST['username']);
    }


    if (!$stmt->execute()) {
        die(json_encode(array('status' => false, 'code' => 2, 'data' => $conn->error)));
    }

    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        die(json_encode(array('status' => false, 'code' => 3, 'data' => 'Chưa có công việc nào')));
    }

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    die(json_encode(array('status' => true, 'code' => 0, 'data' => $data)));

?>