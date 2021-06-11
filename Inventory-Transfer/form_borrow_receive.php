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
        
        $insert_details = " insert into inv_borrow_details (inv_code,factory_code,amt,tx_id,ts) values('$inv_only_code[0]','{$data['lending_factory']}','{$_POST['borrow_amt']}','$tx_id','$ts') ";
//        echo $insert_details;
//        exit();
        $ins_details = $conn->queryTis620($insert_details);
        
        
        
        header( "location: form_borrow_approve.php?tx_id=$tx_id" );
    }
//    
    
    
    
    if($_POST['submit'] != ''){
        
        $sql = " select * from inv_borrow_details _log where tx_id = '{$_GET['tx_id']}' ";
        $rs = $conn->queryTis620($sql);
        while($data = $conn->parseArray($rs)){
            
           $check_amt = " select * from inv_borrow_details _log  ";
            
        }
        
        
        
        $update = "  ";
        
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
            
            function toSaveStoreLoca(round,tx_id,inv_code){
                
                
                var store = $('#store_receive'+round).val();
                var location = $('#loca_receive'+round).val();
                
                if(store==''){
                    alert('กรุณาเลือก Store');
                    return false
                }
                if(location==''){
                    alert('กรุณาเลือก Location');
                    return false
                }
                
                var amt_movein = $('#amt_movein'+round).val();
                var amt_received = $('#amt_received'+round).val();
                

                

 
         //    alert(store+'---------------'+location);
             
             $.post("api/lending_received.php",{tx_id:tx_id,store:store,location:location,round:round,inv_code:inv_code,amt_movein:amt_movein},function(data){
                 if(data=='updated'){
                     
//                     alert('test');
                     window.location.href= "form_borrow_receive.php?tx_id="+tx_id;
                     
                 }else{
//                     alert(data);
        } 
             });
             
             
            //     alert('test2');
             
                 $("#ifMoreThings_"+inv_code).load("api/load_location_more.php");
             
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
          
          
          function toLend(store_id,invlend,round,tx_id,fac_code){
              var lending_amount = parseInt($('#lending'+round).val());
              var remain_in_store = parseInt($('#remain_in_store'+round).val());
              var tx_id = tx_id;
//         alert(store_id+'--------------'+invlend+'-------------'+round+'----------------'+lending_amount+'-----------'+remain_in_store+'-----------------------------'+tx_id);
         
         if(remain_in_store < lending_amount){
             alert('ไม่สามารถให้ยืมมากว่าจำนวนคงเหลือได้');
             return false;
         }else{
             
             var confirm_insert = confirm("ยืนยันการยืมจาก store : "+store_id+" ?");
             if(confirm_insert == true){
                 
                            $.post("api/lending_store.php", {store_id: store_id, invlend:invlend, lending_amount:lending_amount,remain_in_store:remain_in_store,tx_id:tx_id , fac_code:fac_code}, function (data) {
                if(data='inserted'){
//                    alert('ทำการยืมเรียบร้อย');
 
//                    $('#lending'+round).style.display = "none"
                }
            	});
                 window.location.href= "form_borrow_receive.php?tx_id="+tx_id;
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

function confirmReceive(tx_id,round,inv_code,receiver){
    var check = $('#check'+round).val();
    
    var to_confirm = confirm( 'ยืนยันการรับอะไหล่' );
//    alert(check+'----------------------------------------'+tx_id+'-----------------------'+round);

        if(to_confirm==true){
                $.post("api/lending_received.php", {check: check, tx_id:tx_id , inv_code:inv_code,receiver:receiver}, function (data) {
                if(data='updated'){          
                            window.location.href= "form_borrow_receive.php?tx_id="+tx_id;
                }
            	});
            }else{
                return false;
            }
    
}

function confirmAllReceive(tx_id){
    
    var to_confirm = confirm( 'ยืนยันการรับอะไหล่' );
    
    if(to_confirm == true){
    
    $.post("api/approve_received.php",{tx_id:tx_id},function(data){
        if(data='updated'){
            
            alert('รับอะไหล่เรียบร้อยแล้ว');
             window.location.href= "form_borrow_receive.php?tx_id="+tx_id;
        }
    });
    
    }
    
    
}

function loadLocationByStore(round,inv_code){
//    alert(inv_code);
    var store = $('#store_receive'+round).val();
    
//    alert("#loca_receive"+round);
    
    $("#loca_receive"+round).load("api/load_location_by_store.php?store="+store);
//    alert("#loca_receive"+round);

}


function ifAmtNotDone(round, inv){
    var alreadyReceived = parseInt($('#alreadyReceived'+round).val());
    var totalLending = parseInt($('#totalLending'+round).val());
    var amt_movein = parseInt($('#amt_movein'+round).val());
    
//    if(amt_movein = ''){
//         alert('จำนวนที่จะรับเข้าต้องมากกว่า0และไม่เป็นค่าว่าง');
//         $("#amt_movein"+round).val('');
//        return false;
//    }
    
//    alert(totalLending+'has to be'+(amt_movein+alreadyReceived));
    
    if((amt_movein+alreadyReceived)>totalLending){
        alert('จำนวนที่จะรับเข้า ไม่สามารถมากว่าจำนวนที่ได้รับได้');
         $("#amt_movein"+round).val('');
        return false;
       
    }    
    
}


      
      function lendingFactory(){
          
          var lending_fac = $('#lending_fac').val();
          
          window.location.href = "form_borrow_approve.php?lending_fac="+lending_fac;
      }
      
      
      
      function toRemove(round,store,loca,tx_id,inv_code){

              $.post("api/remove_partial_receive.php",{tx_id:tx_id,inv_code:inv_code,loca:loca,store:store},function(data){
        if(data='updated'){
            
            alert('ลบเรียบร้อยแล้ว');
             window.location.href= "form_borrow_receive.php?tx_id="+tx_id;
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
                    
                <input type="button" style="float: right" onclick="return window.location.href='<? echo 'borrow_receive.php' ?>'" value="ออกจากหน้านี้"/>
                
                
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

      if($_GET['tx_id'] != ''  &&  $data["status"] =="approved"){
      
          
          
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
                    <tr  style="width:100%">
                        <th>รายการอะไหล่</th>
                        <!--<th>จำนวนอะไหล่คงเหลือ</th>-->
                        <!--<th>จำนวนที่ต้องการยืม</th>-->
                        <th>จำนวนที่ได้รับ</th>
                        <!--<th>จำนวนที่รับเข้า</th>-->
                        <th>Store ที่รับเข้า / Location ที่รับเข้า</th>
 
                        <th>#</th>
 
 
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
 
                <td><?  echo $row["inv_code"]." (".$uu->getNameth("inv",$row["inv_code"]).")";  ?></td>
                <td style="text-align: center;">
                    <?
             $count = " select sum(amt) as total_received from inv_borrow_details_transfer where tx_id = '{$_GET['tx_id']}' and inv_code = '{$row["inv_code"]}' ";
// echo $count;
             $rs_count = $conn->queryTis620($count);
             $row_count = $conn->parseArray($rs_count);    
                $total_received =     $row_count['total_received'];
             
                $sql1 = " select sum(amount_lending) as lend_amt  from inv_borrow_details_log where inv_code = '{$row["inv_code"]}' and tx_id = '{$_GET["tx_id"]}' group by inv_code ";
//                echo $sql1;
                $rs1 = $conn->queryTis620($sql1);
                $row1 = $conn->parseArray($rs1);
                $lending_amt = $row1['lend_amt'];
                
//                echo $lending_amt."(".( $lending_amt - $total_received) .")";
                echo $lending_amt ;
                
                ?>
                    <input hidden name="amt_received<? echo $i ?>" id="amt_received<? echo $i ?>" type="text" value="<? echo $row1['lend_amt']; ?>" >
                </td>
                <? // if($row_count['total_received']<$row1['lend_amt']){ ?>
                
                <!--<td style="text-align: center;">-->
                    
                    <input hidden id="alreadyReceived<? echo $i ?>" value="<? echo $row_count['total_received'] ; ?>" >
                    <input hidden id="totalLending<? echo $i ?>" value="<? echo $row1['lend_amt'] ; ?>" >
                    
                        <input hidden onchange="ifAmtNotDone('<? echo $i ?>','<? echo $row["inv_code"] ?>')" name="amt_movein<? echo $i ?>" id="amt_movein<? echo $i ?>" type="text"  value="<? echo $row1['lend_amt'] ?>"  >
                        <!--</td>-->
                <? // }else{ ?>
                <!--<td style="text-align: center;"> รับเข้าหมดแล้ว </td>-->
                <? // } ?>
                <td style="text-align: center;"  style="width:100%">
                    <table style="width:100%">
                        <? if($row_count['total_received']<$row1['lend_amt']){ ?>
                        <tr style="width:100%">
                            <td>
                                <select style="width:100%" onchange="loadLocationByStore('<? echo $i ?>','<? echo $row["inv_code"] ?>')" name="store_receive<? echo $i ?>" id="store_receive<? echo $i ?>"  >
                        <option value="" >--- เลือก Store ---</option>
                        <?
                
                $sel_store = " select store_code from inv_tx_details where tx_id like '%ADJ%' and factory_code = '{$_SESSION['factory_code']}' AND inv_code = '{$row["inv_code"]}' group by store_code ";
                $rs_store = $conn->queryTis620($sel_store);
                while($row_store = $conn->parseArray($rs_store)){
                        $_nameth_store = " SELECT nameth FROM inv_store WHERE code = '{$row_store['store_code']}' ";
//                        echo $_nameth_store;
                        $rs_nameth_store = $conn->queryTis620($_nameth_store);
                        $row_nameth_store = $conn->parseArray($rs_nameth_store);
                        
                ?>
                        <option <? echo $selected ?>  value="<? echo $row_store['store_code'] ?>"><? echo $row_nameth_store['nameth'] ?></option> 
                <? } ?>
                        </select>
                            </td>
                            <td>
                        <select style="width:100%" class="fieldNotNull" name="loca_receive<? echo $i ?>" id="loca_receive<? echo $i ?>" ></select>
                            </td>
                        </tr>
                        <? } ?>
            <? 
            $see_if_any = " select * from inv_borrow_details_transfer where tx_id = '{$_GET['tx_id']}' and inv_code = '{$row["inv_code"]}' ";
            $rs_if_any = $conn->queryTis620($see_if_any);
            $rounddd = 0;
            while($row_if_any = $conn->parseArray($rs_if_any)){ ?>
                        <tr id="ifMoreThings" style="width:100%" >
                <td><? echo $row_if_any['store_code'] ; ?></td>
                <td><? echo $row_if_any['loca_code'] ; ?></td>
                <td>จำนวนที่รับเข้า : <? echo $row_if_any['amt'] ; ?></td>
                <? if($data['receive_status'] !="receive_completed"){ ?>
                <td style="text-align:right;color:red;cursor: pointer"><? echo $row1['receive_status'] ?><a onclick="toRemove('<? echo $rounddd; ?>','<? echo $row_if_any['store_code'] ?>','<? echo $row_if_any['loca_code'] ?>','<? echo $_GET['tx_id'] ?>','<? echo $row["inv_code"] ?>')" >ลบ</a></td>
            <? } ?>
            </tr>
            <? $rounddd++; } ?>
                    </table>
                </td>
                
                
                <td style="text-align: center;">
             <?        
             if($row_count['total_received']<$row1['lend_amt']){
             ?>

                    <input onclick="toSaveStoreLoca('<? echo $i ?>','<? echo $_GET['tx_id'] ?>','<? echo $row['inv_code'] ?>')" type="button" name="save<? echo $i ?>" id="save<? echo $i ?>" value="บันทึก"  ></td>
             <? }else{ ?>
                รับหมดแล้ว
             <? } ?>
            </tr>

                       <?  $i++; }  ?>
       
            
        </table>

           
           
           
        </div>
                   <div style="text-align:right;">
               
               <?
               $check_if_all_received = " SELECT * FROM inv_borrow WHERE tx_id = '{$_GET['tx_id']}'; ";
               $rs_if_all_received = $conn->queryTis620($check_if_all_received);
                $data_if_all_received = $conn->parseArray($rs_if_all_received);
                
               $count = " select sum(amt) as total_received from inv_borrow_details_transfer where tx_id = '{$_GET['tx_id']}'  ";
// echo $count;
             $rs_count = $conn->queryTis620($count);
             $row_count = $conn->parseArray($rs_count);    
                $total_received =     $row_count['total_received'];
             
                $sql1 = " select sum(amount_lending) as lend_amt  from inv_borrow_details_log where  tx_id = '{$_GET["tx_id"]}' ";
//                echo $sql1;
                $rs1 = $conn->queryTis620($sql1);
                $row1 = $conn->parseArray($rs1);
                $lending_amt = $row1['lend_amt'];
                
               if($total_received == $lending_amt){
                   ?>
               <input <? if($data_if_all_received['receive_status'] == 'receive_completed'){ echo 'disabled'; } ?> type="submit" onclick="confirmAllReceive('<? echo $_GET['tx_id'] ?>')" name="submit" style="text-align:right" value="ยืนยันการรับ"/>
               <? } 
               if($data_if_all_received['receive_status'] == 'receive_completed'){?>
               <p>ยืนยันอะไหล่เรียบร้อยแล้ว</p>
               <? } ?>
           </div>
   
           
           <?   
           
            if(isset($_GET['tx_id'])){
                $edit = true;
                $sql99 = "SELECT * FROM inv_borrow WHERE tx_id = '{$_GET['tx_id']}';";
 
                $rs99 = $conn->queryTis620($sql99);
                $data2 = $conn->parseArray($rs99);

           
           if($data2['receive_status'] =="receive_completed"){
                        echo '<br><b> ผู้ยืนยันการรับอะไหล่ : <b>' ;
                        echo $uu->getNameth('hr', $data2["complete_received_by"]) ;
           }
           if($data2['status']=="cancel"){
                        echo '<br><b> ผู้ยกเลิกอะไหล่ : <b>' ;
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
