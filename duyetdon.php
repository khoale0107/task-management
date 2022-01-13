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

<?php
    if ($_SESSION['permission'] === "Nhân viên") {
        ?>
            <div class="d-flex min-vh-100 flex-column align-items-center justify-content-center px-4">
                <h5 class="text-secondary text-center mb-4">Bạn không có quyền truy cập vào trang này</h5>
                <a href="index.php" class="btn btn-primary text-center">Quay về trang chủ</a>   
            </div>
        <?php

        die();
    }
?>

<body>
    <div id="wrapper">
        <?php include 'navbar.php'; ?>

        <div class="container">
            <div class="row px-sm-5">
                <div class="col p-0 px-sm-5">
                    <div class="border p-3 rounded bg-white">
                        <h5>Danh sách yêu cầu nghỉ phép</h5>
                        <hr class="mt-2 ">
                        <div class="text-muted mb-2"><b>Phòng ban: <?= !!($_SESSION['department-name']) ? $_SESSION['department-name'] : "Tất cả" ?></b></div>

                        <div class=" mb-2 request-container">
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <?php include_once 'footer.php'; ?> 
    </div>


    <!--request modal-->
    <div class="modal" id="request-modal" tabindex="-1" >
        <div class="modal-dialog" style="max-width: 650px">
            <div class="modal-content">
            <div class="modal-header">
                <h5>Duyệt yêu cầu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body  ">
                <div class="d-flex flex-column flex-sm-row mb-2">
                    <div class="d-flex mb-2 flex-grow-1">
                        <img class="rounded-circle align-self-center mr-2" id="modal-avatar" height="36" width="36" src="" alt="img">
    
                        <div class="flex-grow-1" style="width:0px">
                            <div class="" style=""><b id="hoten" class="mb-0">Khoa Lê</b></div>
                            <div id="employeeid" class="text-muted">51900753</div>
                        </div>
                    </div>

                    <div class="d-flex flex-row flex-sm-column">
                        <div class="ml-auto order-1">
                            Trạng thái:<span id="status" class="badge ml-2"></span >
                        </div>
                        <div class="order-0">
                            Số ngày yêu cầu:&nbsp<span id="songay"></span>
                        </div>
                    </div>
                </div>

                <hr class="mt-1 mb-2 bg-secondary">
                <div id="reason" class="px-2" style="min-height:5rem"></div>
                <hr class="mt-1 mb-2 bg-light">

                <div class="px-2 mb-3">
                    File đính kèm:<a href="#" id="file" class="ml-2" download></a>
                </div>

                <div class="button-group float-right">
                    <button type="button" class="btn btn-danger" onclick="refuse()">Refuse</button>
                    <button type="button" class="btn btn-success" onclick="approve()" >Approve</button>
                </div>
            </div>

        </div>
    </div>


</body>

<script src="main.js"></script>
</html>

