//login page=================================================================================
if (window.location.pathname.includes("login.php")) {
    $(document).ready(function () {
        //chuc nang linh tinh
        if ($("input[name=username]").val() === '') {
            $("input[name=username]").focus();
        }
        else {$("input[name=password]").focus();}
        
        $("#login-button").click(function (e) { 
            e.preventDefault();
    
            let username = $("input[name=username]").val();
            let password = $("input[name=password]").val();
            let rememberCheck = $("input[type=checkbox]").prop('checked');
    
            //check empty input
            if (username == '' || password == '') {
                $("#login-message").text("Please enter username and password.");
                return;
            }
    
            //send login request
            $.post('API/handle-login.php', {username, password, rememberCheck}, function(data) {
                if (data.status) {
                    console.log(data);
                    window.location.replace("index.php");
                }
                else {
                    $("#login-message").text(data.data);
                } 
            }, 'json')
            .fail(function(xhr, status, error) {
                alert("Cannot connect to handle-login.php:" + xhr.responseText);
            });   
        });
    });
}

//doi mat khau page=================================================================================
if (window.location.pathname.includes('reset-password')) {
    $("#change-password-button").click(function (e) { 
        e.preventDefault();
        
        let currentPassword = $("input[name='current-password']").val();
        let newPassword = $("input[name='new-password']").val();
        let confirmPassword = $("input[name='confirm-password']").val();

        if (currentPassword == '' || newPassword == '' || confirmPassword == '') {
            $("#error-message").text("Hãy nhập đủ thông tin"); 
            return;
        }

        if (newPassword.length < 6) {
            $("#error-message").text("Mật khẩu phải chứa ít nhất 6 ký tự"); 
            return;
        }

        $.post('API/handle-reset-password.php', 
            {
                'current-password': currentPassword, 
                'new-password': newPassword, 
                'confirm-password': confirmPassword
            },
            function(data) {
                if (data.status) {
                    $("#error-message").removeClass('text-danger')
                    $("#error-message").addClass('text-success').text(data.data);

                    if (window.location.pathname.includes('reset-password-required.php')) {
                        window.location.replace("/index.php");
                    }
                }
                else {
                    $("#error-message").removeClass('text-success')
                    $("#error-message").addClass('text-danger').text(data.data);
                }
                console.log(data.data);
            }, 'json')
        .fail(function(xhr, status, error) {
            alert("Cannot connect to handle-reset-password.php:"  + xhr.responseText);
        });
    });
}


