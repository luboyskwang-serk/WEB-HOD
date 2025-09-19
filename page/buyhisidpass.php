



<style>
    .bb {
        margin-top:-6rem;
    }
</style>
<div class="container-fluid bb p-0 col-lg-10 col-10" style="background-color:#0f0f0f" >
    <div class="container-sm m-auto p-2 pt-0 aos-init aos-animate" data-aos="zoom-in">


        <div class="container-fluid ps-3 pe-3 pb-3" style="border-radius:1vh;">
        
        <div class="p-2">
            <h5 class="m-0"><h5 class=" mb-2 mt-2" style="color:#e3e3e3;">
            <i class="fa-duotone fa-clock-rotate-left fa-spin fa-spin-reverse" style="--fa-primary-color: #e3e3e3; font-size:14px; --fa-secondary-color: #15ed10;"></i>
             ประวัติการเติมเกมส์ MAIL - PASS</h5>
             <p style="font-size:14px; color:#eaac13;">ของคุณ : <span><?php echo htmlspecialchars(strtoupper($user['username'])); ?></span></p>
        </div>

       
        <div class="m-0" style="background-color:#00000000">
            
        
            <div class="table-responsive">
                <table class="table  table-striped " id="table" >
                    
                <thead >
                    <tr >
                        <th scope="col" class="text-center">#</th>
                        <th style="padding-left:-6rem;" scope="col">ชื่อรายการ</th>
                        <th style="padding-left:6rem;" scope="col">รายละเอียด</th>
                        <th style="padding-left:6rem;" scope="col">สถานะ</th>
                    </tr>
                    </thead>

                    <tbody style="color:#e4e4e4;">
                    <?php
                $get_user = dd_q("SELECT * FROM service_order WHERE cosid = ? ORDER BY id DESC",  [$_SESSION["id"]]);

                function st($text)
                {
                    if ($text == "no") {
                        echo "<button class='btn btn_1'>กำลังดำเนินการ <i class='fa-solid fa-exclamation'></i></i></button>";
                    } elseif ($text == "yes") {
                        echo "<button class='btn btn_2'>ทำรายการสำเร็จ <i class='fa-duotone fa-circle-check'></i></button>";
                    } elseif ($text == "not") {
                        echo "<button class='btn btn_3'>เกิดข้อผิดพลาด ติดต่อแอดมิน <i class='fa-duotone fa-circle-xmark fa-fade fa-flip-both'></i></button>";
                    }
                }

                function getimg($text)
                {

                    $i = dd_q("SELECT * FROM service_prod WHERE name = ?",  [$text]);
                    $is = $i->fetch(PDO::FETCH_ASSOC);
                    return $is["img"];
                    
                    
                }
                
                while ($row = $get_user->fetch(PDO::FETCH_ASSOC)) {
                
                ?>       
                <tr>
                    <th class="fsid " ><img src="<?php echo htmlspecialchars(getimg($row['prod'])); ?>" width="150px" height="auto"> </th>
                    <th class="fsid pe-5"><?php echo htmlspecialchars($row['prod']); ?></th>
                    <th class="fsid" ><span style="color:#67c473">UID </span> : <?php echo htmlspecialchars($row['user']); ?> &nbsp; <br></th>
                    <th ><?php echo htmlspecialchars(st($row['status'])); ?></th>
                </tr>
                <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>


        </div>


    </div>
</div>




<style>
.fsid {
    font-weight:300;
    font-size:13px;
    color:#e3e3e3;
}
.btn_1 {
    color:#fed46c;
    font-size:12px;
    background-color:#fed46c00;
    border: solid 1px #fed46c;
}

.btn_2 {
    color:#6fcc65;
    font-size:12px;
    background-color:#6fcc6500;
    border: solid 1px #6fcc65;
}

.btn_3 {
    color:#e3574e;
    font-size:12px;
    background-color:#e3574e00;
    border: solid 1px #e3574e;
}
</style>














<script>
    $(document).ready(function () {
        $('#table').DataTable();
    });
</script>




