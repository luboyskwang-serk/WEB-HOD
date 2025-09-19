<?php include 'data.php'; ?> <?php session_start();
                                error_reporting(0);
                                require_once("system/a_func.php");
                                if (isset($_SESSION['id'])) {
                                    $q1 = dd_q("SELECT * FROM users WHERE id = ? LIMIT 1", [$_SESSION['id']]);
                                    if ($q1->rowCount() == 1) {
                                        $user = $q1->fetch(PDO::FETCH_ASSOC);
                                    } else {
                                        session_destroy();
                                        $_GET['page'] = "login";
                                    }
                                }
                                $get_static = dd_q("SELECT * FROM static");
                                $static = $get_static->fetch(PDO::FETCH_ASSOC); // $config["pri_color"] = "#FF2B2B";// $config["sec_color"] = "#9A0D0D";
                                ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="DedaZen | เติมเกมส์ออนไลน์ราคาถูกที่สุดในไทย และยังจำหน่ายแอพพรีเมียมราคาถูก " />
    <meta name="keywords" content="เติมเกมฟีฟาย เติมเกม Rov เติมเกม Valorant พับจีโมบาย โรบัค บริการเติมเกม มีโปรโมชั่นราคาถูกคุ้มที่สุด เติมได้ตลอด 24 ชั่วโมง เติมเกมValorant เติมเกมBlackCloverM ขายไอดีrovลดราคา เติมพับจีโมบายราคาถูก เว็บสุ่มรางวัลสุดคุ้ม สุ่มเพชรฟีฟาย สุ่มบัตรการีน่า สุ่มคูปอง RoV และสุ่มของรางวัลอื่นๆอีกมากมาย บริการเติมเกมราคาถูก เติมเงินมือถือ บัตรเติมเกม เติมเกมฟรี เว็บสำเร็จรูป ขายสินค้าออนไลน์ (ecommerce website) เลือกแพคเกจสำหรับเว็บไซต์ ตามการใช้งานของคุณ ฟรี ใบรับรอง SSL สำหรับร้านออนไลน์ ตลอดการใช้งาน ตลอดการใช้งาน" />
    <meta name="author" content="Dedazen Facebook">
    <meta name="robots" content="index, follow">
    <meta name="googlebots" content="index, follow">
    <meta name='language' content='TH'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config['name']; ?></title>
    <meta property="og:title" content="<?php echo $config['name']; ?> | Homepage">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://<?php echo $config['name']; ?>">
    <meta property="og:image" content="<?php echo $config['logo']; ?>">
    <meta property="og:description" content="<?php echo $config['des']; ?>">
    <meta name="keywords" content="ขายไอดีเกม,ขายบัตรเติมเกมออนไลน์,ไอดีไก่ตันคุ้มๆ,ไอดีไก่ตันเผ่าวี4,ไอดีเอฟเอฟ,ไอดีกันตัน6หมัด,กลุ่องสุ่มไก่ตัน1บาท,กล่องสุ่ม1บาท,ไกตัน1บาท,บัตรเติมเงิน,ซื้อรหัสเกมปลอดภัย,rov,ROV,บัตรการีน่า,บัตรทรู,เว็บขายไอดีเกม,เติมเกมฟีฟาย,เว็บเติมเกม,เว็บขายไอดีเกมฟีฟาย,เว็บขายไอดีเกมrov,ขายรหัสฟีฟาย,DedaZen.store,ซื้อรหัสฟีฟายราคาถูก,ซื้อบัตรเติมเงิน,จำหน่ายบัตรทรู,จำหน่ายรหัสเกมออนไลน์,สุ่มไอดีหัวค้างคาว,สุ่มท่าปักธง,รับซื้อไอดีฟีฟาย,รับซื้อไอดีrov,รับซื้อไอดีPB,ขายไอดีPB,ขายไอดีฟีฟาย,ขายไอดีrov,สุ่มบัตรทรู,สุ่มของรางวัล,สุ่มเพชรฟีฟาย,สุ่มไอดีฟีฟาย,เว็บสุ่มบัตรการีน่า,ดีโม่ช็อป,เว็บขายรหัสไม่เกรียน,ขายไอดีเกมออนไลน์"> <!-- Favicon -->
    <link rel="shortcut icon" href="/dz/favicon.png">
    <link rel="stylesheet" href="system/css/second.css">
    <link href="https://fastly.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://fastly.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> <!-- <link rel="stylesheet" href="system/gshake/css/box.css"> -->
    <link href="https://kit-pro.fontawesome.com/releases/v6.2.0/css/pro.min.css" rel="stylesheet">
    <script src="//fastly.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://fastly.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/fontawesome-all.min.css"> <!-- CSS Front Template -->
    <link rel="stylesheet" href="assets/css/theme.css"> <!-- JS Global Compulsory -->
    <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="assets/vendor/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/vendor/bootstrap/bootstrap.min.js"></script> <!-- JS Front -->
    <script src="assets/js/hs.core.js"></script> <!-- <link rel="stylesheet" href="assets/owl/dist/assets/owl.carousel.min.css"> --> <!-- <link rel="stylesheet" href="assets/owl/dist/assets/owl.theme.default.min.css"> -->
    <style>
        :root {
            --main: <?php echo $config["main_color"]; ?>;
            --sub: <?php echo $config["sec_color"]; ?>;
            --sub-opa-50: <?php echo $config["main_color"]; ?>80;
            --sub-opa-25: <?php echo $config["main_color"]; ?>;
        }
    </style>
    <link rel="stylesheet" href="system/css/option.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@100..700&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <style>
        .owl-items {
            max-width: 220px;
            max-height: 220px;
        }

        .owl-items img {
            border-radius: 25px !important;
            animation: glow 2s infinite ease-in-out;
        }

        * {
            font-family: "Anuphan", sans-serif;
        }

        body {
            background-image: url('<?= $config['bg'] ?>');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
            overflow-x: hidden;
        }
    </style>
