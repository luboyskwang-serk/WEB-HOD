
<div class="container-fluid bb col-lg-10 col-10">  
<div class="container-sm mt-5 shadow-sm p-4 mb-4" data-aos="fade-down" style="background-color:#0f0f0f">
    <center>
            <div class="col-12 col-lg-12 p-2 mb-2" style="border-radius: 1vh;">
                <div class="d-flex justify-content-between">
                    <div class="text-center text-lg-start">
                    <h5 class="m-0"><h5 class=" mb-2 mt-2" style="color:#e3e3e3;">
                    <i class="fa-regular fa-pen-to-square fa-fade"></i>
                     หมวดหมู่เติมเกมส์</h5>
                    <p style="font-size:14px; color:#eaac13;"><?php echo $config['name']; ?></span></p>
                    </div>

                    
                </div>
            </div>
        </center>
    <div class="d-flex justify-content-center">


                    <!-- ปุ่มย้อนกลับ -->
                    <button class="btn mx-1 btn-back mt-2 mb-2 text-white"onclick="window.history.back()"><i class="fa-duotone fa-house"></i></button>
                                        
                
                    <button class="btn btn-back mt-2 mb-2 text-white"  id="open_insert">
                        <i class="fa-duotone fa-square-plus fa-fade" style="--fa-primary-color: #f3b81b; --fa-secondary-color: #f3b81b;"></i>
                        เพิ่มหมวดหมู่ใหม่
                    </button>

                    <style>
                        .btn-back {
                            background-color:#1c1a1a;
                            color:#507b50;
                            border-radius:1vh;
                            font-size:14px;
                        }
                        .btn-back:hover {
                            color:#2e2e2e;
                        }
                    </style>


