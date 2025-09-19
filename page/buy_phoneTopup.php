<?php if ($apistatus == "2") {?>
<?php
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.wepay.in.th/comp_export.php?json=null',
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

$data = json_decode($response, true); // แปลง JSON เป็น array

if (isset($data['data']['mtopup'])) {
  $gtopup_data = $data['data']['mtopup'];
  
  if (isset($_GET['name'])) {
    $requested_company_id = $_GET['name'];
    // foreach ($gtopup_data as $data) {
    //   if ($data['company_id'] == $requested_company_id) {
    //     echo("-------------------<br/>");
    //     echo("company_id: " . $data['company_id']. "<br/>");
    //     echo("company_name: " . $data['company_name']. "<br/>");
    //     echo("-------------------<br/>");
    //   }
    // }
  } else {
    echo "โปรดระบุ 'company_id' ใน parameter GET";
  }
} else {
  echo "ไม่พบข้อมูล 'cashcard'";
}

?>         
<style>
   .blog-mumu {
   background-color: #16171a;
   border: solid 1px #212224;
   border-radius: 6px;
   margin-top:1rem;
   }
   .blog-mu {
   background-color: #fdfdfd;
   box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px;
   border-radius: 6px;
   }
   .blog-mu-green {
   background-color: #152301;
   border: solid 2px #212324;
   border-radius: 10px;
   width: 19vh;
   height: 8vh;
   }
   .blog-mu-green:hover {
   border: solid 3px white;
   }
   .blog-mu:hover {
   border: solid 1px var(--main);
   }
   .tick {
    position: absolute;
    top: 5px;
    right: 5px;
    width: 20px;
    height: 20px;
    background-color: green;
    border-radius: 50%;
    display: none; 
}

.tick.show {
    display: block; 
}
#uid:invalid {
            border-color: red;
        }
        #uid:invalid + .uid-error {
            display: block;
            color: red;
            font-size: 12px;
            margin-top: 7px;
        }
