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
    //load lich su nop don
    require_once ('API/connection.php');

    $stmt = $conn->prepare('SELECT @rownum := @rownum + 1 AS STT,  t.*
                            FROM nghiphep t, (SELECT @rownum := 0) r
                            WHERE username = ?
                            ORDER BY ngaylap DESC;');

    $stmt->bind_param('s', $_SESSION['user']);

    if (!$stmt->execute()) {
        die(json_encode(array('status' => false, 'code' => 2, 'data' => $conn->error)));
    }

    $result = $stmt->get_result();
?>

<body>
<div id="wrapper">
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h5>Nộp đơn xin nghỉ phép</h5>
        <hr class="mt-2 ">


        <div class="row">
            <!--form nop don -->
            <div class="col-lg-3 mb-3 mb-lg-0 " >
                <div class="p-3  bg-white border rounded">
                    <h5>Tạo đơn mới</h5>
                    <div class="dropdown-divider"></div>
                    <div class="form-group">
                        <label for="">Số ngày nghỉ:</label>
                        <input type="number" class="form-control" id="day-number" name="" value="1" min="1">
                    </div>
                    <div class="form-group">
                        <label for="">Lý do:</label>
                        <textarea class="form-control" id="reason" name="" rows="4" placeholder=""></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">File đính kèm:</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>

                    <div id="error-message" class="my-3 text-center"></div>

                    <div class="d-flex flex-end mt-4">
                        <button class="btn btn-success ml-auto submit-btn" id="submit-btn">Gửi / Submit</button>
                    </div>

                </div>
            </div>

            <!--lich su nop don -->
            <div class=" col-lg-9 pl-3 pl-lg-0 mb-4 mb-lg-0">
                <div class="border p-3 rounded bg-white">
                    <h5>Lịch sử nộp đơn</h5>
                    <div class="dropdown-divider"></div>

                    <div class="d-flex text-muted justify-content-end">
                        <div >Tổng: 
                            <?php 
                                if ($_SESSION['permission'] == "Nhân viên") {
                                    echo '12 ngày';
                                }
                                else echo '15 ngày';
                            ?>
                        </div>

                        <div class="ml-4">Đã nghỉ:
                            <?php
                                $so_ngay_nghi = 0;
                                foreach ($result as $row) {
                                    if ($row['trangthai'] == 'approved') {
                                        $so_ngay_nghi += $row['songay'];

                                    }
                                }
                                echo $so_ngay_nghi .' ngày';  
                            ?>
                        </div>

                        <div class="ml-4">Còn lại: 
                            
                            <?php
                                $so_ngay_con_lai = 0;
                                if ($_SESSION['permission'] == "Nhân viên") {
                                    $so_ngay_con_lai = 12 - $so_ngay_nghi;
                                }
                                else $so_ngay_con_lai = 15 - $so_ngay_nghi;

                                echo "<span id='remain-days'>$so_ngay_con_lai</span>" . ' ngày';
                            ?>
                        </div>
                    </div>

                    <div class="overflow-auto" style="max-height:480px">
                        <table class="table mb-0 table-striped" >
                            <thead class="bg-light ">
                                <tr class="">
                                    <th>STT</th>
                                    <th>Số ngày</th>
                                    <th style="min-width:200px">Lý do</th>
                                    <th>File đính kèm</th>
                                    <th>Ngày lập</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
    
                            <tbody>
                                <?php
                                    foreach ($result as $row) {
                                        ?>
                                            <tr>
                                                <td><?= $row['STT']?></td>
                                                <td><?= $row['songay']?></td>
                                                <td><?= $row['lydo']?></td>
                                                <td>
                                                    <?php
                                                        if ($row['file'] != '') {
                                                            $file =  $row['file'];
                                                            echo "<a href='nghiphep-files/$file' download>$file</a>";
                                                        }
                                                        else echo '-';
                                                    ?>
                                                </td>
                                                
                                                <td><?= date_format(date_create($row['ngaylap']),"Y-m-d"); ?></td>

                                                <td>
                                                    <?php
                                                        if ($row['trangthai'] == 'waiting')
                                                            echo '<div class="badge badge-info">waiting</div>';
                                                        else if ($row['trangthai'] == 'approved')
                                                            echo '<div class="badge badge-success">approved</div>';
                                                        else if ($row['trangthai'] == 'refused')
                                                            echo '<div class="badge badge-danger">refused</div>';
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- modal -->
    <div class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lỗi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p class="modal-message">Modal body text goes here.</p>
                    <button type="button" class="btn btn-light float-right" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'footer.php'; ?> 
</div>
</body>

<script src="main.js"></script>
</html>