//quan ly nhan vien page==========================================================================================
if (window.location.pathname.includes("nhanvien.php")) {
    $(document).ready(function () {
        loadEmployee(); //load nhan vien

        //load nhan vien
        function loadEmployee() {
            $("tbody").empty();
            $.get('API/get-employees.php',function(data) {
                if (data.status) {
                    data.data.forEach(nhanvien => {
                        let {username, hoten, chucvu, tenphongban} = nhanvien

                        let row = ` <tr>
                                        <td><a href="profile.php?username=${username}">${username}</a></td>
                                        <td>${hoten}</td>
                                        <td>${chucvu}</td>
                                        <td>${tenphongban}</td>
                                        
                                        <td>
                                            <div class="dropdown text-center">
                                                <span class="btn" data-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </span>
                                                <div class="dropdown-menu shadow">
                                                    <a  class="btn btn-light rounded-0 dropdown-item" href="profile.php?username=${username}">
                                                        Chi tiết
                                                    </a>
                                                    <div  class="btn btn-light rounded-0 dropdown-item" href="#" onclick="showConfirmReset(this)">
                                                        Reset mật khẩu
                                                    </div>
                                                    <div  class="btn btn-light rounded-0 dropdown-item text-danger" href="#" onclick="showConfirmDelete(this)">
                                                        Xóa nhân viên
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr> `

                        $("tbody").append(row);
                    });
                } else {
                    console.log("0 rows of nhanvien");
                }
            }, 'json')
            .fail(function(xhr, status, error) {
                alert("Cannot connect to get-employees.php:" + xhr.responseText);
            });  
        }

        //chuc nang linh tinh
        $("button[type=reset]").click(function (e) { 
            $("#error-message").empty();
        });
        $(".navbar-collapse a[href='nhanvien.php']").addClass("active");

        //load phong ban vao select box
        $.get('API/get-departments.php',
            function(data) {
                if (data.status) {
                    data.data.forEach(phongban => {
                        let {ID, tenphongban} = phongban

                        let option = `<option value="${ID}" name="${tenphongban}">${tenphongban}</option>`

                        $(".select-department").append(option);
                    });
                } else {
                    alert(data.data)
                }
            }, 'json')
        .fail(function(xhr, status, error) {
            alert("Cannot connect to get-departments.php:" + xhr.responseText);
        }); 

        //them nhan vien
        $("#add-employee-btn").click(function (e) {
            e.preventDefault();

            let employeeid = $("input[name=employeeid]").val().trim();
            let fullname = $("input[name=fullname]").val().trim();
            let departmentid = $("form .select-department").val()

            console.log(departmentid);
            //check input
            if (employeeid == '' || fullname == '') {
                $("#error-message").removeClass("text-success").addClass("text-danger")
                $("#error-message").text("Hãy nhập đủ thông tin.");
                return;
            }

            if (!departmentid) {
                $("#error-message").removeClass("text-success").addClass("text-danger")
                $("#error-message").text("Hãy chọn phòng ban.");
                return;
            }

            $.post("API/add-employee.php", 
                {
                    employeeid,
                    fullname,
                    departmentid
                },
                function(data)  {
                    //them thanh cong
                    if (data.status) {
                        loadEmployee();
                        $("button[type=reset]").click()
                        $("#error-message").empty();
                        $('.toast b').text("Thêm nhân viên thành công.");
                        $('.toast').toast('show');
                    }
                    else {
                        $("#error-message").removeClass("text-success").addClass("text-danger")
                        $("#error-message").text("Mã nhân viên đã tồn tại.");
                    }
                }, "json")
            .fail((xhr) => {
                alert("Cannot connect to add-emplyee.php" + xhr.responseText);
            });
        });

        //xoa nhan vien
        $("#confirm-delete-btn").click(function (e) { 
            e.preventDefault();

            $.post("API/delete-employee.php",
                {
                    employeeid: $('#modal-delete').attr('employeeid')
                },
                function (data) {
                    //xoa thanh cong
                    if (data.status) {  
                        loadEmployee();
                        $('.toast-header-message').text("Xóa nhân viên thành công");
                        $('.toast').toast('show');
                    }
                    else {
                        console.log(data.data);
                    }
                }, "json"
            ).fail(() => {
                alert("Cannot connect to delete-employee.php:"  + xhr.responseText);
            })
        });
        
        //reset mat khau mac dinh
        $("#confirm-reset-btn").click(function (e) { 
            e.preventDefault();

            let employeeid = $('#modal-reset').attr('employeeid');
            $.post("API/set-default-password.php",
                {
                    employeeid
                },
                function (data) {
                    if (data.status) {
                        $('.toast-header-message').text(`Reset mật khẩu tài khoản ${employeeid} thành công`);
                        $('.toast').toast('show');
                    }
                    else {
                        console.log(data.data);
                    }
                }, "json"
            ).fail(() => {
                alert("Cannot connect to set-default-password.php:"  + xhr.responseText);
            })
        });
        
        //loc nhan vien theo phong ban
        // $('#search-by-department').change(function (e) { 
        //     e.preventDefault();
        //     var optionSelected = $("option:selected", this);
        //     let department = $("option:selected", this).attr('name');

        //     $("tbody tr").each(function() {
        //         let currentRowString = ($(this).text())
        //         $(this).toggle(currentRowString.includes(department))
        //     });
        // });
    });

    function showConfirmReset(e) {
        let currentRow = $(e).closest('tr');
        let employeeid = currentRow.children("td:nth-child(1)").text();
        let currentFullName = currentRow.children("td:nth-child(2)").text();

        //set employeeid
        $('#modal-reset').attr('employeeid', employeeid)
        $('#modal-reset .modal-body').text(`Thiết lập mật khẩu của '${currentFullName}' thành mặc định?`)
        $('#modal-reset').modal('show')
    }

    function showConfirmDelete(e) {
        let currentRow = $(e).closest('tr');
        let employeeid = currentRow.children("td:nth-child(1)").text();
        let currentFullName = currentRow.children("td:nth-child(2)").text();

        $('#modal-delete').attr('employeeid', employeeid)
        $('#modal-delete .modal-body').text(`Đồng ý xóa tài khoản của '${currentFullName}'?`)        
        $('#modal-delete').modal('show')
    }

}