</head>

<body> <!-- #111015!important;-->
    <nav class="navbar navbar-dark navbar-expand-lg m-0 shadow-sm mb-0" style="background-color:#080808">
        <div class="container-sm col-lg-10 col-12 " style="background-color:#080808"> <a class="navbar-brand " href="/?page=home"><img src="<?= $config['logo'] ?>" height="80px" width="auto"></a> <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar"> <i class="fa-light fa-grip-lines fa-fade"></i> </button>
            <div class="offcanvas offcanvas-end text-bg-dark ps-2 pe-5" style="margin-right:-5rem;background-color:#080808" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header mt-2 text-center"> <img src="<?php echo $config['logo']; ?>" class="offcanva" width="150px" id="offcanvasDarkLabel"> <button type="button" class="btn-close btn-close-white me-4 pe-5" data-bs-dismiss="offcanvas" aria-label="Close" style="font-size:18px;"></button> </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 p-2">
                        <li class="nav-item"> <a class="nav-link active text-danger" aria-current="page" style="font-size:14px" href="/?page=home">หน้าหลัก</a> </li>
                        <li class="nav-item"> <a class="nav-link active text-danger" aria-current="page" style="font-size:14px" href="/?page=topup">เติมเหรียญ</a> </li>
                        <li class="nav-item"> <a class="nav-link active text-danger" aria-current="page" style="font-size:14px" href="/?page=shop" rel="สุ่มไอดีฟีฟาย 1 บาท ไอดีไก่ตันคุ้มๆ">ร้านค้า</a> </li>
                        <li class="nav-item"> <a class="nav-link active text-danger" aria-current="page" style="font-size:14px" href="/?page=games" rel="สุ่มไอดีฟีฟาย 1 บาท ไอดีไก่ตันคุ้มๆ">สุ่มวงล้อ</a> </li>
                        <li class="nav-item"> <a class="nav-link active text-danger" aria-current="page" style="font-size:14px" href="/?page=cashcard" rel="บัตรเงินสด">บัตรเงินสด</a> </li>
                        <li class="nav-item"> <a class="nav-link active text-danger" aria-current="page" style="font-size:14px" href="/?page=phoneTopup" rel="เติมเงิน / ชื้อแพคเกจเน็ต">เติมเงิน / ชื้อแพคเกจเน็ต</a> </li>
                        <li class="nav-item dropdown btn-log-0"> <a class="nav-link text-warning dropdown-toggle" style="font-size:14px" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> เติมเกมส์ออนไลน์ </a>
                            <ul class="dropdown-menu dropdown-menu-dark me-4 pe-2">
                                <center>
                                    <li> <a class="dropdown-item mb-1 text-danger" style="font-size:14px" href="?page=termgame"> ดูเกมส์ทั้งหมด</a> </li>
                                </center>
                                <li> <a class="dropdown-item mb-1 text-danger" style="font-size:14px" href="?page=buy_termgame&game_name=FREEFIRE"> <img src="assets/game/game/FREEFIRE.png" class="img-game"> &nbsp;FREEFIRE <p class="des-game">เติมเกมฟีฟายสุดคุ้ม</p> </a> </li>
                                <li> <a class="dropdown-item mb-1 text-danger" style="font-size:14px" href="?page=buy_termgame&game_name=ROV-M"> <img src="assets/game/game/ROV-M.png" class="img-game"> &nbsp;ROV <p class="des-game">เติมเกม ROV</p> </a> </li>
                                <li> <a class="dropdown-item mb-1 text-danger" style="font-size:14px" href="?page=buy_termgame&game_name=PUBGM-D"> <img src="assets/game/game/PUBGM-D.png" class="img-game"> &nbsp;PUBG Mobile <p class="des-game">เติมเกมพับจี</p> </a> </li>
                                <li> <a class="dropdown-item mb-1 text-danger" style="font-size:14px" href="?page=buy_termgame&game_name=IDENTITYV"> <img src="assets/game/game/IDENTITYV.png" class="img-game"> &nbsp;iDENTITY <p class="des-game">เติมเกม iDENTITY V</p> </a> </li>
                                <li> <a class="dropdown-item mb-1 text-danger" style="font-size:14px" href="?page=buy_termgame&game_name=VALORANT-D"> <img src="assets/game/game/VALORANT-D.png" class="img-game"> &nbsp;VALORANT <p class="des-game">เติมเกม VALORANT</p> </a> </li>
                            </ul>
                        </li>
                        <style>
                            .img-game {
                                margin-top: 1rem;
                                width: 35px;
                                border-radius: 0.5vh;
                            }

                            .des-game {
                                font-size: 11px;
                                color: #d6c09b;
                                margin-left: 2.8rem;
                                margin-top: -1.5rem;
                            }

                            .game-dd {
                                padding: 0.1rem 0.5rem;
                                font-size: 10px;
                                background-color: #ffb5b5;
                                color: #ea5858;
                                border-radius: 5px;
                            }
                        </style> <?php if ($byshop_status == "on") : ?> <li class="nav-item"> <a class="nav-link active text-danger" aria-current="page" style="font-size:14px" href="/?page=premiumapp">แอพพรีเมี่ยม</a> </li> <?php endif; ?> <li class="nav-item dropdown btn-log-0"> <a class="nav-link text-warning dropdown-toggle" style="font-size:14px" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> ติดต่อเรา</a>
                            <ul class="dropdown-menu dropdown-menu-dark me-4">
                                <li> <a class="dropdown-item mb-1 text-danger" style="font-size:14px" href="<?php echo $config["fb"]; ?>"> <img src="/dz/fb.png" width="18">&nbsp;Facebook</a> </li>
                                <li> <a class="dropdown-item mb-1 text-danger" style="font-size:14px" href="<?php echo $config["discord"]; ?>"> <img src="/dz/discord.png" width="18">&nbsp;Discord</a> </li>
                                <li> <a class="dropdown-item mb-1 text-danger" style="font-size:14px" href="<?php echo $config["lined"]; ?>"> <img src="/dz/line.png" width="18">&nbsp;Line</a> </li>
                                <li> <a class="dropdown-item" style="font-size:14px;color:#d6c09b;" href="/?page=question"> Q&A คำถามยอดฮิต</a> </li>
                            </ul>
                        </li>
                    </ul>
                    <style>
                        @media only screen and (max-width: 600px) {
                            .btn-log-1 {
                                border-radius: 1vh;
                                padding: 0.2rem 0.5rem;
                                margin-right: 2.5rem;
                                text-align: center;
                            }
                        }
                    </style> <?php if (!isset($_SESSION['id'])) { ?> <ul class="navbar-nav mb-2 mt-2 col-lg-0 ">
                            <li class="nav-item mb-2 btn-log"> <a class="nav-link align-self-center" style="color:#ebebeb;padding: 0.2rem 0.5rem;font-size:14px;" aria-current="page" href="?page=login"> <i class="fa-light fa-right-to-bracket"></i>&nbsp;เข้าสู่ระบบ</a> </li>
                            <style>
                                .btn-log {
                                    background-color: #1e1e1e;
                                    border-radius: 0.5vh;
                                    padding: 0.2rem 0.5rem;
                                }

                                .btn-log:hover {
                                    background-color: #4a5f48;
                                }

                                .btn-log-1 {
                                    border-radius: 1vh;
                                    padding: 0.2rem 0.5rem;
                                }

                                @media only screen and (max-width: 600px) {
                                    .btn-log {
                                        background-color: #1e1e1e;
                                        border-radius: 0.3vh;
                                        padding: 0.2rem 0.5rem;
                                        margin-right: 2.5rem;
                                        text-align: center;
                                    }

                                    .btn-log:hover {
                                        background-color: #4a5f48;
                                    }

                                    .btn-log-1 {
                                        border-radius: 1vh;
                                        padding: 0.2rem 0.5rem;
                                        margin-right: 2.5rem;
                                        text-align: center;
                                    }
                                }
                            </style>
                            <li class="nav-item mb-2 btn-log-1"> <a class="nav-link " style="border-radius:1vh;color:#f3f3f3;padding: 0.2rem 0.5rem;font-size:14px;" aria-current="page" href="?page=register"> <i class="fa-light fa-user-plus"></i> สมัครสมาชิก</a> </li>
                        </ul> <?php } else { ?> <ul class="navbar-nav me-5 mt-2 mb-lg-0 ">
                            <li class="nav-item dropdown" style="list-style: none;"> <a class="nav-link active text-danger" style="font-size:14px" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:#343434;"> <i class="fa-solid fa-user-vneck-hair"></i> &nbsp;:&nbsp;โปร์ไฟล์ของฉัน </a>
                                <ul class="dropdown-menu shadow-sm p-2 me-3 ms-3 pt-2 pb-2 text-white" style="border-radius: 1vh;background-color:#2a2a2a;" aria-labelledby="navbarDropdown">
                                    <li> <a class="dropdown-item mb-1 text-danger disabled text-center"><small> &nbsp;&nbsp;ชื่อผู้ใช้ :<?php echo htmlspecialchars($user["username"]); ?></small></a> </li> <a class="dropdown-item mb-1 text-danger disabled text-center"><small> <i class="fa-duotone fa-circle-dollar" style="--fa-primary-color: #d8a301;--fa-secondary-color: #fefaf1;"></i>&nbsp;&nbsp;เครดิต : <?php echo $user["point"]; ?> </small> </a>
                                    <li> <a class="dropdown-item mb-1 text-danger disabled text-center"><small> &nbsp;&nbsp;ยอดเติมสะสม : <?php echo $user["total"]; ?></small></a> </li>
                            </li>
                            <div class="dropdown-divider text-white"></div>
                            <li><a class="dropdown-item tout mb-1 text-white" href="?page=profile&subpage=cimg"><small> <i class="fa-regular fa-user text-main fa-fade"></i> &nbsp;&nbsp;ตั่งค่าบัญชี</small></a></li> <?php if ($user["rank"] == "1") { ?> <li><a class="dropdown-item tout-1 mb-1" href="?page=backend"><small><i class="fa-duotone fa-money-check-dollar-pen"></i> &nbsp;จัดการร้านค้า [แอดมิน]</small></a></li> <?php } ?> <div class="dropdown-divider"></div>
                            <li> <a class="dropdown-item tout mb-2 text-center text-white" href="?page=logout"> <small> <i class="fa-duotone fa-right-to-bracket"></i>&nbsp;ออกจากระบบ </small></a>
                                <style>
                                    .tout {
                                        color: #f1f1f1;
                                    }

                                    .tout:hover {
                                        color: #d33131;
                                        border-radius: 1vh;
                                        background-color: #ffffff;
                                        filter: drop-shadow(10px 10px 50px red) invert(25%);
                                    }

                                    .tout-1 {
                                        color: #ff8401;
                                    }

                                    .tout-1:hover {
                                        color: #393939;
                                        border-radius: 1vh;
                                        filter: drop-shadow(10px 10px 20px red) invert(25%);
                                    }
                                </style>
                            </li>
                        </ul>
                        </li>
                        </ul> <?php } ?>
                </div>
            </div>
        </div>
    </nav> <?php function admin($user)
            {
                if (isset($_SESSION['id']) && $user["rank"] == "1") {
                    return true;
                } else {
                    return false;
                }
            }
            if (isset($_GET['page']) && $_GET['page'] == "menu") {
                require_once('page/simple.php');
            } elseif (isset($_GET['page']) && $_GET['page'] == "login" && !isset($_SESSION['id'])) {
                require_once('page/login.php');
            } elseif (isset($_GET['page']) && $_GET['page'] == "logout" && isset($_SESSION['id'])) {
                session_destroy();
                echo "<script>window.location.href = '';</script>";
            } elseif (isset($_GET['page']) && $_GET['page'] == "profile" && isset($_SESSION['id'])) {
                require_once('page/profile.php');
            } elseif (isset($_GET['page']) && $_GET['page'] == "games" && isset($_SESSION['id'])) {
                require_once('page/games.php');
            } elseif (isset($_GET['page']) && $_GET['page'] == "topup") {
                if (isset($_SESSION['id'])) {
                    require_once('page/topup.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "redeem") {
                if (isset($_SESSION['id'])) {
                    require_once('page/redeem.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "id") {
                if (isset($_SESSION['id'])) {
                    require_once('page/id.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "gp") {
                if (isset($_SESSION['id'])) {
                    require_once('page/gp.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "service") {
                if (isset($_SESSION['id'])) {
                    require_once('page/service.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "service_buy") {
                if (isset($_SESSION['id'])) {
                    require_once('page/service_buy.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "Topup_qr") {
                if (isset($_SESSION['id'])) {
                    require_once('page/topup_qrcode.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "steam") {
                if (isset($_SESSION['id'])) {
                    require_once('page/steam.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "product" && isset($_GET['id'])) {
                if (isset($_SESSION['id'])) {
                    require_once('page/product.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "slidebloxfruit") {
                if (isset($_SESSION['id'])) {
                    require_once('page/csgo_1.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "id_p" && isset($_GET['id'])) {
                if (isset($_SESSION['id'])) {
                    require_once('page/id_p.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "shop") {
                if (isset($_SESSION['id'])) {
                    require_once('page/shop.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "premiumapp") {
                if (isset($_SESSION['id'])) {
                    require_once('page/premiumapp.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "promotions") {
                if (isset($_SESSION['id'])) {
                    require_once('page/promotions.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "topupnew") {
                if (isset($_SESSION['id'])) {
                    require_once('page/promo/topupnew.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "openweb") {
                if (isset($_SESSION['id'])) {
                    require_once('page/promo/openweb.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "apppremium") {
                if (isset($_SESSION['id'])) {
                    require_once('page/apppremium.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "history_premium") {
                if (isset($_SESSION['id'])) {
                    require_once('page/history_premium.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "buyapp") {
                if (isset($_SESSION['id'])) {
                    require_once('page/buyapp.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "buy") {
                if (isset($_SESSION['id'])) {
                    require_once('page/buy.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "question") {
                if (isset($_SESSION['id'])) {
                    require_once('page/question.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "my_premiumapp") {
                if (isset($_SESSION['id'])) {
                    require_once('page/myapp.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "termgame") {
                if (isset($_SESSION['id'])) {
                    require_once('page/termgame.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "buy_termgame") {
                if (isset($_SESSION['id'])) {
                    require_once('page/buy_termgame.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "cashcard") {
                if (isset($_SESSION['id'])) {
                    require_once('page/cashcard.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "buy_cashcard") {
                if (isset($_SESSION['id'])) {
                    require_once('page/buy_cashcard.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "phoneTopup") {
                if (isset($_SESSION['id'])) {
                    require_once('page/phoneTopup.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "buy_phoneTopup") {
                if (isset($_SESSION['id'])) {
                    require_once('page/buy_phoneTopup.php');
                } else {
                    require_once('page/login.php');
                }
            } elseif (isset($_GET['page']) && $_GET['page'] == "register" && !isset($_SESSION['id'])) {
                require_once('page/register.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "backend") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "user_edit") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "product_manage") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "stock_manage" && $_GET['id'] != "") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "code_manage") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "slip_manage") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "mmn_manage") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "backend_buy_historyapi") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "product_managepeamsub") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "category_manage") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "backend_buy_history") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "backend_topup_history") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "carousel_manage") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "recom_manage") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "my_order") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "order") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "order_success") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "order_unsuccess") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "order_temp") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "service_manage") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "service_manage_cate") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "service_manage_main") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "service_his") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "crecom_manage") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "website") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "apibyshop") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "apibyshop_his") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "apigame") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "category_game") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "product_game") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "productrw_game" && $_GET['id'] != "") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "stock_game" && $_GET['id'] != "") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "histermgameAdmin") {
                require_once('page/backend/histermgameAdmin.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "peamsubproduct") {
                require_once('page/backend/menu_manage.php');
            } elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "history_topup_all_peamsub") {
                require_once('page/backend/menu_manage.php');
            } else {
                require_once('page/simple.php');
            } ?> <!-- Remove the container if you want to extend the Footer to full width. -->
    <div class="w3-container"> <!-- Footer -->
        <footer class="text-center text-lg-start" style="background-color: #07080a;color:#d1d1d1;font-size:14px;"> <!-- Style -->
            <style>
                .text-dd {
                    text-decoration: none;
                    color: #ff9f00;
                }

                .text-dd:hover {
                    color: #60c867;
                }

                .bank-img {
                    width: 100%;
                    border-radius: 4px;
                }

                .bank-img:hover {
                    filter: grayscale(100%);
                }
            </style> <!-- Grid container -->
            <div class="container p-4 pb-0 mt-5"> <!-- Section: Links -->
                <section class=""> <!--Grid row-->
                    <div class="row"> <!-- Grid column -->
                        <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                            <h6 class="text-uppercase mb-4 font-weight-bold" style="color:#af7322"> <?php echo $config['name'] ?> </h6> <img class="fw-normal mb-2" src="/logohod.png" width="185px">
                        </div> <!-- Grid column --> <!-- Grid column -->
                        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                            <h6 class="text-uppercase mb-4 font-weight-bold">แนะนำ</h6>
                            <p class="fw-normal"><a href="?page=topup" class="link-cor"><i class="fa-light fa-angle-right"></i> เติมเหรียญ</a> </p>
                            <p class="fw-normal"><a href="?page=question" class="link-cor"><i class="fa-light fa-angle-right"></i> วิธีใช้งานเว็บ?</a> </p>
                            <p class="fw-normal"><a href="?page=shop" class="link-cor"><i class="fa-light fa-angle-right"></i> ซื้อสินค้า</a> </p>
                        </div>
                        <style>
                            .link-cor {
                                text-decoration: none;
                                color: #d3d3d3;
                            }

                            .link-cor:hover {
                                color: #af7322;
                            }
                        </style> <!-- Grid column -->
                        <hr class="w-100 clearfix d-md-none" /> <!-- Grid column -->
                        <div class="col-md-3 col-lg-2 col-xl-4 mx-auto mt-3">
                            <div id="fb-root"></div>
                            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v19.0&appId=1193705631514661" nonce="KXxaXb9x"></script>
                            <div class="fb-page" data-href="<?php echo $config["fb"]; ?>" data-tabs="timeline" data-width="" data-height="130" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                                <blockquote cite="<?php echo $config["fb"]; ?>" class="fb-xfbml-parse-ignore"> <a href="<?php echo $config["fb"]; ?>"><?= $config['web_title'] ?></a> </blockquote>
                            </div>
                        </div>
                    </div> <!--Grid row-->
                </section> <!-- Section: Links -->
                <hr class="my-3"> <!-- Section: Copyright -->
                <section class="p-3 pt-0">
                    <div class="row d-flex align-items-center"> <!-- Grid column -->
                        <div class="col-md-7 col-lg-6 text-center text-md-start"> <!-- Copyright -->
                            <div class="p-3 fw-normal"> © 2024 Copyright: <a class="text-dd" target="_black" href="<?= $config['fb'] ?>"> <?php echo $config['name'] ?> </a> </div> <!-- Copyright -->
                        </div> <!-- Grid column --> <!-- Grid column -->
                        <div class="col-md-5 col-lg-6 ml-lg-0 text-center text-md-end"> <!-- Bank --> <a class="btn-floating m-1"> <img src="assets/img/bank.png" class="bank-img" alt=""> </a> <!-- Grid column --> </div>
                </section> <!-- Section: Copyright -->
            </div> <!-- Grid container -->
        </footer> <!-- Footer -->
    </div> <!-- End of .container --> <?php if ($_GET['true'] === "discord") { ?> <script>
            Swal.fire({
                icon: 'success',
                title: 'แจ้งเตือน',
                text: "เข้าสู่ระบบด้วย Discord สำเร็จ"
            }).then(function() {
                window.location = "?page=home";
            });
        </script> <?php } elseif ($_GET['error'] === "discord") { ?> <script>
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: "เข้าสู่ระบบด้วย Discord ไม่สำเร็จ"
            }).then(function() {
                window.location = "?page=home";
            });
        </script> <?php } elseif ($_GET['true'] === "line") { ?> <script>
            Swal.fire({
                icon: 'success',
                title: 'แจ้งเตือน',
                text: "เข้าสู่ระบบด้วย Line สำเร็จ"
            }).then(function() {
                window.location = "?page=home";
            });
        </script> <?php } elseif ($_GET['error'] === "line") { ?> <script>
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: "เข้าสู่ระบบด้วย Line ไม่สำเร็จ"
            }).then(function() {
                window.location = "?page=home";
            });
        </script> <?php } ?> <style>
        .shopbtn {
            border-radius: 1vh;
            background-color: #e34343;
            color: #fff;
        }

        .shopbtn:hover {
            background-color: #560000;
            color: #fff;
            filter: drop-shadow(8px 8px 20px red) invert(15%);
        }

        .tblu {
            text-transform: uppercase;
            background: linear-gradient(to right, #d51f1f 0%, #ff9f00 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none
        }

        .tbbg {
            text-decoration: none;
            font-size: 13px;
            color: #4d4d4d;
        }

        .tbbg:hover {
            text-transform: uppercase;
            background: linear-gradient(to right, #d51f1f 0%, #ff9f00 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
    <script>
        function tobuy(id, name, s, b) {
            $("#modal_title").html('<i class="fa-duotone fa-cart-shopping-fast"></i>&nbsp;&nbsp;' + name);
            $("#shop-btn").attr("data-id", id);
            $("#shop-btn").attr("data-name", name);
            $("#s").html(s);
            $("#b").html(b);
            const myModal = new bootstrap.Modal('#buy_count ', {
                keyboard: false
            }) myModal.show();
        }

        function detail(id) {
            var formData = new FormData();
            formData.append('id', id);
            $.ajax({
                    type: 'POST',
                    url: 'system/call/product_detail.php',
                    data: formData,
                    contentType: false,
                    processData: false,
                }).done(function(res) {
                    $("#p_img").attr("src", res.img);
                    $("#p_name").html(res.name);
                    $("#p_des").html(res.des);
                    const myModal = new bootstrap.Modal('#product_detail', {
                        keyboard: false
                    }) myModal.show();
                }).fail(function(jqXHR) {
                        console.log(jqXHR);
                        res = jqXHR.responseJSON;
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: res.message
                        }) //console.clear();});}
    </script>
    <script>
        async function shake_alert(status, result) {
                if (status) {
                    if (result.salt == "prize") { // await GShake();Swal.fire({icon: 'success', title: 'สำเร็จ', text: result.message }).then(function() {window.location = "?page=profile&subpage=buyhis";});}else {await GShake();Swal.fire({icon: 'error', title: 'เสียใจด้วย', text: result.message });}}else {if (result.salt == "salt") {// await GShake();Swal.fire({icon: 'error', title: 'เสียใจด้วย', text: result.message });}else {Swal.fire({icon: 'error', title: 'ผิดพลาด', text: result.message });}}}function buybox() {var name = $("#shop-btn").attr("data-name");var formData = new FormData();formData.append('id', $("#shop-btn").attr("data-id"));formData.append('count', $("#b_count").val());Swal.fire({title: 'ยืนยันการสั่งซื้อ?', text: "ยืนยันที่จะซื้อ " + name + " หรือไม่", icon: 'warning', showCancelButton: true, confirmButtonColor: '#3b2e69', cancelButtonColor: '#d33', confirmButtonText: 'ยืนยัน' }).then((result) => {if (result.isConfirmed) {$.ajax({type: 'POST', url: 'system/buybox.php', data: formData, contentType: false, processData: false, beforeSend: function() {$('#btn_buyid').attr('disabled', 'disabled');$('#btn_buyid').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>รอสักครู่...');}, }).done(function(res) {console.log(res) result = res;// await GShake();shake_alert(true, result);console.clear();$('#btn_buyid').html('<i class="fas fa-shopping-cart mr-1"></i>สั่งซื้อสินค้า');$('#btn_buyid').removeAttr('disabled');}).fail(function(jqXHR) {console.log(jqXHR) res = jqXHR.responseJSON;shake_alert(false, res);$('#btn_buyid').html('<i class="fas fa-shopping-cart mr-1"></i>สั่งซื้อสินค้า');$('#btn_buyid').removeAttr('disabled');});}}) }
    </script>
    <script>
        AOS.init(); // var options = {// strings: [`<?php //echo $s_info['des'];
                                                    ?>`], // typeSpeed: 40, // color: "#fff" // };// var typed = new Typed('#typing', options);
    </script>
</body>

</html>