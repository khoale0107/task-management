<?php
    require_once 'check-session.php';
    
    require_once 'check-password.php';

    require_once './API/connection.php';

    //if user not specify a username, get their username instead (set default)
    $input_username = !empty($_GET['username']) ? $_GET['username'] : $_SESSION['user'];

    //prevent admin from viewing his profile since he dose not have that feature
    if ($_SESSION['user'] == 'admin' && $input_username == 'admin') {
        header('Location:index.php');
        die();
    }
    //prevent user from looking up for admin profile
    else if ($input_username == 'admin') {
        header('Location:profile.php');
        die();
    }

    $hoten = ''; 
    $chucvu = '';
    $tenphongban = '';
    $avatar = '';

    $error = '';

    $stmt = $conn->prepare('SELECT username, hoten, chucvu, tenphongban, avatar FROM account, phongban 
                            WHERE account.maphongban = phongban.ID AND account.username = ?');

    $stmt->bind_param("s", $input_username);

    if (!$stmt->execute()) {
        die($error = $stmt->error);
    }
    
    $result = $stmt->get_result();

    //if look for an invalid user, return to their own profile
    if ($result->num_rows == 0) {
        header("Location:profile.php");
        die();
    }

    $row = $result->fetch_assoc();


    $hoten = $row['hoten'];
    $chucvu = $row['chucvu'];
    $tenphongban = $row['tenphongban'];
    $avatar = $row['avatar'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $hoten?> | Website</title>
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
                <!--avatar column ========================================================== -->
                <div class="col-lg-4 mb-3 mb-lg-0 p-0" >
                    <div class="p-3 pt-4 bg-white border rounded">
                        <div class="mb-3 mx-auto rounded-circle position-relative" style="width:160px; height:160px">
                            <img class="rounded-circle w-100 h-100" src="assets/img/<?= $avatar?>" >

                            <?php if($_SESSION['user'] == $input_username ) { ?>
                                <div class="avatar-overlay rounded-circle">
                                    <span>
                                        <i class="fas fa-camera"></i>
                                    </span>
                                </div>                        
        
                            <?php } ?>
                            
                            <input type="file" name="avatar" id="avatar" accept="image/*" style="display: none;">
                        </div>

                        <div class="text-center">
                            <div><h5><b><?= $hoten?></b></h5></div>
                            <div>Employee ID: <?= $input_username?></div>
                        </div>

                        
                        <?php if($_SESSION['user'] == $input_username) { ?>
                            <hr>
                            <div class="btn btn-light d-block mx-auto mb-2 change-avatar-btn">
                                <i class="fas fa-image mr-1"></i>
                                Cập nhật ảnh đại diện
                            </div>
                            <a class="btn btn-light d-block mx-auto" href="reset-password-optional.php">
                                <i class="fas fa-key mr-1"></i>
                                Đổi mật khẩu
                            </a>       
                        <?php } ?>


                    </div>
                </div>

                <!-- info column ================================================================================== -->
                <div class=" col-lg-8 p-0 px-lg-3 mb-4 mb-lg-0">

                    <div class="border p-3 rounded bg-white">
                        <h5>Thông tin nhân viên</h5>

                        <hr>

                        <div class="form-group mt-3">
                            <label for="">Mã nhân viên:</label>
                            <input type="text" class="form-control" id="username" disabled value="<?= $input_username?>">
                        </div>
                        <div class="form-group">
                            <label for="">Tên người dùng:</label>
                            <input type="text" class="form-control" id="" disabled value="<?= $input_username?>">
                        </div>
                        <div class="form-group">
                            <label for="new-password">Họ và tên:</label>
                            <input type="text" class="form-control" id="" disabled value="<?= $hoten?>">
                        </div>
                        <div class="form-group">
                            <label for="">Chức vụ:</label>
                            <input type="text" class="form-control" id="" disabled value="<?= $chucvu?>">
                        </div>
                        <div class="form-group mb-0">
                            <label for="">Phòng ban:</label>
                            <input type="text" class="form-control" id="" disabled value="<?= $tenphongban?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
            include_once 'footer.php';
        ?> 
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
</body>


<script src="main.js">

</script>

</html>