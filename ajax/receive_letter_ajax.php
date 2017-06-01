<?php
include '../inc/check.php';

if(!isset($_POST["oper"]))
	exit;


switch(@$_POST['oper'])
{
	case "qrydata":
		goto QRYDATA;
    case "update":
        goto UPDATE;
    default:
        exit;
}

QRYDATA:

$sql = "SELECT 'row_' || ROWNUM AS DT_RowId, name, letter_no, receive_date, take_date, agent, mark, room_code
        FROM   letter
        WHERE  take_date='^^^^^^'
		";

$aoData['data'] = $db -> query_array($sql, true);



echo json_encode($aoData); 
exit;


UPDATE:
$take_date = $_POST["take_date"];
$agent = $_POST["agent"];
$name = $_POST["name"];
$letter_no = $_POST["letter_no"];
$receive_date = $_POST["receive_date"];

$sql = "UPDATE letter
        SET take_date = '$take_date', agent = '$agent'
        WHERE name = '$name'
        AND letter_no = '$letter_no'
        AND receive_date = '$receive_date'
		";

$msg = $db -> query($sql);
echo iconv("BIG5", "UTF-8", $msg['message']);
exit;

?>