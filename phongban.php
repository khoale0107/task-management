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
    <title>Document</title>
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
        include_once 'navbar.php';
    ?>

    <div class="container">
        <?php
            require_once 'permission-admin.php';
        ?>

        <div class="row ">
            <!-- danh sach phong ban========================================================== -->
            <div class="col-lg-9 mb-3 mb-lg-0 p-0" >
                <div class="p-3 bg-white border rounded">
                    <h5 class="mb-0">
                        <span class="mx-1 "><i class="fas fa-table"></i></span>
                        Danh sách phòng ban
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

                    <!-- table=============================== -->
                    <div class="border  overflow-auto" style="max-height:430px">
                        <table class="table mb-0 table-hover">
                            <thead class="sticky-top bg-light" style="z-index: 1;">
                                <tr class="">
                                    <th >ID</th>
                                    <th>Tên phòng ban</th>
                                    <th class="w-50">Mô tả</th>
                                    <th>Số phòng</th>
                                    <th>Trưởng phòng</th>
                                    <th class="text-center">Tùy chọn</th>

                                </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- them/sua phong ban================================================================================== -->
            <div class="col-lg-3 p-0 px-lg-3 mb-4 mb-lg-0">
                <div class="border p-3 rounded bg-white">
                    <h5>
                        <span class="mx-1 "><i class="fas fa-plus"></i></span>
                        Thêm phòng ban
                    </h5>
                    
                    <hr>
                    <form class="" >
                        <div class="form-group">
                            <label class="control-label" for="department-name">Tên phòng ban:</label>
                            <input type="text" class="form-control" id="department-name" name="departmentName" placeholder="Tên phòng ban">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description">Mô tả:</label>
                            <!-- <input type="text" class="form-control" id="description" name="description" placeholder="Mô tả"> -->
                            <textarea class="form-control" rows="5" id="description" name="description" placeholder="Mô tả"></textarea>

                        </div>

                        <div class="form-group">
                            <label class="control-label" for="number-of-rooms">Số phòng:</label>
                            <input type="number" class="form-control" id="number-of-rooms" name="numberOfRooms" value="1" min="1">
                        </div>

                        <div id="error-message" class=" text-danger text-center"></div>
                        <br>

                        <div class="d-flex">
                            <button type="submit" id="add-department-btn" class="btn btn-success flex-grow-1 flex-sm-grow-0" >Add</button>
                            <button type="reset" class="btn btn-light ml-1 border">Clear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <!-- modal cap nhat phong ban  -->
    <div class="modal" id="modal-update" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Cập nhật phòng ban</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="" >
                        <div class="form-group">
                            <label class="control-label" for="department-name-modal">Tên phòng ban:</label>
                            <input type="text" class="form-control" id="department-name-modal" placeholder="Tên phòng ban">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description-modal">Mô tả:</label>
                            <!-- <input type="text" class="form-control" id="description-modal" placeholder="Mô tả"> -->
                            <textarea class="form-control" rows="5" id="description-modal"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="number-of-rooms-modal">Số phòng:</label>
                            <input type="number" class="form-control" id="number-of-rooms-modal" min="1">
                        </div>

                        <div id="error-message-modal" class="text-danger text-center"></div>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button class="btn" data-dismiss="modal">Hủy</button>
                    <button id="confirm-update-btn" class="btn btn-primary" >Cập nhật</button>
                </div>
            </div>
        </div>
    </div>


    <!-- modal bo nhiem truong phong --> 
    <div class="modal " id="modal-assign-manager" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">=</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-0 pt-1">
                    <div class="d-flex mb-1">
                        <div style="font-weight:500;" class="dapartment-name">
                            Bổ nhiệm trưởng phòng:
                        </div>
                    </div>

                    <div class="employee-list">

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal">Hủy</button>
                    <button id="assign-btn" class="btn btn-primary" >Xác nhận</button>
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