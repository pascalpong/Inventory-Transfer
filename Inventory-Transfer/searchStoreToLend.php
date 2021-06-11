<?
session_start();
if($_SESSION["lang"]=="EN"){
    include '../config/variable_en.php';
    
}else{
    include '../config/variable_th.php';
}
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
        <title><? echo $bmorderlist_txt; ?></title>
    </head>
    <body style="padding-right: 10px">
        
       
        <!--<button style="float: right;" onclick="return closeDialog()"><? echo $exitpage_txt; ?></button>-->
        
        <p style="margin-left: 20px;margin: 0;">
                <label for="search">
                    <strong><? echo $find_txt; ?></strong>
                </label>
        <input  type="text" size="50" id="search"  value="<?
            $key = iconv('utf-8','tis620',$_GET['inv_code']);
            echo $key; ?>"/>
           
        </p>
        
        <table id="tablesorter-demo1" class="tablesorter"  style="width: 100%;">
            <thead>
                <tr>
                    <th><? echo $code_txt; ?></th>
                    <th><? echo 'store'; ?></th>
                    <th><? echo 'location'; ?></th>
                    <th><? echo 'Remaining'; ?></th>
                </tr>
            </thead>
            <tbody>
                <?
                require_once '../classes/Connect.class.php';
                $conn = new Connect();
                
                $borrow = " select lending_factory from inv_borrow where tx_id = '{$_GET['tx_id']}' ";
                $rs_borrow  = $conn->queryTis620($borrow);
                $row_borrow = $conn->parseArray($rs_borrow);
                
                $sql = " select store_code,loca_code, factory_code  from inv_tx_details where inv_code =  '{$_GET['inv_code']}' and factory_code = '{$row_borrow['lending_factory']}' group by store_code , loca_code , factory_code  ; ";
//                echo $sql;
                $rs  = $conn->queryTis620($sql);
                while($row1 = $conn->parseArray($rs)){
                 //  print_r($row1);
        $sql52 = "SELECT   SUM(amt) AS remain FROM inv_tx_details td WHERE td.inv_code = '{$_GET['inv_code']}'  AND (tx_id LIKE  'ADJ%' OR tx_id LIKE  'RCV%'  OR tx_id LIKE  'RTN%') and td.store_code = '{$row1['store_code']}' and td.loca_code = '{$row1['loca_code']}' and  td.factory_code = '{$row_borrow['lending_factory']}' ; "; 
//        echo $sql1."<br/>";
        $rs52 = $conn->queryTis620($sql52);
        $row52  = $conn->parseArray($rs52);
        $sql2 = " SELECT  SUM(amt) AS remain   FROM inv_tx_details td WHERE td.inv_code = '{$_GET['inv_code']}'   AND (tx_id LIKE  'BRW%' OR tx_id LIKE  'ISS%'  OR tx_id LIKE  'ISP%') and td.store_code = '{$row1['store_code']}' and td.loca_code = '{$row1['loca_code']}' and  td.factory_code = '{$row_borrow['lending_factory']}' ;";
//         echo $sql2."<br/>";
        
        $rs2 = $conn->queryTis620($sql2);
        $row2  = $conn->parseArray($rs2);
        
        $new_remain = $row52['remain']-$row2['remain'];
        
        $inv_borrow = " select * from inv_borrow where  ";
        
                    ?>
                
                
                    <tr style="cursor: pointer;" onclick="window.parent.selectStoreLoca('<? echo $_GET['inv_code']; ?>','<? echo $row1['store_code']; ?>','<? echo $row1['loca_code']; ?>','<? echo $new_remain ?>','<? echo $_GET['round'] ?>')">
                        <td><a class="click-machine" ><? echo $_GET['inv_code']; ?></a></td>
                        <td><a class="click-machine" ><? echo $row1['store_code']; ?></a></td>
                        <td><a class="click-machine" ><? echo $row1['loca_code']; ?></a></td>
                        <td><a class="click-machine" ><? echo $new_remain; ?></a></td>
                    </tr>
                <?
                } 
                ?>
            </tbody>
        </table>
        <? 
//        require_once '../classes/InvStock.class.php';
//        $stock = new InvStock();
//        
//        echo  $remaining = $stock->getRemainIgnoreCase($_GET['inv_code']); 
        ?>
    </body>
</html>