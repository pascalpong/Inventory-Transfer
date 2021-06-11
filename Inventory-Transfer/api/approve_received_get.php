<?php

require_once '../../classes/Connect.class.php';
$conn =  new Connect();
require_once '../../classes/InvStock.class.php';
$stock = new InvStock();    

$tx_id = $_GET['tx_id'];
$ts = date("Y-m-d H:i:s");
$receive_person = $_SESSION['username'];


 

    $sql_tx = " select * from inv_tx where refno = '$tx_id' ";
//    echo $sql_tx.'<br>';
    $rs_tx = $conn->queryTis620($sql_tx);
    $data_tx = $conn->parseArray($rs_tx);
    
    if($data_tx['refno']!='' && $data_tx['txtype']!='ISS'){
        
        echo $data_tx['refno'].$data_tx['txtype'];
        
    }else{
//        echo 'here';
        $time = date('Y-m-d H:i:s',  time());
        $docdate  = date('Y-m-d');
        require_once '../../classes/CostCenter.class.php';
        $cost = new CostCenter();  
        $tx_idiss =  $stock->getNewTXID("RCV", $_SESSION["factory_code"]);
        $getCostCenter = $cost ->getCostCenter($_SESSION["factory_code"]);
        
        $update_borrow = " update inv_borrow  set receive_status = 'receive_completed' , complete_received_by = '$receive_person'  where tx_id = '$tx_id' ";
        $rs_update_borrow = $conn->queryTis620($update_borrow);
        
        $get_inv_tx = " select * from inv_borrow where tx_id = '$tx_id' ";
        $rs_inv_tx = $conn->queryTis620($get_inv_tx);
        $data_inv_tx = $conn->parseArray($rs_inv_tx);
        
        $get_hr_dept = " select hr_dept from hr where code =  '{$data_inv_tx['inv_requestor']}'  ";
        $rs_hr_dept = $conn->queryTis620($get_hr_dept);
        $data_hr_dept = $conn->parseArray($rs_hr_dept);
        
        $insert_tx = " INSERT INTO  inv_tx(tx_id,txtype,refno,txdate,spectator_id,spectator_dept,etc,create_by,docdate,factory_code,return_type,cost_center)VALUES('$tx_idiss','RCV','$tx_id','{$time}','{$data_inv_tx['inv_requestor']}','{$data_hr_dept['hr_dept']}','BORROW','{$_SESSION['username']}','{$docdate}','{$_SESSION["factory_code"]}','TRF','{$getCostCenter}') ";
        $rs_insert_tx = $conn->queryTis620($insert_tx);
        
        $transfer_borrow_to_details = " select * from inv_borrow_details_transfer where tx_id = '$tx_id'  ";
        echo $transfer_borrow_to_details;
        
        $rs_borrow_to_details = $conn->queryTis620($transfer_borrow_to_details);
        while($data_borrow_to_details = $conn->parseArray($rs_borrow_to_details)){

 
//            $update_borrow_log = " update inv_borrow_details_log set ts_receive = '$time' , received_by = '{$_SESSION['username']}' ";
//            $rs_borrow_log = $conn->queryTis620($update_borrow_log);
            
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// AVG LOT
        require_once '../../classes/InvStock.class.php';
        $stock = new InvStock();        
        $uop = $stock->getAverageByLocaStore($data_borrow_to_details['inv_code'],$data_borrow_to_details['loca_code'],$data_borrow_to_details['store_code']);
//      echo $sql;
        $sql_inv_tx = " select * from inv_tx  where refno='$refno' AND  txtype='RCV';"; 
//      echo $sql2;
        $rs_inv_tx = $conn->queryTis620($sql_inv_tx);
        if($conn->getNumRowdata($rs_inv_tx)>0){
        $rs_inv_tx = $conn->queryTis620($sql_inv_tx);
        while($row_inv_tx  = $conn->parseArray($rs_inv_tx)){
        $tx_idiss = $row_inv_tx["tx_id"];
        }
        }
            
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// END AVG
        $fac_real = " select borrowing_factory from inv_borrow where tx_id = '$tx_id' ";
        $rs_fac_real = $conn->queryTis620($fac_real);
        $row_fac_real  = $conn->parseArray($rs_fac_real);
            
        $insert_tx_details = " INSERT INTO inv_tx_details (inv_code,store_code,loca_code,factory_code,amt,uop,discount,direction,ts,tx_id,edit_acc)  VALUES('{$data_borrow_to_details['inv_code']}','{$data_borrow_to_details['store_code']}','{$data_borrow_to_details['loca_code']}','{$row_fac_real['borrowing_factory']}','{$data_borrow_to_details['amt']}','$uop','0','0','$time','$tx_idiss','1') "; 
        echo $insert_tx_details.'<br>'.'updated'.'<br>';
        $rs_insert_tx_details = $conn->queryTis620($insert_tx_details);
        

        $update_details_id = " update inv_borrow_details_log set rcv_details_tx_id = '$tx_idiss' , receive_status = 'confirmed_approved' , confirm_receive_by = '$receive_person' ,ts_confirm_receive = '$ts'  where tx_id = '$tx_id' and inv_code = '{$data_borrow_to_details['inv_code']}'  ";
        echo $update_details_id.'<br>';
        $rs_update_details_id = $conn->queryTis620($update_details_id);   
  
        }

    }
    

 