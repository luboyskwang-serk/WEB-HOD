<?php
function generateState()
{
    $length = 10;

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    $state = '';
    for ($i = 0; $i < $length; $i++) {
        $state .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $state;
}

$state = generateState();
?>
<style>
    .form-control {
        border: none;
        border-bottom: 3px solid var(--main);
        border-radius: 0px;
    }

    .tc {
        font-weight: 500;
        text-transform: uppercase;
        background: linear-gradient(to right, #d51f1f 0%, #ff9f00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-decoration: none
    }

    .fsh {
        font-size: 16px;
        color: #dfdfdf;
    }

    .bb {
        background-color: #0e0e0f;
        border: solid 1px #232326;
    }

    .card-dz {
        background-color: #0f0f0f;
        border-radius: 1vh;
        border: solid 1px #232326;
    }

    .btn-dz {
        background-color: #141416;
        border: solid 1px #232326;
    }

    #discord-button {


        .icon {
            width: 25px;
            height: 25px;
            margin-right: 15px;

            svg {
                fill: white;
            }
        }

        a {
            color: white;
            font-weight: bold;
            border-radius: 8px;
            display: inline-flex;
            padding: 10px 15px;
            background-color: #5865F2;
            text-decoration: none;
            width: 100%;
            display: flex;
            justify-content: center;
            /* จัดเรียงตรงกลางในแนวนอน */

            &:hover {
                background-color: #6a7fc9;
            }
        }
    }

    #line-button {


        .icon {
            /* width: 25px;
     height: 25px; */
            margin-right: 15px;

            font-size: 25px;
        }

        a {
            color: white;
            font-weight: bold;
            border-radius: 8px;
            display: inline-flex;
            padding: 10px 15px;
            background-color: #06C755;
            text-decoration: none;
            width: 100%;
            display: flex;
            justify-content: center;
            /* จัดเรียงตรงกลางในแนวนอน */

            &:hover {
                background-color: #4CC764;
            }
        }
    }
</style>
<div class="container-fluid p-0 mt-4 ">
    <div class="container-sm m-cent  ps-4 pe-4" style=" margin-bottom: 4em!important;">
        <div class="container-fluid p-4 shadow-sm card-dz">
            <div class="col-lg-6 m-cent pt-4" style="margin-bottom: 4em!important;">
                <div>

                    <h1 class="tc" style="font-size: 26px;">LOGIN</h1>
                    <h1 class="fsh"><?php echo $config['name']; ?></h1></span>




                </div>
                <br>
                <div class="container-fluid ps-0 pe-0 " style="margin-top:-1rem;">
                    <div class="col-lg-8 m-cent">
                        <div class="mt-2 mb-3">
                            <label class="mb-2">ชื่อผู้ใช้</label>
                            <br>
                            <input type="text" style="font-size:14px;" class="bb form-control-lg  w-100 text-or" id="user" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="mb-2">
                            <label class="mb-2">รหัสผ่าน</label>
                            <br>
                            <input type="password" style="font-size:14px;" class="bb form-control-lg mb-0 w-100  text-or" id="pass" placeholder="Password" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <p class="text-end text-white mt-0 mb-1">ลืมรหัสผ่าน ?</p>
                        <br>
                        <button class="btn btn-dz text-white  ps-4 pe-4  pt-2 pb-2 w-100 d-inline" id="btn_regis"><i class="fa-solid fa-arrow-right"></i>&nbsp;เข้าสู่ระบบ</button>


                        <!-- <div style="padding: 100" align="center">
                                    <div class="fb-login-button" data-max-rows="1" data-size="large" data-button-type="login_with" scope="public_profile,email" onlogin="checkLoginState();" auto-logout-link="true"></div>
                                </div>  -->


                        <div id="line-button" class="mt-4">
                            <a href="https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=2005554516&redirect_uri=https://khunbaimai.in.th/auth/line.php&state=<?= $state ?>&scope=openid%20profile&bot_prompt=aggressive" target="_blank">

                                <div class="icon">
                                    <i class="fa-brands fa-line "></i>
                                </div>
                                <span>เข้าสู่ระบบด้วย Line</span>
                            </a>
                        </div>

                        <div id="discord-button" class="mt-2">
                            <a href='/auth/discord.php' target="_blank">

                                <div class="icon">
                                    <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 245 240">
                                        <path class="st0" d="M104.4 103.9c-5.7 0-10.2 5-10.2 11.1s4.6 11.1 10.2 11.1c5.7 0 10.2-5 10.2-11.1.1-6.1-4.5-11.1-10.2-11.1zM140.9 103.9c-5.7 0-10.2 5-10.2 11.1s4.6 11.1 10.2 11.1c5.7 0 10.2-5 10.2-11.1s-4.5-11.1-10.2-11.1z" />
                                        <path class="st0" d="M189.5 20h-134C44.2 20 35 29.2 35 40.6v135.2c0 11.4 9.2 20.6 20.5 20.6h113.4l-5.3-18.5 12.8 11.9 12.1 11.2 21.5 19V40.6c0-11.4-9.2-20.6-20.5-20.6zm-38.6 130.6s-3.6-4.3-6.6-8.1c13.1-3.7 18.1-11.9 18.1-11.9-4.1 2.7-8 4.6-11.5 5.9-5 2.1-9.8 3.5-14.5 4.3-9.6 1.8-18.4 1.3-25.9-.1-5.7-1.1-10.6-2.7-14.7-4.3-2.3-.9-4.8-2-7.3-3.4-.3-.2-.6-.3-.9-.5-.2-.1-.3-.2-.4-.3-1.8-1-2.8-1.7-2.8-1.7s4.8 8 17.5 11.8c-3 3.8-6.7 8.3-6.7 8.3-22.1-.7-30.5-15.2-30.5-15.2 0-32.2 14.4-58.3 14.4-58.3 14.4-10.8 28.1-10.5 28.1-10.5l1 1.2c-18 5.2-26.3 13.1-26.3 13.1s2.2-1.2 5.9-2.9c10.7-4.7 19.2-6 22.7-6.3.6-.1 1.1-.2 1.7-.2 6.1-.8 13-1 20.2-.2 9.5 1.1 19.7 3.9 30.1 9.6 0 0-7.9-7.5-24.9-12.7l1.4-1.6s13.7-.3 28.1 10.5c0 0 14.4 26.1 14.4 58.3 0 0-8.5 14.5-30.6 15.2z" />
                                    </svg>
                                </div>
                                <span>เข้าสู่ระบบด้วย Discord</span>

                            </a>
                        </div>

                        <hr>


                        <center>
                            <p class="text-secondary  mt-2"><a href="?page=register" class="text-secondary " style="text-decoration: none;"><i class="fa-regular fa-user-plus"></i>&nbsp;สมัครสมาชิกเพื่อเข้าใช้งาน</a></p>
                        </center>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer>