//quan ly phong ban page==========================================================================================
if (window.location.pathname.includes("phongban.php")) {
    $(document).ready(function () {
        //chuc nang linh tinh
        $("button[type=reset]").click(function (e) { 
            $("#error-message").empty();
        });
        $(".navbar a[href='phongban.php']").addClass("active");

        loadDepartment(); //load phong ban

        //load phong ban
        function loadDepartment() {
            $("tbody").empty();
            $.get('API/get-departments.php', function(data) {
                if (data.status) {

                    data.data.forEach(phongban => {
                        let {ID, tenphongban, tentruongphong, mota, sophong} = phongban

                        if (!tentruongphong) {
                            tentruongphong = "-";
                        }

                        let row = ` <tr>
                                        <td>${ID}</td>
                                        <td>${tenphongban}</td>
                                        <td>${mota}</td>
                                        <td>${sophong}</td>
                                        <td>${tentruongphong}</td>
                                        <td>
                                            <div class="dropdown text-center">
                                                <span class="btn" data-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </span>
                                                <div class="dropdown-menu shadow">
                                                    <div class="btn btn-light rounded-0 dropdown-item" href="#" onclick="showEditModal(this)">
                                                        Cập nhật phòng ban
                                                    </div>
                                                    <div class="btn btn-light rounded-0 dropdown-item" href="#" onclick="showAssignManagerModal(this)">
                                                        Bổ nhiệm trưởng phòng
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr> `

                        $("tbody").append(row);
                    });
                } else {
                    alert("0 rows of phongbang");
                }
            }, 'json')
            .fail(function(xhr, status, error) {
                alert("Cannot connect to get-departments.php:" + xhr.responseText);
            });  
        }



        //them phong ban 
        $("#add-department-btn").click(function (e) {
            e.preventDefault();

            let departmentName = $("input[name=departmentName]").val().trim();
            let description = $("textarea[name=description]").val().trim();
            let numberOfRooms = $("input[name=numberOfRooms]").val().trim();
        
            //check input
            if (departmentName == '' || description == '' || numberOfRooms == '') {
                $("#error-message").removeClass("text-success").addClass("text-danger")
                $("#error-message").text("Hãy nhập đủ thông tin.");
                return;
            }


            $.post("API/add-department.php", 
                {
                    departmentName,
                    description,
                    numberOfRooms
                },
                function(data)  {
                    //them thanh cong
                    if (data.status) {
                        loadDepartment();
                        $("button[type=reset]").click()
                        $("#error-message").empty();
                        $('.toast-header-message').text("Thêm phòng ban thành công.");
                        $('.toast').toast('show');
                    }
                    else {
                        $("#error-message").removeClass("text-success").addClass("text-danger")
                        $("#error-message").text(data.data);
                    }
                }, "json")
            .fail((xhr) => {
                alert("Cannot connect to add-department.php" + xhr.responseText);
            });
        });

        //sua/cap nhat phong ban 
        $("#confirm-update-btn").click(function (e) { 
            let departmentid = $('#modal-update').attr('departmentid')
            let departmentName = $('#department-name-modal').val().trim();
            let description = $('#description-modal').val().trim();
            let numberOfRooms = $('#number-of-rooms-modal').val().trim();

            if (departmentName == '' || description == '') {
                $("#error-message-modal").text("Hãy nhập đủ thông tin.");
                return;
            }

            if (numberOfRooms == '') {
                $("#error-message-modal").text("Số phòng không hợp lệ");
                return;
            }

            $.post("API/update-department.php",
                {
                    departmentid, 
                    departmentName,
                    description, 
                    numberOfRooms,
                },
                function(data) {
                    if (data.status) {
                        loadDepartment();
                        $('.toast-header-message').text(`Cập nhật ${departmentName} thành công.`);
                        $('.toast').toast('show');
                        $('#modal-update').modal('hide')
                    }
                    else {
                        $("#error-message-modal").text(data.data);
                    }
                }, "json")
            .fail(() => {
                showFailedDialog("Cannot connect to update-department.php")
            })  
        });

        //bo nhiem truong phong 
        $("#assign-btn").click(function (e) { 
            e.preventDefault();
            let departmentid = $('#modal-assign-manager').attr('departmentid')
            let employeeid = $('input[name=username]:checked').val();

            console.log(employeeid);
            console.log(departmentid);
            
            $.post('API/update-department-manager.php', {departmentid, employeeid},
            function(data) {
                if (data.status) {
                    loadDepartment();
                    $('.toast-header-message').text("Cập nhật trưởng phòng thành công.");
                    $('.toast').toast('show');
                    $('#modal-assign-manager').modal('hide')
                } else {
                    alert(data.data)
                }
            }, 'json')
            .fail(function(xhr, status, error) {
                alert("Cannot connect to update-department-manager.php.php:" + xhr.responseText);
            }); 
        });


    });

    //show modal cap nhat phong ban
    function showEditModal(e) {
        //prepare modal
        let currentRow = $(e).closest('tr');
        let departmentid = currentRow.children("td:nth-child(1)").text();
        let departmentName = currentRow.children("td:nth-child(2)").text();
        let description = currentRow.children("td:nth-child(3)").text();
        let numberOfRooms = currentRow.children("td:nth-child(4)").text();

        $('#modal-update').attr('departmentid', departmentid)
        $('#department-name-modal').val(departmentName);
        $('#description-modal').val(description);
        $('#number-of-rooms-modal').val(numberOfRooms);
        $("#error-message-modal").empty();

        //show modal
        $('#modal-update').modal('show')
        $('input[id=department-name-modal]').focus();
    }
    

    //show modal bo nhiem truong phong
    function showAssignManagerModal(e) {
        //prepare modal
        let currentRow = $(e).closest('tr');
        let departmentid = currentRow.children("td:nth-child(1)").text();
        let departmentName = currentRow.children("td:nth-child(2)").text();

        $('#modal-assign-manager').attr('departmentid', departmentid)
        $("#modal-assign-manager .modal-title").text(`${departmentName}`);
        $("#assign-btn").attr('disabled', true);


        $('#modal-assign-manager').modal('show')
        
        //load nhan vien theo phong ban
        $("#modal-assign-manager .employee-list").empty();
        $.post('API/get-employees-by-department.php', {departmentid}, function(data) {
            if (data.status) {
                let truongphong = {};

                data.data.forEach(nhanvien => {
                    let {username, hoten, chucvu, avatar} = nhanvien
                    
                    if (chucvu === "Trưởng phòng") {
                        truongphong = nhanvien;

                        let disabledRow = `<label  class=" rounded-0  p-3 mb-0 w-100" >
                                                <div class="d-flex align-items-center">
                                                    <input type="radio" value="" disabled  checked>
                                                    <div class="ml-2 d-flex">
                                                        <img style="object-fit: cover;" class="rounded-circle mr-2" height="40" width="40" src="assets/img/${avatar}" alt="img">
                                                        <div class="d-flex flex-column">
                                                            <div>${hoten}</div>
                                                            <div class="text-muted" style="font-size:0.8rem">Trưởng phòng</div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </label>`
                                        
                        $("#modal-assign-manager .employee-list").prepend(disabledRow);
                    }

                    else {
                        let row =  `<label  class="btn btn-light  dropdown-item p-3 mb-0" >
                                        <div class="d-flex align-items-center">
                                            <input type="radio" name="username" value="${username}" onchange="$('#assign-btn').attr('disabled', false);">
                                            
                                            <div class="ml-2">
                                                <img style="object-fit: cover;" class="rounded-circle mr-2" height="40" width="40" src="assets/img/${avatar}" alt="img">

                                                ${hoten}
                                            </div>
                                        </div>
                                    </label>`;

                        $("#modal-assign-manager .employee-list").append(row);
                    }
                });
            } 

            else {
                let message = $('<div>Chưa có nhân viên nào</div>').addClass('text-muted text-center py-3')
                $(".employee-list").append(message)
            }
        }, 'json')
        .fail(function(xhr, status, error) {
            alert("Cannot connect to get-employees-by-department.php:" + xhr.responseText);
        });  
    }

}


