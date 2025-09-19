
<?php
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://peamsub24hr.online/api/api_product', 
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

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
    $updatestock = dd_q("UPDATE apipeam_product SET stock =  ? WHERE id = ? ", [$stock, $id]);
    $updatepricestock = dd_q("UPDATE apipeam_product SET price_default =  ? , name = ? WHERE id = ? ", [$pricevip,$name,$id]);
    if($stmt->RowCount() > 0){
    }else{
    $product = dd_q("INSERT INTO apipeam_product (id, name, price_default, price,img, stock, c_type, des,showitem) VALUES (?, ?, ? , ? , ?, ?, ?, ? , ? )", [
        $id,
        $name,
        $pricevip,
        $price,
        $img,
        $stock,
        $c_type,
        $des,
        '0',
    ]);
}
}
?>
<style>
    .top-right {
        position: absolute;
        top: 2px;
        left: 10px;
    }

    .top-right1 {
        position: absolute;
        bottom: 10px;
        right: 10px;
    }

    .bg-glass {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0));
        backdrop-filter: blur(30px);
        -webkit-backdrop-filter: blur(30px);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
    }

    .bg-glassx {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.396));
        backdrop-filter: blur(30px);
        -webkit-backdrop-filter: blur(30px);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
    }

    .border-ys {
        border: 2px solid rgba(0, 0, 0, 0);
        transition: all .5s ease;
    }

    .border-ys:hover {
        border: 2px solid #2fa41c;
    }

   
    .text-deda {
        text-transform: uppercase;
        background: linear-gradient(to right,#ffb900 0%, #e31b1b 100%) ;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .dd-99 {
           font-size:13px;
           margin-top:-0.5rem;
           color:#a2a2a2;
        }

        .img-app {
            background-image: url(<?php echo $config['bg_premium']; ?>);
            background-repeat: no-repeat;
            background-position: center; 
            background-size: cover;
            border-radius: 6px 6px 0px 0px;
            width: 100%;
        }
        .text-app {
            color:#f7f7f7;
        }
        .dedazen {
            background-color:#2ea200;
            color:#fff;
        }

        .dedazen:hover {
            background-color:#1f510b;
            border: solid 1px #4b4b4b;
            color:#87ff57;
        }


        /* สถานะสินค้า */
        .btn-out {
            background-color:#de3535;
        }
        .btn-out:hover{
            color:#de3535;
        }
        .app-strock {
            color:#55d131;
            font-size:14px;
        }
        .text-x {
            color:#c42323;
        }
</style>


<div class="container-fluid bb mt-4 col-lg-8 col-12" style="margin-bottom:6rem;">
<div class="section-tittle p-2">
    <h2 class="text-deda">แอพพรีเมียม </h2>
    <p class="dd-99">APP PREMIUM  <i class="fa-duotone fa-tv fa-fade"></i></p>

</div>

<!-- รายการสั่งซื้อล่าสุด -->



<div class="container mt-2">
  <!--   <div class="card border"> -->
        <div class="card-body scrollable-container">
            <div class="col-md-12 col-sm-12 col-12 mt-1 mb-4 " >
                    <!-- <h4 class="m-2 text-dark">
                        <i class='bx bx-store'></i> รายการสินค้า <span class="text-dark-50" style="font-size: 16px;">( ร้านค้า )</span>
                    </h4> -->

                    <div class="row">
                        <?php
                        $result_load_packz = dd_q("SELECT * FROM apipeam_product WHERE showitem = 1");
                        while ($row = $result_load_packz->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <div class="col-md-31 col-sm-3 col-12 px-2 d-flex align-items-stretch" >
                                <div class="card mb-3 w-100 border-ys" data-aos="fade-up" style="background-color:#1f2125;">
                                   


                                     <div class="img-app" style="height:96px;">
                                        <img src="<?= $row['img'] ?>" class="p-2" style="width:85px; border-radius:1.5vh;">
                                    </div>

                                    
                                  


                                    <div class="card-body d-flex flex-column">
                                        <h6 class="text-app"><?= $row['name'] ?></h6>
                                        <!-- <small class="text-dark"><i class="fa-brands fa-creative-commons-share"></i> ประเภทสินค้า <?= $row['id'] ?></small> -->
                                        <!-- <small class="text-white text-center"><i class="fa-regular fa-circle-user"></i> คงเหลือ <?= $row['stock'] ?> ชิ้น</small> -->
                                       
                                        <?php if ($row['stock'] == 0) : ?>
                                            <div>
                                                <small style="color:#ffc100;"><i class="fa-solid fa-circle-notch fa-spin"></i> รออัพเดตสินค้า 23.59 น.</small>
                                                <span>
                                                    <h6 class="text-white">ราคา <?= number_format($row['price'], 2) ?> ฿</h6>
                                                </span>
                                            </div>
                                            <?php else : ?>
                                                <span class="app-strock">พร้อมจำหน่าย 
                                                <i class="fa-duotone fa-circle-check fa-fade" style="--fa-primary-color: #23ed28; --fa-secondary-color: #48c014;"></i>
                                                </span>
                                                <span>
                                                    <h6 class="text-white">ราคา <?= number_format($row['price'], 2) ?> ฿</h6>
                                                </span>
                                                
                                        <?php endif ?>
                                    </div>





                                    <div class="p-2">


                                            <!--  <button class="btn btn-primary w-100 mb-2" onclick="buypremium(<?= $row['id'] ?>)">สั่งซื้อ (<?= number_format($row['price'], 2) ?> เครดิค)</button> -->


                <?php if ($row['stock'] >= 1) {
            echo '<button class="btn w-100 dedazen mb-2 text-center text-white submit_buypeamsub" 
                          style="border-radius: 9px;" point="'.$row['price'].'" product="'.$row['name'].'" 
                          id="'.$row['id'].'"> ราคา '. $row['price'] .' บาท </button>';
        } else {?>
                  <button class="btn w-100 btn-out mb-2 text-white"  id="shop-btnX"><i class="fa-light fa-ban fa-beat-fade"></i> สินค้าหมด</button>
                                        <?php }?>

                                        <button class="btn w-100 btn-secondary mb-2 text-center text-white "onclick="get_detailpeamsub(<?php echo $row['id']; ?>)"><i class="fa-regular fa-info-circle"></i>&nbsp;รายละเอียดสินค้า </button>

                                        
                                        <?php if (isset($_SESSION['id'])) : ?>
                                            <?php else: ?>
                                                <button class="btn btn-primary w-40 mb-2" onclick="CradURL('./page/login')">เข้าสู่ระบบเพื่อสั่งซื้อ</button>
                                            <?php endif ?>



                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$q = dd_q("SELECT * FROM apipeam_product");
?>

<?php while ($row = $q->fetch(PDO::FETCH_ASSOC)): ?>
    <div class="modal fade" id="ShopModal<?=$row['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color:#000000;">
                <div class="modal-header">
                    <h1 class="modal-title text-white fs-5" id="exampleModalLabel"><?=$row['name']?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <center><img src="<?=$row['img']?>" class="p-4" style="width:11.1rem;"></center>
                        <h5 class="text-white"><?=$row['name']?></h5>
                        <small class="text-white"><i class="fa-brands fa-creative-commons-share"></i> ประเภทสินค้า <?=$row['id']?></small>
                        <small class="text-white"><i class="fa-regular fa-circle-user"></i> คงเหลือ <?=$row['stock']?> ชิ้น</small>
                    </div>

                    <!-- รายละเอียด -->
                    <h6 class="text-white mt-2 mb-2">
<?php
                    $detailapi = htmlspecialchars($row['des']);
                $detailapi = html_entity_decode($detailapi);
                $detailapi = str_replace('\n', '<br>', $detailapi);
                echo $detailapi;
                ?>
                </h6>

                </div>
                <div class="modal-footer">
                    <?php if(isset($_SESSION['id'])): ?>
                        <button class="btn btn-primary w-50 mb-1" onclick="buypremium(<?=$row['id']?>)">สั่งซื้อ (<?=number_format($row['price'], 2)?> เครดิต)</button>
                    <?php else: ?>
                        <button class="btn btn-primary w-40 mb-2" onclick="CradURL('./page/login')">เข้าสู่ระบบเพื่อสั่งซื้อ</button>
                    <?php endif ?>
                    <button type="button" class="btn btn-success w-40" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>


    </div>



<?php endwhile; ?>

<?php if (isset($_SESSION['id'])): ?>
     <!-- Additional content for authenticated users -->
    <!-- <button class="btn btn-primary w-100 mb-2" onclick="buypremium(100)"> Test สั่งซื้อ ( เครดิค)</button> -->
<?php endif; ?>


<script>

    $(".submit_buypeamsub").click(function () {
    var product = $(this).attr("product");
    var price = $(this).attr("point");
    var id = $(this).attr("id");
    Swal.fire({
        title: 'คุณยืนยันคำสั่งซื้อหรือไม่',
        html: 'หลังจากกดสั่งซื้อแล้วกรุณารอ 30 วินาที<br> สินค้า : ' + product + '<br> ราคา : ' + price + ' บาท ',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#13DB2B',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยันสั่งซื้อ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
if (result.isConfirmed) {
            Swal.fire({
                title: 'กรุณารอสักครู่',
                html: 'กรุณารอคำสั่งซื้อเสร็จสิ้น !<br> ห้ามกดออกจากหน้าต่างนี้เด็ดขาด',
                icon: 'warning',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                type: "POST",
                url: "system/buyidpeamsub.php",
                dataType: "json",
                data: { id },
                success: function (data) {
                    if (data.status == "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ !',
                            text: data.msg,
                            timer: 800,
                            timerProgressBar: true,
                            willClose: () => {
                                window.location.href = '?page=history_premium';
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: data.status,
                            title: 'เกิดข้อผิดพลาด!',
                            text: data.msg,
                            showConfirmButton: true,
                            timerProgressBar: true,
                            willClose: () => {
                                window.location.reload();
                            }
                        });
                    }
                }
            });
        }
    });
});
</script>
<script>

function get_detailpeamsub(id) {
        var formData = new FormData();
        formData.append('id', id);
        $.ajax({
            type: 'POST',
            url: 'system/call/product_detailpeamsub.php',
            data: formData,
            contentType: false,
            processData: false,
        }).done(function(res) {
            console.log(res);
            $("#productq").html(res.name);
            $("#imgq").attr('src',res.img);
            $("#priceq").html(res.price);
            $("#des").html(res.des);
            $("option[value='"+res.c_type+"']").attr('selected', 'selected');
            $("#save_btn").attr("data-id", id);
            const myModal = new bootstrap.Modal('#product_detailpeamsub', {
                keyboard: false
            })
            myModal.show();
        }).fail(function(jqXHR) {
            console.log(jqXHR);
            res = jqXHR.responseJSON;
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: res.message

            })
        });
    }
    </script>
    <div class="modal fade" id="product_detailpeamsub" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa-duotone fa-shopping-basket"></i>&nbsp;&nbsp;รายละเอียดสินค้า</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-9 m-cent">
                        <center class="mt-4">
                        <img class="img-fluid" style="border-radius:15px" id="imgq" width="30%"><br>
                            <p id="productq" style="word-wrap: break-word;">N/A</p>
                        </center>
                    </div>
                    <div class="container-fluid ps-3 pe-3">
                        <p class="text-dark m-0"><i class="fa-regular fa-info-circle"></i> รายละเอียดสินค้า </p>
                        <hr class="mt-1 mb-1">
                        <p class="text-secondary" style="word-wrap: break-word; white-space:pre-wrap;" id="des">N/A
                            <hr class="mt-1 mb-1">
                            <b id="des"></b>
                    </div>
                </div>
                <div class="modal-footer">

                <?php
				$stmt = dd_q("SELECT * FROM apipeam_product");
		$stmt->execute();
		$result = $stmt->fetchAll();
			foreach($result as $row){
                           }               ?>
                    <button type="button" class="btn bg-danger text-white" id="count" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div> 
</div>
                        </div>