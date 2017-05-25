<?php
  session_start();
  include_once("../inc/connect.php");
  define('FPDF_FONTPATH',"./font");
  require('chinese-unicode.php');

  $title = "未領郵件清冊";
  $sql = "SELECT dept_no, dept_full_name
          FROM stfdept
          WHERE use_flag IS NULL";
	$data = $db -> query_array($sql);

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

  $sql = "SELECT name, letter_no, receive_date, take_date, room_code, dept_code
        FROM letter
        WHERE take_date = '^^^^^^'";
  $row = $db -> query_array($sql);

  $pdf = new PDF_Unicode();
  //$pdf->SetMargins(5,5);  //設定邊界(需在第一頁建立以前)
  $pdf->AddPage();
  $pdf->AddUniCNShwFont('font1','DFKaiShu-SB-Estd-BF');
  $pdf->SetFont('font1', 'B', 18);

  $pdf->SetFontSize(16);
  $pdf->Cell(0,10,$title,0,1,'C');
  $pdf->SetFontSize(10);
  $pdf->Cell(50,10);
  $pdf->Cell(0 , 10, "系所",0,1,'C');
  $pdf->Cell(10, 10, "姓名",1,0,"C");
  $pdf->Cell(40, 10, "信件號碼",1,0,"C");
  $pdf->Cell(20, 10, "收件日期",1,0,"C");
  $pdf->Cell(20, 10, "收件校區",1,0,"C");
  $pdf->Cell(30, 10, "簽名",1,0,"C");

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

    if (strlen(@$dept_noToName[$dept_code])>30 || strlen($name)>30) $height = 20;
    else $height = 10;

    $pdf->Cell(10,$height,$i+1,1,0,"C");

    $pdf->Cell(20,$height,@$dept_noToName[$dept_code],1,0,"C");
    $pdf->Cell(20,$height,$name,1,0,"C");
    if ($height==20)
    	multiCell(30,$height,$letter_no,0,0,"C"); //當字串長度太長時,切成兩行顯示
    else
    	$pdf->Cell(30,$height,$letter_no,1,0,"C");

    $pdf->Cell(10,$height,$receive_date,1,0,"C");
    $pdf->Cell(15,$height,$room_code,1,0,"C");
    $pdf->Cell(1,$height,"","L",1,"C");
    // $a['data'][] = array(
    //   "" . $dept_code . @$dept_noToName[$dept_code],
    //   $name,
    //   $letter_no,
    //   $receive_date,
    //   $room_code,
    //   ""
    // );
  }
  $pdf->Ln();
  $pdf->Output();

  //當字串長度太長時,切成兩行顯示
  function multiCell($width,$height,$text,$border,$ln,$align){
    global $pdf;
    $text1=mb_substr($text,0,9,"UTF-8"); //第一行
    $text2=mb_substr($text,9,10,"UTF-8"); //第二行
    $CurrentX = $pdf->GetX();
    $CurrentY = $pdf->GetY() ;
    $pdf->SetXY($CurrentX,$CurrentY);
    $pdf->Cell($width,$height/2,$text1,"T",$ln,$align);
    $pdf->SetXY($CurrentX,$CurrentY+6);
    $pdf->Cell($width,$height/2,$text2,0,$ln,$align);
    $pdf->SetXY($CurrentX+$width,$CurrentY);
  }
?>
