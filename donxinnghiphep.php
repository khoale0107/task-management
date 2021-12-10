<?php
    //check if logged in
    require_once 'check-session.php';
    
    //check if need reset password (check if password and username are the same)
    require_once 'check-password.php';
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
    <?php include 'navbar.php'; ?>

    <div class="container">

        <!-- tabs -->
        <ul class="nav nav-tabs">
            <!-- only 'nhân viên', 'trưởng phòng' can make request -->
            <?php if ($_SESSION['permission'] !== 'Admin') { ?>
                <li class="nav-item">
                    <a class="nav-link active text-secondary active" data-toggle="tab" href="#create-application">Ghi nhận yêu cầu</a>
                </li>
            <?php } ?>
            
            <!-- only 'admin', 'trưởng phòng' can approve request -->
            <?php if ($_SESSION['permission'] !== 'Nhân viên') { ?>
                <li class="nav-item">
                    <a class="nav-link text-secondary <?= $_SESSION['permission'] === 'Admin' ? "active" : ''?>" data-toggle="tab" href="#check-application">Duyệt yêu cầu</a>
                </li>
            <?php } ?>
            
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <br>

            <?php if ($_SESSION['permission'] !== 'Admin') { ?>
                <div class="tab-pane container active" id="create-application">
                    Tạo đơn
                </div>
            <?php } ?>

            <?php if ($_SESSION['permission'] !== 'Nhân viên') { ?>
                <div class="tab-pane container <?= $_SESSION['permission'] === 'Admin' ? "active" : ''?>" id="check-application">
                    Duyệt đơn
                </div>
            <?php } ?>


        </div>
    </div>

    <?php include_once 'footer.php'; ?> 
</div>
</body>

<script src="main.js"></script>
</html>