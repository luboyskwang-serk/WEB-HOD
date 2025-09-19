<style>
    .ff {
        text-transform: uppercase;
        background: linear-gradient(to right, #d51f1f 0%, #ff9f00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-decoration: none
    }

    /* CD MANU */
    .cd {
        color: #f3950c;
    }

    .cd:hover {
        color:rgb(255, 0, 0);
    }

    /* BG-CD MANU */
    .bg-cd {
        background-color: #0e0f13
    }

    /* CD-1 drop manu */
    .cd-1 {
        color:rgb(255, 255, 255);
        filter: drop-shadow(10px 10px 30px red) invert(15%);
    }

    .cd-1:hover {
        text-transform: uppercase;
        background: linear-gradient(to right, #d51f1f 0%, #ff9f00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-decoration: none
    }
</style>



<div class=" pt-2 col-lg-12" style="display: flex; justify-content: center;">
    <nav class="navbar navbar-expand-lg me-4 ms-4">
        <div class="container-fluid ">
            <a class="navbar-brand ff" href="#">จัดการหลังบ้าน</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-duotone fa-diagram-cells fa-fade p-1"
                    style="--fa-primary-color: #df8811; --fa-secondary-color: #df8811;"></i>

            </button>

            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 150px;">

                    

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle cd" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            ตั้งค่าเว็บไซต์
                        </a>
                        <ul class="dropdown-menu bg-cd">
                            <li><a class="dropdown-item cd-1" href="?page=backend">ผลรวมร้านค้า</a></li>
                            <li><a class="dropdown-item cd-1" href="?page=website">ตั้งค่าเว็บไซต์</a></li>
                            <li><a class="dropdown-item cd-1" href="?page=carousel_manage">จัดการรูปภาพสไลด์</a></li>
                            <li><a class="dropdown-item cd-1" href="?page=apibyshop">ตั่งค่าแอพพรีเมียม Byshop</a></li>
                        </ul>
                    </li>
                  

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle cd" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            จัดการการเติมเงิน
                        </a>
                        <ul class="dropdown-menu bg-cd">
                            <li><a class="dropdown-item cd-1" href="?page=slip_manage">จัดการธนาคาร</a></li>
                            <!-- <li><a class="dropdown-item cd-1" href="?page=mmn_manage">จัดการแม่มะณี</a></li> -->
                            <li><a class="dropdown-item cd-1" href="?page=code_manage">จัดการโค้ด</a></li>
                        </ul>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle cd" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            จัดการร้านค้า
                        </a>
                        <ul class="dropdown-menu bg-cd">
                            <li><a class="dropdown-item cd-1" href="?page=product_manage">จัดการสินค้า</a></li>
                            <li><a class="dropdown-item cd-1" href="?page=category_manage">จัดการหมวดหมู่</a></li>
                            <li><a class="dropdown-item cd-1" href="?page=user_edit">จัดการสมาชิก</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle cd" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            จัดการการแนะนำ
                        </a>
                        <ul class="dropdown-menu bg-cd">
                            <li><a class="dropdown-item cd-1" href="?page=crecom_manage">หมวดหมู่แนะนำ</a></li>
                            <li><a class="dropdown-item cd-1" href="?page=recom_manage">สินค้าแนะนำ</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle cd" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            จัดการ API GAMEs
                        </a>
                        <ul class="dropdown-menu bg-cd">
                            <li><a class="dropdown-item cd-1" href="?page=apigame">ตั้งค่า API GAMEs</a></li>
                            <li><a class="dropdown-item cd-1" href="?page=histermgameAdmin">ประวัติการเติมเกม</a></li>
                        </ul>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle cd" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            จัดการวงล้อ
                        </a>
                        <ul class="dropdown-menu bg-cd">
                            <li><a class="dropdown-item cd-1" href="?page=product_game">จัดการวงล้อ(สินค้า)</a></li>
                            <li><a class="dropdown-item cd-1" href="?page=category_game">จัดการหมวดหมู่วงล้อ</a></li>
                        </ul>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle cd" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            จัดการแอพพรีเมียม Peamsub24hr
                        </a>
                        <ul class="dropdown-menu bg-cd">
                            <li><a class="dropdown-item cd-1" href="?page=peamsubproduct">จัดการสินค้า API APP</a></li>
                            <li><a class="dropdown-item cd-1" href="?page=history_topup_all_peamsub">ประวัติการสั่งซื้อแอพ</a></li>
                        </ul>
                    </li>


                    <!-- 
                                <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle cd" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    จัดการ การเติมเกมส์
                                </a>
                                    <ul class="dropdown-menu bg-cd">
                                        <li><a class="dropdown-item cd-1" href="?page=order">ประวัติการเติมเกมส์ทั้งหมด</a></li>
                                        <li><a class="dropdown-item cd-1" href="?page=service_manage">แก้ไข เพิ่มหมวดหมู่</a></li>
                                    </ul>
                                </li>
                                -->


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle cd" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            ประวัติทั้งหมด
                        </a>
                        <ul class="dropdown-menu bg-cd">
                            <li><a class="dropdown-item cd-1" href="?page=backend_buy_history">ประวัติการสั่งซื้อ</a>
                            </li>
                            <li><a class="dropdown-item cd-1" href="?page=apibyshop_his">ประวัติการสั่งซื้อแอพ</a></li>
                            <li><a class="dropdown-item cd-1" href="?page=backend_topup_history">ประวัติการเติมเงิน</a>
                            </li>
                        </ul>
                    </li>

                </ul>

            </div>
        </div>
    </nav>
</div>

<?php
if (admin($user) && isset($_GET['page']) && $_GET['page'] == "backend") {
    require_once ('page/backend/dashboard.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "user_edit") {
    require_once ('page/backend/user_edit.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "category_manage") {
    require_once ('page/backend/category.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "product_manage") {
    require_once ('page/backend/product.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "stock_manage" && $_GET['id'] != "") {
    require_once ('page/backend/stock.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "category_game") {
    require_once('page/backend/Gcategory.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "product_game") {
    require_once('page/backend/Gproduct.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "productrw_game" && $_GET['id'] != "") {
    require_once('page/backend/Gproduct_rw.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "stock_game" && $_GET['id'] != "") {
    require_once('page/backend/Gstock.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "code_manage") {
    require_once ('page/backend/code_manage.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "slip_manage") {
    require_once ('page/backend/slip_manage.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "mmn_manage") {
    require_once ('page/backend/mmn_manage.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "backend_buy_historyapi") {
    require_once ('page/backend/buy_historyapi.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "backend_buy_history") {
    require_once ('page/backend/buy_history.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "backend_topup_history") {
    require_once ('page/backend/topup_history.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "website") {
    require_once ('page/backend/website.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "peamsubproduct") {
    require_once ('page/backend/peamsubproduct.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "history_topup_all_peamsub") {
    require_once ('page/backend/history_topup_all_peamsub.php'); 
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "carousel_manage") {
    require_once ('page/backend/carousel_manage.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "recom_manage") {
    require_once ('page/backend/recom_manage.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "crecom_manage") {
    require_once ('page/backend/crecom_manage.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "apibyshop") {
    require_once ('page/backend/apibyshop.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "my_order") {
    require_once ('page/backend/my_order.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "order") {
    require_once ('page/backend/order.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "order_success") {
    require_once ('page/backend/order_success.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "order_unsuccess") {
    require_once ('page/backend/order_unsuccess.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "order_temp") {
    require_once ('page/backend/order_temp.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "service_manage") {
    require_once ('page/backend/service_manage.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "service_manage_main") {
    require_once ('page/backend/service_manage_main.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "service_manage_cate") {
    require_once ('page/backend/service_manage_cate.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "service_his") {
    require_once ('page/backend/service_his.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "apibyshop_his") {
    require_once ('page/backend/apibyshop_his.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "apigame") {
    require_once ('page/backend/apigame.php');
} elseif (admin($user) && isset($_GET['page']) && $_GET['page'] == "histermgameAdmin") {
    require_once ('page/backend/histermgameAdmin.php');
}
?>
</div>
</div>
</div>
</div>