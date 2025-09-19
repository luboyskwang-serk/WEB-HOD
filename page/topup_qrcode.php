<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Decoder</title>
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.0.0/dist/jsQR.js"></script>
    <style>
        .container {
            margin-top: 60px;
        }

        .bordrt {
            border: var(--main) solid 2px;
            border-radius: 0.5vh;
        }
        .card {
            background-color: #0e0e0f;
            border: solid 1px #1b1b1e;
            border-radius: 1vh;
        }
        .text-for{
            color:#ececec;
            float: left;
            margin-bottom: 10px;
        }
        .form-control {
            background-color: #090a0d;
            border: solid 1px #1b1b1e;
            border-radius: 1vh;
            color:#81da65;
        }
        .text-danger {
            font-size: 13px;
        }
        .btn-vare {
            background-color: #364836;
            border: solid 1px #567756;
            color:#59c159;
        }
        .btn-vare:hover{
            border-bottom: solid 2px #59c159;
            background-color: #00000000;
            color: #364836;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card p-2">
            <div class="card-body scrollable-container">
                <center>
                    <div class="col-lg-3" data-aos="fade-down" data-aos-duration="700">
                        <img src="/assets/icon/prompay.png" class="img-fluid">
                    </div>
                </center>
                <div data-aos="fade-left" data-aos-duration="750">
                    <center>
                        <label for="point" class="text-for">ระบุจำนวนเงิน</label>
                       
                        <div data-aos="fade-left" data-aos-duration="750">
                            <input type="text" id="req_amount" class="form-control text-center mt-1" placeholder="จำนวนเงินที่ต้องการเติม">
                        </div>
                        <div class="label text-danger mt-2">**เตรียมแอปชำระเงินของคุณให้พร้อมก่อนกดชำระเงิน</div>
                        <button type="submit" class="btn btn-vare w-100" style="margin-top: 20px;" onclick="ok_paynow();">สร้างคิวอาร์โค้ดเพื่อชำระเงิน</button>
                    </center>
                </div>
            </div>
        </div>
    </div>
<style>.watermark {
            position: absolute;
            top: 35%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 30%; 
            opacity: 0.3; 
        }</style>
    <!-- Modal Qr code  -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bordrt">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">สแกนจ่ายด้วย QR code</h1>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <span>ชื่อบัญชี : <?= $config['web_slip_name'] ?></span><br>
                        <img id="qrcodegannew" src="test1.PNG" alt="qr" class="w-50 bordrt">
                        <img src="<? echo  $config['logo']; ?>" class="watermark" alt="watermark">
                        <br>
                        <span>จำนวนเงินที่ชำระ</span><br>
                        <h2 id="amount"></h2>
                        <span>สแกน QR Code เพื่อจ่ายเงิน</span><br>
                        <span>กรุณาจ่ายเงินภายในเวลา</span>
                        <h4 class="text-danger" id="countdown"></h4>
                       
                    </div>
                </div>


            </div>
        </div>
    </div>

    <script>
        function decodeQRCodeFromBase64(base64Image) {
            return new Promise((resolve, reject) => {
                var img = new Image();
                img.onload = function() {
                    try {
                        var canvas = document.createElement("canvas");
                        canvas.width = img.width;
                        canvas.height = img.height;
                        var ctx = canvas.getContext("2d");
                        ctx.drawImage(img, 0, 0);
                        var imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                        var code = jsQR(imageData.data, imageData.width, imageData.height);
                        if (code) {
                            resolve(code.data);
                        } else {
                            reject(new Error('ไม่พบ QR code หรือไม่สามารถอ่านได้'));
                        }
                    } catch (error) {
                        reject(error);
                    }
                };
                img.onerror = function() {
                    reject(new Error('ไม่สามารถโหลดภาพได้'));
                };
                img.src = base64Image;
            });
        }

        function checkNumber(number) {
    $.ajax({
        type: 'POST',
        url: '/system/confirm_qrcode.php',
        data: {
            amount: number
        },
        success: function(response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    text: response.message
                }).then(function() {
                    // Redirect to the page with the original GET parameter
                    window.location.href = "?page=<?php echo htmlspecialchars($_GET['page']); ?>";
                });
            } else {
                console.log('Retrying in 5 seconds...');
                setTimeout(function() {
                    checkNumber(number); // Retry after 5 seconds
                }, 3000);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error:', textStatus, errorThrown);
            console.log('Retrying in 5 seconds...');
            setTimeout(function() {
                checkNumber(number); // Retry after 5 seconds
            }, 3000);
        }
    });
}

        function ok_paynow() {
            var formData = new FormData();
            formData.append('req_amount', $("#req_amount").val());
            var loadingSwal = showLoadingMessage();
            $.ajax({
                type: "POST",
                url: "system/gen_qrcode.php",
                data: formData,
                contentType: false,
                processData: false,
            }).then((res) => {
                console.log(res);
                hideLoadingMessage(loadingSwal);
                if (res.status == "fail") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: res.message,
                    });
                    $('.btn-ok').html('สร้างคิวอาร์เพื่อชำระเงิน');
                } else {
                    $('#staticBackdrop').modal('show');
                    startCountdown(res.time_out);
                    $("#qrcodegannew").attr("src", res.img);
                    checkNumber(res.amount);
                    document.getElementById('amount').textContent = res.amount + ' ฿';
                }
            });
        }

        function showLoadingMessage() {
            return Swal.fire({
                icon: 'warning',
                title: 'โปรดรอสักครู่',
                text: 'ระบบกำลังดำเนินการ โปรดห้ามรีเฟรช',
                showConfirmButton: false,
            });
        }

        function hideLoadingMessage(loadingSwal) {
            if (loadingSwal) {
                loadingSwal.close();
            }
        }

        function ok_confirm() {
            $.ajax({
                type: "POST",
                url: "system/confirm_qrcode.php",
            }).then((res) => {
                console.log(res);
                if (res.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Payment Success!!',
                        text: res.message,
                    }).then(() => {
                        window.location.reload();
                    });
                    $('.btn-confirm').html('แจ้งการโอนเงิน');
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: res.message,
                    }).then(() => {
                        $('.btn-confirm').html('แจ้งการโอนเงิน');
                    });
                }
            });
        }

        function startCountdown($time) {
            const secondsInput = parseInt($time, 10);
            const countdownElement = document.getElementById('countdown');
            let remainingSeconds = secondsInput;
            const updateCountdown = () => {
                if (remainingSeconds > 0) {
                    const minutes = Math.floor(remainingSeconds / 60);
                    const seconds = remainingSeconds % 60;
                    countdownElement.textContent =
                        `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    remainingSeconds--;
                } else {
                    countdownElement.textContent = 'หมดเวลา';
                    clearInterval(countdownInterval);
                }
            };
            updateCountdown();
            const countdownInterval = setInterval(updateCountdown, 1000);
        }
    </script>
</body>

</html>