//quan ly task/nhiem vu page=================================================================================================
if (window.location.pathname.includes("congviec.php")) {
    $(document).ready(function () {
        $(".navbar-collapse a[href='congviec.php']").addClass("active");
        
    });
    
    
}


//nop don nghi phep page=================================================================================================
if (window.location.pathname.includes("nopdon.php")) {
    $(document).ready(function () {
        //chuc nang linh tinh
        $(".navbar-collapse a[href='nopdon.php']").addClass("active");
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        //nop don/submit
        $(".submit-btn").click(function (e) { 
            e.preventDefault();

            //check input
            let dayNumber = $("input[id='day-number']").val();

            if (!$.isNumeric(dayNumber) || dayNumber < 1) {
                showModal("Lỗi", "Số ngày nghỉ không hợp lệ2.")
                
                return;
            }
            // if (dayNumber < 1) {
            //     showModal("Lỗi", "Số ngày nghỉ không hợp lệ.")
                
            //     return;
            // }

            if ($("#remain-days").html() == 0) {
                showModal("Lỗi", "Bạn không được phép nghỉ thêm ngày nào trong năm nay.")

                return;
            }

            if (parseInt(dayNumber) > parseInt($("#remain-days").html())) {
                $(".modal-message").text("Số ngày nghỉ vượt mức cho phép");
                $('.modal').modal('show')
                return;
            }

            let reason = $("textarea[id=reason]").val().trim();
            if (reason == '') {
                $(".modal-message").text("Hãy nhập lý do.");
                $('.modal').modal('show')
                return;
            }



            let userName = $("#username").text(); //#userid tren navbar
            
            let fd = new FormData();
            fd.append('songay', dayNumber);
            fd.append('lydo', reason);
            fd.append('username', userName);

            // append file if selected
            if($('#customFile')[0].files.length > 0 ){
                let file = $("#customFile")[0].files[0];
                fd.append('file', file);
            }


            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'API/nopdon-api.php', true);

            xhr.onload = function() {
                let data = JSON.parse(this.responseText)
                if (data.status) {
                    alert(data.data)
                    window.location.reload();
                }
                else {
                    showModal("Lỗi", data.data)
                }
            }	

            xhr.send(fd);

        });

        //validate file
        $("#customFile").change(function (e) { 
            e.preventDefault();
            console.log(e.target.files[0]);

            let file = e.target.files[0];
            let ext = file.name.split('.').pop();
            let invalidExtentions = ['exe', 'sh', 'msi']

            if (invalidExtentions.includes(ext)) {
                $(".modal-message").text("Tập tin không hợp lệ.");
                $('.modal').modal('show')
                e.target.value = ''
                $(".custom-file-label").text('Choose file');
                return;
            }
            else if (file.size > 10 * 1024 * 1024) {
                $(".modal-message").text("Kích thước tập tin không được vượt quá 10MB.");
                $('.modal').modal('show')
                e.target.value = ''
                $(".custom-file-label").text('Choose file');
                return;
            }
        });
        

    });

}


