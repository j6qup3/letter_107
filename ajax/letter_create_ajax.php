<?php
	session_start();
  	include '../inc/connect.php';

  	$empl_no = $_SESSION['empl_no'];
  	$empl_name = $_SESSION['empl_name'];

  	if($_POST["oper"] == "query")
  	{

  		$SQLStr = " SELECT * FROM letter";

  		$row = $db -> query_array($SQLStr);

  		$a['data']="";

  		for($i = 0; $i < count($row['NAME']) ; $i++)
  		{

  			if($row['ROOM_CODE'][$i] == 1)
  				$room_code = "進德";
  			else if ($row['ROOM_CODE'][$i] == 2)
  				$room_code = "寶山";

  		    $a['data'][] = array(
  		        $row['NAME'][$i],
  		        $row['LETTER_NO'][$i],
  		        $row['RECEIVE_DATE'][$i],
  		        $row['TAKE_DATE'][$i],
  		        $row['TAKE_CODE'][$i],
  		        $row['DEPT_CODE'][$i],
  		        $room_code,
  		        $row['AGENT'][$i],
  		        $row['MARK'][$i]
  		    );

  		}
  		echo json_encode($a);

  	}

  	else if($_POST['oper'] == "dept_fill")
  	{
  		$stu_name = $_POST["stu_name"];

  		$sql = "SELECT CLS_ID FROM students WHERE STU_NAME = '$stu_name' ";

  		// echo $sql;
  		// exit;

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
  		//echo substr($cls_id_st, 1, 3);
  		// echo $sql2;
  		// exit;

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
