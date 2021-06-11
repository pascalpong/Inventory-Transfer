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
require_once '../classes/Authen.class.php';
$aut = new Authen();
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
        
//        $update_borow = " update inv_borrow set status = 'approved' , approve_by = '{$_SESSION['username']}' , approve_ts = '$ts' where tx_id = '{$tx_id}' ";
//        echo $update_borow;
//        exit();
//        $ins_upd_bor = $conn->queryTis620($update_borow);
        
        $insert_details = " insert into inv_borrow_details (inv_code,factory_code,amt,tx_id,ts) values('$inv_only_code[0]','{$data['lending_factory']}','{$_POST['borrow_amt']}','$tx_id','$ts') ";
//        echo $insert_details;
//        exit();
        $ins_details = $conn->queryTis620($insert_details);
        
        
        
        header( "location: form_borrow_approve.php?tx_id=$tx_id" );
    }
//    
    
    
    
    


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
                   $( "#dialogStore" ).dialog({
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
            
            function selectStoreLoca(inv_code_use, store_code , loca_code , remaining , round){
            
//            alert(inv_code_use);
      $('#store_code'+round).val(store_code);
      $('#loca_code'+round).val(loca_code);
      $('#inv_code_use'+round).val(inv_code_use);
      $('#remaining_in_strore'+round).val(remaining);
      $("#dialogStore").dialog( "close" );
    }
            
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
            function selectCertainAmount(round,tx_id,amt_request){
                var remain_in_store = parseInt($('#remaining_in_strore'+round).val());
            
                var req_amt = parseInt($('#lending_amount'+round).val());
                         
                if(req_amt >amt_request ){
                alert('ไม่สามารถให้ยืมเกินจำนวนที่ขอได้');
                $('#lending_amount'+round).val(remain_in_store);
                return false;
                }
                
                if(req_amt > remain_in_store){
                alert('จำนวนในStore ไม่พอ สำหรับการให้ยืม');
                return false;
                }else{

                $('#lending_amount'+round).val(req_amt);
                var amount_left = remain_in_store - req_amt;
                $('#remaining_in_strore'+round).val(amount_left);
                var invlend =  $('#inv_code_use'+round).val();
                var loca_id = $('#loca_code'+round).val();
                var store_id = $('#store_code'+round).val();
                var fac_id = $('#factory_id'+round).val();
//                  alert(fac_id+'-------------------------'+remain_in_store); 
                $.post("api/lending_store.php", {remain_in_store:remain_in_store , lending_amount : req_amt , invlend:invlend , tx_id:tx_id , loca_id:loca_id , store_id:store_id , fac_id:fac_id }, function (data) {
                if(data='inserted'){
                    
//                       alert(data);
                       
                       
                       window.location.href = window.location.href ;
                       
                    $('#display'+round).style.display = 'none';
//                    alert('ทำการยืมเรียบร้อย');
                    
//                    $('#lending'+round).style.display = "none"
                }
            	});
                
                }

                
    }
            
            
            function selectFullAmount(round,req_amt,tx_id){
                var remain_in_store = parseInt($('#remaining_in_strore'+round).val());
                
                var req_amt = parseInt(req_amt);
                            
                if(req_amt > remain_in_store){
                alert('จำนวนในStore ไม่พอ สำหรับการให้ยืม');
                return false;
                }else{

                $('#lending_amount'+round).val(req_amt);
                var amount_left = remain_in_store - req_amt;
                $('#remaining_in_strore'+round).val(amount_left);
                var invlend =  $('#inv_code_use'+round).val();
                var loca_id = $('#loca_code'+round).val();
                var store_id = $('#store_code'+round).val();
                var fac_id = $('#factory_id'+round).val();
                
//                alert(fac_id+'facccc'+req_amt+'-------------------------'+remain_in_store);
                
                $.post("api/lending_store.php", {remain_in_store:remain_in_store , lending_amount : req_amt , invlend:invlend , tx_id:tx_id , loca_id:loca_id , store_id:store_id ,fac_id:fac_id }, function (data) {
                if(data='inserted'){
                    
//                 alert(data);
                    $('#display'+round).style.display = 'none';
//                    alert('ทำการยืมเรียบร้อย');
//                    $('#lending'+round).style.display = "none"
                }
            	});
                
                }

                
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
            
            function loadStore(round,tx_id){
                $('#dialogStore').dialog("open");
                
                var inv_code = $('#inv_code'+round).val();
                
                $("#iframeStore").attr("src",'searchStoreToLend.php?inv_code='+inv_code+'&tx_id='+tx_id+'&round='+round);
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
          
          
          function toLend(round,tx_id){
              var lending_amount = parseInt($('#lending_amount'+round).val());
              var remain_in_store = parseInt($('#remaining_in_strore'+round).val());
              var store_id = $('#store_code'+round).val();
              var loca_id = $('#loca_code'+round).val();
              var invlend = $('#inv_code_use'+round).val();
              var fac_id = $('#factory_id'+round).val();
              var tx_id = tx_id;
//         alert(fac_id+'facccc'+store_id+'--------------'+invlend+'-------------'+round+'----------------'+lending_amount+'-----------'+remain_in_store+'-----------------------------'+tx_id);
         
         if(remain_in_store < lending_amount){
             alert('ไม่สามารถให้ยืมมากว่าจำนวนคงเหลือได้');
             return false;
         }else{
             
             var confirm_insert = confirm("ยืนยันการยืมจาก store : "+store_id+" ?");
             if(confirm_insert == true){
                 
                            $.post("api/lending_store.php", {store_id: store_id, invlend:invlend, lending_amount:lending_amount,remain_in_store:remain_in_store,tx_id:tx_id , loca_id:loca_id , fac_id:fac_id}, function (data) {
                if(data='inserted'){
//                    alert(data);
                    $('#display'+round).style.display = 'none';
//                    alert('ทำการยืมเรียบร้อย');
                    
//                    $('#lending'+round).style.display = "none"
                }
            	});
//                 window.location.href= "form_borrow_lending.php?tx_id="+tx_id;
             }else{
                  return false;
             }
             

         }
 
          }
              
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

      
      function lendingFactory(){
          
          var lending_fac = $('#lending_fac').val();
          
          window.location.href = "form_borrow_approve.php?lending_fac="+lending_fac;
      }

      function toApproveLend(user_approve , tx_id , total_rounds){
          
//          alert('totalrounds'+total_rounds+'----------txid='+tx_id+'--------------user='+user_approve);

                $.post("api/lending_approve.php", {user_approve: user_approve, tx_id:tx_id, total_rounds:total_rounds }, function (data) {
                if(data='inserted'){
//                    alert(data);

                    alert('The approval is completely done');
                    
                     window.location.href = "form_borrow_lending.php?tx_id="+tx_id;

                }
            	});
         
      }
      
      function toCancelLend(user_approve , tx_id , total_rounds){
          
                          $.post("api/lending_cancel.php", {user_approve: user_approve, tx_id:tx_id, total_rounds:total_rounds }, function (data) {
                if(data='updated'){
//                    alert(data);

                    alert('The cancel is completely done');
                    
                     window.location.href = "form_borrow_lending.php?tx_id="+tx_id;

                }
            	});
          
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
        <div id="dialogStore" title="เลือกสโตร์ที่ต้องการให้ยืม" >
            <iframe frameborder="0" width="700px" height="480px" id="iframeStore" ></iframe>
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
                    
                <input type="button" style="float: right" onclick="return window.location.href='<? echo 'borrow_lending.php' ?>'" value="ออกจากหน้านี้"/>
                
                
            <div style="float: left; width: 100%;height: auto; margin: 2px; border: 1px solid #D9D9D9;background-color: white;">
                <div style="clear: both; height: 23px; background-color: #9CC4E4; padding-top: 7px; ">
                    <span style="margin-left: 20px;">รายละเอียดการขอยืมอะไหล่</span>
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
                             <input <?php echo $chktypereadonly ;?>  type="text"   maxlength="30" name="ref_no"  size="30%" value="<? echo $data["ref_no"]; ?>"/>
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
                        <td><input readonly="" value="<? echo $data['lending_factory']  ?>" ></td>
                        
                        
                    </tr>
                      <tr >
                        <td>  
                           หมายเหตุ
                        </td>
                         <td>
                             <input <?php echo $chktypereadonly;?> type="text" name="etc" size="60%" value="<?php echo $data['etc']  ?>"/>
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

      if($_GET['tx_id'] != ''  && ($data["status"] =="w"||$data["status"] =="approved")){
      
          
          
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
                        <!--<th>จำนวนอะไหล่คงเหลือ</th>-->
                        <th>จำนวนที่ต้องการยืม</th>
                        <th>ยืมจากStore / จำนวนที่เหลือใน Store</th>
                        <th>จำนวนที่ให้ยืม</th>
 
 
                    </tr>
                 </thead>
                       <? 
                        require_once '../classes/InvStock.class.php';
                        $stock = new InvStock();

                $sql = "select * from inv_borrow_details WHERE tx_id ='{$_GET["tx_id"]}';";
//                echo $sql;
                $rs = $conn->queryTis620($sql);
                $i = 0;
                 while($row = $conn->parseArray($rs)){
                     
                     
                     
            ?>
            <tr>
 
                     <td><?  echo $row["inv_code"]." (".$uu->getNameth("inv",$row["inv_code"]).")";  ?>
                         <input readonly hidden name="inv_code<? echo $i; ?>" id="inv_code<? echo $i ?>" value="<? echo $row["inv_code"] ?>" >
                     
                     </td>
                     
 
<!--                     <td><?  
//                        $remaining = $stock->getRemainIgnoreCase($row['inv_code']);
//                        echo $remaining ;
                        ?></td>-->
 
               
                <td style="text-align: center;"><?  echo $row["amt"];  ?></td>
                <td style="text-align: center;">
                    <? 
                    $chk  = "select * from inv_borrow_details_log where tx_id = '{$_GET['tx_id']}' and inv_code = '{$row["inv_code"]}' ";
                    
//                    echo $chk;
                    
                    $rs_chk = $conn->queryTis620($chk);
                    $data_chk = $conn->parseArray($rs_chk);
                    
                    
        $sql52 = "SELECT   SUM(amt) AS remain FROM inv_tx_details td WHERE td.inv_code = '{$row["inv_code"]}'  AND (tx_id LIKE  'ADJ%' OR tx_id LIKE  'RCV%'  OR tx_id LIKE  'RTN%') and td.store_code = '{$data_chk['store_code']}' and td.loca_code = '{$data_chk['loca_code']}'  ; "; 
//        echo $sql1."<br/>";
        $rs52 = $conn->queryTis620($sql52);
        $row52  = $conn->parseArray($rs52);
        $sql2 = " SELECT  SUM(amt) AS remain   FROM inv_tx_details td WHERE td.inv_code = '{$row["inv_code"]}'   AND (tx_id LIKE  'BRW%' OR tx_id LIKE  'ISS%'  OR tx_id LIKE  'ISP%') and td.store_code = '{$data_chk['store_code']}' and td.loca_code = '{$data_chk['loca_code']}'  ;";
//         echo $sql2."<br/>";
        
        $rs2 = $conn->queryTis620($sql2);
        $row2  = $conn->parseArray($rs2);
        
        $new_remain = $row52['remain']-$row2['remain'];
                    
        if($data_chk['store_code'] == ''){
         ?>
                    <a><img onclick="return loadStore('<? echo $i ?>','<? echo $_GET['tx_id'] ?>')" style="border: 0;cursor: pointer;" align="left" src="../style/images/icon1/Search.png"  width="20px" height="20px"/></a>
        <? } ?>
                    
                    Store : <input name="store_code<? echo $i ?>" id="store_code<? echo $i ?>" type="text" readonly value="<? if($data_chk['store_code'] != ''){ echo $data_chk['store_code'];} ?>" >
                   Location :     <input name="loca_code<? echo $i ?>" id="loca_code<? echo $i ?>" type="text" readonly value="<? if($data_chk['store_code'] != ''){ echo $data_chk['loca_code'];} ?>" >
                            <input hidden name="inv_code_use<? echo $i ?>" id="inv_code_use<? echo $i ?>" type="text" readonly  value="<? if($data_chk['store_code'] != ''){ echo $data_chk['inv_code']  ;} ?>"  >
                                <input hidden name="factory_id<? echo $i ?>" id="factory_id<? echo $i ?>" type="text" readonly  value="<? echo $data['lending_factory'] ?>"  >
                                On-hand :             <input name="remaining_in_strore<? echo $i ?>" id="remaining_in_strore<? echo $i ?>" type="text" readonly value="<? echo  $new_remain ?>"  >
                                   

                </td>
                <td>
                    <input  <? if($data_chk['approve_ts'] != ''){echo 'readonly' ;} ?>   name="lending_amount<? echo $i ?>" id="lending_amount<? echo $i ?>" type="text" value="<? echo $data_chk['amount_lending'] ?>"> <input <? if($data_chk['approve_ts'] != ''){echo 'disabled' ;} ?> onclick="selectCertainAmount('<? echo $i ?>','<? echo $_GET['tx_id'] ?>','<? echo $row["amt"] ?>')" type="button" value="Submit" >
                        <? if($data_chk['store_code'] == ''){  ?>
                        <a   style="color:blue; cursor: pointer; " id="display<? echo $i ?>" onclick="selectFullAmount('<? echo $i ?>','<? echo $row["amt"]  ?>','<? echo $_GET['tx_id'] ?>')" >เลือกเต็มจำนวน</a>
                        <? } ?>
                </td>
 
          
            </tr>
            <? $round[] = $i  ;
                   $total_rounds = count($round);
                    ?>
                       <?  $i++; }  ?>

            
        </table>
           
           
           
        </div>
        
   
           
           <?   
           
            if(isset($_GET['tx_id'])){
                $edit = true;
                $sql99 = "SELECT * FROM inv_borrow WHERE tx_id = '{$_GET['tx_id']}';"; 
 
                $rs99 = $conn->queryTis620($sql99);
                $data2 = $conn->parseArray($rs99);
              //echo $sql99;

       if($data2["status"] != 'lended' ){ ?>
           
      
                 <? // print_r($round) 
                 $chk_if_approve = " select status from inv_borrow_details_log where tx_id = '{$data2['tx_id']}'  ";
                 $rs_if_approve = $conn->queryTis620($chk_if_approve);
                 $data_if_approve = $conn->parseArray($rs_if_approve);
                 
                 ?>
        <? $chk = $aut->checkAuthenCode($_SESSION['username'],'borrowment-approve-borrow');?>
        
        <!--borrowment-approve-borrow-->
        //<? // if(){ ?>
                <input  <? if($chk=="A"||$chk=="R"){}else{echo 'disabled';} ?>  id="bb" type="button" <? if($data_if_approve['status'] == 'lended_approved' || $data_if_approve['status'] == 'lended_canceled'){ echo 'hidden'; } ?> onclick="toApproveLend('<? echo $_SESSION['username'] ?>','<? echo $_GET['tx_id'] ?>','<? echo $total_rounds ?>')" value="อนุมัติ"   />   
                <input <? if($chk=="A"||$chk=="R"){}else{echo 'disabled';} ?> id="cc" type="button" <? if($data_if_approve['status'] == 'lended_approved' || $data_if_approve['status'] == 'lended_canceled'){ echo 'hidden'; } ?>  onclick="toCancelLend('<? echo $_SESSION['username'] ?>','<? echo $_GET['tx_id'] ?>','<? echo $total_rounds ?>')"  value="ยกเลิก"   />
 
                      
                      
      <? // echo $data_if_approve['status']  
      echo $data_if_approve["approve_person"];
      ?>
             
            <br> <br>
               <!--<input id="bb" type="button" onclick="return confirmap()" value="approve"   />-->
                   
           
                 </form>
           <?php } 
           
                $chk_if_approve_per = " select approve_person from inv_borrow_details_log where tx_id = '{$data2['tx_id']}'  ";
                 $rs_if_approve_per = $conn->queryTis620($chk_if_approve_per);
                 $data_if_approve_per = $conn->parseArray($rs_if_approve_per);
           
           if($data_if_approve['status'] == 'lended_approved'){
                        echo '<br><b> ผู้อนุมัติ : <b>' ;
                        echo $uu->getNameth('hr', $data_if_approve_per["approve_person"]) ;
           }           
           if($data_if_approve['status'] == 'lended_canceled'){
                        echo '<br><b> ผู้ยกเลิก : <b>' ;
                        echo $uu->getNameth('hr', $data_if_approve_per["approve_person"]) ;
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
