
<?php
    if ($_SESSION['permission'] !== "Admin") {
        ?>
            <div class="d-flex min-vh-100 flex-column align-items-center justify-content-center px-4">
                <h5 class="text-secondary text-center mb-3">Bạn không có quyền truy cập vào trang này</h5>
                <a href="index.php" class="btn btn-primary text-center">Quay về trang chủ</a>   
            </div>
        <?php

        die();
    }


?>