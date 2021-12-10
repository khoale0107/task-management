<?php
    session_start();
    header('Content-Type: application/json');

    if (isset($_SESSION['user'])) {
        header('Location:index.php');
        die();
    }
    
    require_once 'connection.php';

    //check input
    if (empty($_POST['username']) || empty($_POST['password'])) {
        die(json_encode(array('status' => false, 'data' => 'Parameters not valid.')));
    }

    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    //prepare sql
    $stmt = $conn->prepare('SELECT * FROM account WHERE username = ?');
    $stmt->bind_param("s", $input_username);
    
    if (!$stmt->execute()) {
        die(json_encode(array('status' => false, 'data' => $stmt->error)));
    }
    
    $result = $stmt->get_result();
    //verify username
    if ($result->num_rows == 0) {
        die(json_encode(array('status' => false, 'data' => 'Incorrect username or password.')));
    }
    
    //verify password
    $row = $result->fetch_assoc();
    if (password_verify($input_password, $row['password'])) {
        //set session
        $_SESSION['user'] = $input_username;
        $_SESSION['hashed-password'] = $row['password'];
        $_SESSION['full-name'] = $row['hoten'];
        $_SESSION['permission'] = $row['chucvu'];
        $_SESSION['avatar'] = $row['avatar'];

        //set cookie
        if (isset($_POST['rememberCheck'])) {
            if ($_POST['rememberCheck'] === 'true') {
                setcookie('username', $input_username, time() + (86400*365), "/");
            }
        }
        die(json_encode(array('status' => true, 'data' => 'Login Successfully!')));

    } else {
        die(json_encode(array('status' => false, 'data' => 'Incorrect username or password.')));
    }

?>