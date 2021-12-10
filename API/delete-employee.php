<?php
    require_once ('connection.php');
    header('Content-Type: application/json');

    if (empty($_POST['employeeid'])) {
        die(json_encode(array('status' => false, 'code' => 1, 'data' => 'Parameters not valid')));
    }

    $username = $_POST['employeeid'];

    $stmt = $conn->prepare('DELETE FROM account WHERE username = ?');
    $stmt->bind_param("s", $username);
    
    if (!$stmt->execute()) {
        die(json_encode(array('status' => false, 'code' => 2, 'data' => $stmt->error)));
    }
    else if ($stmt->affected_rows == 0) {
        die(json_encode(array('status' => false, 'code' => 3, 'data' => 'User not found')));
    }
    else {
        die(json_encode(array('status' => true, 'code' => 0, 'data' => "User deleted")));
    }
?>

