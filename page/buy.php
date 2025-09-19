<!-- PhotoSwipe CSS -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/default-skin/default-skin.min.css"> -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

<?php
if ($_GET['id'] != '') {
    $pdshop = dd_q("SELECT * FROM box_product WHERE id = ? LIMIT 1", [$_GET['id']]);
    if ($pdshop->rowCount() != 0) {
        $row_1 = $pdshop->fetch(PDO::FETCH_ASSOC);
        $count = dd_q("SELECT * FROM box_stock WHERE p_id = ?", [$row_1['id']])->rowCount();
?>
        <style>
            .help-button {
                color: #f2f2f2;
                text-decoration: none;
                background-color: #1d1e21;
                border-radius: 6px;
                font-weight: 300;
            }

            @media only screen and (max-width: 600px) {
                .help-button {
                    display: flex;
                    margin-top: 10px;
                }
            }

            .btn-dark-des {
                font-weight: 300;
                background-color: #222322;
                padding: 0.4rem 0.8rem;
                border-radius: 8px;
            }

            .frominput-product {
                background-color: #2e2e2e;
                border: none;
                color: #e3e3e3
            }

            .minus {
                background-color: #2e2e2e;
                border: none;
                color: #e3e3e3
            }

            .plus {
                background-color: #2e2e2e;
                border: none;
                color: #e3e3e3
            }

            .box-price {
                border: solid 1px #212224;
                border-radius: 8px;
                background-color: #101012;
                font-weight: 400;
            }

            .box-price-1 {
                border-radius: 8px;
                background: linear-gradient(to right, #4b8e41 0%, #4a7554 100%);
            }

            .connect {
                text-align: center;
                font-size: 12px;
                font-weight: 300;
                border-radius: 0.5vh;
                color: #43488e;
                text-decoration: none;
            }

            .connect:hover {
                color: #a2a8f7;
                background-color: #313562;
            }

            .carousel {
                overflow: hidden;
            }

            .carousel-inner {
                border-radius: 1vh;
                transition: all .35s ease;
            }

            .owl-item>.item>img {
                width: auto;
                max-height: 50px;
                border-radius: 0.5vh;
                border: 2px solid #2e2e2e00;
                object-fit: cover;
                cursor: pointer;
                transition: all .35s ease;
            }

            .owl-item:hover>.item>img {
                border: 2px solid var(--main);
            }

            .owl-item.active>.item>img {
                border: 2px solid var(--main);
            }
        </style>
        <div class="mt-3 mb-3">
            <div class="container-sm">
                <div class="<?php echo $bg ?> shadow p-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb d-flex justify-content-center mt-3">
                            <li class="breadcrumb-item"><a href="?page=shop" style="text-decoration: none; color: #6C757D;"> สินค้าทั้งหมด</a></li>
                            <li class="breadcrumb-item"><a href="?page=shop&category=<?= htmlspecialchars($row_1['c_type']) ?>" style="text-decoration: none; color: #6C757D;"> <?= htmlspecialchars($row_1['c_type']) ?></a></li>
                            <li class="breadcrumb-item" aria-current="page" style="color: var(--font)"><?= htmlspecialchars($row_1['name']) ?></li>
                        </ol>
                    </nav>
                    <div class="row">
                        <div class="col-12 col-lg-6 p-3">
                            <div id="PDCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="<?= htmlspecialchars($row_1['img']) ?>" class="img-fluid d-block w-100">
                                    </div>
                                    <?php
                                    $pd_imgs = dd_q("SELECT img FROM product_imgs WHERE pid =  ? ORDER BY id ASC ", [$row_1['id']]);
                                    while ($row = $pd_imgs->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <div class="carousel-item">
                                            <img src="<?= htmlspecialchars($row['img']) ?>" class="img-fluid d-block w-100">
                                        </div>
                                    <?php } ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#PDCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#PDCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                            <div class="owl-carousel owl-theme mt-2">
                                <div class="item">
                                    <img class="imgowl" src="<?= htmlspecialchars($row_1['img']) ?>" data-image-id="0">
                                </div>
                                <?php
                                $i = 1;
                                $pd_imgs2 = dd_q("SELECT img FROM product_imgs WHERE pid = ? ORDER BY id ASC ", [$row_1['id']]);
                                while ($row = $pd_imgs2->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <div class="item">
                                        <img class="imgowl" src="<?= htmlspecialchars($row['img']) ?>" data-image-id="<?= $i ?>">
                                    </div>
                                <?php
                                    $i++;
                                }
                                ?>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 p-3 ">
                            <p class="ttcolor-1 mt-1" style="text-decoration: none; margin-top:-1.2rem;">ชื่อสินค้า : <b><?= htmlspecialchars($row_1['name']) ?><b></p>
                            <h3 style="color:#e35252"> โปรดอ่านก่อนทำการสั่งซื้อ </h3>
                            <p style="color:#b82323; MARGIN-TOP:-10px;  font-weight:300;">อ่านรายละเอียดได้ด้านล่างนี้!</p>

                            <div class="<?php echo $bg ?> p-3 rounded">
                                <div class="row" style="color:#8e8e8e; margin-top:-1rem;">
                                    <!-- รายละเอียด -->
                                    <div class="col-auto  mb-2 p-2 pe-3 ps-3">รายละเอียดสินค้า <i class="fa-duotone fa-circle-exclamation fa-fade"></i></div>
                                    <br>

                                    <!-- รายละเอียดของสินค้า -->
                                    <h5 class="text-secondary box-price p-2 ps-3" style="word-wrap: break-word; white-space:pre-wrap; font-size:16px; font-weight:200;"><?= htmlspecialchars($row_1['des']) ?></h5>

                                    <span class="m-0 align-self-center" style="font-weight:500; float:left; line-height: 0.9;">
                                        <?php if ($user["vip_role"] == "1") { ?>
                                            <?php if ($row_1['price_vip'] > 0) { ?>
                                                ราคา <strong style="color:#A30000;font-size:16px;"><del><?php echo number_format($row_1['price']); ?> ฿ </del></strong> <br>ลดเหลือ <strong style="color:#f0ab0c;font-size:20px;"><?php echo number_format($row_1['price_vip']); ?> ฿ </strong>
                                            <?php } else { ?>
                                                ราคา <strong style="color:#f0ab0c;font-size:20px;"><?php echo number_format($row_1['price']); ?> ฿ </strong>
                                            <?php } ?>
                                        <?php } else { ?>
                                            ราคา <strong style="color:#f0ab0c;font-size:20px;"><?php echo number_format($row_1['price']); ?> ฿ </strong>
                                        <?php } ?>
                                    </span>


                                    <p class="mt-3" style="font-size:14px; color:#3e3e3e; font-weight:300;">
                                        <b>
                                            <span class=" ttcolor">⚠ คำเตือน :</span>
                                            ระบบมีโอกาสเกิดข้อผิดพลาดได้ทุกเมื่อ <br>
                                            โปรดอัดคลิปวีดิโอก่อนทำการซื้อสินค้าเพื่อเป็นหลักฐาน
                                            หากไม่มีหลักฐานในการยืนยัน
                                            ทางร้านขอสงวนสิทธิ์รับผิดชอบต่อความเสียหายที่เกิดขึ้น <i class="fa-duotone fa-shield-xmark fa-fade" style="--fa-primary-color: #dc141a; --fa-secondary-color: #dc141a;"></i>
                                        </b>
                                    </p>
                                    &nbsp;

                                    <!-- จำนวนสินค้าที่ต้องการ -->

                                    <div class=" mt-4" style="text-align:right">
                                        จำนวนสินค้าที่ต้องการ <i class="fa-duotone fa-circle-plus"></i></div>
                                    <div class="d-grid mt-2">

                                        <!--  <div class="group">
                                                <svg stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="icon">
                                                <path d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" stroke-linejoin="round" stroke-linecap="round"></path>
                                                </svg>
                                                <input class="input form-control text-center quantity"  name="quantity" value="1" id="b_count" min="0">
                                     </div>
 -->
                                        <div class="input-group">
                                            <!--  <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()"
                                                class="minus input-group-text rounded-start rounded-0">-</button>
 -->
                                            <input class="form-control text-center quantity frominput-product" id="b_count" min="0" name="quantity" value="1">

                                            <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus input-group-text rounded-end rounded-0" style="font-weight:300; font-size:12px; color:#727272">
                                                ระบุจำนวนสินค้า
                                            </button>
                                            <button class="btn w-40 p-2 box-price-1 text-white" id="shop-btn" onclick="buybox()" data-id="<?= $row_1['id'] ?>" data-name="<?= $row_1['name'] ?>" data-price="<?= $row_1['price'] ?>"> สั่งซื้อสินค้า</button>
                                        </div>
                                    </div>
                                    <!-- <div class="mb-2">
                                        <input type="number" id="b_count" class="form-control text-center" value="1">
                                    </div> -->
                                </div>
                                <center>
                                    <p class="mt-3" style="font-size:13px; color:#444444; font-weight:300"><i class="fa-duotone fa-circle-exclamation fa-fade fa-sm" style="--fa-primary-color: #e22126; --fa-secondary-color: #e22126;"></i>
                                        อ่านให้ครบก่อนสั่งซื้อ หากซื้อแล้วถือว่าท่านยินยอม ทางเราจะไม่มีการคืนเงินทุกกรณี </p>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
            <script>
                $(document).ready(function() {
                    function adjustCarouselHeight() {
                        var activeItem = $('#PDCarousel .carousel-item.active img');
                        var carouselInner = $('#PDCarousel .carousel-inner');
                        carouselInner.css('height', activeItem.height());
                    }

                    adjustCarouselHeight();

                    $('#PDCarousel').on('slid.bs.carousel', function() {
                        adjustCarouselHeight();
                    });

                    $(window).on('resize', function() {
                        adjustCarouselHeight();
                    });

                    $('.owl-carousel').owlCarousel({
                        loop: false,
                        margin: 5,
                        nav: false,
                        dots: false,
                        autoWidth: true,
                        height: "50px",
                        responsive: {
                            0: {
                                items: 4
                            }
                        }
                    });

                    $('.owl-carousel .owl-item').click(function() {
                        var index = $(this).index();
                        $('.carousel').carousel(index);
                    });

                    $('#PDCarousel').on('slid.bs.carousel', function() {
                        var index = $('.carousel-item.active').index();
                        $('.owl-carousel').trigger('to.owl.carousel', [index, 300]);
                        $('.owl-carousel .owl-item').removeClass('active');
                        $('.owl-carousel .owl-item').eq(index).addClass('active');
                    });
                });
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


<!-- 
        <center>
            <div class="row">
                <div class="col mt-2">
                <h5 class="ttcolor">วิธีการสั่งซื้อ</h5>
                    <div class="embed-responsive embed-responsive-16by9 mt-2">
                        <iframe class="embed-responsive-item"  style="border-radius:0.5vh;" 
                            src="https://www.youtube.com/embed/fve-q-rn2xg" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </center>
-->


<!-- <style>
    .ttcolor {

        text-transform: uppercase;
        background: linear-gradient(to right, #ff4040 0%, #ff9e00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .ttcolor-1 {

        text-transform: uppercase;
        background: linear-gradient(to right, #4a7554 0%, #89dd81 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style> -->


<!-- PhotoSwipe HTML structure -->
<!-- <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                <button class="pswp__button pswp__button--share" title="Share"></button>
                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>
            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>
            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>
            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div> -->


<!-- PhotoSwipe JavaScript -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe-ui-default.min.js"></script> -->

<!-- Initialize PhotoSwipe -->
<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        var galleryElements = document.querySelectorAll('.gallery-item');

        galleryElements.forEach(function(element) {
            element.addEventListener('click', function(event) {
                event.preventDefault();

                var items = [{
                    src: element.querySelector('img').getAttribute('src'),
                    w: element.querySelector('img').naturalWidth,
                    h: element.querySelector('img').naturalHeight
                }];

                var options = {
                    index: 0,
                    shareEl: false
                };
                var gallery = new PhotoSwipe(document.querySelector('.pswp'), PhotoSwipeUI_Default, items, options);
                gallery.init();
            });
        });
    });
</script> -->


<!-- <style>
    .group {
        display: flex;
        line-height: 30px;
        align-items: center;
        position: relative;
        max-width: 200px;
    }

    .input {
        width: 100%;
        height: 45px;
        line-height: 30px;
        padding: 0 5rem;
        padding-left: 3rem;
        border: 2px solid transparent;
        border-radius: 10px;
        outline: none;
        background-color: #f8fafc;
        color: #0d0c22;
        transition: .5s ease;
    }

    .input::placeholder {
        color: #94a3b8;
    }

    .input:focus,
    input:hover {
        outline: none;
        border-color: rgba(129, 140, 248);
        background-color: #fff;
        box-shadow: 0 0 0 5px rgb(129 140 248 / 30%);
    }

    .icon {
        position: absolute;
        left: 1rem;
        fill: none;
        width: 1rem;
        height: 1rem;
    }
</style> -->