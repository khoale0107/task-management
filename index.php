<?php

    //check if logged in
    require_once 'check-session.php';
    
    //check if need reset password (check if password and username are the same)
    require_once 'check-password.php';

    if ($_SESSION['permission'] !== "Admin") {
        header("Location: congviec.php");
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div id="wrapper">
    <?php
        include_once 'navbar.php';
    ?>

    <div class="container">
        <?php
            if ($_SESSION['permission'] === 'Admin') {
            ?>
                <div class="row text-center" style="font-size: 24px">
                    <div class="col-sm-6 col-lg-3  mb-3">
                        <a href="nhanvien.php" class="square d-flex flex-column bg-white shadow text-decoration-none text-info border">
                            <div class="pt-3 px-3 "><b>Nhân viên</b></div>
                            <div class="p-3 flex-grow-1"><i class="fas fa-users"></i></div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-lg-3  mb-3">
                        <a href="phongban.php" class="square d-flex flex-column bg-white shadow text-decoration-none text-info border">
                            <div class="pt-3 px-3 "><b>Phòng ban</b></div>
                            <div class="p-3 flex-grow-1"><i class="fas fa-building"></i></div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-lg-3   mb-3">
                        <a href="duyetdon.php" class="square d-flex flex-column bg-white shadow text-decoration-none text-info border">
                            <div class="pt-3 px-3 "><b>Duyệt đơn</b></div>
                            <div class="p-3 flex-grow-1"><i class="fas fa-clipboard-check"></i></div>
                        </a>
                    </div>
                </div> 
            <?php
            }
        ?>
    </div>
    
    <?php
        include_once 'footer.php';    
    ?> 


</div>
</body>

</html>