</script>
<script type="text/javascript">
    $("#btn_regis").click(function(e) {
        e.preventDefault();
        var formData = new FormData();
        formData.append('user', $("#user").val());
        formData.append('pass', $("#pass").val());
        $('#btn_regis').attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: 'system/login.php',
            data: formData,
            contentType: false,
            processData: false,
        }).done(function(res) {

            result = res;
            console.log(result);
            if (res.status == "success") {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    text: result.message
                }).then(function() {
                    window.location = "?page=home";
                });
            }
            if (res.status == "fail") {
                Swal.fire({
                    icon: 'error',
                    title: 'ผิดพลาด',
                    text: result.message
                });
                $('#btn_regis').removeAttr('disabled');
            }
        }).fail(function(jqXHR) {
            console.log(jqXHR);
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: res.message
            })
            $('#btn_regis').removeAttr('disabled');
        });
    });
</script>



<script>
    var bFbStatus = false;
    var fbID = "";
    var fbName = "";
    var fbEmail = "";

    window.fbAsyncInit = function() {
        FB.init({
            appId: '1081391696252495',
            cookie: true,
            xfbml: true,
            version: 'v19.0'
        });
        FB.AppEvents.logPageView();
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));


    function statusChangeCallback(response) {

        if (bFbStatus == false) {
            fbID = response.authResponse.userID;

            if (response.status == 'connected') {
                getCurrentUserInfo(response)
            } else {
                FB.login(function(response) {
                    if (response.authResponse) {
                        getCurrentUserInfo(response)
                    } else {
                        console.log('Auth cancelled.')
                    }
                }, {
                    scope: 'email'
                });
            }
        }

        bFbStatus = true;
    }

    function getCurrentUserInfo() {
        FB.api('/me?fields=name,email', function(userInfo) {

            fbName = userInfo.name;
            fbEmail = userInfo.email;

            console.log(fbID);
            console.log(fbName);
            console.log(fbEmail);
        });
    }

    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    }
</script>