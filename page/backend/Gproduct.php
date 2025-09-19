<style>
    .tblu-1 {
        font-size: 16px;
        border: none;
        padding: 0.5rem;
        border-radius: 1vh;
        color: #f4f4f4;
        background: linear-gradient(to right, #d51f1f 0%, #ff9f00 100%);

    }

    .tblu-2 {
        border: none;
        padding: 0.5rem;
        border-radius: 1vh;
        color: #262626;
        background: linear-gradient(to right, #b5b5b5 0%, #fcfcfc 100%);

    }

    .ff {
        text-transform: uppercase;
        background: linear-gradient(to right, #d51f1f 0%, #ff9f00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-decoration: none
    }
</style>

<div class="container-sm mt-2 col-lg-10 col-10 shadow-sm p-4 mb-4" style="background-color:#0e0e0e; border-radius:1vh;">

    <div class="p-2">
        <h5 class="m-0">
            <h5 class=" mb-2 mt-0" style="color:#c6c6c6;">
                <i class="fa-duotone fa-bag-shopping" style="--fa-primary-color: #09a811; font-size:14px; --fa-secondary-color: #15ed10;"></i>
                จัดการสินค้า
                <span>
                    <button class="tblu-1 ms-2 me-2 mt-3 mb-0 col-5 col-lg-3" id="open_insert"> เพิ่มสินค้าใหม่</button>
                </span>
            </h5>
            <p style="font-size:14px; color:#eaac13;">แอดมิน : <span><?php echo htmlspecialchars(strtoupper($user['username'])); ?></span></p>
    </div>




    <div class="table-responsive mt-3 ">
        <table id="table" class="table mt-2">
            <thead class="table-dark bg-dark ">
                <tr class="">
                    <th class="sorting sorting_asc">id</th>
                    <th scope="col" class="ps-3 text-center" style="color:#eaac13;"> ภาพสินค้า</th>
                    <th scope="col" class="ps-3 text-center" style="color:#eaac13;"> ชื่อสินค้า</th>
                    <th scope="col" class="ps-3 text-center" style="color:#eaac13;"> ราคา</th>
                    <th scope="col" class="ps-3 text-center" style="color:#eaac13;"> ชนิดการสุ่ม</th>
                    <th scope="col" class="ps-3 text-center" style="color:#eaac13;"> หมวดหมู่</th>
                    <th scope="col" class="ps-3 text-center" style="color:#eaac13;"> จัดการรางวัล</th>
                    <th scope="col" class="ps-3 text-center" style="color:#eaac13;"> แก้ไข</th>
                    <th scope="col" class="ps-3 text-center" style="color:#eaac13;"> ลบ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $get_user = dd_q("SELECT * FROM game ORDER BY id DESC");
                while ($row = $get_user->fetch(PDO::FETCH_ASSOC)) {
                    $cg = dd_q("SELECT * FROM game_category WHERE id = ?", [$row['cid']])->fetch(PDO::FETCH_ASSOC);
                ?>
                    <tr>
                        <td class="text-center" style="font-size:13px; color:#e8e8e8"><?php echo $row['id']; ?></td>
                        <td class="text-center"><img style="border-radius:1vh;" src="<?php echo htmlspecialchars($row['img']); ?>" width="100px" alt=""></td>
                        <td class="text-center" style="font-size:13px; color:#e8e8e8"><?php echo htmlspecialchars($row['name']); ?></td>
                        <td class="text-center" style="font-size:13px; color:#e8e8e8"><?php echo number_format($row['price']); ?></td>
                        <td class="text-center" style="font-size:13px; color:#e8e8e8"><?php
                                                                                        if ($row['r_type'] == "wheel") {
                                                                                            echo "วงล้อ";
                                                                                        }
                                                                                        ?></td>
                        <td class="text-center" style="font-size:13px; color:#e8e8e8"><?php echo htmlspecialchars($cg['name']); ?></td>
                        <td class="text-center"><a class="btn btn-warning text-dark w-100 col-4" style="width : 130px!important" href="?page=productrw_game&id=<?php echo $row["id"]; ?>"><i class="fa-solid fa-box"></i>&nbsp;รางวัล</a></td>
                        <td class="text-center"><button class="tblu-2 text-dark w-100" style="width : 130px!important" onclick="get_detail(<?php echo $row['id']; ?>)"><i class="fa-solid fa-pencil"></i>&nbsp;แก้ไข</button></td>
                        <td class="text-center"><button class="btn btn-danger text-white w-100" style="width : 130px!important" onclick="del('<?php echo $row['id']; ?>','<?php echo htmlspecialchars($row['name']); ?>')"><i class="fa-solid fa-trash"></i> ลบ</button></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="product_detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa-duotone fa-pencil"></i>&nbsp;&nbsp;แก้ไขสินค้า</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-10 m-cent ">
                    <div class="mb-2">
                        <div class="mb-2">
                            <p class="text-secondary mb-1">ชื่อสินค้า <span class="text-danger">*</span></p>
                            <input type="text" id="name" class="form-control" value="username">
                        </div>
                        <div class="mb-2">
                            <p class="text-secondary mb-1">ลิงค์รูปภาพหลัก <span class="text-danger">*</span></p>
                            <input type="text" id="img" class="form-control" value="">
                        </div>
                        <div class="mb-2">
                            <p class="text-secondary mb-1">ราคาสินค้า <span class="text-danger">*</span></p>
                            <input type="text" id="price" class="form-control" value="0">
                        </div>
                        <div class="mb-2">
                            <p class="m-0">โค้ดสีพื้นหลัง</p>
                            <input type="color" class="form-control mb-2 w-100 form-control-color" style="height: fit-content;" id="picker_bg" value="#000000" title="Choose your color">
                            <input type="text" class="form-control" id="bg" value="#000000">
                            <script>
                                $("#picker_bg").on("input", () => {
                                    $("#bg").val($("#picker_bg").val());
                                });
                                $("#bg").keyup(() => {
                                    $("#picker_bg").val($("#bg").val());
                                });
                            </script>
                        </div>
                        <div class="mb-2">
                            <p class="text-secondary mb-1">หมวดหมู่สินค้า <span class="text-danger">*</span></p>
                            <select class="form-select" id="type_category">
                                <option value="0" selected>เลือกหมวดหมู่</option>
                                <?php
                                $addgr = dd_q("SELECT * FROM game_category ORDER BY id DESC");
                                while ($row = $addgr->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <option id="c_type_selected" value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" id="save_btn" data-id="">เซฟ</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="product_insert" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa-duotone fa-pencil"></i>&nbsp;&nbsp;เพิ่มสินค้า</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-10 m-cent ">
                    <div class="mb-2">
                        <div class="mb-2">
                            <p class="text-secondary mb-1">ชื่อสินค้า <span class="text-danger">*</span></p>
                            <input type="text" id="p_name" class="form-control" value="">
                        </div>
                        <div class="mb-2">
                            <p class="text-secondary mb-1">ลิงค์รูปภาพ <span class="text-danger">*</span></p>
                            <input type="text" id="p_img" class="form-control" value="">
                        </div>
                        <div class="mb-2">
                            <p class="text-secondary mb-1">ราคาสินค้า <span class="text-danger">*</span></p>
                            <input type="text" id="p_price" class="form-control" value="0">
                        </div>
                        <div class="mb-2">
                            <p class="m-0">โค้ดสีพื้นหลัง</p>
                            <input type="color" class="form-control mb-2 w-100 form-control-color" style="height: fit-content;" id="p_picker_bg" value="#000000" title="Choose your color">
                            <input type="text" class="form-control" id="p_bg" value="#000000">
                            <script>
                                $("#p_picker_bg").on("input", () => {
                                    $("#p_bg").val($("#p_picker_bg").val());
                                });
                                $("#p_bg").keyup(() => {
                                    $("#p_picker_bg").val($("#p_bg").val());
                                });
                            </script>
                        </div>
                        <div class="mb-2">
                            <p class="text-secondary mb-1">หมวดหมู่สินค้า<span class="text-danger">*</span></p>
                            <select class="form-select" id="p_type_category">
                                <option value="0" selected>เลือกหมวดหมู่</option>
                                <?php
                                $getrow = dd_q("SELECT * FROM game_category ORDER BY id DESC");
                                while ($row = $getrow->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิดหน้านี้</button>
                <button type="button" class="btn btn-primary ps-4 pe-4" id="insert_btn" data-id="">เพิ่มสินค้า</button>
            </div>
        </div>
    </div>
</div>
<script>
    $("#open_insert").click(function() {
        const myModal = new bootstrap.Modal('#product_insert', {
            keyboard: false
        })
        myModal.show();
    });
    $("#save_btn").click(function() {
        var formData = new FormData();
        formData.append('id', $("#save_btn").attr("data-id"));
        formData.append('img', $("#img").val());
        formData.append('name', $("#name").val());
        formData.append('price', $("#price").val());
        formData.append('border', $("#bg").val());
        formData.append('cid', $("#type_category").val());
        $.ajax({
            type: 'POST',
            url: 'system/backend/Gproduct_update.php',
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
        formData.append('name', $("#p_name").val());
        formData.append('price', $("#p_price").val());
        formData.append('border', $("#p_bg").val());
        formData.append('cid', $("#p_type_category").val());
        formData.append('id', <?= number_format($_GET['id']) ?>);
        $.ajax({
            type: 'POST',
            url: 'system/backend/Gproduct_insert.php',
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
        formData.append('id', id);

        $.ajax({
            type: 'POST',
            url: 'system/backend/call/Gproduct_detail.php',
            data: formData,
            contentType: false,
            processData: false,
        }).done(function(res) {
            console.log(res);
            $("#img").val(res.img);
            $("#name").val(res.name);
            $("#price").val(res.price);
            $("#bg").val(res.border);
            $("#picker_bg").val(res.border);
            var select = document.getElementById('type_category');
            var selectedOption = select.options[select.selectedIndex];
            if (selectedOption) {
                selectedOption.removeAttribute('selected');
            }
            $("option[value='" + res.cid + "']").attr('selected', 'selected');
            $("#save_btn").attr("data-id", id);
            const myModal = new bootstrap.Modal('#product_detail', {
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
                formData.append('id', id);
                $.ajax({
                    type: 'POST',
                    url: 'system/backend/Gproduct_del.php',
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
        formData.append('bg', $("#site_bg").val());
        formData.append('phone', $("#site_phone").val());
        formData.append('main_color', $("#site_main_color").val());
        formData.append('logo', $("#site_logo").val());
        formData.append('sec_color', $("#site_sec_color").val());
        formData.append('contact', $("#site_contact").val());
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