//duyet don nghi phep page=================================================================================================
if (window.location.pathname.includes("duyetdon.php")) {
    let requestList = []
    let currentRequestID

    $(document).ready(function () {
        //chuc nang linh tinh
        $(".navbar-collapse a[href='duyetdon.php']").addClass("active");

        loadRequest()
        
    });

    //load yeu cau nghi phep
    function loadRequest() {
        requestList = []
        $(".request-container").empty()
        
        let id = $("#department-id").html();


        let fd = new FormData();
        fd.append('department-id', id);

        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'API/get-leave-requests.php', true);

        xhr.onload = function() {
            let data = JSON.parse(this.responseText)
            if (data.status) {
                data.data.forEach(function(item, index) {
                    requestList.push(item);

                    let badgeType = "";
                    if (item.trangthai == 'waiting') {
                        badgeType = 'info'
                    }
                    else if (item.trangthai == 'approved') {
                        badgeType = 'success'
                    }
                    else if (item.trangthai == 'refused') {
                        badgeType = 'danger'
                    }

                    let ngaylap = new Date(item.ngaylap)
                    let ngaylapTmp = new Date(item.ngaylap)
                    ngaylapTmp.setHours(0, 0, 0, 0)
                    
                    let curDate = new Date()
                    curDate.setHours(0, 0, 0, 0)

                    let formattedDate = "";

                    //show time or date
                    if(ngaylapTmp.getTime() === curDate.getTime()) {
                        formattedDate = ngaylap.toLocaleTimeString('it-IT' , {hour:"numeric", minute:"numeric"})
                    }
                    else {
                        formattedDate = ngaylap.toLocaleDateString('vi-VN', { month:"short", day:"numeric"})
                    }

                    let request = ` <div onclick="showModal(this)" data-index="${index}" class="btn list-group-item list-group-item-action d-flex align-items-center px-2 px-sm-3  rounded-0">
                                        <div class="mr-3">
                                            <img class="rounded-circle" height="36" width="36" src="assets/img/${item.avatar}" alt="img">
                                        </div>

                                        <div class="flex-grow-1 ellipsis">
                                            <b>${item.hoten}</b>
                                        </div>
                                        
                                        
                                        <div class="d-flex flex-column flex-sm-row justify-content-end" style="min-width: 72px; margin-left: 0px; text-align: end;">
                                            <strong>${formattedDate}</strong>    
                                            <div class="" style="min-width: 72px">
                                                <div class="badge badge-${badgeType} ">${item.trangthai}</div >
                                            </div>
                                        </div>
                                    </div>
                                `

                    // <div style="min-width:70px">
                    // </div>
                    // <div></div>
                    $(".request-container").append(request);
                })

                console.log(requestList);
            }
            else {
                alert(data.data)
            }
        }	

        xhr.send(fd);
    }   

    //show modal of request
    function showModal(e) {
        
        let index = $(e).attr('data-index');
        $("#modal-avatar").attr("src", `assets/img/${requestList[index].avatar}`);
        $("#hoten").text(requestList[index].hoten);
        $("#songay").text(requestList[index].songay);
        $("#employeeid").text(requestList[index].username);
        $("#reason").text(requestList[index].lydo);
        $("#file").text(requestList[index].file);
        $("#status").text(requestList[index].trangthai);
        $("#file").attr("href", "nghiphep-files/" + requestList[index].file);

        if (requestList[index].trangthai == 'waiting') {
            $("#status").removeClass("badge-success");
            $("#status").removeClass("badge-danger");
            $("#status").addClass("badge-info");

        }
        else if (requestList[index].trangthai == 'approved') {
            $("#status").removeClass("badge-info");
            $("#status").removeClass("badge-danger");
            $("#status").addClass("badge-success");

        }
        else {
            $("#status").removeClass("badge-success");
            $("#status").removeClass("badge-info");
            $("#status").addClass("badge-danger");
        }


        if (requestList[index].trangthai != 'waiting') {
            $(".btn-group").css("display", "none");
        }
        else {
            $(".btn-group").css("display", "inline-flex");

        }
        
        currentRequestID = requestList[index].ID
        
        $('.modal').modal('show')
    }

    function approve() {
        let fd = new FormData();
        fd.append('ID', currentRequestID);

        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'API/approve-leave-request.php', true);

        xhr.onload = function() {
            let data = JSON.parse(this.responseText)

            if (data.status) {
                $('.modal').modal('hide')
                alert(data.data)
                loadRequest()
            }
            else {
                alert(data.data)
            }
        }	

        xhr.send(fd);
    }

    function refuse() {
        let fd = new FormData();
        fd.append('ID', currentRequestID);

        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'API/refuse-leave-request.php', true);

        xhr.onload = function() {
            let data = JSON.parse(this.responseText)

            if (data.status) {
                $('.modal').modal('hide')
                alert(data.data)
                loadRequest()
            }
            else {
                alert(data.data)
            }
        }	

        xhr.send(fd);
    }

}


