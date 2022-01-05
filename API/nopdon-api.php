<?php
    require_once ('connection.php');
    header('Content-Type: application/json');

    if (empty($_POST['songay']) || empty($_POST['lydo']) || empty($_POST['username'])) {
        die(json_encode(array('status' => false, 'code' => 1, 'data' => 'Parameters not valid')));
    }

    $songay = $_POST['songay'];
    $lydo = $_POST['lydo'];
    $username = $_POST['username'];

    if (!filter_var($songay, FILTER_VALIDATE_INT) || $songay < 1) {
        die(json_encode(array('status' => false, 'code' => 2, 'data' => 'Số ngày không hợp lệ')));
    }

    $file_name = '';
    $file_tmp = '';
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


        
    }


    $sql = "CALL xin_nghi_phep('$username', '$songay', '$lydo', '$file_name')";

    if (!$conn->query($sql)) {
        die(json_encode(array('status' => false, 'code' => 5, 'data' => $conn->error)));
    }

    if (!file_exists("../nghiphep-files/$file_name")) {
        //success
        move_uploaded_file($file_tmp, "../assets/files-nghiphep/$file_name");
    }
    
    die(json_encode(array('status' => true, 'code' => 0, 'data' => 'Nộp đơn thành công')));
?>