<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.wepay.in.th/comp_export.php?json=null',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);

$data = json_decode($response, true); // แปลง JSON เป็น array

if (isset($data['data']['gtopup'])) {
  $gtopup_data = $data['data']['gtopup'];
//   print_r($gtopup_data); // แสดงข้อมูลที่ดึงออกมา
} else {
  echo "ไม่พบข้อมูล 'gtopup'";
}
?>


<div class="container-fluid p-0 ">
    <div class="container-sm  m-cent  p-0 pt-4 ">
        <div class="container-sm ">



    <div class="container-fluid">


    <center>
    <h4 class="ttcolor" style="font-weight:600;"> เติมเกมส์ออนไลน์  </h4> 
    </center>

   <div class="container-fluid mt-4">
				<div class="row justify-content-center justify-content-lg-start">
					<div class="row" >
						<?php 
						foreach ($gtopup_data as $data) {
						?>

						<style>
							.ttcolor {
								text-transform: uppercase;
								background: linear-gradient(to right, #ff4040 0%, #ff9e00 100%);
								-webkit-background-clip: text;
								-webkit-text-fill-color: transparent;
							}
							.bgcolor {
								background: linear-gradient(to right, #385bb0 0%, #00c1f0 100%);
							}
						</style>


						<div class="col-md-2 col-sm-4 col-4 px-1 d-flex align-items-stretch hvr-float pointer">
							<div class=" mb-3 p-1 w-100 aos-init aos-animate" 
							style="border-radius: 0.5vh; ; 
							;" data-aos="fade-up">
                    <a href="?page=buy_termgame&amp;game_name=<?=$data['company_id'];?>" style="text-decoration:none">
                    <div style="border-radius: 0.5vh;
                                background-image: url('/assets/game/banner/<?=$data['company_name'];?>.png');
                                background-repeat: no-repeat;
                                background-size: cover;
                                background-position: center;
                                width: 100%;
                                height: auto; /* ปรับความสูงตามที่ต้องการ */
                                filter: blur(8px);
                                -webkit-filter: blur(8px);
                                ">
                                
	
						
                            </div>
                            <div>
                                                            <img src="/assets/game/game/<?=$data['company_id'];?>.png" class="p-0" 
                                style="width:100%;   border-radius:0.5vh;
                                                    background-color: rgb(0,0,0);
                                                    background-color: rgba(0,0,0, 0.4);
                                ">
                                </div>

<h5 class="text-center mt-2 mb-2" style="color:#af7322; font-size:10px; font-weight:500;"><?=$data['company_name'];?></h5>
                  </a>
				  </div>	
						</div>

						<?php  } ?>
					</div>
                </div>


            </div>
        </div>
    </div>
</div>