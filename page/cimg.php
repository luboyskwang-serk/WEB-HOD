<style>
    .form-control{
        border: 0;
        border-bottom: 2px solid var(--main);
        background-color: transparent;
    }
    .tt {
        color:#3b3b3b;
    }
    .bb {
        background-color:#0c0c0d;
        margin-top:-5rem;
        padding:2rem;
        padding-bottom:3rem;
        border-radius:1vh;
        border: solid 0.5px var(--main);

    }
    .text-bss {
        text-transform: uppercase;
            background: linear-gradient(to right, #d51f1f 0%, #ff9f00 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration:none
    }
    .savebtn {
        color:#ca2525;
        background-color:#ffb3b3;
        border:none;
        padding:0.4rem 1rem;
        border-radius:1vh;
    }
    .ht {
        float:left;
        color:#cfcfcf;
    }
    .prodile-img {
        border: solid 1px var(--main);
        border-radius:100%;
        background-color:#ff9f00;
    }

.font-99 {
    color:#ebebeb;
    font-size:13px;
    margin-bottom:-0.1rem;
}
.font-98 {
    color:#ffc100;
    font-size:16px;
    margin-bottom:1rem;
}

    .card-dz {
        background-color: #0f0f0f;
        border-radius: 1vh;
        border: solid 1px #232326;
    }
    .btn-dz{
        background-color: #141416;
        border: solid 1px #232326;
        color:#a0a0a0;
    }
    .name {
        font-weight: 600;
        color:#cfcfcf;
    }
    .link-profile {
        text-decoration: none;
        color:#cfcfcf;
    }
    .name-profile{
        color:#af7322;
        font-weight: 500;
    }

    .btn-topup {
        color:#e5e5e5;
        background-color: #2a2e3d;
        border-radius: 5vh;
        border: solid 1px #3b3d4a;
        font-size:12px;
    }
    .btn-topup:hover{
        color:#ff9f00;
    }
    .text-buy {
        color: #d3d3d3;
    }
    .name-buy{
        color: #63656d;
    }
    .btn-id{
        background-color: #141416;
        border-radius: 50px;
        color: #af7322;
        font-size: 13px;
    }
    .hr-line {
        border-top: solid 1px #5a616a;
        width: 90%;
        align-items: center;
    }
</style>




<section>
  <div class="container" style="margin-top:-3.5rem;">
    
    <div class="row">
      <div class="col-lg-4">
        <div class="card-dz mb-4">
          <div class="card-body text-center">
            <img class="imgs prodile-img" src="<?php echo $user['profile'];?>" alt="avatar" width="50%" 
              class="rounded-circle img-fluid" style="width: 90px;">
            <h5 class="name my-3"><?php echo htmlspecialchars($user["username"]); ?></h5>
            <p class="text-muted mb-1" style="margin-top:-0.8rem; font-size:13px;">ระดับสมาชิก : <?php echo htmlspecialchars($user["rank"]); ?></p>

            <div class="d-flex justify-content-center mb-2">
                <input type="text" class="form-control tt" id="img" placeholder="วางลิ้งค์รูปเท่านั้น" value="<?php echo $user["profile"];?>">
              <button  id="btn_cimg" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-dz ms-1">อัพเดตรูป</button>
            </div>

          </div>
        </div>


        <div class="card-dz mb-4 mb-lg-0">
          <div class="p-0">
            <ul class="list-group list-group-flush rounded-3">
              
              <a href="?page=profile&subpage=buyhis" class="link-profile">
                <li class="card-dz text-white list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fa-solid fa-angle-right"></i>
                    <p class="mb-0">ประวัติการสั่งซื้อ</p>
                </li>
              </a>

              <a href="?page=profile&subpage=myapp" class="link-profile">
                <li class="card-dz text-white list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fa-solid fa-angle-right"></i>
                    <p class="mb-0">ประวัติการสั่งซื้อแอพ</p>
                </li>
              </a>

              <a href="?page=profile&subpage=histermgame" class="link-profile">
                <li class="card-dz text-white list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fa-solid fa-angle-right"></i>
                    <p class="mb-0">ประวัติการเติมเกมส์</p>
                </li>
              </a>

              <a href="?page=profile&subpage=hiscashcard" class="link-profile">
                <li class="card-dz text-white list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fa-solid fa-angle-right"></i>
                    <p class="mb-0">ประวัติการซื้อบัตรเงินสด</p>
                </li>
              </a>

              <a href="?page=profile&subpage=hisphoneTopup" class="link-profile">
                <li class="card-dz text-white list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fa-solid fa-angle-right"></i>
                    <p class="mb-0">ประวัติการเติมเงิน / ซื้อแพคเกจ</p>
                </li>
              </a>

              
              
              <a href="?page=profile&subpage=topuphis" class="link-profile">
                <li class="card-dz text-white list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fa-solid fa-angle-right"></i>
                    <p class="mb-0">ประวัติการเติมเงิน</p>
                </li>
              </a>


              

              <?php
                if ($user["rank"] == "1") {
                ?>
              <a href="?page=backend" class="link-profile">
                <li class="card-dz text-white list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fa-solid fa-angle-right"></i>
                    <p class="mb-0" style="color:#e94747;">จัดการหลังบ้าน</p>
                </li>
              </a>
              <?php
                }
                 ?>
              
            </ul>
          </div>
        </div>
      </div>


      <div class="col-lg-8">
        <div class="card-dz mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0 name-profile">ยอดเงินคงเหลือ</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $user["point"]; ?> เหรียญ 
                    <span> 
                        <a href="?page=topup" class="btn btn-topup">
                            เติมเพิ่ม
                        </a>
                    </span>
                </p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0 name-profile">ยอดการเติมสะสม</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $user["total"]; ?> บาท</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0 name-profile">วันที่สมัคร</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $user["date"]; ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3 mb-4">
                <p class="mb-0 name-profile">ID ผู้ใช้</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $user["id"]; ?>
                <span style="font-size: 13px; color:#3b3b3b;">ใช้เลขไอดีนี้เพื่อแจ้งแอดมิน กรณีพบเจอปัญหา</span>
                </p>
              </div>
            </div>
          </div>
        </div>



        <div class="row">
          <div class="col-md-6">
            <div class="card-dz mb-4 mb-md-0">
              <div class="card-body">
                <p class="mb-4"><span class="font-italic me-1" style="color:#af7322">เปลี่ยนรหัสผ่าน</span> Edit Password
                </p>
                <p class="mb-1" style="font-size: .77rem;">ระบุรหัสผ่านเก่า</p>
                <input type="password" class="btn bg-dark w-100" id="o_pass" placeholder="รหัสผ่านเก่า" style="color: #cdcdcd">
                
                <p class="mt-4 mb-1" style="font-size: .77rem;">ระบุรหัสผ่านใหม่</p>
                <input type="password" class="btn bg-dark w-100" id="pass" placeholder="รหัสผ่านใหม่" style="color: #cdcdcd">

                <p class="mt-4 mb-1" style="font-size: .77rem;">ระบุรหัสผ่านใหม่อีกครั้ง</p>
                <input type="password" class="btn bg-dark w-100" id="pass2" placeholder="รหัสผ่านใหม่อีกครั้ง" style="color: #cdcdcd">

                <button id="btn_regis" class="btn-dz btn w-100 mt-2">
                <i class="fa-regular fa-key-skeleton fa-fade fa-xs" style="color: #ee262c;"></i>&nbsp;ยืนยันการเปลี่ยน</button>

              </div>
            </div>
          </div>



          <div class="col-md-6">
            <div class="card-dz mb-4 mb-md-0">
              <div class="card-body">
                <p class="mb-4"><span class="font-italic me-1" style="color:#af7322">ประวัติการสั่งซื้อ</span> Buyhis
                <span><a href="?page=profile&subpage=buyhis" class="btn btn-topup">ดูทั้งหมด</a></span>
                </p>

                <?php 
                            $q = dd_q("SELECT * FROM boxlog WHERE uid = ? ORDER BY id DESC  Limit 2 ", [$_SESSION['id']]);
                            $i = 1;
                            while($row = $q->fetch(PDO::FETCH_ASSOC)){
                                
                        ?>

               
                <div class="row ">
                    <p class="mb-2 name-buy" style="font-size: .77rem;">
                        ชื่อสินค้า : <?php echo htmlspecialchars($row['category']);?>
                        <span class="btn btn-id">#<?php echo htmlspecialchars($row['id']);?></span>
                    </p>
                    <h6 class="text-buy mb-2">
                        รายละเอียด : <?php echo ($row['prize_name']);?></h6>
                    <p class="name-buy">ราคา <span style="color:#ff9f00"><?php echo number_format($row['price']); ?></span> บาท</p>
                    
                    <div style="float: right; font-size: 12px; color:#63656d">
                        <span>
                            เวลา : <?php echo htmlspecialchars($row['date']);?>
                        </span>
                    </div>

                    <hr class="hr-line container mt-2 mb-4">
                    
                </div>

                <?php
                                $i++;
                            }
                        ?>
               
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
  </div>
</section>



       
       <script type="text/javascript">

        $("#btn_cimg").click(function(e) {
            e.preventDefault();
            var formData = new FormData();
            formData.append('img' , $("#img").val());
            $('#btn_cimg').attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: 'system/changeimg.php',
                data:formData,
                contentType: false,
                processData: false,   
            }).done(function(res){
                
                result = res;
                console.log(result);
                if(res.status == "success"){
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ',
                        text: result.message
                    }).then(function() {
                            window.location = "?page=profile&subpage=cimg";
                    });
                }
                if(res.status == "fail"){
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: result.message
                    });
                    $('#btn_cimg').removeAttr('disabled');
                }
            }).fail(function(jqXHR){
                console.log(jqXHR);
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: res.message
                })
                $('#btn_cimg').removeAttr('disabled');
            });
        });
    </script>
</div>
    </div>
</div>

    <script type="text/javascript">

        $("#btn_regis").click(function(e) {
            e.preventDefault();
            var formData = new FormData();
            formData.append('o_pass', $("#o_pass").val() );
            formData.append('pass'  , $("#pass").val() );
            formData.append('pass2' , $("#pass2").val());
            $('#btn_regis').attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: 'system/changepass.php',
                data:formData,
                contentType: false,
                processData: false,   
            }).done(function(res){
                
                result = res;
                console.log(result);
                if(res.status == "success"){
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ',
                        text: result.message
                    }).then(function() {
                            window.location = "?page=profile";
                    });
                }
                if(res.status == "fail"){
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: result.message
                    });
                    $('#btn_regis').removeAttr('disabled');
                }
            }).fail(function(jqXHR){
                console.log(jqXHR);
                //   res = jqXHR.responseJSON;
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: res.message
                })
                //console.clear();
                $('#btn_regis').removeAttr('disabled');
            });
        });
    </script>
</div>