<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Sarabun:100,200,400,300,500,600,700" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"/>	
	<script src="https://css_script.byshop.me/buy/_dist/js/jquery.min.js"></script>
	<script src="https://css_script.byshop.me/buy/_dist/js/datatables.min.js"></script>
	<script src="https://css_script.byshop.me/buy/_dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://css_script.byshop.me/buy/css/fontawesome-5.2.0.css">
	<script src="https://css_script.byshop.me/buy/_dist/js/sweetalert.min.js"></script>
  </head>
  <body>
 <style type="text/css">
	body
	{
		font-family:"Sarabun", sans-serif;
		 background-color: #d4d8de;
	}
</style >
<br>
<div class="container" style="margin-top:100px;margin-bottom:100px;">
 <div class="container  rounded-6 shadow-40 mt-3"  style="background: white;border-radius: 10px;padding: 20px;"  data-aos="flip-down" data-aos-anchor="#example-anchor" data-aos-offset="500" data-aos-duration="1500">
<br>
<span class="card-title"><b><i class="fa fa-shopping-bag" aria-hidden="true"></i> รายการสั่งซื้อ </b> <span style="color:#999;font-size: 75%; ">(ล่าสุด)</h6></span>
<hr>
<marquee direction="left">
<div class=" d-flex flex-row ">
                <?php
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api_app_premium.byshop.me/api/history',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 1,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  //ดึกรายการซื้อสินค้า API ใส่ keyapi เพื่อแสดงรายการขาย
  CURLOPT_POSTFIELDS => array('keyapi' => 'ใส่Keyapiของท่าน'),  
  CURLOPT_HTTPHEADER => array(
    'Cookie: PHPSESSID=u8df3d96ij8re36ld76cl64t3p'
  ),
));


                    $response = curl_exec($curl);
                    $listbuy = json_decode($response);
                    $product_list_buy = '';
					//กำหนดรายการขายล่าสุด 10 รายการ
                    for ($i=0; $i < 10 ; $i++) { 
                        $product_list_buy .= '

<div style="background-color: #ffffff;font-size: 60%" class=" d-flex mr-5 mt-3"> <br>  
<img class="img-fluid rounded" style="margin:0 auto;  height: 50px;" src="https://img_app.byshop.me/buy/img/img_app/'. substr ($listbuy[$i]->name ,0,2).'.png">
<span><b>&nbsp;&nbsp;&nbsp;'. $listbuy[$i]->name .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
<br>&nbsp;&nbsp;&nbsp;'. $listbuy[$i]->time .'<br>
<b><p style="font-size: 13px">&nbsp;&nbsp;<span class="rounded-pill badge bg-success">&nbsp;&nbsp;<i class="fa fa-check-circle" aria-hidden="true"></i> ขายแล้ว !! &nbsp;&nbsp;</span></b></p>
</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
						';
                    }
					
					
					// แสดงรายการขาย
                    echo $product_list_buy;
                    curl_close($curl);
                ?>


    </marquee>        
        </div>


