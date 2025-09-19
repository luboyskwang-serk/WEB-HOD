<style>
    .form-control{
        border: 0;
        border-bottom: 2px solid var(--main);
        background-color: transparent;
    }
    .bb {
        color: #fff;

    }
    .text-bss {
        text-transform: uppercase;
            background: linear-gradient(to right, #d51f1f 0%, #ff9f00 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration:none
    }
    .btn-dz{
        background-color: #141416;
        border: solid 1px #232326;
        color:#a0a0a0;
    }
    .btn-dz:hover {
        color: #ff9f00;
    }
    


</style>


    <center>
        <h1 class="bb">เปลี่ยนรหัสผ่านสำเร็จ !</h1>
        <a href="?page=profile&subpage=cimg"  class="btn-dz btn mt-2">
            <i class="fa-light fa-arrow-left-long"></i> กลับไปที่การตั่งค่า
        </a>
       
    </center>

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