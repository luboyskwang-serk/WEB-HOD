<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>



<div class="container-fluid bb col-lg-10 col-10">  
<div class="container-sm mt-5 shadow-sm p-4 " data-aos="fade-down" style="background-color:#0f0f0f">
    <center>
            <div class="col-12 col-lg-12 p-2 mb-2" style="border-radius: 1vh;">
                <div class="d-flex justify-content-between">
                    <div class="text-center text-lg-start">
                    <h5 class="m-0"><h5 class=" mb-2 mt-2" style="color:#e3e3e3;">
                    <i class="fa-regular fa-pen-to-square fa-fade"></i>
                    จัดการการเติมเกมส์</h5>
                    <p style="font-size:14px; color:#eaac13;"><?php echo $config['name']; ?></span></p>

                    <a href="?page=order">
                      <button class="btn btn-back text-white" onclick="del()">ประวัติการเติมเกมส์</button>
                    </a>


                    </div>

                    
                </div>
            </div>
        </center>



    <div class="d-flex container-fluid mb-2">
      <div class="row">


        <div class="col mt-4">
                      <a href="?page=service_manage_cate">
                      <img src="./assets/img/th2.png" class="img-th" width="250px" alt="">
                      <!-- <button class="btn btn-back mt-2 mb-2 text-white"  id="open_insert">
                          จัดการหมวดหมู่เติมเกมส์
                      </button> -->
                    </a>
        </div>
                 
             <div class="col mt-4">
                    <a href="?page=service_manage_main">
                    <img src="./assets/img/th1.png" class="img-th" width="250px" alt="">
                      <!-- <button class="btn btn-back mt-2 mb-2 text-white"  id="open_insert">
                          แก้ไขรายการสินค้าเติมเกมส์
                      </button> -->
                    </a>
              </div>

             
              
                    

      </div>
                    



                    
                    <style>
                      .img-th:hover {
                        filter: drop-shadow(5px 5px 30px red) invert(100%);
                      }
                        .btn-back {
                            background-color:#1c1a1a;
                            color:#507b50;
                            border-radius:1vh;
                            font-size:14px;
                        }
                        .btn-back:hover {
                            color:#2e2e2e;
                        }
                    </style>


</div>
</div>



<script type="text/javascript">
    
    $("#subm").click(function(e) {
        e.preventDefault();
        var check;
        var formData = new FormData();
        formData.append('st', $("#st").val());
        formData.append('img', $("#img").val());
        formData.append('mes', $("#mes").val());
        

        $('#btn_regis').attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: 'system/backend/service_edit.php',
            data: formData,
            contentType: false,
            processData: false,
        }).done(function(res) {
            result = res;
            console.log(result);
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
            //console.clear();
            $('#btn_regis').removeAttr('disabled');
        });
    });
</script>