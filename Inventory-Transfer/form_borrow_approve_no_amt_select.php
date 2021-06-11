<?
session_start();

 if($_SESSION["factory_code"]==""){
             echo "session หมดอายุ กรุณาออกจากโปรแกรมแล้ว login ใหม่";
             exit();
 }

include '../config/variable_th.php';

$chk = false;
require_once '../classes/Connect.class.php';
$conn =  new Connect();

//require_once '../classes/Utility.class.php';
//$uu =  new Utility();
//
//require_once '../classes/CostCenter.class.php';
//$cost = new CostCenter();
//$getCostCenter = $cost ->getCostCenter($_SESSION["factory_code"]);
//
//    
    
    
     if(isset($_GET['tx_id'])){
     
 
$sql = " select * from inv_borrow where tx_id = '{$_GET['tx_id']}'  ";

//echo $sql ;
     $rs = $conn->queryTis620($sql);
 
      $data = $conn->parseArray($rs);
}
    
    if(isset($_POST["add"])){

        $ts = date("Y-m-d H:i:s");
        $tx_id  =  $data['tx_id'];
        
        $inv_only_code = explode( '(',$_POST['invcode']);
//        print_r($inv_only_code);
        $fac_code = " select lending_factory from inv_borrow where tx_id = '$tx_id' ";
        $rs_fac_code = $conn->queryTis620($fac_code);
        $data_fac_code = $conn->parseArray($rs_fac_code);
        
        $insert_details = " insert into inv_borrow_details (inv_code,loca_code,amt,tx_id,ts,factory_code) values('$inv_only_code[0]','{$data['lending_factory']}','{$_POST['borrow_amt']}','$tx_id','$ts','{$data_fac_code['lending_factory']}') ";
//        echo $insert_details;
//        exit();
        $ins_details = $conn->queryTis620($insert_details);
        
        
        
        header( "location: form_borrow_approve.php?tx_id=$tx_id" );
    }
//    
    
    
    
    
    
        if($_GET['approve']=='approve'){
         $ts = date("Y-m-d H:i:s");
         $approve_by = $_GET['approve_by'];
         $tx_id  =  $data['tx_id'];
         $approve = " update inv_borrow set approve_by = '$approve_by' , approve_ts = '$ts' , status = 'approved' where tx_id = '$tx_id'   ";
         $ins_approve = $conn->queryTis620($approve);
//         echo $approve;
        }
        
        
        if($_GET['approve']=='cancel'){
         $ts = date("Y-m-d H:i:s");
         $approve_by = $_GET['approve_by'];
         $tx_id  =  $data['tx_id'];
         $dis_approve = " update inv_borrow set approve_by = '$approve_by' , approve_ts = '$ts' , status = 'cancel' where tx_id = '$tx_id'   ";
         $ins_dis_approve = $conn->queryTis620($dis_approve);
//         echo $dis_approve;
        }

 
    $chk = FALSE;
    

 


