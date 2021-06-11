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
    
 if(isset($_POST['submit'])){
     
     
     
     $lending_factory = $_POST['lending_fac'];
     $lending_store = $_POST['lending_store'];
     $inform_by = $_POST['spactator2'];
     $requestor = $_POST['hr_code2'];
     
     $hr_fac = " select factory_code from hr where code = '$requestor' ";
     $rs_fac = $conn->queryTis620($hr_fac);
     $row_fac = $conn->parseArray($rs_fac);
     
     $borrowing_factory = $row_fac['factory_code'];
     $etc = $_POST['etc'];
     $ref_no = $_POST['ref_no'];
     $ts= date('Y-m-d H:i:s');

     
           $sql = "SELECT   top 1  *  FROM inv_borrow  WHERE lending_factory ='$lending_factory' ORDER BY auto_id  DESC  ;";
           $rs = $conn->queryTis620($sql);
//         echo $sql.'<br>';
//         
//         exit();
           $nextid = 0001;
           while( $row = $conn->parseArray($rs)){
              $oldtx_id = explode('-', $row['tx_id']);
              
              
//                echo $oldtx_id[2].'<br>';
//                $oldtx_id =$row['tx_id'];
                
//               echo  $oldtx_id ;
                $nextid=$oldtx_id[2]+1;
                
           }

          $tx_id = "BOR-".$_POST['lending_fac']."-". sprintf("%04d",$nextid) ;
//          echo $tx_id;
//        exit();
        $nowdate = date("Y-m-d H:i:s");
        $sql2 = "  insert into inv_borrow (lending_factory,lending_store,tx_id,ref_no,etc,inform_by,inv_requestor,ts,status,borrowing_factory) values('$lending_factory','$lending_store','$tx_id','$ref_no','$etc','$inform_by','$requestor','$ts','w','$borrowing_factory')  ";
//     echo $sql2;
//     exit();
     $conn->queryTis620($sql2);

    header("Location: form_borrow_request.php?tx_id=".$tx_id);
       
   
     
    }
    
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
        
        $chk = " select * from inv_borrow_details where tx_id = '{$_GET['tx_id']}' and inv_code = '{$inv_only_code[0]}' ";
//        echo $chk.'<br>';
        $rs = $conn->queryTis620($chk);
        $data = $conn->parseArray($rs);
        
//        echo $data['inv_code'].'<br>'.$inv_only_code[0];
//        exit();
        if($data['inv_code'] == $inv_only_code[0]){
            ?>
    <script>
    alert('อะไหล่ตัวนี้ได้ถูกเพิ่มเข้าไปในรายการแล้ว');
    </script>
                <?
        }else{

//        print_r($inv_only_code);
        
        $insert_details = " insert into inv_borrow_details (inv_code,factory_code,amt,tx_id,ts) values('$inv_only_code[0]','{$data['lending_factory']}','{$_POST['borrow_amt']}','$tx_id','$ts') ";
//        echo $insert_details;
//        exit();
        $ins_details = $conn->queryTis620($insert_details);
        
        
        
        header( "location: form_borrow_request.php?tx_id=$tx_id" );
        }
    }
