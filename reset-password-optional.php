<?php
    require_once 'check-session.php';

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
<?php
        include_once 'navbar.php';
    ?>

    <div class="container">
        <div class=" col-md-7 col-lg-5  mx-auto pt-4 pb-4 shadow-lg rounded-lg border bg-white" >
            <div class="">
                <h5 class='  text-primary'>Đổi mật khẩu</h5>
                <hr>

                <form>
                    <div class="">
                        <div class="form-group">
                            <label for="current-password">Mật khẩu hiện tại:</label>
                            <input type="password" class="form-control" id="current-password" name="current-password" placeholder="Mật khẩu hiện tại">
                        </div>
                        <div class="form-group">
                            <label for="new-password">Mật khẩu mới:</label>
                            <input type="password" class="form-control" id="new-password" name="new-password" placeholder="Mật khẩu mới">
                        </div>
                        <div class="form-group">
                            <label for="confirm-password">Xác nhận mật khẩu mới:</label>
                            <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Xác nhận mật khẩu mới">
                        </div>
                    </div>

                    <div id="error-message" class="text-danger text-center"></div>


                    <div class="col-md-5 mx-auto">
                        <button id="change-password-button" class="change-password-button mt-4  btn btn-success w-100" >Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
        include_once 'footer.php';
    ?>
</div>

<script src="main.js"></script>
</body>

</html>