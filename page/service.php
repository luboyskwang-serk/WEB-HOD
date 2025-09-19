<?php include 'data.php' ?>
            <div class="container-sm p-0 col-lg-10">
        <div class="container-fluid">
        <div class="container-sm ">
            <div class="container-fluid">
            <div class="container-fluid bg-back p-3 pt-2"  style="border-radius: 1vh; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1), 0 6px 20px 0 rgba(0, 0, 0, 0.15);">
                    <?php if (!isset($_GET['category'])) : ?>

                    <center class="mt-4 mb-4">
                            <span class="h4 ttcolor"><b>บริการเติมเกมส์</b></span>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb d-flex justify-content-center mt-0">
                                    <li class="breadcrumb-item ttcolor"><a href="?page=index" style="text-decoration: none; font-size:13px;"> หน้าหลัก</a></li>
                                    <li class="breadcrumb-item"><a href="#!" style="text-decoration: none; color: #6C757D; font-size:13px;"> บริการเติมเกมส์ทั้งหมด </a></li>

                                </ol>
                            </nav>


                        </center>



                      

                    <?php else : ?>

                <div class="container-sm mt-2">
                    <center class="mt-4 mb-4">
                                    <span class="h4 ttcolor"><b>หมวดหมู่เกมส์ : <?= htmlspecialchars($_GET['category']); ?> </b></span>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb d-flex justify-content-center mt-0">
                                            <li class="breadcrumb-item ttcolor"><a href="?page=index" onclick="history.back()" style="text-decoration: none; font-size:13px;">  บริการเติมเกมส์</a></li>
                                            <li class="breadcrumb-item"><a href="#!" style="text-decoration: none; color: #6C757D; font-size:13px;"><?= htmlspecialchars($_GET['category']); ?></a></li>

                                        </ol>
                                    </nav>


                    </center>
                </div>


            </div>
            </div> 
    
                                            
                    <?php endif ?>
                    <div class="row justify-content-center justify-content-lg-start">
                        <?php if (!isset($_GET['category'])) {
                            $cfind = dd_q("SELECT * FROM service_cate ");
                            $check = $cfind->rowCount();
                            if ($check  == NULL) {
                                echo '<h6 class=" text-center">ไม่มีบริการในตอนนี้</h6>';
                            } elseif ($_GET['category'] == NULL) {
                                header('Location: ' . $_SERVER['HTTP_REFERER']);
                            }
                            while ($row = $cfind->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <style>
    .filters{
                                filter: grayscale(100%);
                            }
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
        border-radius: 5px;
        transition: all .5s ease;
    }
    .shops-body>.shops-img:hover {
        transform: scale(1.035);
    }
    .shops-body>.shops-text-center {
        position: absolute;
        top: 90%;
        left: 60%;
        transform: translate(-50%, -50%);
        opacity: 0;
        transition: all .5s ease;
    }
    .shops-body:hover>.shops-text-center {
        left: 10%;
        opacity: 1;
        font-size: 13px;
        padding: 0 20px;
        border-radius: 1vh;
        font-weight:300;
        color:#8f8f8f;
        background-color: #33473700;
    }
</style>
                                    
                                </style>



                                <div class="col-12 col-lg-6 mb-3">
                            <a href="?page=service&category=<?= $row['name'] ?>">
                                <div class="shops-body w-100">
                                    <img class="shops-img" src="<?= htmlspecialchars($row['img']) ?>">
                                    <div class="shops-text-center">
                                        <?= htmlspecialchars($row['des']) ?>
                                    </div>
                                </div>
                            </a>
                        </div>



                            <?php } ?>
                            <?php
                        } else {
                            $find = dd_q("SELECT * FROM service_prod WHERE cate = ? ORDER BY id DESC", [$_GET['category']]);
                            while ($row = $find->fetch(PDO::FETCH_ASSOC)) {
                                
                            ?>
                        <div class="col-12 col-lg-4 mb-4 cc" data-aos="zoom-in">
                            <div class="card-body shadow-sm p-0 text-white card-body  " style="border-radius: 1vh; overflow: hidden; height: fit-content;  ">
                                <div class="container-fluid p-0 ">
                                    <div class="view overlay">
                                        <center>
                                              <img class="img-fluid " src="<?php echo htmlspecialchars($row["img"]); ?>" style="border-radius: 1vh; width: 100%; max-width: 100vh;">
                                          </center>
                                          <a href="#!">
                                              <div class="mask rgba-white-slight"></div>
                                          </a>
                                      </div>
                                      <center>
                                    

                                     </center>'
                                     
                                      <div class="card-body p-3 pt-1 pb-1 ">
                                      <center>


                                      <!-- box-service -->
                                    <p class="text-white main-badge m-0 mt-1 pt-1 pb-1 tx-box mb-1" style="width: fit-content; float:right"><i class='bx bxs-notification'></i> พร้อจำหน่าย </p>

</center>
                                        <h6 class=" text-strongest mb-1 mt-1" style="word-wrap: break-word;"><?php echo htmlspecialchars($row["name"]); ?></h6>     
                                                                                <div class="d-flex justify-content-between">
                                                                                

                                            <p class="text-main align-self-center m-0"><strong>ราคา : <?php echo number_format($row['price'], 2);?> <p class="text-white main-badge bg-main align-self-center m-0">บาท</p><br></strong></p>
                                            
                                        </div>
                                                                     
                                        <footer class="mt-2 " style="color:#f0aa14"><span class="blockquote-footer tx-tt">รายละเอียด</span><br> <?php echo htmlspecialchars($row["des"]); ?>                

                                      
                                          <center>
                                              <a href="?page=service_buy&id=<?= $row['id'] ?>" class="btn tx-box2 w-100 mt-3 mb-2">
                                              <i class="fa-thin fa-cart-shopping fa-fade"></i>&nbsp;สั่งซื้อตอนนี้เลย</a>
                                          </center>
                                      </div>
                                  </a>
                              </div>
                          </div>
                      </div>
                        <?php             }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .ttcolor {
            text-transform: uppercase;
            background: linear-gradient(to right, #ff4040 0%, #ff9e00 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .bg-cus {
                            font-size:13px;
                            padding : 0.5rem 1rem;
                            border:none;
                            background: #0f0c29;  /* fallback for old browsers */
                            background: -webkit-linear-gradient(to right, #24243e, #302b63, #0f0c29);  /* Chrome 10-25, Safari 5.1-6 */
                            background: linear-gradient(to right, #24243e, #302b63, #0f0c29); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

                    }
                    .bg-cus:hover{
                        background: #dc8900;
                    }
                
        
</style>



<!-- tx-box -->    
<style>
        .tx-box {
            font-size:12px;
            background-color:#0ab20a0a;
            border-radius:5px;
            border: solid 0.5px #63b158;

        }

        .tx-box2 {
            padding:1rem;
            color:#eb8bff;
            font-size:12px;
            background-color:#3d300a0a;
            border-radius:4px;
            border: solid 0.5px #eb8bff;

        }

        .tx-box2:hover {
            color:#f3f3f3;
            }

        
    /* .tx-tt {
        color:#ffaa00;
    } */
</style>

