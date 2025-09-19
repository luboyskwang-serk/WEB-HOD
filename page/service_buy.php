<?php
if ($_GET['id'] != '') {
    $pdshop = dd_q("SELECT * FROM service_prod WHERE id = ? LIMIT 1", [$_GET['id']]);
    if ($pdshop->rowCount() != 0) {
        $row_1 = $pdshop->fetch(PDO::FETCH_ASSOC);
        
?>



<style>
    .form-control {
        border: none;
        border-bottom: 3px solid var(--main);
        border-radius: 10px;
    }
</style>
        <div class="container mt-3 mb-3">
            <div class="container-sm">
                <div class="bg-black shadow p-3" style="border-radius: 1vh; overflow: hidden; height: fit-content;  ">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb d-flex justify-content-center mt-3">


                            <center class="mt-4 mb-4">
                            <span class="h4 ttcolor"><b>บริการ</b></span>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb d-flex justify-content-center mt-0">
                                    <li class="breadcrumb-item"><a href="#!" style="text-decoration: none; color: #6C757D; font-size:13px;"> <?= htmlspecialchars($row_1['name']) ?> </a></li>

                                </ol>
                            </nav>


                        </center>
                        </ol>
                    </nav>
                    <div class="row">
                        <div class="col-12 col-lg-6 p-3">
                            <div class="d-flex justify-content-center">
                                <img src="<?= htmlspecialchars($row_1['img']) ?>" style="width: 85%;" class="rounded">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 p-3">
                            <div class=" shadow p-3" style="border-radius: 1vh; overflow: hidden; height: fit-content;  ">
                            <center>
                                <h3 class="text-main">รายการ : <span class="text-white"><?= htmlspecialchars($row_1['name']) ?></span></h3>
                            </center>
                                <div class="row mt-2">
                                    <div class="col">
                                    </div>

                                    <div class=" mt-1 text-white">รายละเอียด</div>
                                    <div class="col">
                                    </div>
                                    <p class="blockquote-footer" style="word-wrap: break-word; white-space:pre-wrap; color:#afafaf;"><?= htmlspecialchars($row_1['des']) ?></p>
                                      <h5 class="h5">ราคา : <?= $row_1['price'] ?></h5> 
                                      <p class="dedazen"><i class="fa-duotone fa-shield-cat fa-beat-fade" style="--fa-primary-color: #51bf26; --fa-secondary-color: #51bf26;"></i>
                                        รวดเร็ว ปลอดภัย ได้รับของชัวร์ <br>จากเรา <?php echo $config['name']; ?> ยินดีให้บริการครับ</p>
                                  

                                    <div class="col">
                                        <hr>
                                    </div>
                                    <div class="col-auto text-white">กรอกข้อมูลของคุณ</div>
                                    <div class="col">
                                        <hr>
                                    </div>

                                    <div class="d-grid mt-1">
                                        <div class="mb-2 "> 

                                            <center class="mb-2">
                                                <button class="btn dsfont-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">ขั้นตอนและวิธีในการเติม <i class="fa-duotone fa-circle-exclamation" ></i> </button>
                                            </center>

                                            <!-- ช่องกรอก UID -->
                                            <input type="text" id="user" class="form-control mt-1 from-ds" placeholder="กรอก UID ตัวอย่าง 1112244***" aria-describedby="basic-addon1" style="border-radius: 0.5vh;">
                                           
                                           
                                           <!--  <p class="dsfont m-0  mt-2">ชื่อในเกม <span class="text-danger">*</span></p>
                                            <input type="text" id="pass" class="form-control mt-1 from-ds" placeholder="กรอกชื่อในเกมของท่าน เช่น DEDAZEN***e" aria-describedby="basic-addon1" style="border-radius: 0.5vh;">
                                        -->
                                       
                                        </div>
                                    </div>
                                   
                                </div>
                                <button class="btn dsfont w-100 text-white mt-3 mb-2" id="shop-btn" onclick="buyservice()" data-id="<?= $row_1['id'] ?>" data-name="<?= $row_1['name'] ?>" data-price="<?= $row_1['price'] ?>" style="background-color: var(--main);">สั่งทำรายการ  ( <?= $row_1['price'] ?> .- )</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


                                                    <div class="offcanvas offcanvas-start bgbb" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
                                                    
                                                    <div class="offcanvas-header bg-main bg-header m-4">
                                                        <h5 class="offcanvas-title " style="color:#f0f0f0" id="offcanvasWithBothOptionsLabel">ขั้นตอนและวิธีในการเติม <i class="fa-solid fa-exclamation"></i></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                    </div>

                                                    <div class="offcanvas-body bg-black ">
                                                        <p class="tx-white"><i class="fa-duotone fa-location-arrow fa-fade" style="--fa-primary-color: #1ec126; --fa-secondary-color: #1ec126;"></i> เลือกสินค้า/บริการของเรา ที่ท่านต้องการ </p>

                                                        <p class="tx-white"><i class="fa-duotone fa-location-arrow fa-fade" style="--fa-primary-color: #1ec126; --fa-secondary-color: #1ec126;"></i> กดปุ่มสั่งซื้อตอนนี้เลย 
                                                        <img width="100%"src="https://cdn.discordapp.com/attachments/1170981715506892801/1209800008468013086/2024-02-21_164142.png?ex=65e83d0f&is=65d5c80f&hm=4ab4cfbfae3145469da16ad4b33415b9fb670a8938393ad6cc6fec6bea5fcc62&" </p>
                                                        
                                                        <p class="tx-white"><i class="fa-duotone fa-location-arrow fa-fade" style="--fa-primary-color: #1ec126; --fa-secondary-color: #1ec126;"></i> เช็คสินค้าของท่านให้ตรง <span class="text-danger">* หากผิดพลาด ทางเราจะไม่รับผิดชอบทุกกรณี</span> </p>
                                                        
                                                        <p class="tx-white"><i class="fa-duotone fa-location-arrow fa-fade" style="--fa-primary-color: #1ec126; --fa-secondary-color: #1ec126;"></i> กรอกรายละเอียดของท่านให้เรียบร้อย  
                                                        <img width="100%" src="https://cdn.discordapp.com/attachments/1170981715506892801/1209800084032847872/2024-02-21_164151.png?ex=65e83d21&is=65d5c821&hm=67aae82aa13c5c053d4b8f7320324ab669f359dafcb6250a629a8c3720548a5a&"</p>
                                                        
                                                        <p class="tx-white"><i class="fa-duotone fa-location-arrow fa-fade" style="--fa-primary-color: #1ec126; --fa-secondary-color: #1ec126;"></i> กดสั่งทำรายการ 
                                                        <img width="100%" src="https://cdn.discordapp.com/attachments/1170981715506892801/1209800084271800330/2024-02-21_164156.png?ex=65e83d21&is=65d5c821&hm=896e0880478c3cf591a7b1747d1cbdc1f5299195eae9bb44659d10910cb9bcf5&"</p>
                                                        
                                                        <p class="tx-white"><i class="fa-duotone fa-location-arrow fa-fade" style="--fa-primary-color: #1ec126; --fa-secondary-color: #1ec126;"></i> สั่งซื้อเรียบร้อยรอแอดมินทำรายการ 10-30 นาที ตามคิวรายการนั้นๆ</p>
                                                        
                                                        <p class="tx-white">เพียงเท่านี้ ก็สามารสั่งซื้อบริการต่างๆ กับเราได้แล้ว</p>

                                                        <center>
                                                        <img width="100%" src="https://cdn.discordapp.com/attachments/1170981715506892801/1209759124405878824/logodedazen12.png?ex=65e816fb&is=65d5a1fb&hm=54bf696eacc2d837a6017dbe55952d05dc98c53593cb215ee229d8267adf4b5d&">
                                                        <p>DedaZen ยินดีให้บริการครับ "-" </p>
                                                        </center>
                                                    </div>
                                                    </div>  

            <style>
            .tx-white {
                color:#bcbcbc;
                font-size:13px;
            }
            .bg-header {
                border-radius:1vh;
            }
            .dedazen{
                font-size:13px;
                color:#393939;
            }
            .dsfont{
                font-size:13px;
                color:#767676;
            } 
            .dsfont-1 {
                background-color:#416a5c;
                font-size:12px;
                border:none;
                color:#eaeaea;
            }  
            .from-ds {
                color:#e5e5e5;
                font-size:12px;
                background-color:#171717
            }
            .h5 {
                font-size:16px;
                color:#ffaa00;
            }
            .bgbb {
                background-color:#1e1e1e00;
            }
            </style>



            <script>
                $("#shop-btn").click(function(e) {
                    e.preventDefault();
                    var formData = new FormData();
                    formData.append('user', $("#user").val());
                    formData.append('pass', $("#pass").val());
                    formData.append('id', $("#shop-btn").attr("data-id"));

                    Swal.fire({
                        title: 'ยืนยันการสั่งซื้อ?',
                        text: "โปรดตรวจสอบข้อมูลว่าถูกต้อง",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ยืนยัน'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#shop-btn').attr('disabled', 'disabled');
                            $.ajax({
                                type: 'POST',
                                url: 'system/buyservice.php',
                                data: formData,
                                contentType: false,
                                processData: false,
                            }).done(function(res) {

                                result = res;
                                console.log(result);
                                // grecaptcha.reset();
                                if (res.status == "success") {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'สำเร็จ',
                                        text: result.message
                                    }).then(function() {
                                        window.location = "?page=profile&subpage=buyhisid";
                                    });
                                }
                                if (res.status == "fail") {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'ผิดพลาด',
                                        text: result.message
                                    });
                                    $('#shop-btn').removeAttr('disabled');
                                }
                            }).fail(function(jqXHR) {
                                console.log(jqXHR);
                                //   res = jqXHR.responseJSON;
                                // grecaptcha.reset();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เกิดข้อผิดพลาด',
                                    text: res.message
                                })
                                //console.clear();
                                $('#shop-btn').removeAttr('disabled');
                            });
                        }
                    })

                    // captcha = grecaptcha.getResponse();
                    // formData.append('captcha', captcha);
                    
                });
                function buyservice() {
                    var name = $("#shop-btn").attr("data-name");
                    var price = $("#shop-btn").attr("data-price");
                    var count = $("#b_count").val();
                    var formData = new FormData();
                    formData.append('id', $("#shop-btn").attr("data-id"));
                    formData.append('count', count);
                    
                }
            </script>
        </div>
<?php
    } else {
        echo "<script>window.location.href = '?page=shop';</script>";
    }
} else {
    echo "<script>window.location.href = '?page=shop';</script>";
}
?>