<?php

require_once '../../classes/Connect.class.php';
$conn =  new Connect();
require_once '../../classes/InvStock.class.php';
$stock = new InvStock();    

$user_approve = $_POST['user_approve'];
$tx_id = $_POST['tx_id'];
$total_rounds = $_POST['total_rounds'];

$ts = date("Y-m-d H:i:s");


        $cancel_stat = " update inv_borrow_details_log set status = 'lended_canceled' , approve_ts = '$ts' , approve_person = '$user_approve' where tx_id = '$tx_id' " ;
//        echo $cancel_stat;
//        exit();
        $rs_cancel = $conn->queryTis620($cancel_stat);

//echo $update;
echo 'updated';