//profile page
if (window.location.pathname.includes("profile.php")) {
    $(document).ready(function () {
        //chuc nang linh tinh
        $(".navbar-collapse a[href='nhanvien.php']").addClass("active");

        $(".change-avatar-btn").click(function (e) { 
            $("input[id=avatar]").click()
        });

        $(".avatar-overlay").click(function (e) { 
            $("input[id=avatar]").click()
        });


        //doi avatar
        $("input[id=avatar]").change(function (e) { 
            let file = $("input[id=avatar]")[0].files[0]
            
            //return if user click cancel
            if (!file) {
                return;
            }
            
            let validExtensions = ["png", "jpg", "jpeg",];
            let fileExtension = file.name.split('.').pop();

            //invalid file
            if (!validExtensions.includes(fileExtension)) {
                showModal("Lỗi", "Chỉ được phép upload tập tin png, jpeg, jpg.")
                $("input[id=avatar]").val("");
                return;
            }

            //valid img
            let formData = new FormData();
            formData.append('avatar', file)
            formData.append('username', $("input[id=username]").val())

            // send request
            $.ajax({
                url:'API/change-avatar.php',
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data){
                    if (data.status) {
                        window.location.reload();
                    }
                    else {
                        alert(data.data)
                    }
                },
                dataType: 'json'
            }).fail(function(a, b, c) {
                alert('Cannot connect to change-avatar.php')
            })        
        });
    });
}

//all pages===============================================================================================
$(document).ready(function(){
    //table search 
    $(".search-input").keyup( function() {
        //bo dau
        function removeAccents(str) {
            return str.normalize('NFD')
                      .replace(/[\u0300-\u036f]/g, '')
                      .replace(/đ/g, 'd').replace(/Đ/g, 'D');
        }

        let inputString = removeAccents($(this).val().toLowerCase().trim());
        $("tbody tr").each(function() {
            let currentRowString = removeAccents($(this).text().toLowerCase())
            $(this).toggle(currentRowString.includes(inputString))
        });
    });

    //clear search box
    $("#clear-searchbox-btn").click(function (e) {
        let searchbox = $(this).siblings(".search-input");
        searchbox.val("");
        $(".search-input").keyup();
    });
});

//show modal
function showModal(title, message) {
    $(".modal-title").text(title);
    $(".modal-message").text(message);
    $('.modal').modal('show')
}


