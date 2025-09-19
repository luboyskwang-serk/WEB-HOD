<?php
?>
<style>
    .ttcolor {
        text-transform: uppercase;
        background: linear-gradient(to right, #af7322 0%, #b48c00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .bg-cus {
        font-size: 13px;
        padding: 0.5rem 1rem;
        border: none;
        background: linear-gradient(to right, #af7322 0%, #b48c00 100%);
        color: #fff;
    }

    .bg-cus:hover {
        background: #8c6a00;
    }


    .img-anim {
        position: relative;
        text-align: center;
        overflow: hidden;
        border-radius: 1vh;
    }

    .img-anim img {
        width: 100%;
        height: auto;
        margin-left: auto;
    }

    .img-anim>img {
        background-size: cover;
        background-position: center;
        transition: all 0.3s ease;
    }

    .img-anim>div.bg {
        position: absolute;
        z-index: 2;
        opacity: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(1, 1, 1, 0.3);
        transition: all 0.3s ease;
    }

    .img-anim>div.text {
        position: absolute;
        z-index: 3;
        top: 120%;
        left: 30%;
        opacity: 0;
        text-transform: uppercase;
        background: linear-gradient(to right, #ff4040 0%, #ff9e00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 13px;
        border-bottom: 1px solid transparent;
        border-image: linear-gradient(to right, #e7e2ea, #ff8000);
        border-image-slice: 1;
        transform: translate(-50%, -50%);
        transition: all 0.3s ease;
    }

    .img-anim:hover>img {
        transform: scale(1.1);
    }

    .img-anim:hover>div {
        opacity: 1;
    }

    .img-anim:hover>div.text {
        top: 80%;
        opacity: 1;
    }

    .content {
        height: auto;
        transition: all .5s ease;
    }

    .content:hover {
        border: 1px solid #ff8000;
    }

    .font-bold {
        font-weight: 700;
    }

    .font-semibold {
        font-weight: 600;
    }

    .border-hov {
        border: 1px solid #ccc;
        transition: 0.3s ease-in-out;
    }
</style>
<div class="container-fluid p-0">
    <div class="container-sm  m-cent  p-0 pt-4 ">
        <div class="container-sm ">
            <div class="container-fluid">
                <div class="container-fluid pt-0 ">
                    <?php if (!isset($_GET['t'])) { ?>
                        <center class="mt-2 mb-2">
                            <span class="h4 ttcolor"><b>เกมสุ่มทั้งหมด</b></span>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb d-flex justify-content-center mt-0">
                                    <li class="breadcrumb-item ttcolor"><a href="?page=index" style="text-decoration: none; font-size:13px;"> หน้าหลัก</a></li>
                                    <li class="breadcrumb-item"><a href="?page=shop" style="text-decoration: none; color: #6C757D; font-size:13px;"> เกมสุ่ม</a></li>
                                </ol>
                            </nav>
                        </center>
                        <div class="card-body" style="margin-bottom: 18%;">
                            <div class="container">
                                <div class="row text-center mx-auto">
                                    <?php
                                    $sh = dd_q("SELECT * FROM game ORDER BY id DESC");
                                    $check = $sh->rowCount();
                                    if ($check  == NULL) {
                                        echo '<h6 class="text-secondary text-center">ไม่มีเกมในตอนนี้</h6>';
                                    }
                                    while ($row = $sh->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <div class="col-xl-6 text-center mx-auto hover-up">
                                            <div class="text-center mx-auto hover-up">
                                                <div class="text-center mx-auto mb-3 hover-up">
                                                    <a href="/?page=games&t=spin&id=<?php echo $row['id']; ?>">
                                                        <div class="img-anim content w-100">
                                                            <img class="bg" src="<?= htmlspecialchars($row['img']) ?>">
                                                            <div class="text font-bold">
                                                                <?= htmlspecialchars($row['name']) ?>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <style type="text/css">
                            .img-thumbnail-image {
                                background-color: black;
                                border: 1px;
                                border-radius: 10px;
                                max-width: 100%;
                                height: auto;
                            }

                            .single-banner-item .banner-image a img {
                                width: 80%;
                                -webkit-border-radius: 5px;
                                transition: all .5s ease;
                                border-radius: 25px;
                            }

                            .single-banner-item {
                                position: relative;
                            }

                            .single-banner-item {
                                position: relative
                            }

                            .single-banner-item .banner-image a {
                                display: block;
                            }

                            .single-banner-item .banner-image a img {
                                width: 500px;
                                -webkit-border-radius: 5px;
                                transition: all .5s ease;
                                border-radius: 25px;
                            }

                            .single-banner-item .banner-image a:hover img {
                                /* -webkit-filter: brightness(120%); */
                                /* filter: brightness(120%); */
                                -webkit-filter: grayscale(100%);
                                /* Safari 6.0 - 9.0 */
                                filter: grayscale(100%);
                                box-shadow: 0 px 0 6px rgba(0, 0, 0, .7);
                                /* -webkit-transform: scale(1.02); */
                                /* transform: scale(1.02); */
                                border-radius: 15px;
                            }
                        </style>
                        <?php } elseif (isset($_GET['t']) && $_GET['t'] === 'spin') {
                        $fp = dd_q("SELECT * FROM game WHERE id = ? ", [$_GET['id']]);
                        if ($fp->rowCount() == 1) {
                            $pd = $fp->fetch(PDO::FETCH_ASSOC);
                        ?>
                            <style>
                                img.spin-reward {
                                    transform: rotate(90deg) translate(-0px, -25%) translateY(0px) !important;
                                    max-height: 150px;
                                    width: auto;
                                }

                                @media only screen and (max-width: 770px) {
                                    img.spin-reward {
                                        max-height: 130px;
                                    }
                                }

                                @media only screen and (max-width: 420px) {
                                    img.spin-reward {
                                        max-height: 100px;
                                    }
                                }

                                .btn.btn-spin {
                                    color: var(--main);
                                    background: <?= $config['main_color'] ?>30;
                                    border: 1.5px solid var(--main);
                                    transition: all .55s ease;
                                }

                                .btn.btn-spin:hover {
                                    color: #fff;
                                    background: <?= $config['main_color'] ?>;
                                }
                            </style>
                            <link rel="stylesheet" type="text/css" href="assets/spin/easywheel.min.css" />
                            <script type="text/javascript" src="assets/spin/jquery.easywheel.min.js"></script>

                            <div class="spinner"></div>

                            <div class="col-12 col-lg-4 m-auto mt-3 mb-4">
                                <center>
                                    <p class="bubble-main text-white"><i class="bx bx-wallet" style="transform: translateY(1px);"></i> เครดิตของคุณ : <span id="credit"><?= number_format($user['point'], 2) ?></span> บาท</p>
                                    <h5 class="text-muted" style="white-space: pre-wrap; width: 100%;">ราคารอบละ : <span class="text-main"><?= number_format($pd['price'], 2) ?> บาท</span></h5>
                                    <button class="btn btn-spin btn-main w-100 d-flex justify-content-center align-items-center" onclick="f()"><i class="fa-regular fa-dice mb-1"></i>&nbsp;<span>สุ่มเลย</span></button>
                                </center>
                            </div>
                            <script>
                                jQuery(document).ready(function() {
                                    tick = new Audio('dist/tick.mp3');
                                    $('.spinner').easyWheel({
                                        items: [
                                            <?php
                                            $get_user = dd_q("SELECT * FROM game_item WHERE p_id = ?  ORDER BY id ASC", [$_GET['id']]);
                                            while ($row = $get_user->fetch(PDO::FETCH_ASSOC)) {
                                            ?> {
                                                    name: '<img src="<?= htmlspecialchars($row['img']) ?>"  class="spin-reward">',
                                                    id: '<?= $row['id'] ?>',
                                                    message: '<?= htmlspecialchars($row['name']) ?>',
                                                    color: "<?= htmlspecialchars($row['bg']) ?>",
                                                },
                                            <?php
                                            }
                                            ?>
                                        ],
                                        duration: 8000,
                                        rotates: 8,
                                        frame: 1,
                                        easing: "easyWheel",
                                        rotateCenter: false,
                                        type: "spin",
                                        markerAnimation: true,
                                        centerClass: 0,
                                        width: 600, //size ของ วงล้อ (หน่วยเป็น px)
                                        fontSize: 13,
                                        textOffset: 10,
                                        letterSpacing: 0,
                                        textLine: "v",
                                        textArc: false,
                                        shadowOpacity: 0,
                                        sliceLineWidth: 1,
                                        outerLineWidth: 5,
                                        centerWidth: 40,
                                        centerLineWidth: 3,
                                        centerImageWidth: 20,
                                        textColor: "#fff",
                                        markerColor: "rgb(231, 76, 60)",
                                        // centerLineColor: "#32343d",
                                        centerBackground: "#FF0000", //สีกลางวงล้อ
                                        centerBackground: "transparent",
                                        centerImage: '<?= htmlspecialchars($config['logo']) ?>',
                                        centerWidth: 40,
                                        centerImageWidth: 40,
                                        sliceLineColor: "<?= htmlspecialchars($pd['border']) ?>",
                                        outerLineColor: "<?= htmlspecialchars($pd['border']) ?>",
                                        shadow: "#000",
                                        selectedSliceColor: "rgb(66, 66, 66)",
                                        button: '.btn-spin',
                                        frame: 1,
                                        ajax: {
                                            url: 'system/game_play.php',
                                            type: 'POST',
                                            data: {
                                                id: <?= htmlspecialchars($_GET['id']) ?>
                                            },
                                            success: function(msg) {},
                                            error: function(msg) {
                                                result = msg.responseJSON;
                                                Swal.fire({
                                                    title: "ขออภัย",
                                                    icon: 'error',
                                                    text: result.message
                                                });
                                            }
                                        },
                                        onStart: function(results, spinCount, now) {},
                                        onStep: function(results, slicePercent, circlePercent) {
                                            if (typeof tick.currentTime !== 'undefined')
                                                tick.currentTime = 0;
                                            tick.play();
                                        },
                                        onProgress: function(results, spinCount, now) {
                                            $(".btn-spin").attr("disabled", true);
                                            $(".btn-spin").html("รอสักครู่...");
                                        },
                                        onComplete: function(results, count, now) {
                                            $(".btn-spin").attr("disabled", false);
                                            $(".btn-spin").html("เริ่มการสุ่ม");
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'คุณได้รับ',
                                                footer: '<a href="?page=profile&subpage=buyhis">ดูของรางวัล</a>',
                                                text: results.message,
                                            }).then(function() {
                                                window.location.reload();
                                            });
                                        },
                                        onFail: function(results, spinCount, now) {},
                                    });
                                });
                            </script>
                        <?php }
                    } else { ?>
                        <script>
                            window.location = "/?page=games";
                        </script>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>