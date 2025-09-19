
<div class="container-fluid bb p-1 col-lg-8 col-10 mt-3" style="background-color:#0e0e0e;">

        <div class="container-fluid ps-3 pe-3 pb-3" style="background-color:#100f0f; box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px; border-radius:1vh;">
        
        <div class="p-2">
            <h5 class="m-0"><h5 class=" mb-2 mt-2" style="color:#c6c6c6;">
            <i class="fa-duotone fa-clock-rotate-left fa-spin fa-spin-reverse" style="--fa-primary-color: #09a811; font-size:14px; --fa-secondary-color: #15ed10;"></i>
             ประวัติการเติมเกม</h5>
             <p style="font-size:14px; color:#eaac13;">ของลูกค้าในเว็บ</span></p>
        <p style="font-size:14px; color:#eaac13;">แอดมิน : <span><?php echo htmlspecialchars(strtoupper($user['username'])); ?></span></p>
        
        </div>

       
        <div class="m-0" style="background-color:#00000000">
            
        
            <div class="table-responsive">
                <table class="table  table-striped " id="table" >
                    <thead >
                    <tr >
                        <th scope="col"  style="color:#eaac13;" class="text-center" class="sorting sorting_asc">เกมที่เติม</th>
                        <th scope="col" class="ps-3 text-center" style="color:#eaac13;">รายละเอียด</th>
                        <th scope="col" class="ps-3 text-center" style="color:#eaac13;">จำนวนเงิน</th>
                        <th scope="col" class="ps-3 text-center" style="color:#eaac13;">ไอดีที่เติม</th>
                        <th scope="col" class="ps-3 text-center" style="color:#eaac13;">รหัสอ้างอิงรายการ</th>
                        <th scope="col" class="ps-3 text-center" style="color:#eaac13;">สถานะ</th>
                        <th scope="col" class="text-center"      style="color:#eaac13;">วันที่</th>
                    </tr>
                    </thead>
                    <tbody style="color:#2c2c2c;">
                        
                    <?php 
                            $q = dd_q("SELECT * FROM his_purchase WHERE uid = ?", [$_SESSION['id']]);
                            $i = 1;
                            while($row = $q->fetch(PDO::FETCH_ASSOC)){
                                
                        ?>


                            <tr>
                            <td class="text-center" style="color:#f9ad09"><?php echo $row['product']; ?></td>
                            <td class="text-center" style="font-size:13px; color:#e8e8e8"><?php echo $row['description']; ?></td>
                            <td class="text-center" style="font-size:13px; color:#e8e8e8"><?php echo $row['price']; ?></td>
                            <td class="text-center" style="font-size:13px; color:#e8e8e8"><?php echo $row['ref']; ?></td>
                            <td class="text-center" style="font-size:13px; color:#e8e8e8"><?php echo $row['dest_ref']; ?></td>
                            <td class="text-center" style="font-size:13px; color:#e8e8e8">
                            <?php if($row['status'] == 2) {?>
                                <div class="badge alert-warning" role="alert">กำลังทำรายการ</div>
                            <?php } elseif ($row['status'] == 1) {?>
                                <div class="badge alert-success" role="alert">รายการสำเร็จ</div>
                            <?php } elseif ($row['status'] == 4) {?>
                                <div class="badge alert-danger" role="alert">รายการล้มเหลว (คืนเงินเข้าระบบ wePAY)</div>
                            <?php } else {?>
                                <div class="badge alert-secondary" role="alert">สถานะไม่ทราบ</div>
                            <?php } ?>

                            </td>
                            <td class="text-center" style="font-size:13px; color:#e8e8e8"><?php echo $row['date']; ?></td>

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

<script>
    $(document).ready(function () {
        $('#table').dataTable( {
        "order": [[ 5, "desc" ]]
} );
    });
</script>