?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>

        <style type="text/css">
            .tableform{
                background-color: #f5f5f5;
                font-family:  Verdana,sans-serif;
            }
            .btn-save{
                text-decoration: none;
                color: gray;
            }
            .btn-save:hover{
                background-color: #D9D9D9;
                color: white;
            }
            .fontsizea{
                font-family:  Verdana,sans-serif;
                font-size: 12px;
            }
            .fieldNotNull{
                background-color: #fffacd;
            }
            .fieldRequest{
                background-color: #fffacd;
                border: 1px solid red;
            }
        </style>
        <!-- Beginning of compulsory code below -->
        <meta http-equiv="content-type" content="text/html; charset=tis-620" />
        
        <link href="../include/jquery/jquery-ui.css" media="screen" rel="stylesheet" type="text/css" />
        <script  type="text/javascript" src="../include/jquery/jquery-1.7.2.min.js"> </script>
        <script  type="text/javascript" src="../include/jquery/jquery-ui.min.js"> </script>
        
        
         <link href="../style/font-page.css" rel="stylesheet" type="text/css"/>
            <link href="../include/unifrom/css/uniform.default.css" rel="stylesheet" type="text/css"/>
            <script  type="text/javascript" src="../include/unifrom/jquery.uniform.js"> </script>
        
        
        <script type="text/javascript">
            
            
            $(document).ready(function(){
                  getHrDept('<? echo $data["division_desti"]; ?>');
                
                
                                    <?  if($data["status"]=="2"){ ?>
                         
//                          document.getElementById("bb").style.visibility = "hidden"; 
                
                        
                <? } ?>
                
                
                  $('.tinput tbody tr:odd').addClass('trgray');
                
                 $( "#dialogWo" ).dialog({
                            height: 500,
                            width:770,
                            modal: true,
                            autoOpen: false
                    });
                    
                         $( "#dialog-form-division" ).dialog({
                            height: 500,
                            width:740,
                            modal: true,
                            autoOpen: false
                    });  
                     $( "#dialog-form-divisionx" ).dialog({
                            height: 500,
                            width:740,
                            modal: true,
                            autoOpen: false
                    });  
                    
                  
                     $( "#dialogWo7" ).dialog({
                            height: 500,
                            width:740,
                            modal: true,
                            autoOpen: false
                    });  
                      $( "#dialogMc" ).dialog({
                            height: 500,
                            width:740,
                            modal: true,
                            autoOpen: false
                    });  
                    
                                  $( "#dialog-form-hr" ).dialog({
                    autoOpen: false,
                    height: 400,
                    width: 650,
                    modal: true,
                    buttons: {
                        "<? echo $butt_ok; ?>": function() {
                            togetChecked();
                            $( this ).dialog( "close" );
                        },
                        "<? echo $cancel_txt; ?>": function() {
                            $( this ).dialog( "close" );
                        }	
                    }
                });
                
            });
            
   function clickSelectLabor(hrcode,hrname,deptcode,deptnamt){
            $('#hr_code2').val(hrcode);
              $('#spactator2').val(hrname);
              $('#hr_dept2').val(deptcode);
              $('#spactator_dept2').val(deptcode);
              $('#spactator_dept_name2').val(deptnamt);
              
               $("#dialog-form-hr").dialog( "close" );
            
          }         
            
            
   function addEquipment(){
         var chk = 0;
        if($('#eq_mc_code').val()==""){
            $('#eq_mc_code').focus();
            $('#eq_mc_code').addClass('fieldRequest');
            chk =1;
            
        }
        
        if($('#eq_eq_code').val()==""){
            $('#eq_eq_code').focus();
            $('#eq_eq_code').addClass('fieldRequest');
            chk =1;
            
        }
        
        if($('#eq_nameth').val()==""){
            $('#eq_nameth').focus();
            $('#eq_nameth').addClass('fieldRequest');
            chk =1;
        }
        
     
      //  alert($('input[name=mcStatus]:radio:checked').val());
        
        
        if(chk==1){
            alert('กรุณาใส่ข้อมูลให้ครบ!!');
            return;
        }
      //  alert($('#eq_mc_code').val());
    
   }
    
    function start(){
        
        if($("#store_source").val()==""){
            alert("กรุณากรอกข้อมูลให้ครบ");
            return false;
        }
        
        if($("#store_desti").val()==""){
            alert("กรุณากรอกข้อมูลให้ครบ");
            return false;
        }
        
        if($("#spactator2").val()==""){
            alert("กรุณากรอกข้อมูลให้ครบ");
            return false;
        }
       
          if($("#fac_desti").val()==""){
            alert("กรุณากรอกข้อมูลให้ครบ");
            return false;
        }
        
        
         if($("#divi_desticode").val()==""){
            alert("กรุณากรอกข้อมูลให้ครบ");
            return false;
        }
        
        
    }
    
    function notnull(){
        
         if($("#amt").val()==""){
            alert("กรุณากรอกข้อมูลให้ครบ");
            return false;
        }
        if($("#loca").val()==""){
            alert("กรุณากรอกข้อมูลให้ครบ");
            return false;
        }
        if($("#invcode").val()==""){
            alert("กรุณากรอกข้อมูลให้ครบ");
            return false;
        }
        
        var amt = parseInt($("#amt").val());
        var onhand =  parseInt($("#onhand").val());
       // alert(amt);
       // alert(onhand);
       
       
        if(amt>onhand){
            alert("ไม่สามารถขอย้ายอะไหล่เกินจำนวนคงเหลือได้");
            return false;
        }
        
       //  return false;
        
        
         return true;
        
    }

    function stopload(success){
        
     //  alert(success);
       
        if (success == 1){
           // $('#inv_code').val($('#inv_code_master').val());
          alert('บันทึกข้อมูลสำเร็จ');
         // refestPage('mc-dept-all.php');
        }
        else {
            alert('ไม่สามารถบันทึกข้อมูลได้เนื่องจากรหัสซ้ำ');
        }
        $('#progess-data').hide();
        return true;   
    }
    
     function refestPage(url){
                document.location.href=url;
                return false;
     }
     
      function loadLabor(){
             // alert(storecode);
             var name = $('#spactator').val();
              $("#dialog-form-hr").dialog( "open" );
               var url = 'searchLabor.php';
              $( "#hr-select" ).attr("src", url);
          }
   function loadDivision(){
             // alert(storecode);
             var name = $('#spactator').val();
              $("#dialog-form-division").dialog( "open" );
               var url = 'searchDivision.php';
              $( "#division-select" ).attr("src", url);
          }
          
             function loadDivisionDesti(){
             // alert(storecode);
             var name = $('#spactator').val();
              $("#dialog-form-divisionx").dialog( "open" );
               var url = 'searchDivisionx.php';
              $( "#divisionx-select" ).attr("src", url);
          }
          
                      function getHrDept(current){
                         //hr_dept
                       
                         var fac  = $("#fac_desti").val(); 
//                         alert(fac);
                         $("#divi_desticode").load("load_division.php?fac="+fac+"&current="+current);
                         
                     }
      function clickSelectInv(code,name,remain,unit){
                $('#invcode').val(code+" ("+name+")");
              
                //  alert(store);
 
                $('#onhand').val(remain);
 
                $('#unit').text(unit);
                $( "#dialogWo7" ).dialog("close");
               
            }
            
                  function clickSelectMc(code,name,store,loca,remain,uop,unit){
                $('#invcode').val(code+" ("+name+")");
              
                //  alert(store);
                $('#store').val(store);
                $('#loca').val(loca);
                $('#onhand').val(remain);
                $('#uop').val(uop);
                $('#unit').text(unit);
                $( "#dialogMc" ).dialog("close");
               
            }
              function clickSelectDivi(code,name,nameen){
                $('#divi_start').val(code + '('+ name +')');
              
                $('#divi_startcode').val(code);
                
                
                
                $( "#dialog-form-division" ).dialog("close");
               
            }
            
