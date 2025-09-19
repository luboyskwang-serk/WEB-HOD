<?php
$f = dd_q("SELECT * FROM setting");
$dt = $f->fetch(PDO::FETCH_ASSOC);
$keyapip = $dt['keyapipeamsub'];

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://peamsub24hr.online/api/money',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_HTTPHEADER => array('apikey: ' . $keyapip),
));

$response = curl_exec($curl);
$peamsub = json_decode($response);
curl_close($curl);
?>
<?php
//topup by day
date_default_timezone_set("Asia/Bangkok");
$midnight = strtotime("today 00:00");
$date_day =  date('Y-m-d H:i:s', $midnight);
$q_1 = dd_q("SELECT sum(amount) AS total FROM topup_his WHERE date > ?", [$date_day]);
$day = $q_1->fetch(PDO::FETCH_ASSOC);
if ($day["total"] == null) {
    $day["total"] = "0.00";
}
// topup by month
date_default_timezone_set("Asia/Bangkok");
$midnight = strtotime("today 00:00");
$date_month =  date('Y-m-01 H:i:s', $midnight);
$q_2 = dd_q("SELECT sum(amount) AS total FROM topup_his WHERE date > ?", [$date_month]);
$month = $q_2->fetch(PDO::FETCH_ASSOC);
if ($month["total"] == null) {
    $month["total"] = "0.00";
}
// topup all
$q_3 = dd_q("SELECT sum(amount) AS total FROM topup_his ");
$topup = $q_3->fetch(PDO::FETCH_ASSOC);
if ($topup["total"] == null) {
    $topup["total"] = "0.00";
}
//shop by day
$q_4 = dd_q("SELECT id FROM boxlog WHERE date > ?", [$date_day]);
$box_day = $q_4->rowCount();
// shop by month
$q_5 = dd_q("SELECT id FROM boxlog WHERE date > ?", [$date_month]);
$box_month = $q_5->rowCount();
// shop by all
$q_6 = dd_q("SELECT id FROM boxlog");
$box_all = $q_6->rowCount();

?>

<style>
    .ff {
        text-transform: uppercase;
        background: linear-gradient(to right, #d51f1f 0%, #ff9f00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-decoration: none
    }

    .boxcard {
        background-color: #000;
        box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
        border-radius: 10px;
    }

    @media only screen and (max-width: 600px) {
        .fsm {
            font-size: 13px;
        }
    }
</style>


<div class="container-sm mt-0 shadow-sm p-4 mb-4">
    <div class="row jusify-content-between  mt-4">


        <div class="col-lg-12 mb-2">

            <div class="container-fluid boxcard p-4">
                <center>
                    <h1 class="td"><?php echo $topup["total"]; ?>฿</h1>
                    <h5 class="text-dark fsm">การเติมเงินทั้งหมด</h5>
                </center>
            </div>
        </div>

        <div class="col-lg-4 col-6 mb-2">
            <div class="container-fluid boxcard p-4">
                <center>
                    <h1 class="td"><?php echo $box_day; ?></h1>
                    <h5 class="text-dark fsm">การซื้อสินค้าวันนี้</h5>
                </center>
            </div>
        </div>

        <div class="col-lg-4 col-6 mb-2">
            <div class="container-fluid boxcard p-4">
                <center>
                    <h1 class="td"><?php echo $day["total"]; ?>฿</h1>
                    <h5 class="text-dark fsm">ยอดการเติมในวันนี้</h5>
                </center>
            </div>
        </div>

        <div class="col-lg-4 col-6  mb-2">
            <div class="container-fluid boxcard p-4">
                <center>
                    <h1 class="td"><?php echo $box_month; ?></h1>
                    <h5 class="text-dark fsm">การซื้อสินค้าเดือนนี้</h5>
                </center>
            </div>
        </div>

        <div class="col-lg-6 col-6 mb-2">
            <div class="container-fluid boxcard p-4 ">
                <center>
                    <h1 class="td "><?php echo $month["total"]; ?>฿</h1>
                    <h5 class="text-dark fsm">การเติมเงินเดือนนี้</h5>
                </center>
            </div>
        </div>

        <div class="col-lg-6 col-12 mb-2">
            <div class="container-fluid boxcard p-4">
                <center>
                    <h1 class="td"><?php echo $box_all; ?></h1>
                    <h5 class="text-dark fsm">การซื้อสินค้าทั้งหมด</h5>
                </center>
            </div>
        </div>

    </div>
    <style>
        .td {
            color: #c8c8c8
        }
    </style>

   