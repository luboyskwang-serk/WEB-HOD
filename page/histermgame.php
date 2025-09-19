



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
             ประวัติการเติมเกมส์</h5>
             <p style="font-size:14px; color:#eaac13;">ของคุณ : <span><?php echo htmlspecialchars(strtoupper($user['username'])); ?></span></p>
        </div>

       
        <div class="m-0" style="background-color:#00000000">
            
        
            <div class="table-responsive">
                <table class="table  table-striped " id="table" >
                    
                <thead >
                    <tr  style="color:#ffffff;">
                        <th scope="col" class="text-center">#</th>
                        <th style="padding-left:-6rem;" scope="col">เกมที่เติม</th>
                        <th style="padding-left:6rem;" scope="col">รายละเอียด</th>
                        <th style="padding-left:6rem;" scope="col">จำนวนเงิน</th>
                        <th style="padding-left:6rem;" scope="col">วันที่ทำรายการ</th>
                    </tr>
                    </thead>


                        <tbody style="color:#ffffff;">
                        <?php 
                            $q = dd_q("SELECT * FROM his_purchase WHERE uid = ? AND type = 'game' ", [$_SESSION['id']]);
                            $i = 1;
                            while($row = $q->fetch(PDO::FETCH_ASSOC)){
                                
                        ?>


                            <tr style="color:#ffffff;">
                                <td style="color:#ffffff;"><?php echo $i; ?></td>
                                <td style="color:#ffffff;"><?php echo $row['product']; ?></td>
                                <td style="color:#ffffff;"><?php echo $row['description']; ?></td>
                                <td style="color:#ffffff;"><?php echo $row['price']; ?></td>
                                <td style="color:#ffffff;"><?php echo $row['date']; ?></td>
                            </tr>
                        <?php
                                $i++;
                            }
                        ?>

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




