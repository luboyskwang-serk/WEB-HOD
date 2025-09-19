<div class="container-fluid bb mt-2 pt-2 col-lg-10 col-10" style="background-color:#0f0f0f" >
    <div class="container-sm m-auto p-2 pt-0 aos-init aos-animate" data-aos="zoom-in">


        <div class="container-fluid ps-3 pe-3 pb-3" style="border-radius:1vh;">
        
        <div class="p-2">
            <h5 class="m-0"><h5 class=" mb-2 mt-2" style="color:#e3e3e3;">
            <i class="fa-regular fa-box-open-full fa-fade"></i>
             ออเดอร์ทั้งหมด</h5>
             <p style="font-size:14px; color:#eaac13;">: <span><?php echo $config['name']; ?></span></p>

             <button class="btn nav-link btn-back align-self-center bg-black"
                onclick="window.history.back()" style="height: fit-content;"><b><i class="fa-regular fa-arrow-left fa-fade"></i>
                ย้อนกลับ</b>
                
            </button>

           </div>

           <div class="container-fluid">
            <div class="row">
                <p>แก้ไขออเดอร์</p>
                <div class="col-lg-1 col-3">
                    <a href="?page=order_success">
                        <button class="btn nav-link btn-back  bg-black">
                            <i class="fa-duotone fa-circle-check" style="--fa-primary-color: #40ea15; --fa-secondary-color: #40ea15;"></i>
                        </button>
                    </a>
                </div>
                <div class="col-lg-1 col-3">
                    <a href="?page=order_unsuccess">
                        <button class="btn nav-link btn-back align-self-center bg-black">
                            <i class="fa-duotone fa-circle-xmark" style="--fa-primary-color: #f80c12; --fa-secondary-color: #f80c12;"></i>
                        </button>
                    </a>
                </div>
                <div class="col-lg-1 col-3">
                    <a href="?page=order_temp">
                        <button class="btn nav-link btn-back align-self-center bg-black">
                            <i class="fa-duotone fa-trash"></i>
                        </button>
                    </a>
                </div>
                </div>
            </div>

         
            <style>
                .btn-back {
                    color:#507b50;
                    border-radius:1vh;
                    font-size:14px;
                }
                .btn-back:hover {
                    color:#2e2e2e;
                }
                .tx-color {
                    color:#b4b4b4;
                    font-weight:300;
                    font-size:14px;
                }
                .success {
                    background-color:#2a3128;
                    color:#e7e7e7;
                    font-size:14px;
                }

                .danger {
                    background-color:#312828;
                    color:#e7e7e7;
                    font-size:14px;
                }
            </style>

        </div>    
 
    <div class="table-responsive mt-3 mb-2">
    
        <table id="table" class="table mt-2">
            <thead class="table-dark bg-dark ">
                <tr class="">
                    <th class="sorting sorting_asc">id</th>
                    <th> รายการ</th>
                    <th> ผู้สั่งซื้อ</th>
                    <th> สถานะ</th>
                    <th> UID</th>
                    <!-- <th> Password</th> -->
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $get_user = dd_q("SELECT * FROM service_order WHERE status = ? AND del = 'no' ORDER BY id DESC", ["no"]);

                function st($text)
                {
                    if ($text == "no") {
                        return "กำลังดำเนินการ";
                    } elseif ($text == "yes") {
                        return "สำเร็จ";
                    } elseif ($text == "not") {
                        return "ไม่สำเร็จ";
                    }
                }
                function getimg($text)
                {

                    $i = dd_q("SELECT * FROM service_prod WHERE name = ?",  [$text]);
                    $is = $i->fetch(PDO::FETCH_ASSOC);
                    return $is["img"];
                    
                    
                }
                function getuser($text)
                {

                    $i = dd_q("SELECT * FROM users WHERE id = ?",  [$text]);
                    $is = $i->fetch(PDO::FETCH_ASSOC);
                    return $is["username"];
                    
                    
                }
                
                while ($row = $get_user->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td class="tx-color"><?php echo $row['id']; ?></td>
                        <!-- <td class="tx-color"><img src="<?php echo htmlspecialchars(getimg($row['prod'])); ?>" width="100px" alt=""></td> -->
                        <td class="tx-color"><?php echo htmlspecialchars($row['prod']); ?></td>
                        <td class="tx-color"><?php echo htmlspecialchars(getuser($row['cosid'])); ?></td>
                        <td class="tx-color"><?php echo htmlspecialchars(st($row['status'])); ?></td>
                        <td class="tx-color"><?php echo htmlspecialchars($row['user']); ?></td>
                        <!-- <td class=""><?php echo htmlspecialchars($row['pass']); ?></td> -->
                      
                      <!-- สถานะการทำรายการเติมเกมส์ -->
                        <td>
                            <button class="btn success w-100" style="width : 130px!important" onclick="suc('<?php echo $row['id']; ?>')">
                                <i class="fa-duotone fa-shield-check fa-fade" style="--fa-primary-color: #16a92d; --fa-secondary-color: #16a92d;"></i>
                                    &nbsp;สำเร็จ
                            </button>
                        </td>
                        <td>
                            <button class="btn danger  w-100" style="width : 160px!important" onclick="unsuc('<?php echo $row['id']; ?>')">
                            <i class="fa-duotone fa-circle-exclamation fa-shake" style="--fa-primary-color: #df090e; --fa-secondary-color: #df090e;"></i>
                                    &nbsp;เกิดข้อผิดพลาด
                             </button>
                        </td>



                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>




<script>
    

    

    function suc(id) {
        Swal.fire({
            title: 'ยืนยันที่จะตั้งสถานะเป็นสำเร็จ',
            text: "คุณแน่ใจหรอที่จะตั้งสถานะ Order นี้เป็นสำเร็จ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('id', id);
                formData.append('st', "yes");
                $.ajax({
                    type: 'POST',
                    url: 'system/backend/order_update.php',
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

    function unsuc(id) {
        Swal.fire({
            title: 'ยืนยันที่จะตั้งสถานะเป็นไม่สำเร็จ',
            text: "คุณแน่ใจหรอที่จะตั้งสถานะ Order นี้เป็นไม่สำเร็จ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('id', id);
                formData.append('st', "not");
                $.ajax({
                    type: 'POST',
                    url: 'system/backend/order_update.php',
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
            url: 'services/backend/website.php',
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