.mu-fontre {
                color: #fff;
                font-size: 13.5px;
                text-transform: uppercase;
                font-weight: 400;
                background: linear-gradient(to right,#F93B12 10%, #F9A212  30%, #F9A212 60% , #F93B12 100%) ;
                background-size: auto auto;
                background-clip: border-box;
                background-size: 200% auto;
                color: #fff;
                background-clip: text;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                animation: textclip 1s linear infinite;
                display: inline-block;
            }


            .form-control {
               background-color:#e4e4e4;
               border:none;
               color:#3e3e3e;
               padding:0.8rem;
            }
            .form-control:hover{
               background-color:#e4e4e4;
               color:#3e3e3e;
            }

            

            @keyframes textclip {
                    to {
                        background-position: 200% center;
                    }
                }


        .btn_modal {
        background: #ffffff;
        border-radius: 1vh;
        padding: 0.5rem 2rem;
        border: none;
    }
</style>
<?php 
foreach ($gtopup_data as $data) {
    if ($data['company_id'] == $requested_company_id) {
        // แสดงค่า "denomination" ที่ได้รับ
    // print_r($data['denomination']);
?>

<div class="container-sm p-2">
   <div class="container-fluid blog-mumu p-0" style="border-radius: 1vh; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1), 0 6px 20px 0 rgba(0, 0, 0, 0.15);">
      <div class="container-sm ">
         <div class="container-fluid">
            <div class="container-fluid border-2 p-0 pt-0 ">
               <div class="row container-fluid d-flex align-items-center">
                  <div class="col-12 col-lg-3 p-1">
                     <div class="d-flex justify-content-center ">
                        <img src="/assets/game/game/<?= $data['company_id'] ?>.png" width="80%" class="rounded mt-4" alt="รูปภาพสินค้าเติมเกม">
                     </div>
                     <div class="mt-3">
                        <!-- รายละเอียดของสินค้า -->
                        <h5 class="text-secondary" style="word-wrap: break-word; white-space:pre-wrap; font-size:16px; font-weight:200;"></h5>
                        <div class="mt-3">
                           
                        </div>
                     </div>
                  </div>



                  <div class="col-12 col-lg-8" style="margin-bottom:3rem">
                  
                  <!-- ชื่อเกม -->
                  <h4 class="text-left mb-4 mt-2 pt-4" style="font-weight:600; color:#c6c6c6;">
                        <i class='bx bxs-check-circle bx-tada'></i>
                              เติมเกม : <?= $data['company_name'] ?> &nbsp;&nbsp;&nbsp;
                     </h4>
                     <p style="font-size:13px; color:#707070; margin-top:-1.5rem;">หากกรอก เบอร์โทรศัพท์ ผิด ร้านจะไม่รับผิดชอบทุกกรณี กรุณาเช็คให้เรียบร้อย</p>


                     <button type="button" style="font-size:12px;" class="btn btn-outline-secondary disabled mb-3">ระบบอัตโนมัติ</button>
                     <button type="button" style="font-size:12px; background-color:#2377d1; color:#fff;" class="btn disabled mb-3"><?= $data['company_name'] ?></button>

                     
                     <input type="text" id="phone" class="form-control mt-1" placeholder="กรอก เบอร์โทรศัพท์ เกมของคุณ" aria-describedby="basic-addon1" style="border-radius: 4px;">
                     <div class="uid-error mu-fontre mt-2 mb-2">* กรุณากรอก เบอร์โทรศัพท์ ก่อนเลือกสินค้า *</div>
                     <br>
                     
                  </div>
               </div>
            </div>
            <div class="container col-12 td col-lg-12 ms-4">
               <p style="color:#6e7185; font-size:14px;"> เลือกรายการที่ต้องการซื้อ</p>
            </div>


            <div class="row container-fluid d-flex lign-items-center mb-4 ms-1" data-aos="zoom-in">
               <style>
                  @media only screen and (max-width: 600px) {
                  .td {
                  margin-top:-3rem;
                  }
                  }
               </style>
               <?php foreach ($data['denomination'] as $game): ?>
               <?php
                  $cost_price = $game['price'];
                  $free = $cost_price + $cost_price * ($apiprice / 100);
                  $free = round($free, 2);
                  $description = preg_replace('/\d+(?:[.,]\d+)?(\s?บาท)/', '', $game['description']);
                  ?>
               <div class="col-12 col-lg-3 mb-1 mt-1">
                  <div class="p-0 text-white" style="border-radius: 1vh; overflow: hidden; height: fit-content;">
                     <button class="container-fluid shop-btne p-2" onclick="confirmPurchase(this)" data-code="<?= $_GET['name'] ?>" data-product="<?= $data['company_id'] ?>" data-price-show="<?= $free ?>" data-price="<?= $game['price'] ?>" data-description="<?= htmlspecialchars($game['description']); ?>">
                        <h6 class="text-ee mt-1"><?= $description ?></h6>
                        <h6 class="text-dd"><?= $free ?> THB</h6> 
                     </button>
                     <div class="tick"></div>
                  </div>
               </div>
               <?php endforeach; ?>
            </div>
         </div>
      </div>
   </div>
</div>
<?php  } } ?>

<script>
function confirmPurchase(button) {
   const price = $(button).data('price');
    const price_show = $(button).data('price-show');
    const product = $(button).data('product');
    const code = $(button).data('code');
    const phone = $("#phone").val();

    Swal.fire({
        title: 'ยืนยันการซื้อ?',
        text: `คุณต้องการซื้อ ${product} ในราคา ${price_show} THB ใช่หรือไม่?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ใช่, ซื้อเลย!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
         let formData = new FormData();
            formData.append('price', price);
            formData.append('product', product);
            formData.append('code', code);
            formData.append('ref', phone);
         $.ajax({
            type: 'POST',
            url: 'system/buy_phoneTopup_api.php',
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
                     window.location = "?page=profile&subpage=hisphoneTopup";
               });
            }
            if (res.status == "fail") {
               Swal.fire({
                     icon: 'error',
                     title: 'ผิดพลาด',
                     text: result.message
               });
               $(this).removeAttr('disabled'); // ยกเลิกค่า disabled เพื่อทำให้ปุ่มสามารถใช้งานได้ใหม่
            }
         }).fail(function(jqXHR) {
            console.log(jqXHR);
            Swal.fire({
               icon: 'error',
               title: 'เกิดข้อผิดพลาด',
               text: res.message
            })
            $(this).removeAttr('disabled'); // ยกเลิกค่า disabled เพื่อทำให้ปุ่มสามารถใช้งานได้ใหม่
         });
      }
    });
}
</script>
</div>


<style>
.text-dd {
   color:#18c803;
   font-weight:600;
   font-size:16.5px;
}
.text-ee {
   font-size:14px;
   font-weight:300;
   color:#e6e6e6;
}
.shop-btne {
   background-color:#1f1f23;
   border: solid 1px #2d2d30;
   border-radius:1vh;
}
.shop-btne:hover{
   border-bottom: solid 4px #2fc41e;
}

                                        .btn-dark-des {
                                            font-weight:300;
                                            background-color:#222322;
                                            padding: 0.4rem 0.8rem;
                                            border-radius:8px;
                                        }
                                        .frominput-product {
                                            background-color:#2e2e2e;
                                            border:none;
                                            color:#e3e3e3
                                        }
                                        .minus {
                                            background-color:#2e2e2e;
                                            border:none;
                                            color:#e3e3e3
                                        }
                                        .plus {
                                            background-color:#2e2e2e;
                                            border:none;
                                            color:#e3e3e3
                                        }
                                        .box-price {
                                            border: solid 1px #212224; 
                                            border-radius:8px;
                                            background-color:#101012
                                        }

                                        .box-price-1 {
                                            border-radius:8px;
                                            background: linear-gradient(to right, #4b8e41 0%, #4a7554 100%);
                                        }
                                        .connect{
                                            text-align:center;
                                            font-size:12px;
                                            font-weight:300;
                                            border-radius:0.5vh;
                                            color:#43488e;
                                            text-decoration:none;
                                        }
                                        .connect:hover{
                                            color:#a2a8f7;
                                            background-color:#313562;
                                        }
                                    </style>


                                 

                           
       
<style>
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
</style>
<?php } else {;?>
                    <div class="alert text-white text-center" role="alert" style="font-size:13px;">
<img src="https://media.tenor.com/GCAp1T2fAZwAAAAj/sorry-im-sorry.gif" width="250px" class="mb-3">
     <h3 class="ttcolor" style="word-wrap: break-word; white-space:pre-wrap;"><i class="fa-duotone fa-circle-exclamation fa-shake fa-sm mb-1 mt-0" style="--fa-primary-color: #e22126; --fa-secondary-color: #e22126;"></i>&nbsp; ขออภัยเป็นอย่างสูง ทางเรากำลังดำเนินการปรับปรุงเว็บไซต์ในการเติมเกมอัตโนมัติ 
     โปรดรอทีมงานของเราดำเนินอย่างเร็วที่สุด กราบขออภัยลูกค้าที่เคารพรัก </h3>
</div>
<?php } ?>