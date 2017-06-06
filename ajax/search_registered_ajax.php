<?php
	session_start();
  include '../inc/connect.php';

	// 先暫用差假系統的系所查詢SQL
	$sql = "SELECT dept_no, dept_full_name
					FROM stfdept
					WHERE use_flag IS NULL";
	$data = $db -> query_array($sql);

	// 建立系所代碼 映射 系所名稱 的array
	$dept_noToName = array();
	$i = 0;
	$dept_name = $data['DEPT_FULL_NAME'];
	foreach ($data['DEPT_NO'] as $dept_no) {
		$dept_noToName[$dept_no] = $dept_name[$i];
		++$i;
	}

	// if (@$_POST['oper'] == "codeToName"){
	// 	echo json_encode($dept_noToName);
  //   exit;
	// }

  if (@$_POST['oper'] == "registered"){
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
      $dept_name = $dept_code . @$dept_noToName[$dept_code];

      if ($room_code == 1)
        $str_room_code = "進德";
      elseif ($room_code == 2) {
        $str_room_code = "寶山";
      }
      $a['data'][] = array(
        $name,
        $letter_no,
        $receive_date,
        $str_room_code,
        $dept_name,
        "<button type='button' class='btn-success' name='modify' title='修改儲存' onclick='Edit(\"$name\", \"$letter_no\", \"$receive_date\", \"$room_code\", \"$dept_code\")' title='儲存修改'><i class='fa fa-save'></i></button>" .
        "<button type='button' class='btn-danger' name='delete' title='刪除' onclick='Delete(\"$name\", \"$letter_no\", \"$receive_date\", \"$room_code\", \"$dept_code\")' title='刪除'><i class='fa fa-times'></i></button>"
      );
    }
    echo json_encode($a);
    exit;
  }
	elseif(@$_POST['oper'] == "dept_fill"){
		$stu_name = @$_POST['stu_name'];

		$sql = "SELECT CLS_ID FROM students WHERE STU_NAME = '$stu_name' ";

		// echo $sql;
		// exit;

		$data = $db -> query_array($sql);

		if(empty($data))
		{
			$data = array();
			echo json_encode($data);
			exit;
		}

		// 根據此學生姓名所對應的系所陣列（同名可能會有多個系所結果）
		$srh_idToName = array();
		foreach ($data['CLS_ID'] as $cls_id) {
			$sub_cls_id = substr($cls_id, 1, 3);
			$cls_name = @$dept_noToName[$sub_cls_id];
			// 根據每個ID(key)，從程式最一開始建的系所代碼映射系所名稱的陣列
			// 去找尋對應系所名稱，並加入陣列
			if ($cls_name !== null)
				$srh_idToName[$sub_cls_id] = $cls_name;
			else
				$srh_idToName[$sub_cls_id] = $sub_cls_id; // 若如"XZ6"沒有對應的系所名稱，則對應名稱存該系所代碼
		}

		echo json_encode($srh_idToName);
		exit;
  }
	elseif (@$_POST['oper'] == "update"){
		$stu_name = $_POST["stu_name"];
		$letter_no = $_POST["letter_no"];
		// $dept_name = $_POST["dept_name"];
		$dept_code = $_POST["dept_code"];
		$room_code = $_POST["room_code"];
		$receive_date = $_POST["receive_date"];

		$origin_stu_name = $_POST["origin_stu_name"];
		$origin_letter_no = $_POST["origin_letter_no"];
		$origin_dept_code = $_POST["origin_dept_code"];
		$origin_room_code = $_POST["origin_room_code"];
		$origin_receive_date = $_POST["origin_receive_date"];

		$receive_date_sec = explode("/", $receive_date);

		$receive_year = (int)($receive_date_sec[0]) - 1911;
		$receive_month = (int)($receive_date_sec[1]);
		$receive_day = (int)($receive_date_sec[2]);


		if(strlen($receive_month) < 2)
			$receive_month = '0' . $receive_month;
		if(strlen($receive_day) < 2)
			$receive_day = '0' . $receive_day;

	 	$receive_date = $receive_year . $receive_month . $receive_day;
		if ($origin_dept_code != "")
	  	$update = "UPDATE letter SET NAME = '$stu_name', LETTER_NO = '$letter_no', RECEIVE_DATE = '$receive_date', DEPT_CODE = '$dept_code', ROOM_CODE = '$room_code' WHERE NAME = '$origin_stu_name' AND LETTER_NO = '$origin_letter_no'  AND RECEIVE_DATE = '$origin_receive_date' AND DEPT_CODE = '$origin_dept_code' AND ROOM_CODE = '$origin_room_code' ";
		else
			$update = "UPDATE letter SET NAME = '$stu_name', LETTER_NO = '$letter_no', RECEIVE_DATE = '$receive_date', DEPT_CODE = '$dept_code', ROOM_CODE = '$room_code' WHERE NAME = '$origin_stu_name' AND LETTER_NO = '$origin_letter_no'  AND RECEIVE_DATE = '$origin_receive_date' AND DEPT_CODE IS NULL AND ROOM_CODE = '$origin_room_code' ";

  	$result = $db -> query_trsac($update);
  	// echo json_encode($update);
  	// exit;
  	if($result)//失敗需rollback
  	{
  	   if( !empty($result["message"]) )
  	   {
  	      // echo json_encode($update);
  	      echo json_encode("更新資料失敗");
  	      exit;
  	   }
  	   else
  	   {
  	      $db -> end_trsac();
  	      echo json_encode("更新成功");
  	      exit;
  	   }
  	}

	}
	else if(@$_POST["oper"] == "delete")
	{

		$stu_name = $_POST["stu_name"];
		$letter_no = (string)$_POST["letter_no"];
		// $dept_name = $_POST["dept_name"];
		$dept_code = $_POST["dept_code"];
		$room_code = $_POST["room_code"];
		$receive_date = $_POST["receive_date"];

		$delete = "DELETE FROM letter WHERE NAME = '$stu_name' AND LETTER_NO = '$letter_no' AND RECEIVE_DATE = '$receive_date' AND DEPT_CODE = '$dept_code' AND ROOM_CODE = '$room_code' ";

		// echo json_encode($delete);
		// exit;

		$result = $db -> query($delete);

		if( !empty($result["message"]) )
			$data = "資料刪除有問題。";
		else
		    $data = "資料刪除完畢";

		echo json_encode($data);
		exit;

	}
?>
