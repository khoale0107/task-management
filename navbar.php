<nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top ">
    <div class="container justify-content-start">
        
        
        <a class="text-decoration-none text-white mr-3 " href="index.php">
            <h4 style="position: relative; top:2px;">Website</h4>
        </a>
        
        <!-- usermenu -->
        <div class="dropdown ml-auto order-md-3">
            <div class="btn  text-white" data-toggle="dropdown">
                <i class="fas fa-user"></i>
                <i class="fas fa-caret-down"></i>
            </div>

            <div class="dropdown-menu shadow" style="transform: translateX(-70%); min-width:200px">
                <a class="dropdown-item d-flex align-items-center pl-3" href="profile.php">

                    <span class="mr-2" >
                        <img class="rounded-circle nav-avatar" height="40" width="40" src="assets/img/<?= ($_SESSION['user'] == 'admin') ? 'admin.png' : $_SESSION['avatar']?>" alt="img">
                    </span>

                    <div class="d-flex flex-column flex-grow-1">
                        <span class=""><b><?= $_SESSION['full-name']?></b></span>
                        <span>
                            @<span id="username"><?= $_SESSION['user']?></span> 
                        </span>
                    </div>
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="index.php" >
                    <span class="mr-2"><i class="fas fa-home"></i></span>
                    Trang chủ
                </a>


                <?php if ($_SESSION['user'] != 'admin') { ?>
                    <a class="dropdown-item" href="profile.php" >
                        <span class="mr-2"><i class="fas fa-user"></i></span>
                        Trang cá nhân
                    </a>
                <?php } ?>


                <a class="dropdown-item" href="reset-password-optional.php" >
                    <span class="mr-2"><i class="fas fa-key"></i></span>
                    Đổi mật khẩu
                </a>
                <a class="dropdown-item" href="logout.php" >
                    <span class="mr-2"><i class="fas fa-sign-out-alt"></i></span>
                    Đăng xuất
                </a>
            </div>
        </div>

        <!-- nav toggle btn -->
        <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- subnav -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <?php
                    if ($_SESSION['permission'] === 'Admin') {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link " href="nhanvien.php">Nhân viên</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="phongban.php">Phòng ban</a>
                            </li>                            
                        <?php
                    }
                    else {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link " href="congviec.php">Công việc</a>
                            </li>

                        <?php
                    }
                ?>

                <?php
                    if ($_SESSION['permission'] !== 'Admin') {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link " href="nopdon.php">Nộp đơn</a>
                            </li>                        
                        <?php
                    }

                    if ($_SESSION['permission'] !== 'Nhân viên') {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link " href="duyetdon.php">Duyệt đơn</a>
                            </li>                        
                        <?php
                    }

                ?>
            </ul>
        </div>  
    </div>
    <div id="department-id" style="display:none"><?= $_SESSION['department-id']?></div>
    <div id="permission" style="display:none"><?= $_SESSION['permission']?></div>
</nav>



