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

            <!-- Create request -->
            <?php if ($_SESSION['permission'] !== 'Admin') { ?>
                <div class="tab-pane container active pt-3" id="create-application">
                    <div class="row">
                        <div class="col-lg-3 mb-3 mb-lg-0 p-0" >
                            <div class="p-3  bg-white border rounded">
                                <h5>Nộp đơn</h5>
                                <div class="dropdown-divider"></div>
                                <div class="form-group">
                                    <label for="">Số ngày nghỉ:</label>
                                    <input type="number" class="form-control" id="" name="" placeholder="1" min="1">
                                </div>
                                <div class="form-group">
                                    <label for="">Lý do:</label>
                                    <textarea class="form-control" id="" name="" placeholder=""></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">File đính kèm:</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>

                                <div class="d-flex flex-end mt-4">
                                    <button class="btn btn-success ml-auto">Gửi / Submit</button>

                                </div>
                            </div>
                        </div>

                        <div class=" col-lg-9 p-0 pl-lg-3 mb-4 mb-lg-0">
                            <div class="border p-3 rounded bg-white">
                                <h5>Lịch sử nộp đơn</h5>
                                <div class="dropdown-divider"></div>

                                <div class="d-flex text-muted justify-content-end">
                                    <div >Số ngày đã nghỉ: 0</div>
                                    <div class="ml-5">Số ngày còn lại: 15</div>
                                </div>

                                <table class="table mb-0  table-hover ">
                                    <thead class="sticky-top bg-light" style="z-index: 1;">
                                        <tr class="">
                                            <th>STT</th>
                                            <th>Số ngày nghỉ</th>
                                            <th>Lý do</th>
                                            <th>File đính kèm</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- Approve request -->
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