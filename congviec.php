<?php
    //check if logged in
    require_once 'check-session.php';
    
    //check if need reset password
    require_once 'check-password.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Công việc</title>
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
        include 'navbar.php';
    ?>

    <div class="container ">
        
        <div class="row ">

        </div>
    </div>

    <!-- modal reset password   -->
    <div class="modal" id="modal-reset" tabindex="-1" role="dialog"  >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Đặt lại mật khẩu?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" data-dismiss="modal">Hủy</button>
                    <button id="confirm-reset-btn" class="btn btn-primary" data-dismiss="modal">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- toast -->
    <div class="toast-container position-fixed">
        <div class="toast hide overflow-hidden border-0" data-delay="2500">
            <div class="toast-header bg-secondary text-white border-0 p-3">
                <span class="text-success mr-2" style="font-size:1.2rem"><i class="fas fa-check-circle"></i></span>
                <b class="mr-auto toast-header-message">Toast Header</b>
                <!-- <button class="ml-2 mb-1 close text-white" data-dismiss="toast">&times;</button> -->
            </div>
        </div>
    </div>

    <?php
        include_once 'footer.php';
    ?> 
</div>

</body>
<script src="main.js"></script>
</html>
