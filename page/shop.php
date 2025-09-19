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
</style>




<div class="container-fluid p-0">
    <div class="container-sm  m-cent  p-0 pt-4 ">
        <div class="container-sm ">
            <div class="container-fluid">
                <div class="container-fluid pt-0 ">

                    <?php if (!isset($_GET['category'])) : ?>
                        <center class="mt-2 mb-2">
                            <span class="h4 ttcolor"><b>รายการสินค้าทั้งหมด</b></span>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb d-flex justify-content-center mt-0">
                                    <li class="breadcrumb-item ttcolor"><a href="?page=index" style="text-decoration: none; font-size:13px;"> หน้าหลัก</a></li>
                                    <li class="breadcrumb-item"><a href="?page=shop" style="text-decoration: none; color: #6C757D; font-size:13px;"> หมวดหมู่</a></li>

                                </ol>
                            </nav>


                        </center>



                    <?php else : ?>
                        <center class="mt-2 mb-2">
                            <span class="h4 ttcolor"><b>หมวดหมู่</b></span>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb d-flex justify-content-center mt-0">
                                    <li class="breadcrumb-item ttcolor"><a href="?page=index" style="text-decoration: none; font-size:13px;"> หน้าหลัก</a></li>
                                    <li class="breadcrumb-item"><a href="" disabled style="text-decoration: none; color: #6C757D; font-size:13px;"> <?= htmlspecialchars($_GET['category']); ?></a></li>

                                </ol>
                            </nav>
                        </center>


                    <?php endif ?>
                    <div class="d-flex justify-content-end">
                        <form id="searchForm " method="GET" class="mb-3">
                            <div class="input-group">
                                <div class="d-flex">
                                    <input name="page" value="shop" hidden />
                                    <input name="category" value="<?= htmlspecialchars($_GET['category']); ?>" hidden />
                                    <input type="text" class="form-control form-control-sec" placeholder="ระบุสินค้าที่ต้องการ" name="c_name">
                                    <button class="btn text-white" type="submit"><i class="fa-regular fa-magnifying-glass"></i> ค้นหา</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <style>
                        .form-control-sec {}

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


                    <div class="row justify-content-center justify-content-lg-start">
                        <?php
                        if (!isset($_GET['category'])) {
                            $cfind = dd_q("SELECT * FROM category ORDER BY RAND()");
                            $check = $cfind->rowCount();
                            if ($check == NULL) {
                                echo '<h6 class="text-secondary text-center">ไม่มีหมวดหมู่ในตอนนี้</h6>';
                            } elseif ($_GET['category'] == NULL) {
                                header('Location: ' . $_SERVER['HTTP_REFERER']);
                            }
                            while ($row = $cfind->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                                <div class="col-12 col-lg-6  mb-3">
                                    <a href="?page=shop&category=<?= htmlspecialchars($row['c_name']) ?>">
                                        <div class="img-anim content w-100">
                                            <img class="bg" src="<?= htmlspecialchars($row['img']) ?>">
                                            <div class="text font-bold">
                                                <?= htmlspecialchars($row['des']) ?>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <?php if ($row['showitem'] == 1) { ?>
                                    <div class="col-12 col-lg-6  mb-3">
                                        <a href="?page=shop&category=<?= htmlspecialchars($row['c_name']) ?>">
                                            <div class="img-anim w-100">
                                                <img class="bg" src="<?= htmlspecialchars($row['img']) ?>">
                                                <div class="text font-bold">
                                                    <?= htmlspecialchars($row['des']) ?>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php
                                }
                            }
                        } else {
                            if (isset($_GET['c_name'])) {
                                $c_name = $_GET['c_name'];
                                // ถ้ามีการระบุคำค้นหา c_name
                                $find = dd_q("SELECT * FROM box_product WHERE c_type = ? AND name LIKE ? ORDER BY  	price_vip DESC", [$_GET['category'], '%' . $c_name . '%']);
                            } else {
                                // ถ้าไม่มีการระบุคำค้นหา c_name
                                $find = dd_q("SELECT * FROM box_product WHERE c_type = ? ORDER BY price_vip DESC", [$_GET['category']]);
                            }
                            while ($row = $find->fetch(PDO::FETCH_ASSOC)) {
                                $stock = dd_q("SELECT * FROM box_stock WHERE p_id = ?", [$row["id"]]);
                                $count = $stock->rowCount();
                                if ($count === NULL) {
                                    $count = 0;
                                    echo '<h6 class="text-secondary text-center">ไม่มีหมวดหมู่ในตอนนี้</h6>';
                                }
                                // วนลูปผลลัพธ์ที่ค้นหาได้

                                // print_r($row);


                                ?>


                                <div class="col-6 col-lg-3 mb-4 px-1" data-aos="zoom-in">

                                    <div class="card-anim-main shadow p-1" style="border: solid 1px #282329; border-radius: 1vh; height: fit-content; background-color:#08080b; box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px; ">
                                        <div class="p-0">
                                            <a href="?page=buy&id=<?= $row['id'] ?>"></a>
                                            <div class="view overlay">



                                                <center>
                                                    <a href="?page=buy&id=<?= $row['id'] ?>">
                                                        <img class="img-fluid mb-1 hv-img" src="<?php echo htmlspecialchars($row["img"]); ?>" style="border-radius: 1vh 1vh 0 0; width: 100%; max-width: 100vh;">
                                                    </a>
                                                </center>

                                                <a href="#!">
                                                    <div class="mask rgba-white-slight"></div>
                                                </a>
                                            </div>

                                            <div class="card-body p-2 pt-2 pb-1">
                                                <h5 class="text-strongest mb-2 mt-1 fs-6" style="word-wrap: break-word; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color:#d5d5d5;"><?php echo htmlspecialchars($row["name"]); ?></h5>


                                                <p style="color:#868686; margin-bottom:0.3rem; font-size:10px;">ราคาสินค้า</p>
                                                <div class="">
                                                    <?php if ($user["vip_role"] == "1") { ?>
                                                        <?php if ($row['price_vip'] > 0) { ?>
                                                            <p class="text-main  align-self-center mb-0"> <strong style="color:#A30000;font-size:12px; line-height: 0.5;"><del><?php echo number_format($row['price']); ?> ฿ </del></strong></p>
                                                            <p class="text-main  align-self-center mb-2"> <strong style="color:#f0ab0c;font-size:18px;"><?php echo number_format($row['price_vip']); ?> ฿ </strong></p>
                                                        <?php } else { ?>
                                                            <p class="text-main  align-self-center mb-2"> <strong style="color:#f0ab0c;font-size:18px;"><?php echo number_format($row['price']); ?> ฿ </strong></p>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <p class="text-main  align-self-center mb-2"> <strong style="color:#f0ab0c;font-size:18px;"><?php echo number_format($row['price']); ?> ฿ </strong></p>
                                                    <?php } ?>
                                                </div>

                                                <span>
                                                    <?php
                                                    if ($count == "0") {
                                                        echo "<p class='' style='width: fit-content; color:#e81313; font-size:10px; background-color: #e8131042; padding: 1px 6px; border-radius:0.5vh;'>สินค้าหมด <i class='fa-sharp fa-light fa-xmark'></i></p>";
                                                    } else {
                                                        echo "<p class='' style='width: fit-content; color:#26180d; font-size:10px; font-weight:500; background-color: #ff9e00; padding: 1px 4px;; border-radius:0.5vh;'>มีสินค้า <i class='fa-regular fa-check'></i></p>";
                                                    }
                                                    ?>
                                                </span>

                                                <center>
                                                    <a href="?page=buy&id=<?= $row['id'] ?>">
                                                        <button class="bg-cus text-white w-100 mb-2 bbbbb " style="border-radius: 1vh;" onclick="tobuy(<?php echo $row['id'] ?>, '<?php echo htmlspecialchars($row['name']); ?>', '<?= $count ?>')">
                                                            <i class="fa-duotone fa-bag-shopping"></i> &nbsp;สั่งซื้อสินค้า
                                                        </button>
                                                    </a>

                                                    <!-- <button class="bg_xl mt-1 mb-1 btn " style="border-radius: 5vh; font-size:14px;">
                                <span class="text-secondary mt-4 mb-4" onclick="detail(<?php echo $row['id']; ?>)">
                                <i class="fa-duotone fa-circle-info fa-fade" style="--fa-primary-color: #0ea501; --fa-secondary-color: #0ea501;"></i>&nbsp;รายละเอียด  </span>
                            </button> -->
                                                </center>

                                                <style>
                                                    @media only screen and (max-width: 600px) {
                                                        .bbbbb {
                                                            width: 100%;

                                                        }

                                                    }
                                                </style>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                            <?php } ?>
                        <?php
                        }
                        ?>
                    </div>



                    <!-- </div>-->


                    <!-- Modal -->
                    <div class="modal fade" id="product_detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header" style="background-color:#030305">

                                    <i class="fa-sharp fa-solid fa-peach" style="color: #fbaca6;"></i>
                                    <h5 class="modal-title ttcolor" id="exampleModalLabel">
                                        &nbsp;&nbsp;รายละเอียดสินค้า</h5>
                                    <button type="button" class="btn-close" style="background-color:#ff9e00;" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body" style="background-color:#030305">
                                    <div class="col-lg-9 m-cent">
                                        <img src="assets/img/mysbox.png" class="img-fluid" style="border-radius:1vh;" id="p_img">
                                        <center class="mt-4">
                                            <h4 id="p_name" style="word-wrap: break-word; color:#f8f8f8;">N/A</h4>
                                        </center>

                                    </div>
                                    <div class="container-fluid ps-3 pe-3">
                                        <p class=" ttcolor m-0"><i class="fa-regular fa-info-circle"></i> รายละเอียดสินค้า </p>
                                        <p class="text-secondary" style="word-wrap: break-word; white-space:pre-wrap; " id="p_des">N/A

                                            <hr class=" mt-2 mb-2" style="filter: drop-shadow(10px 10px 50px red) invert(105%);">
                                            <b>
                                                <p class="mt-3" style="font-size:14px; color:#3e3e3e; font-weight:300;">
                                                    <span class=" ttcolor">⚠ คำเตือน :</span>
                                                    ระบบมีโอกาสเกิดข้อผิดพลาดได้ทุกเมื่อ <br>
                                                    โปรดอัดคลิปวีดิโอก่อนทำการซื้อสินค้าเพื่อเป็นหลักฐาน
                                                    หากไม่มีหลักฐานในการยืนยัน
                                                    ทางร้านขอสงวนสิทธิ์รับผิดชอบต่อความเสียหายที่เกิดขึ้น <i class="fa-duotone fa-shield-xmark fa-fade" style="--fa-primary-color: #dc141a; --fa-secondary-color: #dc141a;"></i>
                                            </b>
                                        </p><code style="color:#d74d4d;"> ADMIN@ BZKL//That</code>
                                        &nbsp;<a href="https://www.facebook.com/thasana.Cgos/" class="connect">สอบถามปัญหา</a>
                                    </div>
                                </div>
                                <div class="footer p-4" style="background-color:#030305">
                                    <button type="button" class="btn btn-secondary-dark w-100 bb-but" style="border-radius: 1vh; font-size:14px; background-color:#0d0c0c;" data-bs-dismiss="modal">
                                        ปิดรายละเอียดสินค้านี้</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <style>
                        .connect {
                            background-color: #a9aef9;
                            font-size: 12px;
                            padding: 0.2rem 0.8rem;
                            border-radius: 0.5vh;
                            color: #43488e;
                            text-decoration: none;
                        }

                        .connect:hover {
                            color: #a2a8f7;
                            background-color: #313562;
                        }

                        .bb-but:hover {
                            color: #ff6e6e;
                        }
                    </style>



                    <!-- END -->
                    <script src="system/js/countup.js"></script>
                </div>
            </div>
        </div>
    </div>