//            function clickSelectDivix(code,name,nameen){
//                $('#divi_desti').val(code + '('+ name +')');
//              
//                $('#divi_desticode').val(code);
//                $( "#dialog-form-divisionx" ).dialog("close");
//               
//            }
            
            
        function loadInv(){

              $( "#dialogWo7" ).dialog("open");
                 
              //   iframeInv
              var inv = $('#invcode').val();
              
                var store_source = $('#store_desti').val();
             var factory =   $('#fac_desti').val();
             var division =   $('#divi_desticode').val(); 
              
              
              var str = inv.split(" (");
                 $("#iframeInv7").attr("src",'searchInv.php?division='+division+""+"&factory="+factory);
             
                return false;
            }
            
            
           function loadMc(){

              $( "#dialogMc" ).dialog("open");
                 
              //   iframeInv
              var inv = $('#invcode').val();
              
              //  var store_source = $('#store_desti').val();
               var factory =   $('#fac_desti').val();
               var divisionx =   $('#divi_desticode').val();
              var str = inv.split(" (");
                 $("#iframeMc").attr("src",'searchMc.php?term='+str[0]+"&division="+divisionx+"&factory="+factory);
             
                return false;
            }  
            
            
        function    checkBorrowAmount(){
               
            var remainAMT = parseInt($('#onhand').val());
            var borrowAMT = parseInt($('#borrow_amt').val());  
            
            if(remainAMT< borrowAMT ){                
                alert('จำนวนอะไหล่เหลือไม่พอให้ยืม');
                
                return false;
            }else{
                
            }
              
            }
            
            
            function  clickChangStore(){
                var sstore = $("#store_source").val();
                //location.href = "tranfer_form.php?store_s="+sstore;
            }
            
            function validate(evt) {
                var theEvent = evt || window.event;
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode( key );
                var regex = /[0-9]|\./;
                if( !regex.test(key) ) {
                    theEvent.returnValue = false;
                    if(theEvent.preventDefault) theEvent.preventDefault();
                }
            }
            
            
               function confirmRe(){
                        var r = confirm("บันทึกสำเร็จ");
                        if (r == true) {
                          window.location.href= window.location.href+"&approve=2";
                        } else {
                           
                        }
            }
                         function confirmAPPROVE(){
                        var r = confirm("บันทึกสำเร็จ");
                        if (r == true) {
                          window.location.href= window.location.href+"&approve=3";
                        } else {
                           
                        }
            }
     
             function confirmap(){
                        var r = confirm("ยืนยันการอนุมัติหรือไม่ ?");
                        if (r == true) {
                          window.location.href= window.location.href+"&approve=3";
                        } else {
                           
                        }
            }
            
            
                  function confirmc(){
                        var r = confirm("ยกเลิกการขอย้ายหรือไม่ ?");
                        if (r == true) {
                          window.location.href= window.location.href+"&approve=C";
                        } else {
                           
                        }
            }
            
            
                   function confirmCancel(approve_by){
                         var hr = approve_by;
                        var r = confirm("ยกเลิกการขอยืมหรือไม่ ?");
                        if (r == true) {
                          window.location.href= window.location.href+"&approve=cancel&approve_by="+hr;
                        } else {
                           
                        }
            }
            
            
     
     
