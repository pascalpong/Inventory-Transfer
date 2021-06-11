<?php

require_once '../../classes/Connect.class.php';
$conn =  new Connect();



$tx_id = $_POST['tx_id'];
$inv = $_POST['inv_code'];
$receiver = $_SESSION['username'];
$store = $_POST['store'];
$location = $_POST['location'];
$ts = date("Y-m-d H:i:s");
$amt_movein = $_POST['amt_movein'];





$insert_tx = " insert into inv_borrow_details_transfer (tx_id,inv_code,store_code,loca_code,amt,uop) values ('$tx_id','$inv','$store','$location','$amt_movein','000')   ";
$rs_ins_tx = $conn->queryTis620($insert_tx);

$checkAmt = " select amount_lending from inv_borrow_details_log where tx_id = '$tx_id' and inv_code = '$inv' ";
                            $rs_checkAmt = $conn->queryTis620($checkAmt);
                            $row_checkAmt = $conn->parseArray($rs_checkAmt);
                            
$checkAmtReceived = " select sum(amt) as total_rec from inv_borrow_details_transfer where tx_id = '$tx_id' and inv_code = '$inv' ";
                            $rs_checkAmtRec = $conn->queryTis620($checkAmtReceived);
                            $row_checkAmtRec = $conn->parseArray($rs_checkAmtRec);
                            
                            
if($row_checkAmt['amount_lending'] != $row_checkAmtRec['total_rec']){
        $check = 'not-yet-received-all';
}else{
        $check = 'received-not-approved-yet';
}

$update = " update inv_borrow_details_log set receive_status = '$check' , ts_receive = '$ts' , received_by = '$receiver' , received_store = '$store' , received_location = '$location'  where tx_id = '$tx_id' and inv_code = '$inv' " ;
//echo $update;
//exit();
$rs = $conn->queryTis620($update);
//echo $update;
echo 'updated';
 
