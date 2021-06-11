<? 
session_start();
if($_SESSION["lang"]=="EN"){
    include '../config/variable_en.php';
    
}else{
    include '../config/variable_th.php';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <meta http-equiv="content-type" content="text/html; charset=tis-620"/>

        <link rel="stylesheet" href="../include/tree-menu/jquery.treeview.css" />
        <style type="text/css">
            .filetree{
                font-family: Verdana, helvetica, arial, sans-serif;
                font-size: 68.75%;
                background: #fff;
                color: #333;

            }
            .filetree ul{

            }
            body{
                margin: 0;
                padding: 0;
            }
            
            .hide-tree{
                position: absolute; 
                height: 100%;
                width: 0%;
                overflow-y: scroll;
                display: none;
            }
            .framefull{
                width: 100%; 
                position: absolute; 
                right: 10px; 
                height: 100%; 
                float: right;
            }
            
            .file a{
                color: #027AC6;
            }


        </style>

        <link rel="stylesheet" href="../style/font-page.css" />
        <script src="../include/tree-menu/lib/jquery.js" type="text/javascript"></script>
        <script src="../include/tree-menu/lib/jquery.cookie.js" type="text/javascript"></script>
        <script src="../include/tree-menu/jquery.treeview.js" type="text/javascript"></script>
        <script src="../include/tree-menu/jquery.treeview.edit.js" type="text/javascript"></script>

        <script type="text/javascript">
            $(function() {
                $("#browser").treeview();
                
                    $(".file >a").click(function(){
                        //alert($(this).attr('href'));
                        
                       
                        $(".file >a").css('color', '#027AC6');
                        $(".file >a").css('font-size', '8pt');
                        
                        $("#mycontent").attr('src',$(this).attr('href'));
                        $(this).css('color', 'red');
                        $(this).css('font-size', '10pt');
                       // $("#progess-data").show();
                        return false;
                    });
                    
                     $(".folder >a").click(function(){
                        //alert($(this).attr('href'));
                         $(".folder >a").css('color', '#027AC6');
                          $(".file >a").css('font-size', '8pt');
                          
                        $("#mycontent").attr('src',$(this).attr('href'));
                        $(this).css('color', 'red');
                        $(this).css('font-size', '10pt');
                       // $("#progess-data").show();
                        return false;
                    });
                    
                    
                 //  $("body").click(function(){
                //       alert('dfdf');
                //   });
               // $("#mycontent").contents().find("body").click(function(){
              //     alert('dfdfdf'); 
                    
              //  });
               
            });
            
            
            function stopProgress(){
                $("#progess-data").hide();
            }
            
            function hideTreebar(){
               // alert('dfdf');
                $('#iframe-div').css('width','98%');
                $('#main').hide();
            }
//            function showTreebar(){
//               // alert('dfdf');
//               
//               if($('#main').css('display')=='none'){
//                    $('#iframe-div').css('width','78%');
//                    $('#main').show();
//               }else{
//                    $('#iframe-div').css('width','98%');
//                     $('#main').hide();
//               }
//            }   
            // window.locatui   
        	
        </script>

    </head>
    <title><? echo $file_txt; ?></title>
    <body >
        <div id='progess-data' style="display: none; z-index: 1010; position: fixed; top: 0px; width: 100%; height: 100%; background-color: white; overflow: auto; opacity:0.6;
             filter:alpha(opacity=60);">
            <br/><br/><br/><br/><br/>
            <center><img src='../images/imgLoad.gif'/></center>
        </div>
    
        <div id="main">
           <?php   
           require_once '../classes/Utility.class.php';
             $uu = new Utility();
             
             if($_GET['ttype']=='' || $_GET['ttype'] == 'BRW'){
                 $title = "ขอยืมอะไหล่";
                 $href_type = "borrow_request.php";
                 $where = " WHERE status = 'w' ";
                 $page ="borrow_request.php";
             }elseif($_GET['ttype'] == 'APBOR'){
                 $title = "รออนุมัติให้ยืมอะไหล่";
                 $href_type = "borrow_request_approve.php";
                 $where = " WHERE status = 'w' ";
                 $page ="borrow_request_approve.php";
             }elseif($_GET['ttype'] == 'LEN'){
                 $title = "ให้ยืมอะไหล่";
                 $href_type = "borrow_lending.php";
                 $where = " WHERE status = 'approved' ";
                 $page ="borrow_lending.php";
             }elseif($_GET['ttype'] == 'RECCHK'){
                 $title = "รับอะไหล่";
                 $href_type = "borrow_receive.php";
                 $where = " WHERE status = 'approved' ";
                 $page ="borrow_receive.php";
             }
                 ?>
            
          
            
            
                <ul id="browser" class="filetree" style="position: absolute; height: 100%;width: 15%;overflow-y: scroll;">
                             <img src="../images/pmii.jpg"  width="150px" />
                            <li><span style="font-size: 16px;color: red;"><a href="../index.php" style="color: red;"><? echo $exitpage_txt; ?></a></span></li>
                            <li><span class="folder"><a href="<? echo $href_type.'?status=w' ; ?>"><? echo $title; ?></a></span>

                <ul>
            <? 
                require_once '../classes/Connect.class.php';
                $conn  = new Connect();
                $sql = "SELECT YEAR(ts) as tsx FROM inv_borrow $where  GROUP BY YEAR(ts) ORDER BY YEAR(ts) DESC;";
//                echo $sql;
                $rsY  = $conn->queryTis620($sql);
                
                while($rowY = $conn->parseArray($rsY)){
                   if($rowY['tsx']==""){
                       continue;
                   } 
            ?>
	<li><span class="folder"><? echo $rowY['tsx'];  ?></span>
                    <ul style="display: none;">
                        <?
                            $sql = "SELECT MONTH(ts) AS m  "
                                    . "FROM inv_borrow  $where and YEAR(ts)  = '{$rowY['tsx']}'   "
                                    . " GROUP BY MONTH(ts)  ORDER BY  MONTH(ts)  DESC;";
                            $rsM = $conn->queryTis620($sql);
//                            echo $sql;
                            
                            
                            while($rowM = $conn->parseArray($rsM)){
                                if($rowM['m']=='0'||$rowM['m']==""){
                                    continue;
                                }
                        ?>
                     <li>
                         <span class="folder">
                             <a href="<? echo $page ?>?m=<? echo $rowM['m']; ?>"><? echo $month_txt; ?> <? echo $rowM['m'];  ?></a>
                        </span>
    
<!--                            <ul style="display: none;">
     
                                    <li><span class="file"><a href="form_borrow_request.php?tx_id=<? echo $rowM['tx_id']; ?>">1111</a></span></li>
                                    <li><span class="file"><a href="form_borrow_request.php?tx_id=<? echo $rowM['tx_id']; ?>">22222</a></span></li>
                                    <li><span class="file"><a href="form_borrow_request.php?tx_id=<? echo $rowM['tx_id']; ?>">333</a></span></li>

                                </ul>-->
                            </li>
                        <?
                            }
                        ?>  
			</ul>
		</li>
            <?  } ?>
                    </ul>
                <?
                if($_GET['ttype'] == 'APBOR'){
                ?>
                                <li><span class="folder"><a href="<? echo $href_type.'?status=approved' ; ?>"><? echo 'อนุมัติแล้ว'; ?></a></span>
                           <ul>
            <? 
                require_once '../classes/Connect.class.php';
                $conn  = new Connect();
                $sql = "SELECT YEAR(ts) as tsx FROM inv_borrow where status = 'approved'  GROUP BY YEAR(ts) ORDER BY YEAR(ts) DESC;";
//                echo $sql;
                $rsY  = $conn->queryTis620($sql);
                
                while($rowY = $conn->parseArray($rsY)){
                   if($rowY['tsx']==""){
                       continue;
                   } 
            ?>
	<li><span class="folder"><? echo $rowY['tsx'];  ?></span>
                    <ul style="display: none;">
                        <?
                            $sql = "SELECT MONTH(ts) AS m  "
                                    . "FROM inv_borrow  WHERE  YEAR(ts)  = '{$rowY['tsx']}' and status = 'approved'  "
                                    . " GROUP BY MONTH(ts)  ORDER BY  MONTH(ts)  DESC;";
                            $rsM = $conn->queryTis620($sql);
//                            echo $sql;
                            
                            
                            while($rowM = $conn->parseArray($rsM)){
                                if($rowM['m']=='0'||$rowM['m']==""){
                                    continue;
                                }
                        ?>
                     <li>
                         <span class="folder">
                             <a href="borrow_request_approve.php?m=<? echo $rowM['m']; ?>&status=approved"><? echo $month_txt; ?> <? echo $rowM['m'];  ?></a>
                        </span>
    
<!--                            <ul style="display: none;">
     
                                    <li><span class="file"><a href="form_borrow_request.php?tx_id=<? echo $rowM['tx_id']; ?>">1111</a></span></li>
                                    <li><span class="file"><a href="form_borrow_request.php?tx_id=<? echo $rowM['tx_id']; ?>">22222</a></span></li>
                                    <li><span class="file"><a href="form_borrow_request.php?tx_id=<? echo $rowM['tx_id']; ?>">333</a></span></li>

                                </ul>-->
                            </li>
                        <?
                            }
                        ?>  
			</ul>
		</li>
            <?  } ?>
                    </ul>    
                                    <li><span class="folder"><a href="<? echo $href_type.'?status=cancel' ; ?>"><? echo 'ยกเลิกแล้ว'; ?></a></span>
                           <ul>
            <? 
                require_once '../classes/Connect.class.php';
                $conn  = new Connect();
                $sql = "SELECT YEAR(ts) as tsx FROM inv_borrow where status = 'cancel'  GROUP BY YEAR(ts) ORDER BY YEAR(ts) DESC;";
//                echo $sql;
                $rsY  = $conn->queryTis620($sql);
                
                while($rowY = $conn->parseArray($rsY)){
                   if($rowY['tsx']==""){
                       continue;
                   } 
            ?>
	<li><span class="folder"><? echo $rowY['tsx'];  ?></span>
                    <ul style="display: none;">
                        <?
                            $sql = "SELECT MONTH(ts) AS m  "
                                    . "FROM inv_borrow  WHERE  YEAR(ts)  = '{$rowY['tsx']}' and status = 'cancel'  "
                                    . " GROUP BY MONTH(ts)  ORDER BY  MONTH(ts)  DESC;";
                            $rsM = $conn->queryTis620($sql);
//                            echo $sql;
                            
                            
                            while($rowM = $conn->parseArray($rsM)){
                                if($rowM['m']=='0'||$rowM['m']==""){
                                    continue;
                                }
                        ?>
                     <li>
                         <span class="folder">
                             <a href="borrow_request_approve.php?m=<? echo $rowM['m']; ?>&status=cancel"><? echo $month_txt; ?> <? echo $rowM['m'];  ?></a>
                        </span>
    
<!--                            <ul style="display: none;">
     
                                    <li><span class="file"><a href="form_borrow_request.php?tx_id=<? echo $rowM['tx_id']; ?>">1111</a></span></li>
                                    <li><span class="file"><a href="form_borrow_request.php?tx_id=<? echo $rowM['tx_id']; ?>">22222</a></span></li>
                                    <li><span class="file"><a href="form_borrow_request.php?tx_id=<? echo $rowM['tx_id']; ?>">333</a></span></li>

                                </ul>-->
                            </li>
                        <?
                            }
                        ?>  
			</ul>
		</li>
            <?  } ?>
                    </ul>
                                
                <? } ?>
                                
                             </li>
                             
                        </ul>
            
             
            </div>
 
        <div id="iframe-div"  style="width: 84.5%; position: absolute; right: 10px; height: 100%; float: right;">
            <iframe  name="mycontentIframe"  id="mycontent" style="width: 100%; height: 98%; border: 0;margin: 0;" src="<?  echo $page; ?>"></iframe>
        </div>
                   
               
    </body>
</html>