</script>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
     $( "#datepickerend" ).datepicker();
  } );
  </script>
      
      <script>
          
              
//            function loadHr(){
//      
//                var mc_dept = $("#mc-code").val();
//                //alert(mc_code);
//                var src = "selectHr.php?mc_dept="+mc_dept;
//                $("#hr-select").attr('src',src);
//                $( "#dialog-form-hr" ).dialog( "open" );
//        
//                //return false;  
//            }




          </script>
      <script>
function myFunction(approve_by) {
 
    var r = confirm("ยืนยันการอนุมัติ ?");
     var hr = approve_by;
    
    
                     if (r == true) {
                        window.location.href= window.location.href+"&approve=approve&approve_by="+hr;
                        } else {
                            
                            
                           
                        }
//    confirm("Press a button!");
}
</script>
      <script>
      
      function lendingFactory(){
          
          var lending_fac = $('#lending_fac').val();
          
          window.location.href = "form_borrow_approve.php?lending_fac="+lending_fac;
      }
      
      
      </script>
      
        <title>รายละเอียดการขอยืมอะไหล่</title>
    </head>
    <body style="font-size:8pt;">
        
       <div id="dialogWo" title="ผู้ขอยืม" >
            <iframe  frameborder="0" width="700px" height="480px" id="iframeWo" src=""></iframe>
            
        </div>
        
        
       <div id="dialogWo7"  title="เลือกรายการอะไหล่"  >
              <iframe  frameborder="0" width="700px" height="480px" id="iframeInv7"  src=""></iframe>
            
        </div>
        
          <div id="dialogMc"  title="เลือกรายการอะไหล่ที่ต้องการยืม"  >
              <iframe  frameborder="0" width="700px" height="480px" id="iframeMc"  src=""></iframe>
            
        </div>
        
        
        <!-- Beginning of compulsory code below -->
        <div style="padding-left: 10px; padding-right: 10px;">

           
            <form action="" method="post"  name="form1" onsubmit="return start()">          
   <?php 
                     if($data["txtype"] == 'MC'){
                      $page =  'tranfer_request.php?ttype=MC';
                     } else {
                          $page =  'tranfer_request.php?ttype=EQ';
                    }
