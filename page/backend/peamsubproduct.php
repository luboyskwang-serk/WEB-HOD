<div class="container-sm bg-black border-2 mt-5 shadow-sm p-4 mb-4">
    <center>
        <h2 class="text-white">&nbsp;<i class="fa-duotone fa-shopping-basket"></i>&nbsp;จัดการสินค้า Peamsub24hr</h2>
    </center>
    <hr class="mt-1 mb-1 border-black">
    <div class="table-responsive mt-3 ">
        <table id="table" class="table mt-2">
            <thead class="table-dark bg-black ">
                <tr class="">
                    <th class="sorting sorting_asc">id</th>
                    <th> ภาพสินค้า</th>
                    <th> ชื่อสินค้า</th>
					<th> คำอธิบาย</th>
                    <th> หมวดหมู่</th>
                    <th> ราคา API</th>
                    <th> ราคาปกติ</th>
                    <th> แก้ไข</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $get_user = dd_q("SELECT * FROM apipeam_product ORDER BY id DESC");
                while ($row = $get_user->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td class="text-white"><?php echo $row['id']; ?></td>
                        <td class="text-white"><img src="<?php echo htmlspecialchars($row['img']); ?>" width="100px" alt=""></td>
                        <td class="text-white"><?php echo htmlspecialchars($row['name']); ?></td>
						<td class="text-white"><?php echo ($row['des']); ?></td>
                        <td class="text-white"><?php echo ($row['c_type']); ?></td>
                        <td class="text-white"><?php echo number_format($row['price_default']); ?></td>
                        <td class="text-white"><?php echo number_format($row['price']); ?></td>
                        <td><button class="btn btn-warning text-white w-100" style="width : 130px!important" onclick="get_detailpeamsub(<?php echo $row['id']; ?>)"><i class="fa-solid fa-pencil"></i>&nbsp;แก้ไข</button>
                        
                        <?php if ($row['showitem'] == 0): ?>
                                            <button type="button" class="btn btn-sm btn-danger mt-1 mb-1 w-100" style="width : 130px!important"><i class="fa-solid fa-eye-slash"></i> ปิดขายอยู่</button>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-sm btn-success mt-1 mb-1 w-100" style="width : 130px!important"><i class="fa-solid fa-eye"></i> เปิดขายอยู่</button>
                                        <?php endif; ?>

                        </td>
                    </tr>
                    <script type="text/javascript">
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="product_detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa-duotone fa-pencil"></i>&nbsp;&nbsp;แก้ไขสินค้า</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-10 m-cent ">
                    <div class="mb-2">




                    <div class="mb-2">
                            <p class="text-secondary mb-1">เปิด-ปิดการขายสินค้า <span class="text-danger">*</span></p>
                            <select class="form-select" id="showitem">
                                <option value="1" selected>✔️ เปิดการขายสินค้ารายการนี้</option>
                                <option value="0" >❌ ปิดการขายสินค้ารายการนี้</option>
                            </select>
                        </div>


                        <div class="mb-2">
                            <p class="text-secondary mb-1">ชื่อสินค้า <span class="text-danger">*</span></p>
                            <input type="text" id="name" class="form-control" value="userproduct">
                        </div>
                        <div class="mb-2">
                            <p class="text-secondary mb-1">ลิงค์รูปภาพ <span class="text-danger">*</span></p>
                            <input type="text" id="img" class="form-control" value="">
                        </div>
                        <div class="mb-2">
                            <p class="text-secondary mb-1">รายละเอียด <span class="text-danger">*</span></p>
                            <textarea id="des" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="mb-2">
                            <p class="text-secondary mb-1">หมวดหมู่สินค้า <span class="text-danger">*</span></p>
                            <select class="form-select" id="type_category">
                                <option value="0" selected>เลือกหมวดหมู่</option>
                                <?php
                                $addgr = dd_q("SELECT * FROM category ORDER BY c_id DESC");
                                while ($row = $addgr->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <option id="c_type_selected" value="<?= $row['c_name'] ?>"><?= $row['c_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <p class="text-secondary mb-1">API Price<span class="text-danger">*</span></p>
                            <input type="text" id="price_default" class="form-control" disabled value="0">
            </div>

                        <div class="mb-2">
                            <p class="text-secondary mb-1">ราคาสินค้า <span class="text-danger">*(ปกติ)</span></p>
                            <input type="text" id="price" class="form-control" value="0">
                        </div>
                     
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" id="save_btn" data-id="">บันทึก</button>
            </div>
        </div>
    </div>
</div>
<script>


    $("#open_insert").click(function() {
        const myModal = new bootstrap.Modal('#product_insert', {
            keyboard: false
        })
        myModal.show();
    });
    $("#save_btn").click(function(e) {
        var formData = new FormData();
        formData.append('id', $("#save_btn").attr("data-id"));
        formData.append('img', $("#img").val());
        formData.append('price_default', $("#price_default").val());
        formData.append('price', $("#price").val());
        formData.append('des', $("#des").val());
        formData.append('c_type', $("#type_category").val());
        formData.append('showitem', $("#showitem").val());
        formData.append('name', $("#name").val());
        $.ajax({
            type: 'POST',
            url: 'system/backend/product_updatepeamsub.php',
            data: formData,
            contentType: false,
            processData: false,
        }).done(function(res) {
            result = res;
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ',
                text: result.message
            }).then(function() {
                window.location = "?page=<?php echo $_GET['page']; ?>";
            });
        }).fail(function(jqXHR) {
            console.log(jqXHR);
            res = jqXHR.responseJSON;
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: res.message
            })
        });
    });

    function get_detailpeamsub(id) {
        var formData = new FormData();
        formData.append('id', id);

        $.ajax({
            type: 'POST',
            url: 'system/backend/call/product_detailpeamsub.php',
            data: formData,
            contentType: false,
            processData: false,
        }).done(function(res) {
            console.log(res);
            $("#name").val(res.name);
            $("#img").val(res.img);
            $("#price_default").val(res.price_default);
            $("#price").val(res.price);
            $("#des").val(res.des);
            $("#c_type").val(res.c_type);
            $("#showitem").val(res.showitem);
            $("option[value='"+res.c_type+"']").attr('selected', 'selected');
            $("#save_btn").attr("data-id", id);
            const myModal = new bootstrap.Modal('#product_detail', {
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
<script>

</script>