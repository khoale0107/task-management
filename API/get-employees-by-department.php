<?php 
    require_once "connection.php";
    header('Content-Type: application/json');

    if (empty($_POST['departmentid'])) {
        die(json_encode(array('status' => false, 'code' => 1, 'data' => 'Parameters not valid')));
    }

    $maphongban = $_POST['departmentid'];

    $stmt = 'SELECT username, hoten, chucvu, tenphongban FROM account, phongban 
            where account.maphongban = ?';

    $stmt = $conn->prepare('SELECT username, hoten, chucvu, avatar FROM account where account.maphongban = ?');
    $stmt->bind_param("i", $maphongban);

    if (!$stmt->execute()) {
        die(json_encode(array('status' => false, 'code' => 2, 'data' => $conn->error)));
    }

    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        die(json_encode(array('status' => false, 'code' => 3, 'data' => 'no rows')));
    }

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    die(json_encode(array('status' => true, 'code' => 0, 'data' => $data)));
?>