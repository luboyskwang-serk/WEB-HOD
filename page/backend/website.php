<?php
$f = dd_q("SELECT * FROM setting");
$dt = $f->fetch(PDO::FETCH_ASSOC);
$keyapip = $dt['apipeamsub'];

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://peamsub24hr.online/api/money',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_HTTPHEADER => array('apikey: ' . $keyapip ),
));

$response = curl_exec($curl);
$peamsub = json_decode($response);
curl_close($curl);
?>
<style>
    .ff {
        text-transform: uppercase;
            background: linear-gradient(to right, #d51f1f 0%, #ff9f00 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration:none
    }
    .bg-from {
        background-color:#030508; 
        border:none;
        padding:0.5rem 1.5rem;
        margin-top:0.5rem;
        border-radius:1vh;
    }
    .font_dedazen {
        font-size:13.5px;
        line-height:2rem;
        color:#9cca99;
        
    }
    .dedazen_boder {
        border: solid 1px #5e8858;
        color:#cecece;
    }
    .headweb {
        color:#efefef;
        margin-top:2rem;
    }

    .box-dd {
        border: solid 1px #30492c;
        border-radius:1vh;
    }
</style>

<




    <!-- ยอดขาย แสดงโชว์หน้าแรก -->
<div class="container-sm mt-0 border-2 shadow-sm p-4 mb-4 rounded">
    <!-- <div class="col-lg-6 m-auto">
        <h5 class="headweb" >เซทค่าผู้ใช้ / ยอดขาย</h5>
    <div class="modal-body box-dd">
                <div class="col-lg-10 m-cent ">
                    <div class="mb-2 ">
                        <p class="m-0 font_dedazen">จำนวนสมาชิก <span class="text-danger">*</span></p>
                        <input type="text" id="s_count" class="dedazen_boder bg-from form-control" value="<?php echo $static['m_count']; ?>">
                    </div>
                    <div class="mb-2 ">
                        <p class="m-0 font_dedazen">จำนวนการสั่งซื้อ <span class="text-danger">*</span></p>
                        <input type="text" id="b_count" class="dedazen_boder bg-from form-control" value="<?php echo $static['b_count']; ?>">
                    </div>
                    <div class="mb-2 ">
                        <center><small class="m-0 text-danger">* หากต้องการล้างค่า ให้กรอกเป็น 0 แล้วบันทึก * </small></center>
                    </div>

                    <button type="button" class="btn btn-primary ps-4 pe-4 tblu-1 w-100" id="insert_btn" data-id="">บันทึกข้อมูล</button>



                

                </div>
            </div> -->
    <!-- ยอดขาย แสดงโชว์หน้าแรก -->

   <!--  
    <center>
        <h3 class="ff mt-3">&nbsp;<i class="fa-duotone fa-list-check fa-fade"></i>&nbsp;จัดการป๊อบอัพโชว์</h3>
    </center>
            <div class="container-sm mt-2 border-2 shadow-sm p-2 mb-0 rounded">
            <div class="row justify-content-between">
                    <div class="mb-2 col">
                        <div class="text-center">
                            <p class="m-0 text-secondary">รูป <span class="text-danger">*</span></p>
                            <input type="text" class="form-control dedazen_boder bg-from form-control-color w-100" id="bganuuou" value="<?php echo $config['bg_ann']; ?>">
                        </div>
                    </div>
                <div class="mb-2 col">
                    <div class="text-center">
                        <p class="m-0 text-secondary">ข้อความ <span class="text-danger">*</span></p>
                        <input type="text" class="form-control dedazen_boder bg-from form-control-color w-100" id="txanuuou" value="<?php echo $config['tx_ann']; ?>">
                    </div>
                </div>
            </div>
    </div> --
    >
</div>



    <!-- ปุ่มลิ้งค์ 4 หมวด -->
<!-- <div class="container-sm mt-0 border-2 shadow-sm p-4 mb-4 rounded">
    <div class="col-lg-6 m-auto">
    <h5 class="headweb" >รูปลิ้งค์ภาพ 4 หมวดหน้าแรก</h5>

    <div class="modal-body box-dd">
    
                <div class="col-lg-10 m-cent ">


                <div class="mb-2 col">
                    <p class="m-0 font_dedazen">ปุ่มเติมเงิน <span class="text-danger">*</span></p>
                    <input type="text" id="c1_dedazen" class="form-control dedazen_boder bg-from" value="<?php echo $config['c1_dedazen']; ?>">
                </div>
                <div class="mb-2 col">
                    <p class="m-0 font_dedazen">ปุ่มเติมเกมส์ออนไลน์ <span class="text-danger">*</span></p>
                    <input type="text" id="c2_dedazen" class="form-control dedazen_boder bg-from" value="<?php echo $config['c2_dedazen']; ?>">
                </div>
                <div class="mb-2 col">
                    <p class="m-0 font_dedazen">ปุ่มสินค้า<span class="text-danger">*</span></p>
                    <input type="text" id="c3_dedazen" class="form-control dedazen_boder bg-from" value="<?php echo $config['c3_dedazen']; ?>">
                </div>
                <div class="mb-2 col">
                    <p class="m-0 font_dedazen">ปุ่มแอพพรีเมียม <span class="text-danger">*</span></p>
                    <input type="text" id="c4_dedazen" class="form-control dedazen_boder bg-from" value="<?php echo $config['c4_dedazen']; ?>">
                </div>
                
                </div>
            </div> -->

     <!-- ปุ่มลิ้งค์ 4 หมวด -->

    


    <h5 class="headweb" >ตั่งค่าเว็บไซต์</h5>


        <div class="mb-2 mt-2 text-center">
            <p class="m-0 font_dedazen">ระบบยอมรับเงื่อนไข <span class="text-danger">* (บังคับหรือไม่บังคับ)</span></p>
               <input class="form-check-input" type="checkbox" role="switch" id="oaccept" <?php echo ($config['oaccept'] == 1) ? 'checked' : ''; ?>>
            <label class="form-check-label text-main" for="oaccept"><?php echo ($config['oaccept'] == 1) ? ' ระบบบังคับยอมรับเงื่อนไข <span class="text-danger">(ใช้อยู่)</span>' :' ระบบยอมรับเงื่อนไขไม่บังคับ <span class="text-danger">(ใช้อยู่)</span>'; ?></label>
           
            
        
        </div>

        
        <div class="mb-2 mt-2 ">
            <p class="m-0 font_dedazen">ชื่อเว็บไซต์ <span class="text-danger">*</span></p>
            <input type="text" id="site_name" class="form-control dedazen_boder bg-from" value="<?php echo $config['name']; ?>">
        </div>

        <div class="row justify-content-between">
            <div class="mb-2 col">
                <p class="m-0 font_dedazen">โลโก้เว็บ <span class="text-danger">*</span></p>
                <input type="text" id="site_logo" class="form-control dedazen_boder bg-from" value="<?php echo $config['logo']; ?>">
            </div>
            <div class="mb-2 col">
                <p class="m-0 font_dedazen">ภาพพื้นหลังเว็บ <span class="text-danger">*</span></p>
                <input type="text" id="site_bg" class="form-control dedazen_boder bg-from" value="<?php echo $config['bg']; ?>">
            </div>
        </div>
        
        <div class="mb-2">
            <p class="m-0 font_dedazen">ประกาศ<span class="text-danger">*</span></p>
            <input type="text" id="ann" class="form-control dedazen_boder bg-from" value="<?php echo $config['ann']; ?>">
        </div>     
        
        <div class="row justify-content-between">
            <div class="mb-5 col">
                <div class="text-center">
                    <p class="m-0 font_dedazen">สีหลักของเว็บไซต์ <span class="text-danger">*</span></p>
                    <input type="color" class="form-control dedazen_boder bg-from form-control-color w-100" id="site_main_color" value="<?php echo $config['main_color']; ?>">
                </div>
            </div>
            <div class="mb-5 col">
                <div class="text-center">
                    <p class="m-0 font_dedazen">สีรองของเว็บไซต์ <span class="text-danger">*</span></p>
                    <input type="color" class="form-control dedazen_boder bg-from form-control-color w-100" id="site_sec_color" value="<?php echo $config['sec_color']; ?>">
                </div>
            </div>
        </div>


        <h5 class="headweb" >จัดการแจ้งเตือนการสั่งซื้อสินค้า</h5>
        <div class="mb-2">
            <p class="m-0  font_dedazen">Webhook Line (Token) <span class="text-danger">*</span></p>
            <input type="text" id="webhook_dc" class="form-control dedazen_boder bg-from" value="<?php echo $config['webhook_dc']; ?>">
        </div>



        <!-- app premium -->
        <div class="row justify-content-between mt-2">
        <h5 class="headweb" >หมวดหมู่แอพพรีเมียม</h5>
            <div class="mb-2 col">
                <p class="m-0 font_dedazen">ภาพหมวดหมู่แอพพรีเมียม <span class="text-danger">*</span></p>
                <input type="text" id="premium_img" class="form-control dedazen_boder bg-from" value="<?php echo $config['premium_img']; ?>">
            </div>
            <div class="mb-2 col">
                <p class="m-0  font_dedazen">ภาพพื้นหลังแอพพรีเมียม <span class="text-danger">*</span></p>
                <input type="text" id="bg_premium" class="form-control dedazen_boder bg-from" value="<?php echo $config['bg_premium']; ?>">
            </div>
        </div>

        <!-- contect -->
        <div class="row justify-content-between mt-2">
            <h5 class="headweb" >ช่องทางการติดต่อ</h5>
            <div class="mb-2">
                <p class="m-0 font_dedazen">Page Facebook <span class="text-danger">*</span></p>
                <input type="text" id="fb" class="form-control dedazen_boder bg-from" value="<?php echo $config['fb']; ?>">
            </div>
            <div class="mb-2 col">
                <p class="m-0  font_dedazen">Discord <span class="text-danger">*</span></p>
                <input type="text" id="discord" class="form-control dedazen_boder bg-from" value="<?php echo $config['discord']; ?>">
            </div>
            <div class="mb-2 col">
                <p class="m-0 font_dedazen">Line <span class="text-danger">*</span></p>
                <input type="text" id="lined" class="form-control dedazen_boder bg-from" value="<?php echo $config['lined']; ?>">
            </div>
            
        </div>


        <h5 class="headweb" >เกี่ยวกับเว็บ</h5>
        <div class="mb-2 ">
            <p class="m-0 font_dedazen">คำอธิบายร้านค้า <span class="text-danger">*</span></p>
            <textarea id="site_des" rows="10" class="form-control dedazen_boder bg-from"><?php echo $config['des']; ?></textarea>
        </div>

        <!-- phone angpao -->

        <div class="row justify-content-between mt-2">
        <h5 class="headweb" >จัดการวอเลท</h5>
            <div class="mb-2 col">
                <p class="m-0  font_dedazen">เบอร์รับเงิน (TrueWallet) <span class="text-danger">*</span></p>
                <input type="text" id="site_phone" class="form-control  dedazen_boder bg-from" value="<?php echo $config['wallet']; ?>">
            </div>
            <div class="mb-2 col">
                <p class="m-0 font_dedazen">วิธีการสร้างซอง (ลิ้งค์รูป) <span class="text-danger">*</span></p>
                <input type="text" id="help" class="form-control dedazen_boder bg-from" value="<?php echo $config['help']; ?>">
            </div>
        </div>


       

        <div class="mb-2 ">

        <input class="form-check-input" type="checkbox" value="1" id="pc" <?php if ($config['fee'] == "on") {
                                                                                    echo "checked";
                                                                                } ?>>
            <label class="feecheck form-check-label mb-2" for="pc">
                ค่าธรรมเนียม เก็บ 2.9% ไม่เกิน 10 บาท
            </label>
 
        </div>
        <!-- phone angpao -->



        <div class="row justify-content-between mt-2">
             <h5 class="headweb" >KEYAPI PeamSub24hr</h5>
            <div class="mb-2 col">  
                    <p class="m-0 font_dedazen">ใส่คีย์ (Peamsub 24hr) 
                        <span class="text-danger">*</span> 
                        <span>
                            <a href="https://peamsub24hr.online/" style="text-decoration:none;">คลิ๊กที่นี่เพื่อรับคีย์</a>
                        </span>
                    </p>
                <input type="text" id="apipeamsub" class="form-control  dedazen_boder bg-from" value="<?php echo $config['apipeamsub']; ?>">
                <h5 class="m-0 text-main mt-1 mb-1"> เงินคงเหลือ API ของท่าน <span style="color:#9cca99;"><?php echo $peamsub->money;?></span></h5>
            </div>
            
        </div>

        <div class="mb-2">
            <button class=" w-100 tblu-1" id="btn_regis" 
            style="background-color:#background: linear-gradient(to right, #d51f1f 0%, #ff9f00 100%);">บันทึกข้อมูล</button>
        </div>

        <!-- END -->
        <style>
            .feecheck {
                color:#dcdcdc;
                font-size:14px;
            }
            .tblu-1 {
                border:none;
                padding:0.5rem;
                border-radius:1vh;
                color:#f4f4f4;
                background: linear-gradient(to right, #d51f1f 0%, #ff9f00 100%);
        }
           
        </style>
    
    </div>
</div>

<script type="text/javascript">





$("#oaccept").change(function() {
    if ($(this).prop('checked')) {
        $("#btn_regis").click();
    }
});
$("#oaccept").change(function() {
    if (!$(this).prop('checked')) {
        $("#btn_regis").click();
    }
});


    $("#insert_btn").click(function() {
        var formData = new FormData();
        formData.append('s_count', $("#s_count").val());
        formData.append('m_count', $("#m_count").val());
        formData.append('b_count', $("#b_count").val());
        $.ajax({
            type: 'POST',
            url: 'system/backend/static_udpate.php',
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
    $("#open_insert").click(function() {
        const myModal = new bootstrap.Modal('#product_insert', {
            keyboard: false
        })
        myModal.show();
    });
    $("#btn_regis").click(function(e) {
        e.preventDefault();
        var check;
        if ($('#pc').is(':checked')) {
            check = "on";
        } else {
            check = "off";
        }

        var checke;
        if ($('#oaccept').is(':checked')) {
            checke = 1;
        } else {
            checke = 0;
        }

        var formData = new FormData();
        formData.append('name', $("#site_name").val());
        formData.append('bg', $("#site_bg").val());
        formData.append('phone', $("#site_phone").val());
        formData.append('main_color', $("#site_main_color").val());
        formData.append('logo', $("#site_logo").val());
        formData.append('bg_premium', $("#bg_premium").val());
        formData.append('premium_img', $("#premium_img").val());
        formData.append('c1_dedazen', $("#c1_dedazen").val());
        formData.append('c2_dedazen', $("#c2_dedazen").val());
        formData.append('c3_dedazen', $("#c3_dedazen").val());
        formData.append('c4_dedazen', $("#c4_dedazen").val());
        formData.append('sec_color', $("#site_sec_color").val());
        formData.append('discord', $("#discord").val());
        formData.append('des', $("#site_des").val());
        formData.append('ann', $("#ann").val());
        formData.append('webhook_dc', $("#webhook_dc").val());
        formData.append('fee', check);
        formData.append('oaccept', checke);
        formData.append('bg_ann', $("#bganuuou").val());
        formData.append('tx_ann', $("#txanuuou").val());
        formData.append('help', $("#help").val());
        formData.append('fb', $("#fb").val());
        formData.append('lined', $("#lined").val());
        formData.append('apipeamsub', $("#apipeamsub").val());
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