<?php
    session_start();
    require_once "connection.php";
    header('Content-Type: application/json');

    if (!isset($_POST['username'])) {
        die(json_encode(array('status' => false, 'code' => 1, 'data' => 'Parameters not valid')));
    }

    if (!isset($_FILES['avatar'])) {
        die(json_encode(array('status' => false, 'code' => 2, 'data' => 'No img uploaded')));
    }

    //delete old avatar from sv ======================================================================================
    $username = $_POST['username'];
    $stmt = $conn->prepare('SELECT avatar FROM account WHERE username = ?');
    $stmt->bind_param("s" ,$username);

    if (!$stmt->execute()) {
        echo json_encode(array('status' => false, 'code' => 3, 'data' => $stmt->error));
        die();
    }

    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        die(json_encode(array('status' => false, 'code' => 4, 'data' => 'User not found')));
    }

    $row = $result->fetch_assoc();
    $old_avatar = $row['avatar'];

    if ($old_avatar !== 'default_avatar.png') {
        if (file_exists('../assets/img/'.$old_avatar)) {
            unlink('../assets/img/'.$old_avatar);
        }

    }
    

    //append new avatar to sv ==========================================================================================
    $file_name = $_FILES['avatar']['name'];
    $file_size =$_FILES['avatar']['size'];
    $file_tmp =$_FILES['avatar']['tmp_name'];

    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
    $valid_extensions= array("png","jpg","jpeg");
    
    //invalid extension
    if(!in_array($file_extension, $valid_extensions)){
        echo json_encode(array('status' => false, 'code' => 6, 'data' => 'Extension not allowed!'));
        die();
    }

    $date = new DateTime();
    $date->getTimeStamp();
    $unique_avatar_name = $username. "_" . $date->getTimeStamp() . "_avatar.png";

    // echo $unique_avatar_name;
    // die();

    $stmt = $conn->prepare('UPDATE account SET avatar = ? WHERE username = ?');
    $stmt->bind_param("ss", $unique_avatar_name ,$username);

    if (!$stmt->execute()) {
        echo json_encode(array('status' => false, 'code' => 7, 'data' => $stmt->error));
        die();
    }

    //append uploaded file 
    if (move_uploaded_file($file_tmp, "../assets/img/".$unique_avatar_name)) {
        $_SESSION['avatar'] = $unique_avatar_name;
        die(json_encode(array('status' => true, 'code' => 0, 'data' => 'uploaded successfully!')));
    }
    //append uploaded file fail
    else {
        echo json_encode(array('status' => false, 'code' => 9, 'data' => 'Failed! Something is wrong, please try again!'));
        die();
    }
    

?>