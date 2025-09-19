<?php
require_once 'a_func.php';

$ws = dd_q("SELECT * FROM setting WHERE 1")->fetch(PDO::FETCH_ASSOC);

function dd_return($status, $message)
{
    if ($status) {
        $json = ['message' => $message];
        http_response_code(200);
        die(json_encode($json));
    } else {
        $json = ['message' => $message];
        http_response_code(400);
        die(json_encode($json));
    }
}

// //////////////////////////////////////////////////////////////////////////

header('Content-Type: application/json; charset=utf-8;');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['id'])) {
        $p = dd_q("SELECT * FROM users WHERE id = ? ", [$_SESSION['id']]);
        $plr = $p->fetch(PDO::FETCH_ASSOC);
        if ($_POST['id'] != "") {
            $q_1 = dd_q('SELECT * FROM users WHERE id = ?', [$_SESSION['id']]);
            if ($q_1->rowCount() >= 1) {
                $row_1 = $q_1->fetch(PDO::FETCH_ASSOC);
                $p = dd_q("SELECT * FROM game WHERE id = ? ", [$_POST['id']]);
                if ($p->rowCount() >= 1) {
                    $pd = $p->fetch(PDO::FETCH_ASSOC);
                    $price = (int) $pd['price'];
                    $point = (int) $plr['point'];
                    if ($point >= $price) {

                        // subtract credit from user
                        $sub = dd_q("UPDATE users SET point = point - ? WHERE id = ? ", [$price, $_SESSION['id']]);
                        if ($sub) {

                            // check stock
                            // 1. get item
                            $f_item = dd_q("SELECT * FROM game_item WHERE p_id = ? AND type = 'reward' ", [$pd['id']]);
                            while ($item = $f_item->fetch(PDO::FETCH_ASSOC)) {
                                $stock = dd_q("SELECT * FROM game_stock WHERE p_id = ? ", [$item['id']]);
                                if ($stock->rowCount() > 0) {
                                    continue;
                                } else {
                                    $cash_back = dd_q("UPDATE users SET point = point + ? WHERE id = ? ", [$price, $_SESSION['id']]);
                                    $err = true;
                                    dd_return(false, "สินค้าในสต็อกบางส่วนหมด");
                                    break;
                                }
                            }

                            // variable to random and max random config
                            $prize = array();
                            $prize['id'] = "";
                            $prize['img'] = "";
                            $round = 0;
                            $max = 100;

                            // start random and check stock again
                            if (!isset($err)) {
                                while ($prize['id'] == "" && $round < $max && !isset($err)) {

                                    // check item stock
                                    $f_item = dd_q("SELECT * FROM game_item WHERE p_id = ? ", [$pd['id']]);
                                    while ($item = $f_item->fetch(PDO::FETCH_ASSOC)) {

                                        // get possibility
                                        $luck = rand(1, 100);
                                        $percent = (int) $item['percent'];

                                        // if get product
                                        if ($luck <= $percent) {

                                            // CHECK STOCK
                                            $stock = dd_q("SELECT * FROM game_stock WHERE p_id = ? LIMIT 1", [$item['id']]);
                                            if ($stock->rowCount() > 0 || $item['type'] != "reward") {
                                                $stock = $stock->fetch(PDO::FETCH_ASSOC);
                                                if ($item['type'] == "point") {
                                                    // ADD POINT TO USER 
                                                    $prize['add'] = (int) $item['credit'];
                                                    $insert = dd_q("UPDATE users SET point = point + ? WHERE id = ? ", [$item['credit'], $_SESSION['id']]);
                                                    $insert = dd_q("INSERT INTO boxlog (date , username , category , price , prize_name , rand , uimg , uid)
                                                        VALUES ( NOW() , ? , ? , ? , ? , 1 , ? , ? )
                                                    ", [
                                                        $plr['username'],
                                                        $pd['name'],
                                                        $price,
                                                        "เครดิตในเว็บจำนวน " . $item['credit'] . "เครดิต",
                                                        $row_1["profile"],
                                                        $_SESSION['id'],
                                                    ]);
                                                } else {
                                                    // GET STOCK AND INSERT TO BUY HISTORY
                                                    $insert = dd_q("INSERT INTO boxlog (date , username , category , price , prize_name , rand , uimg , uid)
                                                        VALUES ( NOW() , ? , ? , ? , ? , 1 , ? , ? )
                                                    ", [
                                                        $plr['username'],
                                                        $pd['name'],
                                                        $price,
                                                        $stock['data'],
                                                        $row_1["profile"],
                                                        $_SESSION['id'],
                                                    ]);
                                                    $del = dd_q("DELETE FROM game_stock WHERE id = ? ", [$stock['id']]);
                                                }
                                                $prize['id'] = $item['id'];
                                                $prize['name'] = $item['name'];
                                                $prize['img'] = $item['img'];
                                                break;
                                            } else {
                                                // set error variable for return error;
                                                $cash_back = dd_q("UPDATE users SET point = point + ? WHERE id = ? ", [$price, $_SESSION['id']]);
                                                $err = true;
                                                dd_return(false, "สินค้าในสต็อกบางส่วนหมด");
                                                break;
                                            }
                                        }
                                    }
                                    $round++;
                                }
                            }
                            if (!isset($err)) {
                                $data = array(
                                    "status" => $round,
                                    "data" => array(
                                        "id"  => $prize['id'],
                                        "img" => $prize['img'],
                                    ),
                                    "selector" => "id",
                                    "winner" => (string) $prize['id'],
                                    "message" => $prize['name'],

                                );
                                if (isset($prize['add'])) $data['data']['add'] = $prize['add'];
                                else $data['data']['add'] = 0;
                                echo json_encode($data);
                            }
                            if ($round >= $max) {
                                $cash_back = dd_q("UPDATE users SET point = point + ? WHERE id = ? ", [$price, $_SESSION['id']]);
                                dd_return(false, "โปรดลองสุ่มอีกครั้งมีบางอย่างผิดพลาด");
                            }
                        }
                    } else {
                        dd_return(false,  "เงินไม่เพียงพอ");
                    }
                } else {
                    dd_return(false,  "ไม่พบสินค้า");
                }
            } else {
                dd_return(false,  "ไม่พบชื่อผู้ใช้งาน");
            }
        } else {
            dd_return(false,  "กรุณากรอก ตัวเลข เท่านั้น");
        }
    } else {
        dd_return(false,  "เข้าสู่ระบบก่อนทำรายการ");
    }
} else {
    dd_return(false,  "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
}
