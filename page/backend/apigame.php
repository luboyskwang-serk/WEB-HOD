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

<style>
     .tblu-1 {
                border:none;
                padding:0.5rem;
                border-radius:1vh;
                color:#f4f4f4;
                background: linear-gradient(to right, #d51f1f 0%, #ff9f00 100%);
        }
    .tblu-2 {
                border:none;
                padding:0.5rem;
                border-radius:1vh;
                color:#262626;
                background: linear-gradient(to right, #b5b5b5 0%, #fcfcfc 100%);
        }
    .ff {
        text-transform: uppercase;
            background: linear-gradient(to right, #d51f1f 0%, #ff9f00 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration:none
    }
    .bg-from {
        background-color:#030508; 
        border:none;
        padding:0.5rem 1.5rem;
        margin-top:0.5rem;
        border-radius:1vh;
    }
           
</style>

<div class="container-sm mt-0  p-4 mb-4" data-aos="fade-down">

    <center>
        <h3 class="ff">ระบบจัดการ API WEPAY Games</h3>
    </center>
    
    <div class="col-lg-6 m-auto">

        <div class="mb-2 <?php echo $bg?> shadow-sm p-4 mb-4 rounded">
            

        <p class="m-0 text-secondary">เปิดใช้งาน / ปิด <span class="text-danger">*</span></p>
            <select class="form-control mb-2 bg-from"  id="apistatus">
                <option value="2" <?php if ($apistatus == 2) {echo "selected";} ?> style="color: #000">เปิดใช้งาน</option>
                <option value="1" <?php if ($apistatus == 1) {echo "selected";} ?> style="color: #000">ปิดใช้งาน</option>
            </select>


            <div class="mb-2 text-secondary">
                <p class="m-0  ">Username <span class="text-danger">*</span></p>
                <input type="text" id="apipubkey" class="form-control bg-from" value="<?php echo $apipubkey; ?>">
            </div>

            <div class="mb-2 text-secondary">
                <p class="m-0  ">Password <span class="text-danger">*</span></p>
                <input type="text" id="apisecrets" class="form-control bg-from" value="<?php echo $apisecrets; ?>">
            </div>

            <div class="mb-2 text-secondary">
                <p class="m-0">Price % (+ COST) <span class="text-danger">* (กรอกเป็นตัวเลขแทนค่า % ได้เลย)</span></p>
                <input type="text" id="apiprice" class="form-control bg-from" value="<?php echo $apiprice; ?>">
            </div>

            <div class="mb-2 text-white text-center">
                <?php $apicosts = 30;?>
                <p class="m-0 ">ตัวอย่างเมื่อบวก % แล้ว (ต้นทุน 30 บาทและ % ที่คุณตั้งคือ <?php echo $apiprice; ?>% ) ราคาที่จะเห็นหน้าร้าน = <?php echo ($apiprice/100)*$apicosts+$apicosts;?> </p>
            </div>
            
            <button class="tblu-1 w-100" id="submit">บันทึกข้อมูล</button>
        </div>
        



    

    </div>
</div>
<script type="text/javascript">
   $("#submit").click(function(e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append('apistatus', $("#apistatus").val());
    formData.append('apipubkey', $("#apipubkey").val());
    formData.append('apisecrets', $("#apisecrets").val());
    formData.append('apiprice', $("#apiprice").val());
    $('#submit').attr('disabled', 'disabled');
    $.ajax({
        type: 'POST',
        url: 'system/backend/apigame_edit.php',
        data: formData,
        contentType: false,
        processData: false,
    }).done(function(res) {
        console.log(res);
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ',
            text: res.message
        }).then(function() {
            window.location = "?page=<?php echo $_GET['page']; ?>";
        });
    }).fail(function(jqXHR) {
        console.log(jqXHR);
        var res = JSON.parse(jqXHR.responseText);
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: res.message
        })
        $('#submit').removeAttr('disabled');
    });
});

</script>
