<?php
	session_start();
  	include '../inc/connect.php';

  	$empl_no = $_SESSION['empl_no'];
  	$empl_name = $_SESSION['empl_name'];

  	if($_POST["oper"] == "area")
  	{
  		if($empl_no == "0000676")
  			$room_code = 1;
  		else
  			$room_code = 2;

  		echo json_encode($room_code);
  		exit;
  	}
  	else if($_POST["oper"] == "query")
  	{

  		$SQLStr = " SELECT * FROM letter WHERE TAKE_DATE = '^^^^^^'";

  		$row = $db -> query_array($SQLStr);

  		$a['data']="";

  		for($i = 0; $i < count($row['NAME']) ; $i++)
  		{

  			if($row['ROOM_CODE'][$i] == 1)
  				$room_code = "進德";
  			else if ($row['ROOM_CODE'][$i] == 2)
  				$room_code = "寶山";

  			$NAME = (string)$row['NAME'][$i];
  			$LETTER_NO = $row['LETTER_NO'][$i];
  			$RECEIVE_DATE = $row['RECEIVE_DATE'][$i];
  			$TAKE_DATE = $row['TAKE_DATE'][$i];
  			$DEPT_CODE = $row['DEPT_CODE'][$i];
  			$ROOM_CODE = $row['ROOM_CODE'][$i];
  			$AGENT = $row['AGENT'][$i];
  			$MARK = $row['MARK'][$i];

  		    $a['data'][] = array(
  		        $row['NAME'][$i],
  		        $row['LETTER_NO'][$i],
  		        $row['RECEIVE_DATE'][$i],
  		        $row['TAKE_DATE'][$i],
  		        $row['DEPT_CODE'][$i],
  		        $room_code,
  		        $row['AGENT'][$i],
  		        $row['MARK'][$i],
  		        "<button type='button' class='btn-warning' name='edit' id='edit' onclick = ' Edit( \"$NAME\", \"$LETTER_NO\",$RECEIVE_DATE, $DEPT_CODE, $ROOM_CODE, \"$AGENT\", \"$MARK\");' title='修改'>修改</button>",
  		        "<button type='button' class='btn-danger' name='delete' id='delete' onclick= ' Delete( \"$NAME\", \"$LETTER_NO\", $RECEIVE_DATE, $DEPT_CODE, $ROOM_CODE, \"$AGENT\", \"$MARK\");' title='刪除'>刪除</button>"

  		    );

  		}
  		echo json_encode($a);

  	}

  	else if($_POST['oper'] == "dept_fill")
  	{
  		$stu_name = $_POST["stu_name"];

  		$sql = "SELECT CLS_ID FROM students WHERE STU_NAME = '$stu_name' ";

  		$cls_id = $db -> query_array($sql);

  		if(empty($cls_id))
  		{
  			$data = array();
  			echo json_encode($data);
  			exit;
  		}

  		$cls_id_st = $cls_id["CLS_ID"][0];

  		$cls_id_3 = substr($cls_id_st, 1, 3);

  		$sql2 = "SELECT DEPT_FULL_NAME FROM stfdept WHERE DEPT_NO = '$cls_id_3' ";

  		$data = $db -> query_array($sql2);

  		$datalist = array();

  		$datalist["CLS_ID"][0] = $cls_id_3;
  		$datalist["DEPT_FULL_NAME"][0] = $data["DEPT_FULL_NAME"][0];

  		echo json_encode($datalist);
  		exit;
  	}
	else if($_POST['oper'] == "create")
	{
		$stu_name = $_POST["stu_name"];
		$letter_no = $_POST["letter_no"];
		$dept_name = $_POST["dept_name"];
		$dept_code = $_POST["dept_code"];
		$room_code = $_POST["room_code"];
		$comment = $_POST["comment"];
		$receive_date = $_POST["receive_date"];

		$receive_date_sec = explode("/",$receive_date);

		$receive_year = (int)($receive_date_sec[0])-1911;
		$receive_month = (int)($receive_date_sec[1]);
		$receive_day = (int)($receive_date_sec[2]);


		if(strlen($receive_month)<2)
			$receive_month='0'.$receive_month;
		if(strlen($receive_day)<2)
			$receive_day='0'.$receive_day;

	 	$receive_date =$receive_year.$receive_month.$receive_day;


	  	$SQLStr = "INSERT INTO letter (NAME,LETTER_NO,RECEIVE_DATE,TAKE_DATE,DEPT_CODE,MARK,ROOM_CODE) values ('$stu_name','$letter_no','$receive_date','^^^^^^','$dept_code','$comment','$room_code')";

      	$result = $db -> query_trsac($SQLStr);

		if($result)//失敗需rollback
		{
			if( !empty($result["message"]) )
			{
			   echo json_encode($result);
			   exit;
			}
			else
			{
				$db -> end_trsac();
				echo json_encode("建檔成功");
				exit;
			}
		}

	}
	else if($_POST['oper'] == "update")
	{
		$stu_name = $_POST["stu_name"];
		$letter_no = $_POST["letter_no"];
		$dept_name = $_POST["dept_name"];
		$dept_code = $_POST["dept_code"];
		$room_code = $_POST["room_code"];
		$comment = $_POST["comment"];
		$receive_date = $_POST["receive_date"];

		$origin_stu_name = $_POST["origin_stu_name"];
		$origin_letter_no = $_POST["origin_letter_no"];
		$origin_dept_name = $_POST["origin_dept_name"];
		$origin_dept_code = $_POST["origin_dept_code"];
		$origin_room_code = $_POST["origin_room_code"];
		$origin_comment = $_POST["origin_comment"];
		$origin_receive_date = $_POST["origin_receive_date"];

		$receive_date_sec = explode("/",$receive_date);

		$receive_year = (int)($receive_date_sec[0])-1911;
		$receive_month = (int)($receive_date_sec[1]);
		$receive_day = (int)($receive_date_sec[2]);


		if(strlen($receive_month)<2)
			$receive_month='0'.$receive_month;
		if(strlen($receive_day)<2)
			$receive_day='0'.$receive_day;

	 	$receive_date =$receive_year.$receive_month.$receive_day;

	  	if($origin_comment != "")
	  	{
	  		$update = "UPDATE letter SET NAME = '$stu_name', LETTER_NO = '$letter_no', RECEIVE_DATE = '$receive_date', TAKE_DATE = '^^^^^^', DEPT_CODE = '$dept_code', MARK = '$comment', ROOM_CODE = '$room_code' WHERE NAME = '$origin_stu_name' AND LETTER_NO = '$origin_letter_no'  AND RECEIVE_DATE = '$origin_receive_date' AND DEPT_CODE = '$origin_dept_code'  AND MARK = '$origin_comment'  AND ROOM_CODE = '$origin_room_code' ";
	  	}
	  	else
	  	{
	  		$update = "UPDATE letter SET NAME = '$stu_name', LETTER_NO = '$letter_no', RECEIVE_DATE = '$receive_date', TAKE_DATE = '^^^^^^', DEPT_CODE = '$dept_code', MARK = '$comment', ROOM_CODE = '$room_code' WHERE NAME = '$origin_stu_name' AND LETTER_NO = '$origin_letter_no'  AND RECEIVE_DATE = '$origin_receive_date' AND DEPT_CODE = '$origin_dept_code'  AND MARK is NULL  AND ROOM_CODE = '$origin_room_code' ";
	  	}


      	$result = $db -> query_trsac($update);

      	if($result)//失敗需rollback
      	{
      	   if( !empty($result["message"]) )
      	   {

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
	else if($_POST["oper"] == "delete")
	{

		$stu_name = $_POST["stu_name"];
		$letter_no = (string)$_POST["letter_no"];
		$dept_name = $_POST["dept_name"];
		$dept_code = $_POST["dept_code"];
		$room_code = $_POST["room_code"];
		$comment = $_POST["comment"];
		$receive_date = $_POST["receive_date"];

		if($comment != "")
		{
			$delete = "DELETE FROM letter WHERE NAME = '$stu_name' AND LETTER_NO = '$letter_no' AND RECEIVE_DATE = '$receive_date' AND TAKE_DATE = '^^^^^^' AND DEPT_CODE = '$dept_code' AND MARK = '$comment' AND ROOM_CODE = '$room_code' ";
		}
		else
		{
			$delete = "DELETE FROM letter WHERE NAME = '$stu_name' AND LETTER_NO = '$letter_no' AND RECEIVE_DATE = '$receive_date' AND TAKE_DATE = '^^^^^^' AND DEPT_CODE = '$dept_code' AND MARK is NULL  AND ROOM_CODE = '$room_code' ";
		}


		$result = $db -> query($delete);

		if( !empty($result["message"]) )
			$data = "資料刪除有問題。";
		else
		    $data = "資料刪除完畢";

		echo json_encode($data);
		exit;

	}


?>