//                     if($data["txtype"] = 'EQ'){
//                          $page =  'tranfer_request.php?ttype=EQ';
//                     }
//                     echo $data["txtype"];
                     ?>
                    
                <input type="button" style="float: right" onclick="return window.location.href='<? echo 'borrow_request_approve.php' ?>'" value="ออกจากหน้านี้"/>
                
                
            <div style="float: left; width: 100%;height: auto; margin: 2px; border: 1px solid #D9D9D9;background-color: white;">
                <div style="clear: both; height: 23px; background-color: #9CC4E4; padding-top: 7px; ">
                    <span style="margin-left: 20px;">อนุมัติการให้ยืมอะไหล่</span>
                </div>
                <input type="hidden" name="editdata" value="<? if($chk){ echo "1"; }else{ echo "0";} ?>"/>
                <table style="font-size: 12px;">
                       <?php  
                             require_once '../classes/Utility.class.php';
                                $uu =  new Utility(); 
                             ?>
                    
                       <?php if($chk){
                                $chktypereadonly = 'readonly';
                            } else {
                                $chktypereadonly = '';
                            } ?>
                     <tr>
                        <td>  
                            
                            เลขที่เอกสาร
                        </td>
                         <td>
                             <input  type="text"  style="background-color: #f5f5f5" maxlength="30" name="textcode" readonly size="30%" value="<? echo $data["tx_id"]; ?>"/>
                        </td
                    </tr>
                    
                    <tr>
                        <td>  
                            
                            เอกสารอ้างอิง
                        </td>
                         <td>
                             <input <?  if(isset($_GET['tx_id'])){  echo " readonly "; } ?>  type="text"   maxlength="30" name="ref_no"  size="30%" value="<? echo $data["ref_no"]; ?>"/>
                        </td>
                    </tr>
                    
                    
                    
                    <tr class="tableform">
                        <td>  
                           วันที่ทำรายการ
                        </td>
                        
                         <td>
                             <input  disabled type="text"  name="datenow" size="30%" value="<? if($data["txdate"]!=""){ echo $data["txdate"]; }else{ echo date("Y-m-d"); } ?>" />
                        </td>
                    </tr>
                  <tr>
                        <td>ผู้ขอยืมอะไหล่</td>
                        <td>
                            <input readonly="" class="" type="text" style="float: left;" id="spactator2"   value="<? echo $uu->getNameth('hr', $data["inv_requestor"])  ?>"  name="requestor_inv" />
 

                          <? echo 'แผนก'; ?> &nbsp;
                          
                          <!--<input class="fieldNotNull" type="hidden" readonly="" id="spactator_dept2"  name="spactator_dept2"  value="<? if($edit){ echo $data['requestor_dept']; } ?>"/>-->
                          <input class=""   readonly="" id="spactator_dept2"  name="spactator_dept2"  value="<? echo $uu->getNameth('hr', $data["inv_requestor"])  ?>"/>
 
                        </td>
                        
                        
                    </tr>
                     <tr>
                 <td><? echo 'ผู้ทำรายการ'; ?></td>
                 <td>
                        <input type="hidden" id="hr_code2"   value="<? if ($edit) {
                            echo $data['create_by'];
                        } else {
                            echo $_SESSION['username'];
                        } ?>"  name="hr_code"/>
                        <input type="hidden" id="hr_dept2"  name="hr_dept"/>
                        <input readonly="" class="notnull" type="text" style="float: left;" id="spactator2" name="spactator2" value="<?
                        require_once '../classes/Hr.class.php';
                        $hr = new Hr();

                        if ($chk) { //echo $data['spectator_id']; 
                            echo $hr->getNameById($data['create_by']);
                            if($data['create_by']=="admin"){
                                echo "admin";
                            }
                        } else {
                            echo $hr->getNameById($_SESSION['username']);
                        }
