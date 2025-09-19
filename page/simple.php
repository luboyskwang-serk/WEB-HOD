<?php $curl = curl_init();
curl_setopt_array($curl, array(CURLOPT_URL => 'https://peamsub24hr.online/api/api_product', CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => '', CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 0, CURLOPT_FOLLOWLOCATION => true, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => 'GET',));
$response = curl_exec($curl);
curl_close($curl);
$load_packz = json_decode($response);
foreach ($load_packz as $data) {
    $id = $data->id;
    $name = $data->name;
    $img = $data->img;
    $des = $data->des;
    $price = $data->price;
    $pricevip = $data->pricevip;
    $agent = $data->agent_price;
    $stock = $data->stock;
    $c_type = $data->c_type;
    $stmt = dd_q("SELECT * FROM apipeam_product WHERE id = ? ", [$id]);
    $resultpd = $stmt->fetch();
    $updatestock = dd_q("UPDATE apipeam_product SET stock = ? WHERE id = ? ", [$stock, $id]);
    $updatepricestock = dd_q("UPDATE apipeam_product SET price_default = ? , name = ? WHERE id = ? ", [$pricevip, $name, $id]);
    if ($stmt->RowCount() > 0) {
    } else {
        $product = dd_q("INSERT INTO apipeam_product (id, name, price_default, price,img, stock, c_type, des,showitem) VALUES (?, ?, ? , ? , ?, ?, ?, ? , ? )", [$id, $name, $pricevip, $price, $img, $stock, $c_type, $des, '0',]);
    }
}
?> <!-- Start -->
<style>
    .shops {
        padding: 20px;
        border-radius: 1vh;
    }

    .shops-body {
        position: relative;
        color: #fff;
        font-weight: 600;
        height: 100%;
    }

    .shops-body>.shops-img {
        width: 100%;
        height: 100%;
        border-radius: 1vh;
        transition: all .5s ease;
    }

    .shops-body>.shops-img:hover {
        transform: scale(1.035);
    }

    .shops-body>.shops-text-center {
        position: absolute;
        top: 80%;
        left: 20%;
        transform: translate(-50%, -50%);
        opacity: 0;
        transition: all .5s ease;
    }

    .shops-body:hover>.shops-text-center {
        left: 50%;
        opacity: 1;
        font-size: 30px;
        padding: 0 20px;
        border-radius: 2vh;
        background-color: var(--main);
    }
