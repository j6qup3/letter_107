<?php
	session_start();
  include '../inc/connect.php';
	$sql = "SELECT dept_no, dept_full_name
					FROM stfdept
					WHERE use_flag IS NULL";
	$data = $db -> query_array($sql);


  if (@$_POST['oper'] == "registered"){
    // 先暫用差假系統的系所查詢SQL
    $sql = "SELECT dept_no, dept_full_name
            FROM stfdept
            WHERE use_flag IS NULL";
    $data = $db -> query_array($sql);

    $dept_noToName = array();
    $i = 0;
    $dept_name = $data['DEPT_FULL_NAME'];
    foreach ($data['DEPT_NO'] as $dept_no) {
      // 查詢掛號資料
      $dept_noToName[$dept_no] = $dept_name[$i];
      ++$i;
    }

    $isTook = @$_POST['take_or_not'];
    $str_isTook = "";
    switch ($isTook) {
      case 'no':
        $str_isTook = "WHERE take_date = '^^^^^^'";
        break;
      case 'yes':
        $str_isTook = "WHERE take_date != '^^^^^^'";
        break;
      case 'all':
        $str_isTook = "";
        break;
      default:
        $str_isTook = "";
        break;
    }

    $sql = "SELECT name, letter_no, receive_date, take_date, room_code, dept_code
          FROM letter " . $str_isTook;
    $row = $db -> query_array($sql);
    $a['data'] = "";
    for($i = 0; $i < count($row['NAME']); ++$i){
      $name = $row['NAME'][$i];
      $letter_no = $row['LETTER_NO'][$i];
      $receive_date = $row['RECEIVE_DATE'][$i];
      $room_code = $row['ROOM_CODE'][$i];
      $dept_code = $row['DEPT_CODE'][$i];

      if ($room_code == 1)
        $room_code = "進德";
      elseif ($room_code == 2) {
        $room_code = "寶山";
      }
      $a['data'][] = array(
        $name,
        $letter_no,
        $receive_date,
        $room_code,
        "" . $dept_code . @$dept_noToName[$dept_code],
      );
    }
    echo json_encode($a);
    exit;
  }
?>
