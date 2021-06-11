<? header('Content-Type: text/html; charset=tis-620');
require_once '../../classes/Connect.class.php';
$conn = new Connect();

$tx_id = $_POST['tx_id'];
$inv_code = $_POST['inv_code'];
$location  = $_POST['loca'];
$store  = $_POST['store'];

$delete = " delete from inv_borrow_details_transfer  where tx_id = '$tx_id' and inv_code = '$inv_code' and store_code = '$store' and loca_code = '$location'  " ;
$rs_count = $conn->queryTis620($delete);

echo 'updated';