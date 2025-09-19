<div class="container"  style="margin-top: -4rem;">
    <div class="card mb-4 bg-black" style="border-radius: 1vh;">
        <div class="card-body scrollable-container">
<h4 class="text-white mt-4 font-bold mb-0 text-center">ประวัติการสั่งซื้อแอพพรีเมียม</h4>
<h5 class="text-main font-bold text-center">Order Premium Application History</h5>

    <div class="table-responsive">

        <table class="table" id="table">
            <thead>
            <tr>
                <th scope="col" class="text-white ">#</th>
                <th scope="col" class="text-white text-center">รายละเอียด</th>
                <th scope="col" class="text-white text-center">วันที่</th>
                <th scope="col" class="text-white text-center">เคลม</th>
            </tr>
            </thead>
            <tbody>
    <?php 
        $q = dd_q("SELECT * FROM boxlogapp WHERE uid = ? ORDER BY id DESC", [$_SESSION['id']]);
        while($row = $q->fetch(PDO::FETCH_ASSOC)){
            
    ?>
             <tr>
                <td class="text-center text-white"><?php echo $row['product_id'];?><br><img src="<?php echo $row['image'];?>" width="50" height="50" style="border-radius: 1vh;"><br><?php echo $row['name'];?> </td>
                <td class="text-center w-50" style="color:#afafaf;" id="<?php echo number_format($i);?>"><?php echo $row['name'];?><br><?php 
                $detailapi = htmlspecialchars($row['details']);
                $detailapi = html_entity_decode($detailapi);
                $detailapi = str_replace('\n', '<br>', $detailapi);
                echo $detailapi;
                ?>
<br><button class="btn border mt-2 btn-warning" onclick="copy('<?php echo number_format($i);?>')"><i class='bx bxs-copy-alt'></i> คัดลอก</button></td>
                <td class="text-center text-white"><?php $time = $row['date']; echo time_elapsed_string("$time");?></td>
                <td class="text-white text-center"><button class="btn btn-sm btn-warning mb-2 border p-3" data-bs-toggle="modal" data-bs-target="#report<?=$row['product_id'];?>">🛒 เคลมสินค้า</button></td>
            </tr>

<div class="modal" id="report<?=$row['product_id'];?>" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header ">
                                            <h5 class="modal-title ttcolor" id="exampleModalLabel"><i class="fa fa-wrench"></i> แจ้งปัญหา</h5>
                                            <button style="border:none; padding:0.5rem; border-radius:50px;" type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa-duotone fa-circle-xmark"></i>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                        <div class="container">
                                        <iframe frameborder="0" height="450" src=" https://peamsub24hr.online/?page=report_api&id=<?=$row['product_id'];?>" width="100%"></iframe>
                                        </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button style="background-color:#e55d5d; border:none;" type="button" class="btn btn-secondary" data-dismiss="modal" class="close" aria-label="Close">ปิดหน้านี้</button>
                                    
                                        </div>
                                        </div>
                                    </div>
                                </div>	
                               

                        <?php  } ?>

</div>
            </tbody>
        </table>

    </div>
    </div>
    </div>
</div>

<?php	
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'ปี',
        'm' => 'เดือน',
        'w' => 'สัปดาห์',
        'd' => 'วัน',
        'h' => 'ชั่วโมง',
        'i' => 'นาที',
        's' => 'วินาที',
    );
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
?>
   <script>
    $(document).ready(function () {
        $('#table').dataTable( {
        "order": [[ 0, "desc" ]]
} );
    });
</script>
<script>
    function copy(row) {
        var r = document.createRange();
        r.selectNode(document.getElementById(row));
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(r);
        document.execCommand('copy');
        Swal.fire(
                                            'สำเร็จ',
                                            'คัดลอกข้อความเรียบร้อย',
                                            'success'
                                        )
        window.getSelection().removeAllRanges();
    }
</script>