//    
    
    
    
    
    
     if(isset($_GET['approve'])){

         
    
}
    
    
    
    
    
 if(isset($_GET['del'])){

     
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
            
            
        function loadInv(factory,tx_id){

              $( "#dialogWo7" ).dialog("open");
 
                 $("#iframeInv7").attr("src",'searchInv.php?factory='+factory+'&tx_id='+tx_id);
             
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
            
            if(borrowAMT == 0){
                alert('จำนวนอะไหล่ที่ยืมไม่สามารถเป็น 0 ได้');
                return false; 
            }
            
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
            
            
                   function confirmCancel(){
                         var hr = $('#hr_approve').val();
                        var r = confirm("ยกเลิกการขอย้ายหรือไม่ ?");
                        if (r == true) {
                          window.location.href= window.location.href+"&approve=C&hr_code="+hr;
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
function myFunction() {
 
    var r = confirm("ยืนยันการอนุมัติ ?");
     var hr = $('#hr_approve').val();
    
    
                     if (r == true) {
                         
                         
                         
                          window.location.href= window.location.href+"&approve=3&hr_code="+hr;
                        } else {
                            
                            
                           
                        }
//    confirm("Press a button!");
}
</script>
      <script>
      
      function lendingFactory(){
          
          var lending_fac = $('#lending_fac').val();
          
          window.location.href = "form_borrow_request.php?lending_fac="+lending_fac;
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
                          $page =  'borrow_request.php?status=w';
                    }
//                     if($data["txtype"] = 'EQ'){
//                          $page =  'tranfer_request.php?ttype=EQ';
//                     }
//                     echo $data["txtype"];
                     ?>
                    
                <input type="button" style="float: right" onclick="return window.location.href='<? echo 'borrow_request.php?status=w' ?>'" value="ออกจากหน้านี้"/>
                
                
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
                             <input <?  if(isset($_GET['tx_id'])){  echo " readonly "; } ?>  type="text"   maxlength="30" name="ref_no"  size="30%" value="<? echo $data["ref_no"]; ?>"/>
                        </td>
                    </tr>
                    
                    
                    
                    <tr class="tableform">
                        <td>  
                           วันที่ทำรายการ
                        </td>
                        
                         <td>
                             <input  disabled type="text"  name="datenow" size="30%" value="<? if($data["txdate"]!=""){ echo $data["txdate"]; }else{ echo date("Y-m-d H:i:s"); } ?>" />
                        </td>
                    </tr>
                  <tr>
                        <td>ผู้ขอยืมอะไหล่</td>
                        <?
                        if(isset($_GET['tx_id'])){
                        ?>
                        <td>
                            <input value="<?   echo $uu->getNameth('hr', $data['inv_requestor']); ?>" readonly=""  />
                            

                          <? echo 'แผนก'; ?> &nbsp;
                          <input readonly=""   value="<? 
                          $sel_dept = " select hr_dept from hr where code = '{$data['inv_requestor']}' ";
//                          echo $sel_dept;
                          $rs_dept = $conn->queryTis620($sel_dept);
                          $row_dept = $conn->parseArray($rs_dept);
                          
                       echo $uu->getNameth('hr_dept', $row_dept['hr_dept']);  ?>"/>
                         <?php 
 
                        if($chk){
                             
                         } else {
              
                        
                         
                         ?>
                          
                       
                        <?php  } ?>
                        </td>
                        <? }else{ ?>
                   <td>
                       
                            <input type="hidden" id="hr_code2"   value="<? if($chk){ echo $uu->getNameth('hr', $data['inv_requestor']); } ?>"  name="hr_code2"/>
                            <input type="hidden" id="hr_dept2"   name="requestor_dept" value="<? if($edit){ echo $data['requestor_dept']; } ?>"/>
                            <input class="fieldNotNull" type="text" style="float: left;" id="spactator2" 
                                   value="<?     if($chk){
                                require_once '../classes/Hr.class.php'; 
                                $hr = new Hr();  
                            echo  $uu->getNameth('hr', $data['inv_requestor']);
                                   }
                              ?>" 
                            name="requestor_inv " />
 

                          <? echo 'แผนก'; ?> &nbsp;
                          
                            <!--<input class="fieldNotNull" type="hidden" readonly="" id="spactator_dept2"  name="spactator_dept2"  value="<? if($edit){ echo $data['requestor_dept']; } ?>"/>-->
                          <input class="fieldNotNull"  hidden  readonly="" id="spactator_dept2"  name="spactator_dept2"  value="<?  echo $data['requestor_dept'];  ?>"/>
                            <input class="fieldNotNull" type="text" readonly="" id="spactator_dept_name2"  name="spactator_dept_name2"  value="<? if($chk){   $deptcode =  $uu->getDept("hr",$data['inv_requestor']); echo $uu->getNameth('hr_dept', $deptcode ) ;} ?>"/>
                         <?php 
 
                        if($chk){
                             
                         } else {
              
                        
                         
                         ?>
                          <a><img onclick="loadLabor('<? echo $data['lending_factory'] ?>')" style="border: 0;cursor: pointer;" align="left" src="../style/images/icon1/Search.png"  width="20px" height="20px"/></a>
                       
                        <?php  } ?>
                        </td>
                        <? } ?>
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
                        <input type="text" readonly="" id="spactator_dept_name2"  name="spactator_dept_name2"  value="<? if ($chk) {
                            echo $uu->getNameth("hr_dept", $hr->getDeptCodeById($data['inv_requestor']));
                           //echo $_SESSION['create_by'];
                        } else {
                            echo $uu->getNameth("hr_dept", $hr->getDeptCodeById($_SESSION['username']));
                           // echo $_SESSION['create_by'];
                        } ?>"/>
                    </td>
            </tr>
                    
                    <tr>
                        
                        
                        <td>  
                             <?php  echo $factorytxt ;?>ต้องการยืมจากโรงงาน
                        </td>
                        <td >
                             <?
                             if($data['lending_factory']!=''){ ?>
                            <input style="width:100%" readonly="" type="text" value="<? echo  $uu->getNameth("mc_factory",$data['lending_factory']) ?>"  >
                       <? }else{  ?>
                             <select name="lending_fac" id="lending_fac" >
                                 <option value="">--เลือกโรงงาน--</option>
                                 <? 
                                 $lending_fac = " select * from mc_factory where status = 'A' and code not in ('{$_SESSION['factory_code']}') ";
                                 $rs = $conn->queryTis620($lending_fac);
                                while($row = $conn->parseArray($rs)){ 
                                        $selected = '' ;
                                    if($_GET['lending_fac']==$row['code']){
                                        $selected = 'selected';
                                    }
                                    ?>
                                 
                                 <option <? echo $selected ?>  value="<? echo $row['code'] ?>"><? echo $row['nameth'] ?></option>
                                    
                         <?       }
                             }
                         ?>
                                 
                             </select>

                        </td>
                        
                        
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
                <div style="float: right;">
                
                    <input  <?  if(isset($_GET['tx_id'])){  echo " hidden "; } ?>   type="submit" name="submit" value="บันทึก" />
            
                   
                </div>
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
                        <th>จำนวนที่อะไหล่ที่เหลือ</th>
                        <th>จำนวนที่ต้องการยืม</th>
                  
<!--                        <th align="center">จำนวนที่ขอโอน</th>-->
                       
                        <th align="center">เลือก</th>
                    </tr>
                 </thead>
            <form action="" method="post"  onsubmit="return notnull()">
            
                                      <?
            if($data["tx_id"] !="" ){
                
                require_once '../classes/InvStock.class.php';
                $stock = new InvStock();
                
      ?>
               <tr>
                        <td>
                            <input  readonly=""  class="fieldNotNull" style="width: 90%; float: left;" id="invcode" type="text" name="invcode" />
 
                    
                         <a><img onclick="return loadInv('<? echo $data['lending_factory'] ?>','<? echo $data["tx_id"] ?>')" style="border: 0;cursor: pointer;" align="left" src="../style/images/icon1/Search.png"  width="20px" height="20px"/></a>
                    
                          
                          
                            
                        </td>
                        <td><input  readonly=""  class="fieldNotNull" style="width: 90%; float: left;" id="onhand" type="text" name="onhand" /></td>
                        <td><input  class="fieldNotNull" style="width: 90%; float: left;" id="borrow_amt" type="text" name="borrow_amt" /></td>
                        
                         <td style="text-align: center;">
                             <? if($data['status']=='cancel'){  ?>
                             รายการนี้ถูกยกเลิกแล้ว
                             <? }elseif($data['status']=='approved'){  ?>
                             ยืนยันการยืมอะไหล่แล้ว
                             <? }else{ ?>
                             <input    type="submit" name="add" value="<? echo $add_txt; ?>" onclick="return checkBorrowAmount()" />
                             <? } ?>
                       <!--<input disabled=""  type="submit" name="add" value="<? echo $add_txt; ?>"/>-->
                        </td>
                       
                        
                    </tr>  <? }else{?>
 <?   }  ?>

            </form>
            <?
                $sql = "select * from inv_borrow_details WHERE tx_id ='{$_GET["tx_id"]}';";
//                echo $sql;
                $rs = $conn->queryTis620($sql);
                
                //echo $sql;
                
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
 
        $remainingas = $remaininga-$row["amt"];
 
                     
                     echo 'จำนวนอะไหล่คงเหลือ'." (".$remainingas.")";  ?></td>
 
               
                <td style="text-align: center;"><?  echo $row["amt"];  ?></td>
          
            </tr>
                <?   }  ?>
             
            
        </table>
           
           
           
        </div>
        
   
           
           <?   
           
            if(isset($_GET['tx_id'])){
     $edit = true;
    $sql = "SELECT * FROM inv_borrow WHERE tx_id = '{$_GET['tx_id']}';";
//    echo $sql;
    $rs = $conn->queryTis620($sql);
    $data0 = $conn->parseArray($rs);
    
   
    $sql99 = "select * from inv_borrow_details WHERE tx_id='{$_GET["tx_id"]}';";
                //echo $sql;
                $rs99 = $conn->queryTis620($sql99);
                $data2 = $conn->parseArray($rs99);
              //echo $sql99;
                
              
//    echo $data['status'];
    
       if($data0['status']=="1"){ 
       if($data2["assest_code"] != null){ ?>
           
        <input id="bb" type="button" onclick="return confirmRe()"  value="ยืนยันการย้าย"   />
              
              <!--<label style="color: red;font-size: 22pt;float: right;margin-right: 30px;">รอดำเนินการ</label>-->
   
 
 <?
 
       }
 }else{?>
         
               <br>
                   
 

                   
                   <form method="get" name="form1">
                       
                                <?php
          
                 require_once '../classes/Authen.class.php';
                        $aut = new Authen();
                        
        $chkxx = $aut->checkAuthenCode($_SESSION['username'],'index-reqasset');
                         ?>
                                
          
                       
                       
 
                        
             
            <br> <br>
               <!--<input id="bb" type="button" onclick="return confirmap()" value="approve"   />-->
                   
           
                 </form>
           <?php } ?>   
            
           <?php
           if($data['status']=="3"){
                 echo '<br><b> ผู้อนุมัติ : <b>' ;
                  echo $uu->getNameth('hr', $data["approve_request"]) ;
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
