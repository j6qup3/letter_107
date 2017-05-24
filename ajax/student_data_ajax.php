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
        //echo $dept_noToName[$dept_no].$dept_no.'<br>';
        ++$i;
      }

        $stu_id=$_POST["stu_id"];
        $stu_name=$_POST["stu_name"];
        $stu_ename=$_POST["stu_ename"];
        $cls_id=$_POST["cls_id"];
        $email=$_POST["email"];
        $sql = "SELECT stu_id,stu_name,stu_ename,cls_id,stu_email
                FROM students
                WHERE 1=1 ";
        if($stu_id!="")
        {
          $sql=$sql." AND stu_id='$stu_id'";
        }
        if($stu_name!="")
        {
          $sql=$sql." AND stu_name='$stu_name'";
        }
        if($stu_ename!="")
        {
          $sql=$sql." AND stu_ename='$stu_ename'";
        }
        if($cls_id!="")
        {
          $sql=$sql." AND substr(cls_id,2,3)='$cls_id'";
        }
        if($email!="")
        {
          $sql=$sql." AND stu_email='$email'";
        }
        //echo $sql;

        $row = $db -> query_array($sql);
        $a['data'] = "";
        for($i = 0; $i < count($row['STU_ID']); ++$i){
          $id_tmp=$row['STU_ID'][$i];
          $name_tmp=$row['STU_NAME'][$i];
          $ename_tmp=$row['STU_ENAME'][$i];
          $cls_tmp=$dept_noToName[substr($row['CLS_ID'][$i],1,3)];
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