?>" />

<?
require_once '../classes/Utility.class.php';
$uu = new Utility();
?>
                 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        <? echo "แผนก"; ?> &nbsp;<input type="hidden" id="spactator_dept2"  name="spactator_dept2"  value="<? if($chk){   $deptcode =  $uu->getDept("hr",$data['inv_requestor']); echo $uu->getNameth('hr_dept', $deptcode ) ;} ?>"/>
                        <input type="text" readonly="" id="spactator_dept_name2"  name="spactator_dept_name2"  value="<? echo 'aaa' ?>"/>
                    </td>
            </tr>
                    
                    <tr>
                        
                        
                        <td>  
                             <?php  echo $factorytxt ;?>ต้องการยืมจากโรงงาน
                        </td>
                        <td><input style="width:100%" readonly="" value="<? echo $uu->getNameth("mc_factory",$data['lending_factory'])  ?>" ></td>
                        
                        
                    </tr>
                      <tr >
                        <td>  
                           หมายเหตุ
                        </td>
                         <td>
                             <input <?  if(isset($_GET['tx_id'])){  echo " readonly "; } ?> type="text" name="etc" size="60%" value="<?php echo $data['etc']  ?>"/>
                        </td>
                          <td>
                                         <div style="width: 100%; height: 25px;">
 
            </div>
                          </td>
                    </tr>
                    
                 

                </table>
            </div>
                 <iframe id="uploa_target" name="target_on" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe> 
            </form>

        </div>
        
      <?
//        if(isset($_GET['tx_id'])){
//            echo $_GET['tx_id'] ;
//            echo 'ssssssssssssssssssssssssssss';
//        }
        
