<?php
    require_once 'API/connection.php';


    $stmt = $conn->prepare('SELECT * from nghiphep');

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

    // $expire = strtotime('2021-12-11 13:21:46');
    $expire = '2021-12-11 13:21:46';
    $date = date('Y-m-d H:i:s');
    $today = date("Y-m-d H:i:s"); 

    $now = new DateTime();
    $nowtimestamp = $now->getTimestamp();
    
    // echo $expire;
    // echo "\n";
    // // echo $today;
    // echo date('m/d/Y H:i:s', $nowtimestamp); 
    // date_default_timezone_set("Asia/Bangkok");
    echo date("Y-m-d H:i:s", time()); 
    // echo time();
    echo "\n";

    // if ($date > $expire) {
    //     echo 'missing';
    // }
    // else {
    //     echo 'Assgined';
    // }


    die(json_encode(array('status' => true, 'code' => 0, 'data' => $data)));
?>