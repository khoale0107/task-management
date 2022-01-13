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

<style>

</style>

<body>
<div id="wrapper">
    <?php           
        include 'navbar.php';
    ?>

    <div class="container ">    
        <div class="row px-lg-5">
            <div class="col px-lg-5">
                <div class="d-flex align-items-center">
                    <h4 class="mb-0">Công việc </h5>

                    <?php           
                        if ($_SESSION['permission'] == 'Trưởng phòng') { ?>
                            <div onclick="" class="btn btn-success ml-auto btn-addtask"><i class="fas fa-plus mr-2"></i>Thêm task</div>
                        <?php }
                    ?>
                </div>

                <hr class="mt-2 bg-light">

                <div class="task-container">
                    <a href="https://www.google.com.vn/?hl=vi" class="d-flex align-items-center  border rounded btn-white p-3 task">
                        <i class="fas fa-clipboard-list mr-3" style="font-size:2rem"></i>
                        <div class="d-flex flex-column flex-grow-1" style="width:0px">
                            <div class="ellipsis task-name"><b>Công việc 1</b></div>
                            <div class="ellipsis">Khoa Lê</div>
                        </div>

                        <div class="d-flex flex-column" style="min-width: 72px;text-align: end;">
                            <strong class="text-decoration-none">16:30</strong>    
                            <div class="" style="min-width: 72px">
                                <div class="badge badge-info ">New</div>
                            </div>
                        </div>
                    </a>

                    <div class="d-flex align-items-center  border rounded btn-white p-3 task">
                        <i class="fas fa-clipboard-list mr-3" style="font-size:2rem"></i>
                        <div class="d-flex flex-column flex-grow-1">
                            <div class="ellipsis"><b>Công việc 1</b></div>
                            <div>Khoa Lê</div>
                        </div>

                        <div class="d-flex flex-column" style="min-width: 72px;text-align: end;">
                            <strong>1 thg 1</strong>    
                            <div class="" style="min-width: 72px">
                                <div class="badge badge-primary ">In progress</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center  border rounded btn-white p-3 task">
                        <i class="fas fa-clipboard-list mr-3" style="font-size:2rem"></i>
                        <div class="d-flex flex-column flex-grow-1">
                            <div class="ellipsis"><b>Công việc 1</b></div>
                            <div>Khoa Lê</div>
                        </div>

                        <div class="d-flex flex-column" style="min-width: 72px;text-align: end;">
                            <strong>1 thg 1</strong>    
                            <div class="" style="min-width: 72px">
                                <div class="badge badge-primary ">Waiting</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center  border rounded btn-white p-3 task">
                        <i class="fas fa-clipboard-list mr-3" style="font-size:2rem"></i>
                        <div class="d-flex flex-column flex-grow-1">
                            <div class="ellipsis"><b>Công việc 1</b></div>
                            <div>Khoa Lê</div>
                        </div>

                        <div class="d-flex flex-column" style="min-width: 72px;text-align: end;">
                            <strong>1 thg 1</strong>    
                            <div class="" style="min-width: 72px">
                                <div class="badge badge-success ">Completed</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center  border rounded btn-white p-3 task">
                        <i class="fas fa-clipboard-list mr-3" style="font-size:2rem"></i>
                        <div class="d-flex flex-column flex-grow-1">
                            <div class="ellipsis"><b>Công việc 1</b></div>
                            <div>Khoa Lê</div>
                        </div>

                        <div class="d-flex flex-column" style="min-width: 72px;text-align: end;">
                            <strong>12:05</strong>    
                            <div class="" style="min-width: 72px">
                                <div class="badge badge-light ">Canceled</div>
                            </div>
                        </div>
                    </div>
                </div>
                

            </div>
        </div>
    </div>

    <?php           
        if ($_SESSION['permission'] == 'Trưởng phòng') { ?>
            <!-- modal them task -->
            <div class="modal" id="modal-addtask" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Tạo công việc mới</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="" >
                                <div class="form-group">
                                    <label class="control-label" for="">Tiêu đề:</label>
                                    <input type="text" class="form-control" id="task-name" placeholder="Tên công việc">
                                    <small class="text-danger error-msg">Hãy nhập tiêu đề</small>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="">Mô tả:</label>
                                    <textarea class="form-control" rows="4" id="task-description" placeholder="Nội dung công việc"></textarea >
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="">Nhân viên thực hiện:</label>
                                    <select name="cars" class="custom-select" id="emp-select">
                                        <option value="" >Chọn nhân viên</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="">Thời hạn:</label>
                                    <input type="datetime-local" class="form-control" id="duedate" min="1">
                                </div>

                                <div class="form-group">
                                    <label for="">File đính kèm:</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>

                                <div id="error-message-modal" class="text-danger text-center"></div>
                            </div>
                        </div>

                        <div class="modal-footer border-top-0">
                            <button class="btn" data-dismiss="modal">Hủy</button>
                            <button onclick="addTask()" class="btn btn-primary" >Giao việc</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
    ?>


    <?php
        include_once 'footer.php';
    ?> 
</div>

</body>
<script src="main.js"></script>
</html>
