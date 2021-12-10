 <?php
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbName = 'web_cuoiky';

    

    mysqli_report(MYSQLI_REPORT_STRICT);
    try {
        $conn = new mysqli($host, $username, $password, $dbName);
        
    } catch (Exception $ex) {
        die(json_encode(array('status' => false, 'data' => "Unable to connect to db")));
    }

?>