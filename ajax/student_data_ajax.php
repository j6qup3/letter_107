<?php
    session_start();
    include '../inc/connect.php';
    if ($_POST['oper']=="qry_dpt")
    {
        $sql2 = "select min(dept_no) dept_no,min(dept_full_name) dept_full_name
            from stfdept
            where use_flag is null
            group by substr(dept_no,1,2)";


        $data = $db -> query_array($sql2);

        echo json_encode($data);
        exit;
    }
    if ($_POST['oper']==0)
    {
      
        $stu_id=$_POST["stu_id"];
        $stu_name=$_POST["stu_name"];
        $stu_ename=$_POST["stu_ename"];
        $cls_id=$_POST["cls_id"];
        $email=$_POST["email"];
        $sql = "SELECT stu_id,stu_name,stu_ename,cls_id,stu_email
                FROM students
                WHERE stu_id='$stu_id'
                OR stu_name='$stu_name'
                OR stu_ename='$stu_ename'
                OR stu_email='$email'";


        $row = $db -> query_array($sql);
        $a['data'] = "";
        for($i = 0; $i < count($row['STU_ID']); ++$i){
          $id_tmp=$row['STU_ID'][$i];
          $name_tmp=$row['STU_NAME'][$i];
          $ename_tmp=$row['STU_ENAME'][$i];
          $cls_tmp=$row['CLS_ID'][$i];
          $email_tmp=$row['STU_EMAIL'][$i];
          $a['data'][] = array(
            $id_tmp,
            $name_tmp,
            $ename_tmp,
            $cls_tmp,
            $email_tmp
          );
        }
        echo json_encode($a);
        exit;
    }
?>
