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
    .task ~ .task {
        margin-top: 1rem;
    }
</style>

<body>
<div id="wrapper">
    <?php           
        include 'navbar.php';
    ?>

    <div class="container ">
        <div class="row">
            <div class="col">
                <h4 class="mb-3">Công việc </h5>
                
                <div class="border  task">Công việc 1</div>
                <div class="border task">Công việc 1</div>
                <div class="border task">Công việc 1</div>
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