//          echo $_GET['tx_id'].'ssssssssssss' ;
      if(isset($_GET['tx_id'])){
      
          
          
      ?>  
       <div style="float: left; width: 100%;height: auto; margin: 2px; border: 1px solid #D9D9D9;background-color: white;">
           <style type="text/css">
               .tablesorter tr td{
                   border: 1px solid gray;
               }
               
                .tinput thead th{
                    border-collapse: collapse;
                    border: 1px solid #CDCDCD;
                }
                .tinput tr td{
                    border-collapse: collapse;
                    border: 1px solid #CDCDCD;
                }
                .trgray{
                    background-color: #E9F2F9;
                }
                .checkNotNull{
                    background-color: #FFFACD;
                    background-image: none;
                }
               
           </style>  
             
        <table class="tinput" style="width: 100%;border-collapse: collapse;border: 1px solid #CDCDCD;">
                <thead style="background-color: #E6EEEE;font-size: 8pt;">
                    <tr>
                        <th>รายการอะไหล่</th>
                        <th>จำนวนอะไหล่คงเหลือ</th>
                        <th>จำนวนที่ต้องการยืม</th>
 
                    </tr>
                 </thead>
                       <? 
                        require_once '../classes/InvStock.class.php';
                        $stock = new InvStock();

                $sql = "select * from inv_borrow_details WHERE tx_id ='{$_GET["tx_id"]}';";
//                echo $sql;
                $rs = $conn->queryTis620($sql);
                 while($row = $conn->parseArray($rs)){
            ?>
            <tr>
 
                     <td><?  echo $row["inv_code"]." (".$uu->getNameth("inv",$row["inv_code"]).")";  ?></td>
 
                     <td><?  
                   $fac = " select lending_factory from inv_borrow where tx_id = '{$_GET["tx_id"]}' " ;
                     $rsfac = $conn->queryTis620($fac);
                    $rowfac  = $conn->parseArray($rsfac);
                     
        $sqlee = "SELECT   SUM(amt) AS remain FROM inv_tx_details td WHERE td.inv_code = '{$row["inv_code"]}'  AND (tx_id LIKE  'ADJ%' OR tx_id LIKE  'RCV%'  OR tx_id LIKE  'RTN%') and factory_code = '{$rowfac['lending_factory']}'; "; 
//        echo $sqlee."<br/>";
        $rsee = $conn->queryTis620($sqlee);
        $rowee  = $conn->parseArray($rsee);
        $sqlww = " SELECT  SUM(amt) AS remain   FROM inv_tx_details td WHERE td.inv_code = '{$row["inv_code"]}'   AND (tx_id LIKE  'BRW%' OR tx_id LIKE  'ISS%'  OR tx_id LIKE  'ISP%') and factory_code = '{$rowfac['lending_factory']}';";
//         echo $sqlww;
        
        $rsww = $conn->queryTis620($sqlww);
        $row1ww  = $conn->parseArray($rsww);
        
        $remaininga =  $rowee['remain']-$row1ww['remain'];
 
                        echo $remaininga ;
                        ?></td>
 
               
                <td style="text-align: center;"><?  echo $row["amt"];  ?></td>
          
            </tr>
                       <?   }  ?>

            
        </table>
           
           
           
        </div>
        
   
           
           <?   
           
            if(isset($_GET['tx_id'])){
                $edit = true;
                $sql99 = "SELECT * FROM inv_borrow WHERE tx_id = '{$_GET['tx_id']}';";
 
                $rs99 = $conn->queryTis620($sql99);
                $data2 = $conn->parseArray($rs99);
              //echo $sql99;

       if($data2["status"] != 'approved' && $data2["status"] != 'cancel'){ ?>
           
      
                 
                <input id="bb" type="button"  onclick="myFunction('<? echo $_SESSION['username'] ?>')" value="อนุมัติ"   />   
                <input id="cc" type="button"  onclick="confirmCancel('<? echo $_SESSION['username'] ?>')"  value="ยกเลิก"   />
 
                      
                      
      
             
            <br> <br>
               <!--<input id="bb" type="button" onclick="return confirmap()" value="approve"   />-->
                   
           
                 </form>
           <?php } 
           
           if($data2['status']=="approved"){
                        echo '<br><b> ผู้อนุมัติ : <b>' ;
                        echo $uu->getNameth('hr', $data2["approve_by"]) ;
           }           
           if($data2['status']=="cancel"){
                        echo '<br><b> ผู้ยกเลิก : <b>' ;
                        echo $uu->getNameth('hr', $data2["approve_by"]) ;
           }
           
          ?>
                   
              
 
               <?  }   ; ?>  
           
           
          <table style="width: 100%;">
         
           </table>
      <?  }  ?>   
      
        <div id="dialog-form-hr" title="<? echo $hrfile_txt.' '.$file_txt; ?>" >
            <!--<fieldset id="set-hriframe">-->     
                <iframe id="hr-select"  frameborder="0"  style="width: 100%;height: 300px;"></iframe>
            <!--</fieldset>-->
        </div> 
                  <div id="dialog-form-division" title="<? echo $hrfile_txt.' '.$file_txt; ?>" >
            <!--<fieldset id="set-hriframe">-->     
                <iframe id="division-select"  frameborder="0"  style="width: 100%;height: 300px;"></iframe>
            <!--</fieldset>-->
        </div> 
              
                  <div id="dialog-form-divisionx" title="<? echo $hrfile_txt.' '.$file_txt; ?>" >
            <!--<fieldset id="set-hriframe">-->     
                <iframe id="divisionx-select"  frameborder="0"  style="width: 100%;height: 300px;"></iframe>
            <!--</fieldset>-->
        </div> 
    </body>
</html>
