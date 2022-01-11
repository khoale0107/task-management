<?php
    //check if logged in
    require_once 'check-session.php';
    
    //check if need reset password
    require_once 'check-password.php';

    require_once './API/connection.php';

    if (empty($_GET['id'])) {
        header('Location:congviec.php');
        die();
    }

    $stmt = $conn->prepare('SELECT task.*, hoten, maphongban from task, account where task.id = ? and task.username = account.username');
    $stmt->bind_param("s", $_GET['id']);

    if (!$stmt->execute()) {
        die($error = $stmt->error);
    }
    
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($result->num_rows == 0) {
        header("Location:congviec.php");
        die();
    }

    $stmt = $conn->prepare('SELECT response.*, duedate, hoten, avatar, chucvu from response, account, task 
    where response.taskid = ? 
    and response.username = account.username and response.taskid = task.id
    ORDER BY responsedate DESC;');
    $stmt->bind_param("s", $_GET['id']);

    if (!$stmt->execute()) {
    die($error = $stmt->error);
    }

    $response_list = $stmt->get_result();
    $is_submit_ontime = 'Đúng hạn';
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

    <?php
        if ($row['username'] != $_SESSION['user'] && $_SESSION['permission'] != 'Trưởng phòng') {
            ?>
                <div class="d-flex min-vh-100 flex-column align-items-center justify-content-center px-4">
                    <h5 class="text-secondary text-center mb-3">Đây không phải task của bạn.</h5>
                    <a href="index.php" class="btn btn-primary text-center">Quay về trang chủ</a>   
                </div>
            <?php
            die();
        }
        
        if ($row['maphongban'] != $_SESSION['department-id']) {
            ?>
                <div class="d-flex min-vh-100 flex-column align-items-center justify-content-center px-4">
                    <h5 class="text-secondary text-center mb-3">Task này không thuộc về phòng của bạn.</h5>
                    <a href="index.php" class="btn btn-primary text-center">Quay về trang chủ</a>   
                </div>
            <?php
            die();
        }
    ?>

    <div class="container ">
        <div class="row px-lg-5">
            <div class="col px-lg-5">
                <div class="d-flex align-items-center mb-2">
                    <h5 class="mb-0">Công việc</h5>


                    <div class="ml-auto">
                        <?php
                            $submitable_status = ['In progress', 'Rejected'];
                            in_array($row['trangthai'], $submitable_status);

                            if ($_SESSION['permission'] == 'Trưởng phòng' and $row['trangthai'] == 'New') {
                                echo "<button id='btn-cancel' class='btn btn-secondary px-4 py-1 ml-auto'>Cancel task</button>";
                            }

                            else if ($_SESSION['permission'] == 'Nhân viên' and $row['trangthai'] == 'New') { 
                                echo "<button id='btn-start' class='btn btn-primary px-4 py-1 ml-auto'>Start</button>";
                            } 

                            else if ($_SESSION['permission'] == 'Nhân viên' and in_array($row['trangthai'], $submitable_status)) {
                                echo "<button id='btn-submit' class='btn btn-primary px-4 py-1 ml-auto'>Submit</button>";
                            }
                        ?>
                    </div>
                </div>
                

                <!-- Noi dung task -->
                <div class="card p-3">
                    <div class="">
                        <div class="d-flex flex-column flex-sm-row mb-2">
                            <div class="d-flex mb-1 flex-grow-1">
                                <i class="fas fa-clipboard-list align-self-center d-none d-sm-block mr-3" style="font-size: 2rem"></i>

                                <div class="flex-grow-1" style="width:0px">
                                    <h5 class="mb-1 mb-sm-0"><?= $row['tieude'] ?></h5>
                                    <div class="text-muted">
                                        Ngày giao:<span class="ml-2"><?= date_format(date_create($row['ngaylap']),"M d, Y") ?></span>
                                    </div>
                                    <div class="text-muted">
                                        Thực hiện:<span class="ml-2"><?= $row['hoten'] ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-row flex-sm-column">
                                    <div class="order-sm-2">Due&nbsp<?= date_format(date_create($row['duedate']),"M d, Y, g:i a")?></div>

                                    <?php
                                        $badgeType = "";
                                        if ($row['trangthai'] == 'New') {
                                            $badgeType = 'info';
                                        }
                                        if ($row['trangthai'] == 'In progress') {
                                            $badgeType = 'info';
                                        }
                                        if ($row['trangthai'] == 'Waiting') {
                                            $badgeType = 'primary';
                                        }
                                        if ($row['trangthai'] == 'Canceled') {
                                            $badgeType = 'secondary';
                                        }
                                        else if ($row['trangthai'] == 'Rejected') {
                                            $badgeType = 'danger';
                                        }
                                        else if ($row['trangthai'] == 'Completed') {
                                            $badgeType = 'success';
                                        }
                                        ?>
                                            <div class=" ml-auto">
                                                <span class="badge badge-<?= $badgeType?>"> <?= $row['trangthai'] ?></span>
                                            </div>
                                        <?php
                                    ?>
                            </div>
                        </div>

                        <hr class="bg-light mt-2">
                    
                        <div class="mb-3 mt-2"><?= $row['mota'] ?>.</div>

                        <!-- task file -->
                        <?php
                            if ($row['file']) { ?>
                                <div>
                                    <a href="./assets/files-task/<?= $row['file'] ?>" download class="border py-1 px-3 rounded no-underline-hover" style="display:inline-block">
                                        <i class="fas fa-file"></i>&nbsp
                                        <span>
                                            <?php
                                                $exploded = explode('/', $row['file']); 
                                                echo end($exploded);
                                            ?>
                                        </span>
                                    </a>                            

                                </div>
                            <?php } 
                        ?>

                        <?php
                            foreach ($response_list as $response) {
                                if (strtotime($response['responsedate']) > strtotime($response['duedate'])) {
                                    $is_submit_ontime = 'Trễ hạn';
                                    break;
                                }
                            }

                            if ($row['trangthai'] == 'Completed') { 
                                ?>
                                <div class="mt-4">
                                    <div><b>Đánh giá: </b><?= $row['rating']?></div>
                                    <div><b>Thời gian hoàn thành: </b><?= $is_submit_ontime?></div>
                                </div>
                                <?php 
                            }
                        ?>

                        <?php
                            if ($_SESSION['permission'] == 'Trưởng phòng' and $row['trangthai'] == 'Waiting') { ?>
                                <div class="float-right mt-4">
                                    <button id='btn-reject' class='btn btn-danger px-4 py-1 '>Reject</button>
                                    <button id='btn-approve' class='btn btn-success px-4 py-1 ml-1'>Approve</button>
                                </div>
                            <?php }
                        ?>
                    </div>
                </div>
                

                <!-- Task Responses -->
                <?php
                    if ($response_list->num_rows != 0) { ?>
                        <div class="font-weight-bold mt-4">Ghi chú</div>
                        <hr class="mt-0 mb-3 bg-secondary">
                    <?php }

                    foreach ($response_list as $row) {
                        $date= date_create($row['responsedate']);
                        $formatted_date = date_format($date,"H:i a,  M d");
                        $hoten = $row['hoten'];

                        $action = '';

                        if ($row['chucvu'] == 'Trưởng phòng') {
                            if (empty($row['content'])) {
                                $action = 'Approved';
                            }
                            else {
                                $action = 'Rejected';
                            }
                        }
                        else if (strtotime($row['responsedate']) > strtotime($row['duedate'])) {
                            $action = 'Turned in late';
                        }
                        else {
                            $action = 'Submitted';
                        }

                        // $action = $row['chucvu'] == 'Trưởng phòng' ? 'Rejected' : 'Submitted';

                        // if (strtotime($row['responsedate']) > strtotime($row['duedate'])) {
                        //     $action = 'Turned in late';
                        // }
                        // elseif (empty($row['content'])) {
                        //     $action = 'Approved';
                        // }

                        $text_color = '';
                        if ($action == 'Rejected') {
                            $text_color = 'danger';
                        }
                        else if ($action == 'Approved') {
                            $text_color = 'success';
                        }
                        else {
                            $text_color = 'muted';
                        } 

                        ?>
                            <div class="pl-2 d-flex mb-3">
                                <img src="./assets/img/<?= $row['avatar'] ?>" class="rounded-circle align-self-top mr-2 mt-1" height="36" width="36"  alt="img">

                                <div class="border px-3 py-2 rounded-lg bg-white flex-grow-1 flex-sm-grow-">
                                    <div class="mb-1">
                                        <div class=" d-flex align-items-center">
                                            <div class="font-weight-bold"><?= $hoten ?></div>
                                            <span class='text-muted d-none d-sm-block' style='font-size: 1rem'>&nbsp- <?= $formatted_date ?></span>
                                            <div class="ml-auto align-self-start text-<?= $text_color?>"><?= $action ?></div>
                                        </div>
                                        <div class="ml-auto text-muted d-block d-sm-none" style="font-size: 0.85rem"><?= $formatted_date ?></div>
                                    </div>

                                    <div class=""><?= $row['content']?></div>
                                    
                                    <!-- Response file -->
                                    <?php
                                        $exploded = explode('/', $row['file']); 
                                        if ($row['file']) { ?>
                                            <div class="mt-3 mb-1">
                                                <a href="./assets/files-task/<?= $row['file'] ?>" download class="border py-1 px-3 rounded no-underline-hover" style="display:inline-block">
                                                    <i class="fas fa-file"></i>&nbsp
                                                    <span><?= end($exploded) ?></span>
                                                </a>                            

                                            </div>
                                        <?php } 
                                    ?> 
                                </div>
                            </div> 
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>

    <?php           
        if ($_SESSION['permission'] == 'Nhân viên') { ?>
            <!-- modal submit task -->
            <div class="modal" id="modal-submit" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Submit</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="" >
                                <div class="form-group">
                                    <label class="control-label" for="">Mô tả:</label>
                                    <textarea class="form-control" rows="4" id="submit-description" placeholder="Để lại mô tả"></textarea >
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
                            <button onclick="submitTask()" class="btn btn-primary" >Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
    ?>

    <?php           
        if ($_SESSION['permission'] == 'Trưởng phòng') { ?>
            <!-- modal reject task -->
            <div class="modal" id="modal-reject" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Reject</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="" >
                                <div class="form-group">
                                    <label class="control-label" for="">Ghi chú:</label>
                                    <textarea class="form-control" rows="4" id="reject-description" placeholder="Nhập ghi chú"></textarea >
                                </div>

                                <div class="form-group">
                                    <label for="">File đính kèm:</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="">Gia hạn deadline:</label>
                                    <input type="datetime-local" class="form-control" id="new-duedate">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal">Hủy</button>
                            <button onclick="rejectTask()" class="btn btn-danger" >Reject</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- modal approve task -->
            <div class="modal" id="modal-approve" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Phê duyệt</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div>
                                <div class="text-center font-weight-bold" style="font-size:1.15rem">Mức độ hoàn thành</div>

                                <div class="d-flex flex-column mt-2">
                                    <div class="mx-auto emo-list" >
                                        <label for="task-rate1" class="btn btn-white pb-2 border-0" data-toggle="tooltip" title="Bad">
                                            <img src="./assets/img/2584582.png" height="40" width="40" alt="Bad">
                                        </label>

                                        <label for="task-rate2" class="btn btn-white pb-2 border-0" data-toggle="tooltip" title="OK">
                                            <img src="./assets/img/2584594.png" height="40" width="40" alt="OK">
                                        </label>

                                        <?php 
                                            if ($is_submit_ontime == 'Đúng hạn') { ?>
                                                <label for="task-rate3" class="btn btn-white pb-2 border-0" data-toggle="tooltip" title="Good">
                                                    <img src="./assets/img/2584606.png" height="40" width="40" alt="Good">
                                                    
                                                </label>
                                            <?php } 
                                        ?>
                                    </div>

                                    <div class="d-none">
                                        <input type="radio" name="task-rate" id="task-rate1" value="Bad">
                                        <input type="radio" name="task-rate" id="task-rate2" value="OK">
                                        <input type="radio" name="task-rate" id="task-rate3" value="Good">
                                    </div>
                                </div>

                            </div>
                            
                        </div>

                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal">Hủy</button>
                            <button onclick="approveTask()" class="btn btn-success" >Appove</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
    ?>




    <div class="d-none" id="task-id"><?=$_GET['id']?></div>

    <?php
        include_once 'footer.php';
    ?> 
</div>

</body>
<script src="main.js"></script>
</html>
