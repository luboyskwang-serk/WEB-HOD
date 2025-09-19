<div class="container-fluid bb p-0 col-lg-8 col-10" style="background-color:#0f0f0f" >
    <div class="container-sm m-auto p-2 pt-0 aos-init aos-animate" data-aos="zoom-in">


        <div class="container-fluid ps-3 pe-3 pb-3" style="border-radius:1vh;">
        
        <div class="p-2">
            <h5 class="m-0"><h5 class=" mb-2 mt-2" style="color:#e3e3e3;">
            <i class="fa-duotone fa-clock-rotate-left fa-spin fa-spin-reverse" style="--fa-primary-color: #e3e3e3; font-size:14px; --fa-secondary-color: #15ed10;"></i>
             ประวัติการเติมเกมส์</h5>
             <p style="font-size:14px; color:#eaac13;"><?php echo $config['name']; ?></span></p>
             <h3 class=" m-0 text-white"><i class='bx bx-store' ></i>&nbsp;ORDER ทำรายการไม่สำเร็จ</h3>
             
             <button class="btn btn-back mt-2 mb-2 text-white" onclick="del()">ย้ายไปถังขยะทั้งหมด</button>
             <button class="btn btn-back mt-2 mb-2 text-white"onclick="window.history.back()"><i class="fa-duotone fa-house"></i></button>
             
             
             <a href="?page=order_temp" style="text-decoration:none;">
                            <button class="btn nav-link btn-back align-self-center bg-black">
                                <i class="fa-duotone fa-trash"></i> ไปที่ถังขยะ
                            </button>
            </a>


            <style>
                 .btn-back {
                    background-color:#141416;
                    color:#507b50;
                    border-radius:0.5vh;
                    font-size:14px;
                }
                .btn-back:hover {
                    background-color:#d63636;
                    color:#2e2e2e;
                }
            </style>
    
            </div>


    <div class="table-responsive mt-3 ">
    
        <table id="table" class="table mt-2">
            <div class="mb-2">


        </div>
            <thead class="table-dark bg-dark ">
                <tr class="">
                    <th class="sorting sorting_asc">id</th>
                    <th> </th>
                    <th> ชื่อสินค้า</th>
                    <th> ผู้สั่งซื้อ</th>
                    <th> สถานะ</th>
                    <th> UID</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $get_user = dd_q("SELECT * FROM service_order WHERE status = ? AND del = 'no' ORDER BY id DESC", ["not"]);

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
                        <td class="tx-color"><img src="<?php echo htmlspecialchars(getimg($row['prod'])); ?>" width="100px" alt=""></td>
                        <td class="tx-color"><?php echo htmlspecialchars($row['prod']); ?></td>
                        <td class="tx-color"><?php echo htmlspecialchars(getuser($row['cosid'])); ?></td>
                        <td class="tx-color"><?php echo htmlspecialchars(st($row['status'])); ?></td>
                        <td class="tx-color"><?php echo htmlspecialchars($row['user']); ?></td>

                        <!-- สถานะการทำรายการเติมเกมส์ -->
                        <td>
                            <button class="btn success w-100" style="width : 130px!important" onclick="suc('<?php echo $row['id']; ?>')">
                                <i class="fa-duotone fa-shield-check fa-fade" style="--fa-primary-color: #16a92d; --fa-secondary-color: #16a92d;"></i>
                                    &nbsp;สำเร็จ
                            </button>
                        </td>
                        <td>
                            <button class="btn warning  w-100" style="width : 130px!important" onclick="back('<?php echo $row['id']; ?>')">
                            <i class="fa-duotone fa-circle-chevron-left fa-fade" style="--fa-primary-color: #eebd2b; --fa-secondary-color: #eebd2b;"></i>
                                    &nbsp;เปลี่ยนกลับ
                             </button>
                        </td>


                    <style>
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
                        .warning {
                            background-color:#474125;
                            color:#e7e7e7;
                            font-size:14px;
                        }
                        .tx-color {
                            color:#b4b4b4;
                            font-weight:300;
                            font-size:14px;
                        }
                    </style>



                    
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
 </div></div>




 <script>
    $(document).ready(function () {
        $('#table').DataTable();
    });
</script>



<script>
    
    function del() {
        Swal.fire({
            title: 'ยืนยันที่จะย้ายทั้งหมดไปถังขยะ',
            text: "คุณแน่ใจหรอที่จะย้าย Order ทั้งหมดไปถังขยะ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('st', "not");
                $.ajax({
                    type: 'POST',
                    url: 'system/backend/order_temp.php',
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

    function back(id) {
        Swal.fire({
            title: 'ยืนยันที่จะตั้งสถานะเป็นกำลังดำเนินการ',
            text: "คุณแน่ใจหรอที่จะตั้งสถานะ Order นี้เป็นกำลังดำเนินการ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('id', id);
                formData.append('st', "no");
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