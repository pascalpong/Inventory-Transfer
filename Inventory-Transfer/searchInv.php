<?
session_start();
if($_SESSION["lang"]=="EN"){
    include '../config/variable_en.php';
    
}else{
    include '../config/variable_th.php';
}
                require_once '../classes/Connect.class.php';
                require_once '../classes/InvStock.class.php';
                 require_once '../classes/Utility.class.php';
                    
                $conn = new Connect();
                $stock = new InvStock();
                $uu = new Utility();
header ('Content-type: text/html; charset=tis-620');  
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
   
    <head>
        <meta http-equiv="content-type" content="text/html; charset=tis-620" />
        
        <link rel="stylesheet" href="../style/font-page.css" type="text/css" media="print, projection, screen" />
        <script type="text/javascript" src="../include/jquery/jquery-1.4.2.js"></script>
        <script type="text/javascript" src="../include/sort-table/jquery-latest.js"></script>
        <script type="text/javascript" src="../include/sort-table/jquery.tablesorter.js"></script>
        <link rel="stylesheet" href="../include/sort-table/themes/blue/style.css" type="text/css" media="print, projection, screen" />
       
        <style type="text/css">
            .tablesorter thead th{
                border: 0.5px solid #CDCDCD;
                border-collapse: collapse;
                
            }
            
        </style>
        <script type="text/javascript">
            $(function() {    
                $("#tablesorter-demo1").tablesorter();
                 $('#search').keyup(function()
                 {
                    searchTable($(this).val());
                 });
  
            });
             
           
           
                            function searchTable(inputVal)
                            {
                                var table = $('#tablesorter-demo1');
                                table.find('tr').each(function(index, row)
                                {
                                    var allCells = $(row).find('td');
                                    if(allCells.length > 0)
                                    {
                                        var found = false;
                                        allCells.each(function(index, td)
                                        {
                                            var regExp = new RegExp(inputVal, 'i');
                                            if(regExp.test($(td).text()))
                                            {
                                                found = true;
                                                return false;
                                            }
                                        });
                                        if(found == true)$(row).show();else $(row).hide();
                                    }
                                });
                            }
                            
                            
                            
                            function closeDialog(){
                                $('#modal-content').hide();
                            }
           
        </script>
        <title><? echo $mcfile_txt; ?></title>
    </head>
    <body style="padding-right: 10px">
      <!--<button style="float: right;" onclick="return closeDialog()"><? echo $exitpage_txt; ?></button>-->
        <form action="" method="GET"> 
            
        <p style="margin-left: 20px;margin: 0;">
                <label for="search">
                    <strong><? echo $find_txt; ?></strong>
                </label>
            <input type="text" name="code" size="50" id="search" value="<?
            $key = iconv('utf-8','tis620',$_GET['term']);
            echo $key; ?>"/>
             <input type="button" name="search"  value="<? echo $find_txt; ?>"/>
              <? echo $labellist_max; ?> <? echo  500;?> <? echo $label_item; ?>
        </p>
            <p>  เลือกโรงงาน : 
            <? 

            $sel_fac  =" SELECT * FROM mc_factory WHERE code NOT IN ('{$_GET['factory']}') ORDER BY code ASC  ";
                        $re_fac  = $conn->queryTis620($sel_fac);
                while($row_fac = $conn->parseArray($re_fac)){
            
            ?>
            <a <? if($_GET['factory']==$row_fac['code']){ echo "style='color:black' href='#' "; }else{ echo " href='searchInv.php?factory={$row_fac['code']}&tx_id={$_GET['tx_id']}' "; } ?>  href="" ><? echo $row_fac['code'] ?></a>   |    
            
                <? } 
                
                ?>
            
            </p>
        </form>

           
        
        <table id="tablesorter-demo1" class="tablesorter"  style="width: 100%;">
            <thead>
                
                <tr>
                    <th><? echo $code_txt; ?></th>
                    <th><? echo 'ชื่ออะไหล่'; ?></th>
                    <th><? echo 'นิคม'; ?></th>
                       <th><? echo 'Remaining '; ?></th>
                    <!--<th><? echo 'เลขที่ทรัพย์สิน'; ?></th>-->
                   
                    
                </tr>
            </thead>
            <tbody>
                <?

               
             //   $factorycodition  = "  AND i.factory_code = '{$_SESSION["factory_code"]}' ";
