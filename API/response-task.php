<?php
    require_once ('connection.php');
    header('Content-Type: application/json');

    if (empty($_POST['taskid']) || empty($_POST['content']) || empty($_POST['username'])) {
        die(json_encode(array('status' => false, 'code' => 1, 'data' => 'Parameters not valid')));
    }  

    $taskid = $_POST['taskid'];
    $content = $_POST['content'];
    $username = $_POST['username'];

    $file_name = '';
    $file_tmp = '';
    $file_folder = '';
    if (isset($_FILES['file'])) {
        $file_name = $_FILES['file']['name'];
        $file_size = $_FILES['file']['size'];
        $file_tmp = $_FILES['file']['tmp_name'];        
    
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $invalid_extensions= array('exe', 'sh', 'msi');
        
        //check extension
        if(in_array($file_extension, $invalid_extensions)){
            echo json_encode(array('status' => false, 'code' => 3, 'data' => 'File không hợp lệ!'));
            die();
        }
        
        //check size
        if($file_size > 10*1024*1024){
            echo json_encode(array('status' => false, 'code' => 4, 'data' => 'Kích thước tập tin không được vượt quá 10MB'));
            die();
        }

        $timestamp = time();
        $file_folder = "$timestamp/$file_name";
        
        mkdir("../assets/files-task/$timestamp");
        move_uploaded_file($file_tmp, "../assets/files-task/$timestamp/$file_name");
    }

    $sql = "CALL response_task('$taskid', '$username', '$content', '$file_folder')";

    if (!$conn->query($sql)) {
        die(json_encode(array('status' => false, 'code' => 5, 'data' => $conn->error)));
    }

    if (empty($_POST['newduedate'])) {
        die(json_encode(array('status' => true, 'code' => 0, 'data' => 'Submit thành công')));
    }

    $stmt = $conn->prepare('UPDATE task SET duedate = ? WHERE id = ?');
    $stmt->bind_param("ss", $_POST['newduedate'], $taskid);

    if (!$stmt->execute()) {
        die(json_encode(array('status' => false, 'code' => 2, 'data' => $stmt->error)));
    }
    
    die(json_encode(array('status' => true, 'code' => 0, 'data' => 'Reject thành công')));

?>