<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style>
    /* hr{
        border-top: 3px solid #000;
    } */
    .videoWrapper {
        position: relative;
        padding-bottom: 56.25%;
        /* 16:9 */
        padding-top: 25px;
        height: 0;
    }

    .videoWrapper iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    /* Input From*/
    .inputGroup {
        margin: 1em 0 1em 0;
        max-width: 100%;
        position: relative;
    }

    .inputGroup input {
        font-size: 100%;
        padding: 0.6em;
        outline: none;
        border: 1px solid #5eba45;
        border-radius: 6px;
        width: 100%;
        background-color: #0f0f0f;
        color: #fefefe;
    }

    .inputGroup label {
        font-size: 90%;
        position: absolute;
        left: 0;
        padding: 0.8em;
        margin-left: 0.5em;
        pointer-events: none;
        transition: all 0.3s ease;
        color: rgb(100, 100, 100);

    }

    .inputGroup :is(input:focus, input:valid)~label {
        transform: translateY(-50%) scale(.9);
        margin: 0em;
        margin-left: 1.3em;
        padding: 0.4em;
        background-color: #0f0f0f;
    }

    .inputGroup :is(input:focus, input:valid) {
        border-color: rgb(150, 150, 200);
    }

    /* #card */

    .card-1 {
        margin-top: 1rem;
        border-radius: 1vh;
    }

    .card {
        border: none;
        border-radius: 1vh;
    }

    .truemoney {
        background-color: #0f0f0f;
        border-radius: 1vh;
        border: solid 1px #232326;

    }

    .truemoney:hover {
        background-color: #3b4638;
        color: #79df5d;
    }

    .truemoney img {
        margin-top: 0.1rem;
        padding: 2px;
        margin-left: 1.3rem;
    }

    .truemoney h6 {
        font-weight: 600;
        color: #fefefe;
        float: left;
        margin-top: 1.5rem;
    }

    .truemoney p {
        color: #a1a1a1;
        font-size: 13px;
        margin-top: -0.5rem;
        float: left;
    }

    .truemoney p:hover {
        color: #79df5d;
    }

    .topup_btn {
        background-color: #272727;
        border: none;
        padding: 0.5rem;
    }

    .topup_btn:hover {
        background-color: #bd2424;
    }

    .fc {

        text-transform: uppercase;
        background: linear-gradient(to right, #30CFD0 0%, #330867 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }



    .ttcolor {
        text-transform: uppercase;
        background: linear-gradient(to right, #ff4040 0%, #ff9e00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .help {
        text-decoration: none;
        color: #626262;
    }

    .help:hover {
        color: #ba1f1f;
        font-weight: 600;
    }
</style>




<div class="container-fluid mt-3 p-0 " style="margin-bottom:8rem;">
    <div class="container-sm p-2" data-aos="fade-left">


        <center class="mt-2 mb-2">
            <span class="h4  ttcolor"><b>ช่องทางการชำระเงิน</b></span>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb d-flex justify-content-center mt-0">
                    <li class="breadcrumb-item"><a style="text-decoration: none; color: #f0ab0c; font-size:13px;"> หน้าหลัก</a></li>
                    <li class="breadcrumb-item"><a style="text-decoration: none; color: #6C757D; font-size:13px;"> รายการทั้งหมด</a></li>

                </ol>
            </nav>





        </center>

        <div class="container text-center mt-4">
            <div class="row">

                <!-- เริ่มต้น -->

                <div class="col-sm-4">
                    <div class="p-4">
                        <div class="w3-bar w3-black">


                            <button class="w3-bar-item w3-button truemoney mb-2" onclick="openCity('truemoney')">
                                <img class="col-3" src="assets/icon/angpao.png" width="45" style="float: left;" alt="">
                                <h6>Truemoney อั่งเปา</h6>
                                <p>เติมเงินผ่านซองของขวัญ</p>
                            </button>

                            <button class="w3-bar-item w3-button truemoney mb-2" onclick="openCity('qrcode')">
                                <img class="col-3" src="assets/icon/slip.png" width="30" style="float: left;" alt="">
                                <h6>ยืนยัน Slip-Qrcode</h6>
                                <p>ยืนยันสลิปผ่าน QR-CODE</p>
                            </button>

                            <a href="?page=Topup_qr"><button class="w3-bar-item w3-button truemoney mb-2">
                                    <img class="col-3" src="assets/icon/prompay.png" width="30" style="float: left;" alt="">
                                    <h6>PromptPay Qrcode</h6>
                                    <p>เติมเงินด้วยระบบพร้อมเพย์</p>
                                </button></a>

                            <a href="?page=redeem"><button class="w3-bar-item w3-button truemoney mb-2">
                                    <img class="col-3" src="assets/icon/code.png" width="30" style="float: left;" alt="">
                                    <h6>Gift-Code Buzzer</h6>
                                    <p>เติมเงินโดยใช้โค๊ดจากร้าน</p>
                                </button></a>





                        </div>
                    </div>
                </div>


                <div class="col-sm-8 mt-1">
                    <div class="card-1" style="background-color:0f0f0f">






                        <!-- true Money Angpao -->
                        <div id="truemoney" class="w3-container city">

                            <div class="ps-4 pe-4 pt-3">
                                <!-- ค่าธรรมเนียม -->
                                <?php if ($config['fee'] == "on") { ?>
                                    <div data-aos="fade-left" data-aos-duration="750">
                                        <p class=" text-center"><b style="color:#e51812; font-size:13px; margin-bottom:0.1rem;">
                                                <i class="fa-duotone fa-circle-xmark fa-fade" style="--fa-primary-color: #f10a0f; --fa-secondary-color: #6f0003;"></i> ค่าธรรมเนียม 2.3 %</b></p>
                                    </div>
                                <?php } ?>
                                <?php if ($config['fee'] == "off") { ?>
                                    <div data-aos="fade-left" data-aos-duration="750">
                                        <p class="text-center"><b style="color:#2fde14; font-size:13px; margin-bottom:0.1rem;">
                                                <i class="fa-duotone fa-circle-check fa-fade" style="--fa-primary-color: #06b013; --fa-secondary-color: #05690d;"></i> ไม่มีค่าธรรมเนียม</b></p>
                                    </div>
                                <?php } ?>
                                <!-- ค่าธรรมเนียม -->

                            </div>

                            <!--  <div class="input-group mb-2 pe-4 ps-4">
                                                          
                                                             <input type="text" id="link" class="form-control text-center mt-1" style="border-radius: .5vh;" placeholder="กรอกลิงค์ซองของขวัญที่นี่">
                                                        </div> -->

                            <div class="inputGroup pe-4 ps-4">
                                <input type="text" id="link" class="text-center mt-1" placeholder="วางลิงค์ซองของขวัญตรงนี้!">
                                <label for="name">กรอกลิงค์ซองของขวัญที่นี่</label>
                            </div>

                            <div class="pe-4 ps-4">

                                <button class="btn-topup p-2 mt-0 text-white w-100" id="topup_btn" style="border-radius: 1vh;" data-aos="fade-up" data-aos-duration="800">
                                    <i class="fa-duotone fa-circle-check fa-fade" style="--fa-primary-color: var(--main); --fa-secondary-color: var(--main);"> </i> ยืนยันการเติมเงิน</button>


                                <center class="p-2">
                                    <p class="m-2" style="font-size:13px; color:#3f3f3f;">หากกดทำรายการไม่ได้ ให้ทำการรีเซ็ตหน้าเว็บใหม่ครับ</p>
                                </center>

                            </div>
                            <center>
                                <div id="capcha" class="g-recaptcha mt-4" data-theme="dark" style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>
                            </center>
                        </div>









                        <div id="promptpay" class="w3-container city p-3" style="display:none">
                            <h6 class="mt-3 " style="color:#626262; font: size 13px;"><i class="fa-duotone fa-circle-xmark fa-fade" style="--fa-primary-color: var(--main); --fa-secondary-color: var(--main);"> </i> โปรดหลีกเลี่ยงการโอนเงิน <br>ช่วงเวลา 22.30 - 03.00 น. (ป้องกันความผิดพลาดของการปรับปรุงธนาคาร)</h6>
                            <div class="section-topup">
                                <img src="https://play-lh.googleusercontent.com/UIdkgBTFEFYTbE-_hUnekG5Aq16au9J7C6RI5gnoAeEZV2zMC3XgOnjL-0aYdmyWk6k=w240-h480-rw" alt="" class="img-fluid">

                                <div class="inputGroup text-start pe-3 ps-3">
                                    <input type="text" class="form-control text-center" placeholder="ระบุจำนวนเงิน" id="input-price">
                                    <label for="name">ทำรายการขั้นต่ำ 50 บาท+</label>
                                </div>

                                <button class="btn-topup-qr btn-topup pe-4 ps-4 p-2 mt-2">
                                    <!-- <i class="fa-regular fa-link fa-fade fa-sm" style="color: #ffffff;"></i> -->
                                    ถัดไปเพื่อสแกนจ่าย <i class="fa-light fa-arrow-right-long"></i>
                                </button>
                            </div>

                            <style>
                                .btn-topup {
                                    width: 100%;
                                    border: none;
                                    border-radius: 0.5vh;
                                    color: #aafaa2;
                                    background-color: #33b40d;
                                }

                                .btn-topup:hover {
                                    background-color: #37592d;
                                }

                                .btn-cancle-qr {
                                    width: 90%;
                                    border: none;
                                    border-radius: 0.5vh;
                                    color: #ff8888;
                                    background-color: #8d1b1b;
                                }

                                .btn-cancle-qr:hover {
                                    background-color: #c83d3d
                                }
                            </style>

                        </div>
                        <div class="section-topup-2" style="display:none">
                            <center>
                                <img src="" alt="" class="img-fluid" id="img-qrcode" style="max-width:250px">
                            </center>

                            <div class="text-center h5 text-danger mt-3 mb-3"> ทำรายการภายใน <span class="count-down" onclick="check_topup()">0:0:0</span></div>
                            <button class="btn-cancle-qr p-2 mb-4" data-aos="fade-up" data-aos-duration="800">
                                ยกเลิกรายการ
                            </button>
                        </div>

                        <script>
                            function check_topup() {
                                var formData = new FormData();
                                formData.append('method', 'submit_qr');
                                $.ajax({
                                    type: 'POST',
                                    url: 'system/qrcode.php',
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                }).done(function(r) {
                                    console.log(r)
                                    if (r.status == 'success') {
                                        Swal.fire(r.status, r.msg, r.status).then(function() {
                                            location.reload()
                                        })
                                    }
                                })
                            }
                            $(document).ready(function() {
                                $('.btn-topup-qr').click(function() {
                                    let amount = $('#input-price').val()
                                    if (!amount) {
                                        Swal.fire('error', 'กรุณากรอกจำนวนเงิน', 'error');
                                        return;
                                    }
                                    var formData = new FormData();
                                    formData.append('method', 'qr_set');
                                    formData.append('amount', amount);
                                    $.ajax({
                                        type: 'POST',
                                        url: 'system/qrcode.php',
                                        data: formData,
                                        contentType: false,
                                        processData: false,
                                    }).done(function(res) {
                                        r = res;
                                        console.log(r)
                                        $('#img-qrcode').attr('src', 'data:image/png;base64,' + r.base64)
                                        sec_start = r.timeout;
                                        setTimeout(time_down, 0);
                                        setInterval(check_topup, 1000);
                                        $('.section-topup').fadeOut(100, () => {
                                            $('.section-topup-2').fadeIn(100);
                                        })
                                    })
                                })
                                $('.btn-cancle-qr').click(function() {
                                    console.log('click')
                                    var formData = new FormData();
                                    formData.append('method', 'cancle');
                                    $.ajax({
                                        type: 'POST',
                                        url: 'system/qrcode.php',
                                        data: formData,
                                        contentType: false,
                                        processData: false,
                                    }).done(function(r) {
                                        location.reload()
                                    })
                                })

                                function time_display(id_tag, time_s) {
                                    min = pad(Math.floor(time_s / 60), 2, 0);
                                    sec = pad(Math.abs((min * 60) - time_s), 2, 0);
                                    if (time_s <= 0) {
                                        $('.count-down').text('00:00');
                                    } else {
                                        $('.count-down').text(min + " : " + sec);
                                    }
                                }

                                var sec_start

                                function time_down() {
                                    sec_start = sec_start - 1;
                                    time_display("time_count_down", sec_start);
                                    if (sec_start > 0) {
                                        setTimeout(time_down, 1000);
                                    }
                                }

                                function pad(n, width, fill) {
                                    n = n + '';
                                    return n.length >= width ? n : new Array(width - n.length + 1).join(fill) + n;
                                }

                                function pad(n, width, fill) {
                                    n = n + '';
                                    return n.length >= width ? n : new Array(width - n.length + 1).join(fill) + n;
                                }
                            })
                        </script>
                    </div>










                    <!-- Scan QR CODE -->
                    <div id="qrcode" class="w3-container city" style="display:none">
                        <!-- QRCODE -->
                        <div class="input-group mb-2 pe-4 ps-4">

                        </div>


                        <div class="pe-4 ps-4 pb-4 bg-dark pt-4" style="border-radius:1vh;">
                            <h6 class="mt-3 " style="color:#efefef; font-size: 12px;">
                                <i class="fa-duotone fa-circle-xmark fa-fade" style="--fa-primary-color: var(--main); --fa-secondary-color: var(--main);"> </i>
                                โปรดหลีกเลี่ยงการโอนเงิน <br>ช่วงเวลา 22.30 - 03.00 น. (ป้องกันความผิดพลาด)
                            </h6>

                            <?php $bank = dd_q("SELECT * FROM bank WHERE id = 1")->fetch(PDO::FETCH_ASSOC); ?>
                            <h5>

                                <hr>
                                <h5 class="mt-1 fw-bold">รายละเอียดบัญชี</h5>
                                <img src="<?php echo $bank['qrcode']; ?>" style="border-radius:1vh; margin-bottom:1rem;" class="w-100" alt="รูปภาพ Qr รับเงิน">

                                <h6 style="color:#efefef;">เลขบัญชี : <?php echo $bank['bnum']; ?></span>
                                    <br>
                                    ชื่อบัญชี : <?php echo $bank['fname']; ?> &nbsp;<?php echo $bank['lname']; ?>

                                    <p class="text-danger" style="margin-top:1rem; margin-bottom:-1rem;"> (หากเกิน 3-5 นาที รบกวนแจ้งแอดมิน)</p><br>

                                    <div class="input-group text-start mb-2">
                                        <input type="text" class="form-control text-center" value="<?php echo $bank['bnum']; ?>" id="myInput" disabled>



                                        <!-- Copy -->
                                        <button class="btn-topup p-2 ms-2 w-25" style="border-radius:0.5vh;" onclick="myFunction()">&nbsp;
                                            <i class="fa-regular fa-link fa-fade fa-sm" style="color: #ffffff;"></i>
                                            <span style="color:#eeeeee"> คัดลอกเลขบัญชี</span> &nbsp;
                                        </button>
                                        <style>
                                            @media only screen and (max-width: 600px) {
                                                .btn-topup span {
                                                    display: none;
                                                }
                                            }
                                        </style>
                                        <!-- Copy -->

                                        <script>
                                            function myFunction() {
                                                var copyText = document.getElementById("myInput");
                                                copyText.select();
                                                copyText.setSelectionRange(0, 99999);
                                                document.execCommand("copy");
                                                navigator.clipboard.writeText(copyText.value);
                                                Swal.fire(
                                                    'คัดลอกสำเร็จ',
                                                    'คัดลอกเลขบัญชีเรียบร้อย',
                                                    'success'
                                                )
                                            }
                                        </script>
                            </h5>


                            <div class="text-input">
                                <span style="color:#35363a; float: right; font-size:12px;">โปรดอัพไฟล์สลิปโอนเงิน</span>
                                <input type="file" class="form-control" id="upload" aria-label="Upload">
                                <img id="imageScanner" style="display: none;" src="#" alt="qr-code-scanner-online">
                            </div>


                        </div>

                        </font>

                    </div>


                    <center>
                        <div id="capcha" class="g-recaptcha mt-4" data-theme="dark" style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>
                    </center>

                    <!-- ปิดท้าย -->
                </div>
            </div>
        </div>
    </div>
</div>




    <!-- Help -->
    <center>
        <div class="mt-4">
            <h4 class="fw-bold" style="color:#2d2d32">พบเจอปัญหาในการเติมอยู่ <i class="fa-regular fa-circle-question"></i></h4>
            <a href="" class="help">วิธีการเติมเงินเข้าเว็บ ?</a>
        </div>
    </center>



    <script>
        function openCity(cityName) {
            var i;
            var x = document.getElementsByClassName("city");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            document.getElementById(cityName).style.display = "block";
        }
    </script>

    <!-- wallet ang -->

    <script>
        $("#topup_btn").click(function() {

            var formData = new FormData();

            formData.append('link', $("#link").val());

            $.ajax({

                type: 'POST',

                url: 'system/topup.php',

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
    </script>
    <!-- End -->




    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
    <script>
        function File2Base64(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = () => resolve(reader.result);
                reader.onerror = (error) => reject(error);
            });
        }
        async function imageDataFromSource(source) {
            const image = Object.assign(new Image(), {
                src: source
            });
            await new Promise((resolve) => image.addEventListener('load', () => resolve()));
            const context = Object.assign(document.createElement('canvas'), {
                width: image.width,
                height: image.height,
            }).getContext('2d');
            context.imageSmoothingEnabled = false;
            context.drawImage(image, 0, 0);
            return context.getImageData(0, 0, image.width, image.height);
        }

        $(function() {
            $('#upload').change(function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'โปรดรอสักครู่',
                    text: "กำลังตรวจสอบ โปรดห้ามรีเฟรช",
                    showConfirmButton: false,
                });
                const input = this;
                const url = $(this).val();
                const ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                if (input.files && input.files[0] && (ext === "png" || ext === "jpeg" || ext === "jpg")) {
                    const reader = new FileReader();
                    reader.onload = async function(e) {
                        const URLBase64 = await File2Base64(input.files[0]);
                        const ImageData = await imageDataFromSource(URLBase64);
                        const code = jsQR(ImageData.data, ImageData.width, ImageData.height);
                        if (code && code.data) {
                            var qrcode = code.data;
                            console.log(qrcode);
                            var formData = new FormData();
                            formData.append('qrcode', qrcode);
                            $.ajax({
                                type: 'POST',
                                url: 'system/slip.php',
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
                                    window.location = "?page=profile&subpage=topuphis";
                                });
                            }).fail(function(jqXHR) {
                                console.log(jqXHR.responseText)
                                res = jqXHR.responseJSON;
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เกิดข้อผิดพลาด',
                                    text: res.message
                                }).then(function() {
                                    window.location = "?page=topup";
                                });
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด',
                                text: 'สลิปไม่มี QR CODE',
                            }).then(function() {
                                window.location = "?page=topup";
                            });
                        }
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'อนุญาตเฉพาะนามสกุล PNG , JPEG และ JPG เท่านั้น โปรดเลือกใหม่',
                    });
                }
            });
        });
    </script>