//                
//               $sql ="SELECT me.eq_code,e.nameth,e.factory_code,e.assetno FROM mc_ref_eq me 
//              LEFT OUTER JOIN equip e ON e.code = me.eq_code
//WHERE me.mc_code = '' AND e.factory_code ='{$_GET['factory']}'";
//              $sql ="SELECT me.eq_code,e.nameth,e.factory_code,e.assetno  FROM mc_ref_eq me 
//              LEFT OUTER JOIN equip e ON e.code = me.eq_code
//WHERE e.factory_code ='{$_SESSION["factory_code"]}'  ";
//                $sql = " select * from inv ";
                $sql = " select inv_tx_details.inv_code as code ,inv.nameth   from inv_tx_details left join inv on inv.code = inv_tx_details.inv_code where inv_tx_details.factory_code  = '{$_GET['factory']}' group by inv_tx_details.inv_code,inv.nameth  ,inv_tx_details.factory_code";
//          echo $sql;
            $result  = $conn->queryTis620($sql);
            
//            echo $_GET['factory'];
                    
                    
                while($row1 = $conn->parseArray($result)){
                    
                 //  print_r($row1);
                //   echo "<br/>";
                  //  $amt = $stock->getRemainByPrice($row1['inv_code'], $row1['store_code'], $row1['loca_code'],$row1['uop']);
//                    $amt = $stock->getRemainIgnorePrice($row1['inv_code'], $row1['store_code'], $row1['loca_code']);
//                    $uop = $stock->getAverage($row1['inv_code']);
                   //  if($amt==""){
                  //          $amt =  0; 
                   //  }
        $sqlaa = "SELECT   SUM(amt) AS remain FROM inv_tx_details td WHERE td.inv_code = '{$row1['code']}'  AND (tx_id LIKE  'ADJ%' OR tx_id LIKE  'RCV%'  OR tx_id LIKE  'RTN%') AND td.factory_code = '{$_GET['factory']}' ; "; 
//        echo $sqlaa."<br/>";
        $rsaa = $conn->queryTis620($sqlaa);
        $rowaa  = $conn->parseArray($rsaa);
        $sqlss = " SELECT  SUM(amt) AS remain   FROM inv_tx_details td WHERE td.inv_code = '{$row1['code']}'   AND (tx_id LIKE  'BRW%' OR tx_id LIKE  'ISS%'  OR tx_id LIKE  'ISP%') AND td.factory_code = '{$_GET['factory']}' ;";
//         echo $sqlss;
        
        $rsss = $conn->queryTis620($sqlss);
        $row1ss  = $conn->parseArray($rsss);
        
        $remain = $rowaa['remain']-$row1ss['remain'];
                    
                    ?>
                
                <?
                $facintxid = "select lending_factory from inv_borrow where tx_id = '{$_GET['tx_id']}'";
                $rsintxid = $conn->queryTis620($facintxid);
        $rowintxid  = $conn->parseArray($rsintxid);
//                echo $rowintxid['lending_factory'];
                if($rowintxid['lending_factory']==$_GET['factory']){ ?>
                
       
                    
                
                <tr style="cursor: pointer;"  onclick="window.parent.clickSelectInv('<? echo $row1['code']; ?>','<? echo $row1['nameth']; ?>','<? echo $remain; ?>','<? echo $row1['assetno']; ?>')">
                       <td><a class="click-machine" ><? echo $row1['code']; ?></a></td>
                        <td><a class="click-machine" ><? echo $row1['nameth']; ?></a></td>
                        <td><a class="click-machine" ><? echo $row1['factory_code']; ?></a></td>
                    <td><a class="click-machine" ><? echo $remain; ?></a></td>
<!--                        <td><a class="click-machine" ><? echo $row1['assetno']; ?></a></td>-->
                        
                    </tr>
                
                <? }else{ ?>
                <tr>
                        <td><p style="color:grey" ><? echo $row1['code']; ?></p></td>
                        <td><p style="color:grey" ><? echo $row1['nameth']; ?></p></td>
                        <td><p style="color:grey" ><? echo $row1['factory_code']; ?></p></td>
                        <td><p style="color:grey" ><? echo $remain; ?></p></td>    
                </tr>
                <?
                }
                }
                ?>
                
                
                
                
            </tbody>
        </table>
      
    
      
    </body>
</html>