<style>
    .ttcolor {
            text-transform: uppercase;
            background: linear-gradient(to right, #89dd81 0%, #477a55  100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .textbb {
            color:#484848;
            font-size:13px;
            margin-bottom:10px;
        }
        .bg-xx {
            background: linear-gradient(to right, #89dd81 0%, #477a55  100%);
        }
</style>
<div class="container-fluid p-4">
    <div class="container-sm  ps-4 pe-4">
        <div class="container-fluid  p-1">
            <div class="col-lg-6 m-auto">
            
            <!-- หัว -->
            <center class="mt-2 mb-2">
                <span class="h4 ttcolor"><b>ช่องทางการชำระเงิน</b></span>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb d-flex justify-content-center mt-0">
                        <li class="breadcrumb-item"><p class="ttcolor" style="text-decoration: none; color: #6C757D; font-size:13px;"> เติมเงินโดยใช้โค๊ดจากร้าน</p></li>

                    </ol>
                </nav>
            </center>


            <img src="" alt="">

            <div data-aos="fade-left" data-aos-duration="750">
                <center><span class="textbb">* แต่ละโค้ดสามารถใช้งานได้หนึ่งครั้งต่อหนึ่งบัญชี</span></center>
                <input type="text" id="link" class="form-control text-center mt-1" style="border-radius: 1vh;" placeholder="กรอกโค้ดที่ได้รับที่นี่" >
            </div>
            <button class="bg-xx btn mt-2 text-white w-100" id="redeem-btn" style="border-radius: 1vh;" data-aos="fade-up" data-aos-duration="800">ยืนยันการใช้งาน
            <i class="fa-duotone fa-circle-check fa-fade" style="--fa-primary-color: #2da413; --fa-secondary-color: #2da413;"></i></button>
            </div>

            <center class="p-2">
                <p class="m-2" style="font-size:13px; color:#3f3f3f;">หากกดทำรายการไม่ได้ ให้ทำการรีเซ็ตหน้าเว็บใหม่ครับ</p>
            </center>
        </div>
    </div>
</div>


<script>
    $("#redeem-btn").click(function(){
        var formData = new FormData();
        formData.append('link'  , $("#link").val());
        $.ajax({
            type: 'POST',
            url: 'system/redeem.php',
            data:formData,
            contentType: false,
            processData: false,   
        }).done(function(res){
            result = res;
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ',
                text: result.message
            }).then(function() {
                    window.location = "?page=<?php echo $_GET['page'];?>";
            });
        }).fail(function(jqXHR){
            console.log(jqXHR);
            res = jqXHR.responseJSON;
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: res.message
            })
            //console.clear();
        });
        // $("#save_btn").attr("data-id") <- id user
    });
</script>