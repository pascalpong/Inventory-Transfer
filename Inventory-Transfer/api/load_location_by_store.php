<? header('Content-Type: text/html; charset=tis-620');
require_once '../../classes/Connect.class.php';
$conn = new Connect();
 

//echo $_GET['inv_code'];
//$sql = " select * from inv_location WHERE storecode='{$_GET["store"]}' and factory_code = '{$_SESSION['factory_code']}' ORDER BY code ASC";
$sql = " select loca_code from inv_tx_details where tx_id like '%ADJ%' and store_code = '{$_GET["store"]}'  and factory_code = '{$_SESSION['factory_code']}' group by  loca_code order by loca_code asc";
//echo $sql;
$rs = $conn->queryTis620($sql);

//echo "<option value=''>---โปรดเลือก---</option>";
echo "<option value=''>---โปรดเลือก---</option>";
while($row = $conn->parseArray($rs)){
   
    $get_nameth = " SELECT nameth FROM inv_location WHERE code = '{$row["loca_code"]}' ";
    $rs_nameth = $conn->queryTis620($get_nameth);
    $row_nameth = $conn->parseArray($rs_nameth);
    $selected = "";
    if($_GET["current"]==$row["loca_code"]){
        $selected = "selected";
    }

?>
<option  <? echo $selected; ?>  value="<? echo $row["loca_code"]; ?>"><? echo $row["loca_code"]." : ".$row_nameth["nameth"]; ?></option>

<? } ?>