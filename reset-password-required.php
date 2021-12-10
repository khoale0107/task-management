<?php
    require_once 'check-session.php';

    //if no need to change password, prevent user from visitting this page
    if (!password_verify($_SESSION['user'], $_SESSION['hashed-password'])) {
        header('Location:index.php');
    } 
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
<body id="reset-password-page" class="min-vh-100">
    <div class="container">
        <div class=" col-md-7 col-lg-5 bg-white mx-auto mt-5 pt-5 pb-4 shadow-lg rounded-lg border" >
            <div class="col">
                <h5 class='   text-primary'>Đổi mật khẩu để tiếp tục</h5>
                <hr>
                
                <form>
                    <div class="">
                        <div class="form-group">
                            <label for="usr">Mật khẩu hiện tại:</label>
                            <input type="password" class="form-control" name="current-password" placeholder="Mật khẩu hiện tại">
                        </div>
                        <div class="form-group">
                            <label for="usr">Mật khẩu mới:</label>
                            <input type="password" class="form-control" name="new-password" placeholder="Mật khẩu mới">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Xác nhận mật khẩu mới:</label>
                            <input type="password" class="form-control" name="confirm-password" placeholder="Nhập lại mật khẩu mới">
                        </div>
                    </div>

                    <div id="error-message" class=" text-danger text-center"></div>


                    <div class="">
                        <button id="change-password-button" class="change-password-button mt-3  btn btn-success w-100" >Đổi mật khẩu</button>
                        <a href="logout.php" class="mt-2  btn border border-primary text-primary w-100" >Đăng xuất</a>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

<script src="main.js">
    
</script>


</body>
</html>