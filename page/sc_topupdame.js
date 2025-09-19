<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
    $('#uid').on('input', function() {
        if ($(this).val().trim() !== '') {
            $('.uid-error').hide();
        } else {
            $('.uid-error').show();
        }
    });

 $(".shop-btne").click(function(e) {
   e.preventDefault();
   var code = $(this).attr("data-code");
   var description = $(this).attr("data-description");
   var price = $(this).attr("data-price");
   var product = $(this).attr("data-product");
   var uid = $("#uid").val();
   var server = $("#server").val();

   


   if (uid.trim() === "") {
       Swal.fire({
           icon: 'error',
           title: 'กรุณากรอก UID',
           text: 'โปรดกรอก UID ก่อนทำการสั่งซื้อ',
       });
       return;
   }

   Swal.fire({
       title: 'ยืนยันการสั่งซื้อ',
       html: "ท่านได้สั่งซื้อ<b> "+name+"</b><br> UID : <b>" +  uid + " </b> <br>ราคา : <b>฿"+price+"</b><br>กรุณาเช็คให้เรียบร้อยก่อนกดยืนยัน" , 
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'ยืนยัน',
       footer:"<h4 class='text-danger'>คำเตือน !! <br> หากกรอก UID ผิดทางร้านจะไม่รับผิดชอบกับความเสียหายที่เกิดขึ้น กรุณาเช็ครหัสให้ถี่ถ้วนก่อนเติมเข้าระบบ</h4>"
   }).then((result) => {
       if (result.isConfirmed) {
           Swal.fire({
               title: 'คำเตือน',
               html: 'หากกรอก UID ผิดทางร้านจะไม่รับผิดชอบกับความเสียหายที่เกิดขึ้น กรุณาเช็ครหัสให้ถี่ถ้วนก่อนเติมเข้าระบบ',
               icon: 'error',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'ยืนยัน',
               cancelButtonText: 'ยกเลิก'
           }).then((result) => {
               if (result.isConfirmed) {
                   Swal.fire({
                       icon: 'warning',
                       title: 'กรุณารอสักครู่',
                       text: 'ระบบกำลังดำเนินการสั่งซื้อ..',
                       allowOutsideClick: false,
                       allowEscapeKey: false,
                       allowEnterKey: false,
                       showConfirmButton: false,
                       onOpen: () => {
                           Swal.showLoading();
                       }
                   });
                   $(this).attr('disabled', 'disabled'); // ตั้งค่าปุ่มเป็น disabled เพื่อป้องกันการคลิกซ้ำ

                   var formData = new FormData();
                   formData.append('ref', $("#uid").val());
                   formData.append('id', code);
                   formData.append('product', product);
                   formData.append('server', server);
                   formData.append('description', description);

                   

                   // ตัวอย่างเพิ่มโค้ด JavaScript สำหรับการส่งข้อมูลไปยัง URL
                   $.ajax({
                       type: 'POST',
                       url: 'system/buy_termgame_api.php',
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
                               window.location = "?page=profile&subpage=histermgame";
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
   });
});

</script>