</div>
    <div class="table-responsive mt-3 ">
        
        <table id="table" class="table mt-2">
            <thead class="table-dark bg-dark ">
                <tr class="">
                    <th class="sorting sorting_asc">id</th>
                    <th> ภาพหมวดหมู่</th>
                    <th> ชื่อหมวดหมู่</th>
                    <th> คำอธิบาย</th>
                    <th> แก้ไข</th>
                    <th> ลบ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $get_user = dd_q("SELECT * FROM service_cate ORDER BY s_id DESC");
                while ($row = $get_user->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td class="ttcolor"><?php echo $row['s_id']; ?></td>
                        <td class="ttcolor"><img src="<?php echo htmlspecialchars($row['img']); ?>" width="100px" alt=""></td>
                        <td class="ttcolor"><?php echo htmlspecialchars($row['name']); ?></td>
                        <td class="ttcolor"><?php echo htmlspecialchars($row['des']); ?></td>
                        <td><button class="btn btn-outline-warning w-100" style="width : 130px!important" onclick="get_detail(<?php echo $row['s_id']; ?>)"><i class="fa-solid fa-pencil"></i>&nbsp;แก้ไข</button></td>
                        <td><button class="btn btn-outline-danger w-100" style="width : 130px!important" onclick="del('<?php echo $row['s_id']; ?>','<?php echo htmlspecialchars($row['username']); ?>')"><i class="fa-solid fa-trash"></i> ลบ</button></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<style>
    .ttcolor {
        color:#dedede;
        font-size:14px;
    }
</style>

<div class="modal fade" id="category_insert" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="exampleModalLabel"><i class="fa-duotone fa-pencil"></i>&nbsp;&nbsp;เพิ่มหมวดหมู่เติมเกมส์ใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-10 m-cent ">
                    <div class="mb-2">
                        <div class="mb-2">
                            <p class=" mb-1 text-dark">ชื่อหมวดหมู่ <span class="text-danger">*</span></p>
                            <input type="text" id="p_name" class="form-control" value="">
                        </div>
                        <div class="mb-2">
                            <p class=" mb-1 text-dark">รายละเอียด <span class="text-danger">*</span></p>
                            <textarea id="p_des" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                        </div>
                        <div class="mb-2">
                            <p class=" mb-1 text-dark">ลิงค์รูปภาพ <span class="text-danger">*</span></p>
                            <input type="text" id="p_img" class="form-control" value="">
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิดหน้านี้</button>
                <button type="button" class="btn btn-primary ps-4 pe-4" id="insert_btn" data-id="">เพิ่มหมวดหมู่</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="category_detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="exampleModalLabel"><i class="fa-duotone fa-pencil"></i>&nbsp;&nbsp;แก้ไขหมวดหมู่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-10 m-cent ">
                    <div class="mb-2">
                        <div class="mb-2">
                            <p class=" mb-1">ชื่อหมวดหมู่ <span class="text-danger">*</span></p>
                            <input type="text" id="name" class="form-control" value="username">
                        </div>
                        <div class="mb-2">
                            <p class=" mb-1">รายละเอียด <span class="text-danger">*</span></p>
                            <textarea id="des" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                        </div>
                        <div class="mb-2">
                            <p class=" mb-1">ลิงค์รูปภาพ <span class="text-danger">*</span></p>
                            <input type="text" id="img" class="form-control" value="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" id="save_btn" data-id="">บันทึก</button>
            </div>
        </div>
    </div>
</div>
<script>
    $("#open_insert").click(function() {
        const myModal = new bootstrap.Modal('#category_insert', {
            keyboard: false
        })
        myModal.show();
    });
    $("#save_btn").click(function() {
        var formData = new FormData();
        formData.append('c_id', $("#save_btn").attr("data-id"));
        formData.append('c_name', $("#name").val());
        formData.append('des', $("#des").val());
        formData.append('img', $("#img").val());
        $.ajax({
            type: 'POST',
            url: 'system/backend/service_cate_update.php',
            data: formData,
            contentType: false,
            processData: false,
        }).done(function(res) {
            result = res;
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ',
                text: result.message
            }).then(function() {
                window.location = "?page=<?php echo $_GET['page']; ?>";
            });
        }).fail(function(jqXHR) {
            console.log(jqXHR);
            res = jqXHR.responseJSON;
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: res.message
            })
            //console.clear();
        });
        // $("#save_btn").attr("data-id") <- id user
    });
    $("#insert_btn").click(function() {
        var formData = new FormData();
        formData.append('img', $("#p_img").val());
        formData.append('c_name', $("#p_name").val());
        formData.append('des', $("#p_des").val());
        $.ajax({
            type: 'POST',
            url: 'system/backend/service_cate_insert.php',
            data: formData,
            contentType: false,
            processData: false,
        }).done(function(res) {
            result = res;
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ',
                text: result.message
            }).then(function() {
                window.location = "?page=<?php echo $_GET['page']; ?>";
            });
        }).fail(function(jqXHR) {
            console.log(jqXHR);
            res = jqXHR.responseJSON;
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: res.message
            })
            //console.clear();
        });
        // $("#save_btn").attr("data-id") <- id user
    });

    function get_detail(id) {
        var formData = new FormData();
        formData.append('s_id', id);

        $.ajax({
            type: 'POST',
            url: 'system/backend/call/service_cate_detail.php',
            data: formData,
            contentType: false,
            processData: false,
        }).done(function(res) {
            console.log(res);
            $("#name").val(res.c_name);
            $("#des").val(res.des);
            $("#img").val(res.img);
            $("#save_btn").attr("data-id", id);
            const myModal = new bootstrap.Modal('#category_detail', {
                keyboard: false
            })
            myModal.show();
        }).fail(function(jqXHR) {
            console.log(jqXHR);
            res = jqXHR.responseJSON;
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: res.message
            })
            //console.clear();
        });

    }

    function del(id, username) {
        Swal.fire({
            title: 'ยืนยันที่จะลบ?',
            text: "คุณแน่ใจหรอที่จะลบผู้ใช้  " + username,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ลบเลย'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('c_id', id);
                $.ajax({
                    type: 'POST',
                    url: 'system/backend/service_cate_del.php',
                    data: formData,
                    contentType: false,
                    processData: false,
                }).done(function(res) {
                    result = res;
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ',
                        text: result.message
                    }).then(function() {
                        window.location = "?page=<?php echo $_GET['page']; ?>";
                    });
                }).fail(function(jqXHR) {
                    console.log(jqXHR);
                    res = jqXHR.responseJSON;
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: res.message
                    })
                    //console.clear();
                });
            }
        })


    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#table').DataTable();
    });
    $("#btn_regis").click(function(e) {
        e.preventDefault();
        var formData = new FormData();
        formData.append('name', $("#site_name").val());
        // formData.append('bg', $("#site_bg").val());
        formData.append('phone', $("#site_phone").val());
        formData.append('main_color', $("#site_main_color").val());
        formData.append('logo', $("#site_logo").val());
        formData.append('sec_color', $("#site_sec_color").val());
        formData.append('font_color', $("#site_font_color").val());
        formData.append('widget_discord'  , $("#site_widget_discord").val() );
        formData.append('discord'  , $("#site_contact_discord").val() );
        formData.append('facebook'  , $("#site_contact_facebook").val() );
        formData.append('des', $("#site_des").val());
        $('#btn_regis').attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: 'system/backend/website.php',
            data: formData,
            contentType: false,
            processData: false,
        }).done(function(res) {
            result = res;
            console.log(result);
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ',
                text: result.message
            }).then(function() {
                window.location = "?page=<?php echo $_GET['page']; ?>";
            });
        }).fail(function(jqXHR) {
            console.log(jqXHR);
            res = jqXHR.responseJSON;
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: res.message
            })
            //console.clear();
            $('#btn_regis').removeAttr('disabled');
        });
    });
</script>