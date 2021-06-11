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
        <input type="text" size="50" id="search"  value="<?
            $key = iconv('utf-8','tis620',$_GET['term']);
            echo $key; ?>"/>
           
        </p>
        
        <table id="tablesorter-demo1" class="tablesorter"  style="width: 100%;">
            <thead>
                <tr>
                    <th><? echo $code_txt; ?></th>
                    <th><? echo $label_employeename; ?></th>
                    <th><? echo $label_dept; ?></th>
                </tr>
            </thead>
            <tbody>
                <?
                require_once '../classes/Connect.class.php';
                $conn = new Connect();
                $key = iconv('utf-8','tis620',$_GET['term']);

                $sql = "select hr.code , hr.nameth as person_name , hr.hr_dept  , hr_dept.nameth as dept_name from hr left join hr_dept on hr_dept.code = hr.hr_dept  where hr.factory_code = '{$_SESSION['factory_code']}' ; ";
//                echo $sql;
 

                $rs  = $conn->queryTis620($sql);
                while($row1 = $conn->parseArray($rs)){
                 //  print_r($row1);

                    ?>
                
                
                    <tr style="cursor: pointer;" onclick="window.parent.clickSelectLabor('<? echo $row1['code']; ?>','<? echo $row1['person_name']; ?>','<? echo $row1['hr_dept']; ?>','<? echo $row1['dept_name']; ?>')">
                        <td><a class="click-machine" ><? echo $row1['code']; ?></a></td>
                        <td><a class="click-machine" ><? echo $row1['person_name']; ?></a></td>
                        <td><a class="click-machine" ><? echo $row1['dept_name']; ?></a></td>
                    </tr>
                <?
                } 
                ?>
            </tbody>
        </table>
    </body>
</html>