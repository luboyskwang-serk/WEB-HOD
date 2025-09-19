
<style>
    .bb {
        margin-top:-6rem;
    }
</style>
<div class="container-fluid bb p-0 col-lg-8 col-10 mt-4" style="background-color:#0e0e0e; border-radius:1vh;">
    <div class="container-sm m-auto p-2 pt-0 aos-init aos-animate" data-aos="zoom-in">


        <div class="container-fluid ps-3 pe-3 pb-3" style="border-radius:1vh;">
        
        <div class="p-2">
            <h5 class="m-0"><h5 class=" mb-2 mt-2" style="color:#e3e3e3;">
            <i class="fa-duotone fa-clock-rotate-left fa-spin fa-spin-reverse" style="--fa-primary-color: #e3e3e3; font-size:14px; --fa-secondary-color: #15ed10;"></i>
             ประวัติการสั่งซื้อ</h5>
             <p style="font-size:14px; color:#eaac13;">ของสมาชิก</span></p>
        </div>

       
        <div class="m-0" style="background-color:#00000000">
            
        
            <div class="table-responsive">
                <table class="table  table-striped " id="table" >
                    <thead >
                    <tr >
                        <th scope="col"  style="color:#eaac13;" class="text-center" class="sorting sorting_asc">   #</th>
                        <th scope="col" class="ps-3 text-center" style="color:#eaac13;">ชื่อผู้ใช้</th>
                        <th scope="col" class="ps-3 text-center" style="color:#eaac13;">รายการ</th>
                        <th scope="col" class="ps-5 text-center" style="color:#eaac13;">สินค้า</th>
                        <th scope="col" class="ps-5 text-center" style="color:#eaac13;">จำนวนเงิน</th>
                        <th scope="col" class="text-center"      style="color:#eaac13;">วันที่</th>
                    </tr>
                    </thead>
                    <tbody style="color:#2c2c2c;">

                    
                            <?php 
                                $get_user = dd_q("SELECT * FROM boxlog ORDER BY date DESC LIMIT 1000");
                                while($row = $get_user->fetch(PDO::FETCH_ASSOC)){
                            ?>


                            <tr>
                                <td style="color:#e8e8e8;"><input type="checkbox" class="checkbox" style="color:#f9ad09" value="<?php echo $row['id']; ?>">&nbsp;&nbsp;<?php echo $row['id']; ?></td>
                                <td style="color:#e8e8e8; font-size:13px;" >                       <?php echo htmlspecialchars($row['username']);?></td>
                                <td style="color:#e8e8e8; font-size:13px;" >                       <?php echo htmlspecialchars($row['category']);?></td>
                                <td style="color:#e8e8e8; font-size:13px;">                        <?php echo ($row['prize_name']);?></td>
                                <td class="text-center" style=" color:#e8e8e8; font-size:13px;"><?php echo number_format($row['price']); ?></td>
                                <td class="text-center" style="color:#e8e8e8; font-size:13px;">    <?php echo htmlspecialchars($row['date']);?></td>
                            </tr>
                        <?php
                                $i++;
                            }
                        ?>

                        </tbody>
                    </table>
                    <button class="btn btn-warning text-white mb-2" ><input type="checkbox" class="form-check-input text-white " id="checkAll" style="color:#e3e3e3; font-size:15px;"> เลือกทั้งหมด </button>
                            <button class="btn btn-danger text-white w-100" id="deleteSelected"><i class="fa-solid fa-trash"></i> ลบทั้งหมดที่เลือก</button>

                </div>
            </div>


        </div>


    </div>
</div>
<script>
    $(document).ready(function () {
        $('#table').dataTable( {
        "order": [[ 0, "desc" ]]
} );
    });
</script>
<script>

    $("#checkAll").click(function() {
        $(".checkbox").prop('checked', $(this).prop('checked'));
    });

    $("#deleteSelected").click(function() {
        var selectedItems = [];
        $(".checkbox:checked").each(function() {
            selectedItems.push($(this).val());
        });

    if (selectedItems.length > 0) {
        Swal.fire({
            title: 'ยืนยันที่จะลบ?',
            text: "คุณแน่ใจหรือไม่ที่จะลบข้อมูลที่เลือก ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ลบเลย'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: 'system/backend/buyhisdel.php',
                    data: {
                        id: selectedItems
                    },
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ',
                            text: res.message
                        }).then(function() {
                            window.location.reload();
                        });
                    },
                    error: function(jqXHR) {
                        console.log(jqXHR);
                        res = jqXHR.responseJSON;
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: res.message
                        });
                    }
                });
            }
        });
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'แจ้งเตือน',
            text: 'โปรดเลือกรายการที่ต้องการลบ'
        });
    }
});
</script>