</style>
<style>
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
        top: 50%;
        left: 30%;
        opacity: 0;
        color: #fff;
        font-size: 20px;
        border-bottom: 1px solid transparent;
        border-image: linear-gradient(to right, #d53535, #ff8b00);
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
        border: 3px solid rgba(0, 0, 0, .3);
        transition: all .5s ease;
    }

    .content:hover {
        border: 3.5px solid var(--main);
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

    #font-color-cs {
        text-transform: uppercase;
        background: linear-gradient(to right, #d51f1f 0%, #ff9f00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .tx-box2 {
        padding: 0.8rem;
        color: #62ac58;
        font-size: 12px;
        background-color: #0ab20a0a;
        border-radius: 5px;
        border: solid 0.5px #4ca73f;
    }

    .tx-box2:hover {
        color: #fff;
        text-transform: uppercase;
        font-weight: 500;
        background: linear-gradient(to right, #1A2317 10%, #56714D 30%, #C3FFAE 60%, #0E150F 98%, #1A2317 100%);
        background-size: auto auto;
        background-clip: border-box;
        background-size: 200% auto;
        color: #fff;
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: textclip 2.5s linear infinite;
        display: inline-block;
    }
</style>
<div class="col-lg mt-1 p-0 ">
    <div class="p-3 pt-0 pb-0 m-cent">
        <div id="carouselExampleControls" class="carousel slide border-spe carousel-fade" data-bs-ride="carousel" style="border-radius: 1vh;
border:none;
">
            <div class="carousel-inner" style="border-radius: 1vh;
"> <?php $active = false;
    $find = dd_q("SELECT * FROM carousel");
    while ($row = $find->fetch(PDO::FETCH_ASSOC)) {
    ?> <div class="carousel-item <?php if (!$active) {
                                        echo "active";
                                        $active = true;
                                    }
                                    ?>"> <img src="<?php echo $row['link'] ?>" class="d-block w-100" alt="..." style="border-radius: 1vh;
    "> </div> <?php
            }
                ?> </div> <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="visually-hidden">Previous</span> </button> <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="visually-hidden">Next</span> </button>
        </div>
    </div>
</div>
<div class="container col-lg mb-2" style="margin-top:1rem;
"> <!-- text เลื่อน ประกาศ -->
    <div class="mt-1 mb-1">
        <div class="input-group">
            <div class="input-group-prepend"> <span class="input-group-text bg-card text-light btn-outline-dark" style="box-shadow: rgba(0, 0, 0, 0.08) 0px 4px 12px;
background-color:#151517;
"> <span style="color:#d9d9d9;
font-size:13px;
"><i class='bx bxs-party'></i> &nbsp;
                        ประกาศ </span> </div>
            <marquee class="form-control bg-card ms-1 btn btn-outline-dark" style="background: #181717;
color:#a4a4a4;
border-radius:0.5vh;
font-size:13px;
font-family:'kanit'">
        </div> <?php echo $config['ann'];
                ?> </marquee>
    </div>
</div> <!-- text เลื่อน ประกาศ --> </div> <!-- <div class="container-fluid mb-2 mt-4" data-aos="fade-up"> <div class="container m-cent pt-2"> <div class="row justify-content-between"> <div class="col-6 col-lg-3 mb-2" data-aos="fade-left"> <div class="image-swap "> <a href="?page=topup"> <img src="<?php echo $config['c1_dedazen'];
                                                                                                                                                                                                                                                                                                            ?>" class="img-fluid w-100" style="border-radius:2vh;
"> </a> </div> </div> <div class="col-6 col-lg-3 mb-2" data-aos="fade-left"> <div class="image-swap "> <a href="?page=termgame"> <img src="<?php echo $config['c2_dedazen'];
                                                                                                                                            ?>" class="img-fluid w-100" style="border-radius:2vh;
"> </a> </div> </div> <div class="col-6 col-lg-3 mb-2" data-aos="fade-left"> <div class="image-swap "> <a href="?page=shop"> <img src="<?php echo $config['c3_dedazen'];
                                                                                                                                        ?>" class="img-fluid w-100" style="border-radius:2vh;
"> </a> </div> </div> <div class="col-6 col-lg-3 mb-2" data-aos="fade-left"> <div class="image-swap "> <a href="?page=apppremium"> <img src="<?php echo $config['c4_dedazen'];
                                                                                                                                                ?>" class="img-fluid w-100" style="border-radius:2vh;
"> </a> </div> </div> </div> </div> </div> -->
<div class="container mb-4 mt-4" data-aos="fade-left">
    <div class="row justify-content-center">
        <div class="col col-lg-2">
            <div class="card-dz pe-4 ps-4 mb-2"> <a href="?page=topup" class="text-dz">
                    <div class="col-4"> <img class="img-fluid author-avatar" src="/dz/manu/duuz1.png" alt=""> </div>
                    <div class="col-md-8"> <span style="font-size:12px;
color:#44464d">| เติมเงินเข้าเว็บ</span>
                        <p class="text-dz text-muted">เติมเหรียญ Dz</p>
                    </div>
                </a> </div>
        </div>
        <div class="col-6 col-lg-2">
            <div class="card-dz pe-4 ps-4 mb-2"> <a href="?page=termgame" class="text-dz">
                    <div class="col-4"> <img class="img-fluid author-avatar" src="/dz/manu/topup1.png" alt=""> </div>
                    <div class="col-md-8"> <span style="font-size:12px;
color:#44464d">| GAME TOPUP</span>
                        <p class="text-dz text-muted">เติมเกมส์</p>
                    </div>
                </a> </div>
        </div>
        <div class="col-6 col-lg-2">
            <div class="card-dz pe-4 ps-4 mb-2"> <a href="?page=shop" class="text-dz">
                    <div class="col-4"> <img class="img-fluid author-avatar" src="/dz/manu/shop1.png" alt=""> </div>
                    <div class="col-md-8"> <span style="font-size:12px;
color:#44464d">| เลือกซื้อสินค้า</span>
                        <p class="text-dz text-muted">ร้านค้า</p>
                    </div>
                </a> </div>
        </div>
        <div class="col-6 col-lg-2">
            <div class="card-dz pe-4 ps-4 mb-2"> <a href="?page=question" class="text-dz">
                    <div class="col-4"> <img class="img-fluid author-avatar" src="/dz/manu/contact1.png" alt=""> </div>
                    <div class="col-md-8"> <span style="font-size:12px;
color:#44464d">| พบเจอปัญหา?</span>
                        <p class="text-dz text-muted">ติดต่อเรา</p>
                    </div>
                </a> </div>
        </div>
        <div class="col-6 col-lg-2">
            <div class="card-dz pe-4 ps-4 mb-2"> <a href="" class="text-dz">
                    <div class="col-4"> <img class="img-fluid author-avatar" src="/dz/manu/howto1.png" alt=""> </div>
                    <div class="col-md-8"> <span style="font-size:12px;
color:#44464d">| ดูวิธีการใช้งาน</span>
                        <p class="text-dz text-muted">วิธีใช้งาน</p>
                    </div>
                </a> </div>
        </div>
        <div class="col-6 col-lg-2">
            <div class="card-dz pe-4 ps-4 mb-2"> <a href="#!" class="text-dz">
                    <div class="col-4"> <img class="img-fluid author-avatar" src="/dz/manu/redeem1.png" alt=""> </div>
                    <div class="col-md-8"> <span style="font-size:12px;
color:#44464d">| เร็วๆนี้</span>
                        <p class="text-dz text-muted">แลกของรางวัล</p>
                    </div>
                </a> </div>
        </div>
    </div>
</div>
<style>
    .text-dz {
        text-decoration: none;
        color: #c3c3c3;
        margin-top: -0.3rem;
    }

    .card-dz {
        background-color: #0f0f0f;
        border-radius: 1vh;
        border: solid 1px #232326;
    }

    .card-dz img {
        padding-top: 0.1rem;
        width: 45px;
    }
</style> <!-- หมวดหมู่แนะนำ -->
<center>
    <div class="container-sm col-12 col-lg-12 mb-3" style="border-radius: 1vh;
">
        <div class="d-flex justify-content-between">
            <div class="text-center text-lg-start">
                <h2 class="h5 fw-bolder m-0">หมวดหมู่ </h2>
                <p style="font-size:12px;
color:#cccccc;
"> แนะนำ <i class="fa-sharp fa-regular fa-fire fa-fade" style="color: #ffaf02;
font-size:14px;
"></i></p>
            </div>
            <div class="m-1">
                <p class="mt-1" style="color:#afafaf;
"> <span style="color:#af7322;
"> <a href="?page=shop" class="btn" style="text-decoration:none;
font-size:10px;
background-color:#af7322;
padding:0.1rem 0.5rem;
border-radius:0.5vh;
color:#ffffff;
"> ดูเพิ่มเติม </a> แนะนำ </span> สำหรับคุณ </p>
            </div>
        </div>
    </div>
</center>
<div class="container-sm p-3 mt-1 col-lg-10" style="margin-top:-0.5rem;
">
    <div class="p-2 container ">
        <div class="row">
            <center> </center> <?php $stmt = dd_q("SELECT * FROM category");
                                $stmt->execute();
                                $result = $stmt->fetchAll();
                                foreach ($result as $rows) {
                                    $dontwant = array(4);
                                    if (!in_array($rows['c_id'], $dontwant)) {
                                ?> <!-- รายการ -->
                    <div class="col-lg-6 col-6 mb-4 af"> <a href="?page=shop&category=<?= htmlspecialchars($rows['c_name']) ?>"> <img class="app_pre w-100" src="<?= htmlspecialchars($rows['img']) ?>" alt="apppremium"> </a> </div> <?php
                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                        ?>
        </div>
    </div>
</div> <?php date_default_timezone_set('Asia/Bangkok');
        $current_server_time = date("Y") . "-" . date("m") . "-" . date("d") . " " . date("H:i:s");
        ?> <?php function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
        $string = array('y' => 'ปี', 'm' => 'เดือน', 'w' => 'สัปดาห์', 'd' => 'วัน', 'h' => 'ชั่วโมง', 'i' => 'นาที', 's' => 'วินาที',);
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . 'ที่แล้ว' : 'เมื่อสักครู่';
    }
    ?> </div>
</div>
</div>
</div>
</div> <!-- ผู้โชคดีล่าสุด -->
<center>
    <h5 style="font-weight: 500;
color:#C4C3C3">การเติมเงินล่าสุด</h5>
</center> <?php $get_user = dd_q("SELECT * FROM topup_his ORDER BY date DESC LIMIT 1");
            $get_user->execute();
            foreach ($get_user as $row) {
            ?> <div class="container d-flex justify-content-center mb-3" data-aos="fade-up">
        <div class="col-lg-4 col-12 card-box mt-2">
            <div class="d-flex align-content-centermb-3">
                <div class="p-2 ps-3 align-content-center">
                    <h5><i class="fa-duotone fa-stars"></i></h5>
                </div>
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0"> <img src="<?php echo htmlspecialchars($row['uimg']);
                                                            ?>" width="50px" class="rounded-circle" alt=""> </div>
                    <div class="flex-grow-0 ms-3 pt-2">
                        <h3 class="h3-nametop mt-2">@<?php echo htmlspecialchars($row['uname']);
                                                        ?> <span style="font-size:12px;
    margin-top:-1rem;
    "> <i class="fa-solid fa-badge-check" style="color: #1774ff;
    "></i> </span> </h3>
                        <p class="text-p-nametop"><?php $time = $row['date'];
                                                    echo time_elapsed_string("$time");
                                                    ?></p>
                    </div>
                </div>
                <div class="ms-auto p-2 align-content-center" style="color:#f9f9f9;
    "><?php echo htmlspecialchars($row['amount']);
        ?>฿</div>
            </div>
        </div>
    </div> <?php $i++;
            }
            ?> <style>
    .card-box {
        background-color: #111213;
        border: solid 1px #2a2c2e;
        border-radius: 0.5vh;
    }

    .h3-nametop {
        color: #f9f9f9;
        font-weight: 500;
        font-size: 18px;
    }

    .text-p-nametop {
        margin-top: -0.5rem;
        color: #eaa313;
        font-size: 13px;
    }
</style>
</div>
</div>
</div> <!-- รายการเติมเงินล่าสุด -->
<div class="container col-11 mt-5 mb-3" data-aos="fade-left">
    <div class="promotext">
        <div class="headtext">
            <h5 class="h5 fw-bolder m-0">โปรโมชั่น - ข่าวสาร</h5>
            <p style="color:#ffffff;
font-size: 13px;
margin-top:-0.5rem;
">Promotions and News</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-4"> <a href="?page=openweb" class="imgpost-a">
                <div class="imgpost"> <img src="/dz/promo/post.png" class="img-hv" width="100%" alt=""> </div>
                <div class="span-post mt-3"> <span class="text2">แนะนำสำหรับคุณ</span> <span class="text3">2024-07-21 14:13:45</span> </div>
                <h3 class="heading mt-2">Dedazen-Store เปิดให้บริการแล้ววันนี้ ลุยกันเล้ยย</h3>
                <div class="mt-1"> <span class="text1">โพสต์โดย : BakiHuam </span> </div>
            </a> </div>
        <div class="col-md-4 mb-4"> <a href="?page=topupnew" class="imgpost-a">
                <div class="imgpost"> <img src="/dz/promo/topupnew.png" class="img-hv" width="100%" alt=""> </div>
                <div class="span-post mt-3"> <span class="text2">แนะนำสำหรับคุณ</span> <span class="text3">2024-07-21 15:03:11</span> </div>
                <h3 class="heading mt-2">บริการเติมเกมออนไลน์ทั้งบนมือถือ และบน PC พร้อมรับส่วนลดสูงสุดถึง 30%</h3>
                <div class="mt-1"> <span class="text1">โพสต์โดย : BakiHuam </span> </div>
            </a> </div>
    </div>
    <div class="promotions"> <a class="promo btn" href="?page=promotions"> ดูข่าวสารเพิ่มเติม <i class="fa-light fa-angle-right fa-fade"></i> </a> </div>
</div>
</div>
</div>
<style>
    .headtext {
        color: #f9f9f9;
    }

    .promotions {
        float: right;
    }

    .promo {
        text-decoration: none;
        color: #ff0000;
        border: solid 1px #2b2b2b;
    }

    .imgpost-a {
        text-decoration: none;
    }

    .imgpost-a:hover {
        text-decoration: none;
    }

    .imgpost {
        overflow: hidden;
        border-radius: 0.5vh;
    }

    .img-hv:hover {
        transition: transform 2s ease-in-out;
        transform: scale(1.2);
    }

    .heading {
        color: #dfdfdf;
        font-weight: 400;
        font-size: 18px;
    }

    .text1 {
        font-size: 14px;
        color: #44464d;
    }

    .text2 {
        background-color: #ff8b00;
        color: #f9f9f9;
        padding: 0.2rem 0.5rem;
        border-radius: 50px;
        font-size: 11px;
    }

    .text3 {
        background-color: #2a2c2e;
        color: #ccc;
        padding: 0.2rem 0.5rem;
        border-radius: 50px;
        font-size: 11px;
    }

    .af:hover {
        filter: drop-shadow(5px 5px 10px #000000) invert(5%);
    }

    .app_pre {
        border-radius: 1vh;
    }

    .pfont {
        color: #c8c8c8;
        font-size: 13px;
    }

    .h5 {
        text-align: center;
    }

    .h5 {
        color: #fff;
        font-size: 24px;
        text-transform: uppercase;
        font-weight: 400;
        background: linear-gradient(to right, rgba(0, 0, 0, 0.61) 0%, rgb(255, 0, 0) 50%, #af7322 100%);
        background-size: auto auto;
        background-clip: border-box;
        background-size: 200% auto;
        color: #fff;
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: textclip 10s linear infinite;
        display: inline-block;
    }

    @keyframes textclip {
        to {
            background-position: 200% center;
        }
    }

    .bg-cus {
        font-size: 13px;
        padding: 0.5rem 1rem;
        border: solid 1px #232326;
        background: linear-gradient(to right, #0f0f0f 0%, #1d1e22 100%);
    }

    .bg-cus:hover {
        background: linear-gradient(to right, #ff0000 0%, #ff0000 100%);
    }

    .bg-tt {
        color: #c7c7c7;
        background-color: #131313;
    }

    .bg-cus_1 {
        font-size: 13px;
        padding: 0.5rem 1rem;
        border: none;
        background: linear-gradient(to right, #d32e2e 0%, #2b2b2b 100%);
    }

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

    .ttcolor {
        text-transform: uppercase;
        background: linear-gradient(to right, #ff4040 0%, #ff9e00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style> <!-- <script> $(document).ready(function(){
    $("#myModal").modal('show');
}
);
</script> -->
<script src="system/js/countup.js"></script>
</div>
</div>
</div>
</div>