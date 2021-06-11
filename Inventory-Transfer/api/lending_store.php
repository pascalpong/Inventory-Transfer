<?php

require_once '../../classes/Connect.class.php';
$conn =  new Connect();


$tx_id = $_POST['tx_id'];
$loca_code = $_POST['loca_id'];
$store_id = $_POST['store_id'];
$fac_code = $_POST['fac_id'];
$inv = $_POST['invlend'];
$lending_amount = $_POST['lending_amount'];
$remain_in_store = $_POST['remain_in_store'];
$ts = date("Y-m-d H:i:s");

$sql = " select * from inv_borrow_details_log where inv_code = '$inv' and store_code = '$store_id' and loca_code = '$loca_code' and  tx_id ='$tx_id' ";
$rs = $conn->queryTis620($sql);
$row = $conn->parseArray($rs);

if($row['store_code'] != ''){
    $insert = " update inv_borrow_details_log    set amount_lending = '$lending_amount'    where inv_code = '$inv' and store_code = '$store_id' and loca_code = '$loca_code' and  tx_id ='$tx_id' ";
}else{
    $insert = " insert into inv_borrow_details_log (inv_code,store_code,factory_code,loca_code,type,amount_lending,amount_existing,tx_id,ts,status) values('$inv','$store_id','$fac_code','$loca_code','LEN','$lending_amount','$remain_in_store','$tx_id','$ts','lended') ";
}

echo $insert;
//exit();
$rs_insert = $conn->queryTis620($insert);

echo 'inserted';
 

