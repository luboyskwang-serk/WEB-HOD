
<style>
    .bb {
        margin-top:-6rem;
    }
    
</style>
<div class="container-fluid bb p-1 col-lg-10 col-10" style="background-color:#0e0e0e;">

        <div class="container-fluid ps-3 pe-3 pb-3" style="background-color:#100f0f; box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px; border-radius:1vh;">
        
        <div class="p-2">
            <h5 class="m-0"><h5 class=" mb-2 mt-2" style="color:#c6c6c6;">
            <i class="fa-duotone fa-clock-rotate-left fa-spin fa-spin-reverse" style="--fa-primary-color: #09a811; font-size:14px; --fa-secondary-color: #15ed10;"></i>
             ประวัติการเติมเงิน</h5>
             <p style="font-size:14px; color:#eaac13;">ของคุณ : <span><?php echo htmlspecialchars(strtoupper($user['username'])); ?></span></p>
        </div>

       
        <div class="m-0" style="background-color:#00000000">
            
        
            <div class="table-responsive">
                <table class="table  table-striped " id="table" >
                    <thead >
                    <tr >
                        <th scope="col"  style="color:#eaac13;" class="text-center" class="sorting sorting_asc">ลำดับ</th>
                        <th scope="col" class="ps-3 text-center" style="color:#eaac13;">จำนวนเงิน</th>
                        <th scope="col" class="text-center"      style="color:#eaac13;">วันที่</th>
                    </tr>
                    </thead>
                    <tbody style="color:#2c2c2c;">
                        <?php 
                            $q = dd_q("SELECT * FROM topup_his WHERE uid = ? ORDER BY id DESC ", [$_SESSION['id']]);
                            $i = 1;
                            while($row = $q->fetch(PDO::FETCH_ASSOC)){
                                
                        ?>


                            <tr>
                            <td class="text-center" style="color:#f9ad09"><?php echo $row['id'];?></td>
                            <td class="text-center" style="font-size:13px; color:#e8e8e8"><?php echo htmlspecialchars($row['amount']);?></td>
                            <td class="text-center" style="font-size:13px; color:#e8e8e8"><?php echo htmlspecialchars($row['date']);?></td>
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
        $('#table').DataTable();
    });
</script>