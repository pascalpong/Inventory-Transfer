<?
    session_start();
    ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>

        <meta http-equiv="content-type" content="text/html; charset=tis-620" />
        
        <link href="../style/default.css?v=4" media="screen" rel="stylesheet" type="text/css" />
        <link href="../style/dropdown.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="../style/dropdown.vertical.rtl.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="../style/default.ultimate.css" media="screen" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="../include/sort-table/themes/blue/style.css" type="text/css" media="print, projection, screen" />
       
        <style type="text/css">
            .click-machine{
                text-decoration: none;
                color: #3D3D3D;
   
            }
        </style>
        
        <script type="text/javascript" src="../include/sort-table/jquery-latest.js"></script>
        <script type="text/javascript" src="../include/sort-table/jquery.tablesorter.js"></script>
        <script type="text/javascript">
            $(function() {    
                $("#tablesorter-demo").tablesorter();
                
                
                $('#search').keyup(function()
                 {
                    searchTable($(this).val());
                 }); 
  
            });
             function searchTable(inputVal){
                                var table = $('#tablesorter-demo');
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
            
            
            
            
            function refestPage(url){
                document.location.href=url;
                return false;
            }
        </script>
        <title>แฟ้มอะไหล่</title>
    </head>
    <body>
        <? include '../include/head-menu/nav-menu.php'; ?>
        <form action="" method="post">
       
            <!--<a href="../chk_asset/report_tranfer.php" target="_blank">รายงานการย้ายทรัพย์สิน(ต้นทาง)</a>-->
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   <span style="margin-left: 20px;margin: 0;">
                <label for="search">
                    <strong>ค้นหา</strong>
                </label>
            <input type="text" size="50" id="search" name="key" value="<?
            $key = $_POST["key"];
            echo $key; ?>"/>
           
            
            <?  
            ?>
        </span>   <input  type="submit"  name="search" value="ค้นหา"  />
        <br> 
            <!--<a href="../chk_asset/report_tranfer_desti.php" target="_blank">รายงานการย้ายทรัพย์สิน(ปลายทาง)</a>-->
      
      
        
        <input onclick="document.location.href='form_borrow_request.php'" style="float: right;" type="button"  name="add"  value="เพิ่ม"  />
    
        <table id="tablesorter-demo" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
            <thead>
                <tr>
                    <th>วันที่ทำรายการ</th>
                    <th>เลขที่ใบย้าย</th>
                    <th>เลขที่เอกสารอ้างอิง</th>
                    <th>ขอยืมจากโรงงาน</th>
                    <!--<th>บริษัท - ต้นทาง</th>-->
                    <th>โรงงานที่ขอยืม</th>
                    <th>ช่างที่ขอยืม</th>
                    <!--<th>สถานะ</th>-->
                   
                </tr>
            </thead>
            <tbody>
                <?
                
                
             require_once '../classes/Connect.class.php';
             $conn = new Connect();
             require_once '../classes/Utility.class.php';
             $uu = new Utility();
                
 
             $where_month = '';
if(isset($_GET['m'])){
    
   $where_month = " AND MONTH(ts) = '{$_GET['m']}' ";
    
}
              $conn = new Connect();
                  $sql = "select * from  inv_borrow WHERE 1 = 1 $where_month AND borrowing_factory  = '{$_SESSION['factory_code']}'  ";
//  echo $sql;
      
                $rs = $conn->queryTis620($sql);
                while ($row = $conn->parseArray($rs)) {
                    
         
                    
                    
                    ?>
                <tr style="cursor: pointer;" onclick="document.location.href='form_borrow_request.php?tx_id=<? echo $row['tx_id']; ?>'">
                    <td>
                        <?php echo $row['ts'] ; ?>
                    </td>
                     <td>
                        <?php echo $row['tx_id'] ; ?>
                    </td>
                     <td>
                        <?php echo $row['ref_no'] ; ?>
                    </td>
                    <td>
                        <?php echo $uu->getNameth('mc_factory', $row['lending_factory']).'( '. $row['lending_factory'].' )' ; ?>
                    </td>
<!--                    <td>
                        <?php echo $uu->getNameth('mc_division', $row['division_start']).'( '.$row['division_start'] .' )' ; ?>
                    </td>-->
                    <?
                    $get_info = " select factory_code,code from hr where code = '{$row['inv_requestor']}'  ";
                    $rs_info = $conn->queryTis620($get_info);
                    $row_info = $conn->parseArray($rs_info);
                    
                    ?>
                    <td>
                        <?php echo $uu->getNameth('mc_factory', $row_info['factory_code']) .'( '.$row_info['factory_code'].' )'; ?>
                    </td>
                     <td>
                        <?php echo $uu->getNameth('hr', $row_info['code']) .'( '.$row_info['code'].' )'; ?>
                    </td>
<!--                    <td>
                        <?php  echo $uu->getNameth('inv_borrow_status', $row['status']) ; ?>
                    </td>-->
                </tr>
                <? } ?>

            </tbody>
        </table>
        </form>
    </body>
</html>