<? header('Content-Type: text/html; charset=tis-620');
require_once '../../classes/Connect.class.php';
$conn = new Connect();
;
 
 
?>
 
 
                <td>aaaaaaaaaaa</td>
                <td style="text-align: center;">
 
                    <input  name="amt_received<? echo $i ?>" id="amt_received<? echo $i ?>" type="text" value="<? echo $row1['lend_amt']; ?>" >
                </td>

                <td style="text-align: center;"><input onchange="ifAmtNotDone('<? echo $i ?>','<? echo $row["inv_code"] ?>')" name="amt_movein<? echo $i ?>" id="amt_movein<? echo $i ?>" type="text"  ></td>

                
                <td style="text-align: center;"> asdfadsfasdf </td>
                
                
                <td style="text-align: center;"><input onclick="toSaveStoreLoca('<? echo $i ?>','<? echo $_GET['tx_id'] ?>','<? echo $row["inv_code"] ?>')" type="button" name="save<? echo $i ?>" id="save<? echo $i ?>" value="บันทึก"  ></td>
 
 
 