<?php
// หน้าสำหรับปิดใช้งาน 2FA
?>

<div class="container-fluid p-0 mt-4">
    <div class="container-sm m-cent ps-4 pe-4" style="margin-bottom: 4em!important;">
        <div class="container-fluid p-4 shadow-sm card-dz">
            <div class="col-lg-6 m-cent pt-4" style="margin-bottom: 4em!important;">
                <div class="text-center">
                    <h1 class="tc" style="font-size: 26px;">ปิดใช้งาน Two-Factor Authentication</h1>
                    <p class="fsh">คุณแน่ใจหรือไม่ที่ต้องการปิดใช้งาน 2FA?</p>
                    
                    <div class="alert alert-warning mt-4">
                        <i class="fa fa-exclamation-triangle"></i>
                        การปิดใช้งาน 2FA จะทำให้บัญชีของคุณมีความปลอดภัยน้อยลง
                    </div>
                    
                    <button class="btn btn-danger btn-lg mt-3" id="btn_disable_2fa">
                        <i class="fa fa-times"></i> ยืนยันการปิดใช้งาน 2FA
                    </button>
                    
                    <a href="?page=profile" class="btn btn-secondary btn-lg mt-3 ms-2">
                        <i class="fa fa-arrow-left"></i> ยกเลิก
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $("#btn_disable_2fa").click(function() {
        Swal.fire({
            title: 'ยืนยันการปิดใช้งาน 2FA',
            text: "คุณแน่ใจหรือไม่ที่ต้องการปิดใช้งาน Two-Factor Authentication?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: 'system/disable_2fa.php',
                    data: {},
                    beforeSend: function() {
                        $('#btn_disable_2fa').attr('disabled', 'disabled');
                        $('#btn_disable_2fa').html('<i class="fa fa-spinner fa-spin"></i> กำลังดำเนินการ...');
                    }
                }).done(function(res) {
                    if (res.status == "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ',
                            text: res.message
                        }).then(function() {
                            window.location = "?page=setup_2fa";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'ผิดพลาด',
                            text: res.message
                        });
                        $('#btn_disable_2fa').removeAttr('disabled');
                        $('#btn_disable_2fa').html('<i class="fa fa-times"></i> ยืนยันการปิดใช้งาน 2FA');
                    }
                }).fail(function(jqXHR) {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้'
                    });
                    $('#btn_disable_2fa').removeAttr('disabled');
                    $('#btn_disable_2fa').html('<i class="fa fa-times"></i> ยืนยันการปิดใช้งาน 2FA');
                });
            }
        });
    });
});
</script>