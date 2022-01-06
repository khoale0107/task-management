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
    <title>Quản lý nhân viên</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<?php
    require_once 'permission-admin.php';
?>


<body>
<div id="wrapper">
    <?php           
        include 'navbar.php';
    ?>

    <div class="container ">
        
        <div class="row ">
            <!-- danh sach nhan vien========================================================== -->
            <div class="col-lg-9 mb-3 mb-lg-0 p-0" >
                <div class="p-3 bg-white border rounded">
                    <h5 class="mb-0">
                        <span class="mx-1 "><i class="fas fa-table "></i></span>
                        Danh sách nhân viên
                    </h5>

                    <hr>

                    <div class="row mb-2">
                        <div class="col-md-4 ml-auto">
                            <div class="position-relative border rounded-lg d-flex">
                                <input type="text" class="border-0 w-100 search-input" placeholder="Tìm kiếm" style="outline:none; margin-left:0.7rem">
                                <a id="clear-searchbox-btn" class="btn pl-1 text-secondary" style="top:0; right:0;">&times;</a>
                            </div>
                        </div>
                    </div>

                    <!-- table==== -->
                    <div class="border  overflow-auto" style="max-height:480px">
                        <table class="table mb-0  table-striped">
                            <thead class="sticky-top bg-light" style="z-index: 1;">
                                <tr class="">
                                    <th>Mã nhân viên</th>
                                    <th>Họ tên</th>
                                    <th>Chức vụ</th>
                                    <th>Phòng ban</th>
                                    <th class="text-center">Tùy chọn</th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- them nhan vien================================================================================== -->
            <div class="col-lg-3 p-0 px-lg-3 mb-4 mb-lg-0">
                <div class="border p-3 rounded bg-white">
                    <h5>
                        <span class="mx-1 "><i class="fas fa-user-plus"></i></span>
                        Thêm nhân viên
                    </h5>
                    
                    <hr>

                    <form class="" >
                        <div class="form-group">
                            <label class="control-label" for="employeeid">Mã nhân viên:</label>
                            <input type="text" class="form-control" id="employeeid" name="employeeid" placeholder="Mã nhân viên">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="fullname">Họ tên:</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Họ tên">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Phòng ban:</label>
                            <select class="custom-select select-department">
                                <option value=""   selected hidden>Chọn phòng ban</option>
                            </select>
                        </div>

                        <div id="error-message" class=" text-danger text-center"></div>
                        <br>


                        <div class="d-flex">
                            <button type="submit" class="btn btn-success flex-grow-1 flex-md-grow-1 flex-lg-grow-0" id="add-employee-btn">Add</button>
                            <button type="reset" class="btn btn-light ml-1 border flex-grow-0 flex-md-grow-1 flex-lg-grow-0">Clear</button>

                        </div>

                    </form>
                </div>
            </div>
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
                    <button class="btn " data-dismiss="modal">Hủy</button>
                    <button id="confirm-reset-btn" class="btn btn-primary" data-dismiss="modal">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal delete employee -->
    <div class="modal" id="modal-delete" tabindex="-1" role="dialog" >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Xóa nhân viên?</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button class="btn " data-dismiss="modal">Hủy</button>
                <button id="confirm-delete-btn" class="btn btn-danger" data-dismiss="modal">Xóa</button>
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
