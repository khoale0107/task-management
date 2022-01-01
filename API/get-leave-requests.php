<?php 
    require_once "connection.php";
    header('Content-Type: application/json');

    $stmt;

    if (!empty($_POST['department-id'])) {
        //truong phong

        // $stmt = $conn->prepare("SELECT nghiphep.*, hoten FROM nghiphep, account 
        //                     WHERE nghiphep.username in (SELECT username FROM account WHERE maphongban = ? AND chucvu != 'Trưởng phòng')
        //                     AND nghiphep.username = account.username
        //                     ORDER BY ngaylap DESC");

        $stmt = $conn->prepare("SELECT nghiphep.*, hoten FROM nghiphep, account 
                                WHERE nghiphep.username = account.username AND maphongban = ? AND chucvu != 'Trưởng phòng'
                                ORDER BY ngaylap DESC");
        
        $stmt->bind_param('s', $_POST['department-id']);
    }
    else {
        //Admin
        $stmt = $conn->prepare("SELECT nghiphep.*, hoten FROM nghiphep, account 
                                WHERE nghiphep.username = account.username AND chucvu = 'Trưởng phòng'
                                ORDER BY ngaylap DESC");
    }

                            


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