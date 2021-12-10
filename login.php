<?php
    session_start();
    //if already logged in, go to mainpage
    if (isset($_SESSION['user'])) {
        header('Location:index.php');
        die();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    
    <link rel="stylesheet" href="style.css">

</head>

<body id="login-page" class="min-vh-100"> 
<div class="container-fluid py-5">
    <div class="col-xl-3 col-lg-6 col-md-8 col-sm-11 bg-white mx-auto pt-5 pb-4 shadow-lg rounded-lg border " id="login-form" >
        <div class="mx-auto  p-0 p-sm-3">
            <h1 class="text-center  font-weight-normal">Login</h1>
            <hr>
            <form   >
                <div class="form-group ">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                        </div>
                        <input class="form-control" type="text" id="username" placeholder="Username" name="username" <?php if (isset($_COOKIE['username'])) echo "value='".$_COOKIE['username']."'"?>>
                    </div>
                </div>
                
                <div class="form-group mb-4">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-unlock"></i></span>
                        </div>
                        <input class="form-control" type="password" id="password" placeholder="Password" name="password">
                    </div>
                </div>


                <div class="form-group">
                    <div class="custom-control custom-checkbox mb-2">
                        <input type="checkbox" class="custom-control-input" id="customCheck" name="remember">
                        <label class="custom-control-label" for="customCheck">Remember username</label>
                    </div>
                </div>

                <div id="login-message" class=" text-danger text-center"></div>

                <br>

                <div class="">
                    <input type="submit" id="login-button" class=" btn btn-primary w-100" value="Login">
                </div>
                
            </form>
        </div>
    </div>
</div>

<script src="main.js"></script>

</body>
</html>


