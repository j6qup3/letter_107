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
  $pdf->SetMargins(5,5);  //設定邊界(需在第一頁建立以前)
  $pdf->AddPage(); // 新的一頁
  $pdf->AddUniCNShwFont('font1','DFKaiShu-SB-Estd-BF');
  $pdf->SetFont('font1', 'B', 18);

  $pdf->SetFontSize(16);
  // Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, int fill [, mixed link]]]]]]])
  $pdf->Cell(0, 10, $title, 0, 1, 'C');
  $pdf->SetFontSize(10);
  $pdf->Cell(25, 10); // 左邊留白
  $pdf->Cell(10, 10, "編號", 1, 0, 'C');
  $pdf->Cell(30, 10, "系所", 1, 0, 'C');
  $pdf->Cell(20, 10, "姓名", 1, 0, "C");
  $pdf->Cell(20, 10, "信件號碼", 1, 0, "C");
  $pdf->Cell(25, 10, "收件日期", 1, 0, "C");
  $pdf->Cell(20, 10, "收件校區", 1, 0, "C");
  $pdf->Cell(25, 10, "簽名", 1, 1, "C");

  // 存上方資料欄位名的寬度
  $arr_width = [25, 10, 30, 20, 20, 25, 20, 25];
  $w_i = 0;
  for($i = 0; $i < count($row['NAME']); ++$i){
    $name = $row['NAME'][$i];
    $letter_no = $row['LETTER_NO'][$i];
    $receive_date = $row['RECEIVE_DATE'][$i];
    $room_code = $row['ROOM_CODE'][$i];
    $dept_code = $row['DEPT_CODE'][$i];
    $dept_name = @$dept_noToName[$dept_code];

    if ($room_code == 1)
      $room_code = "進德";
    elseif ($room_code == 2) {
      $room_code = "寶山";
    }
    if (mb_strlen($dept_name, "UTF-8") >= 8) $height = 20;
    else $height = 10;

    // 左邊留白
    $pdf->Cell($arr_width[$w_i++], $height);
    // 資料編號
    $pdf->Cell($arr_width[$w_i++], $height, $i + 1, 1, 0, "C");

    if ($height == 20)
      multiCell($arr_width[$w_i++], $height, $dept_name, 0, 0, "C"); //當字串長度太長時,切成兩行顯示
    else
      $pdf->Cell($arr_width[$w_i++], $height, $dept_name, 1, 0, "C");
    $pdf->Cell($arr_width[$w_i++], $height, $name, 1, 0, "C");
    $pdf->Cell($arr_width[$w_i++], $height, $letter_no, 1, 0, "C");

    $pdf->Cell($arr_width[$w_i++], $height, $receive_date, 1, 0, "C");
    $pdf->Cell($arr_width[$w_i++], $height, $room_code, 1, 0, "C");
    $pdf->Cell($arr_width[$w_i++], $height, "", 1, 0, "C");
    $pdf->Cell(1, $height, "", "L", 1, "C");
    $w_i = 0;

    // 若到了最後一項，沒剛好滿一頁，也得加頁碼
    if (($i + 1) == count($row['NAME']) && ($i + 1) % 20 != 0){
      $pdf->SetY(266); // 設定頁碼位置
      $pdf->Cell(0, 10, $pdf->PageNo(), 0, 0, 'C'); //頁碼
    }
    // 設定20項一頁，否則自動換頁最後一項系所太長，下格線會跑掉
    elseif (($i + 1) % 20 == 0){
      $pdf->SetY(266); // 設定頁碼位置
      $pdf->Cell(0, 10, $pdf->PageNo(), 0, 0, 'C'); //頁碼
      $pdf->AddPage(); // 新的一頁
    }
  }
  $pdf->Ln();
  $pdf->Output();

  // 當字串長度太長時，切成兩行顯示
  function multiCell($width, $height, $text, $border, $ln, $align){
    global $pdf;
    $len = mb_strlen($text, "UTF-8");
    $text1 = mb_substr($text, 0, $len / 2, "UTF-8"); //第一行
    $text2 = mb_substr($text, $len / 2, $len, "UTF-8"); //第二行
    $CurrentX = $pdf->GetX();
    $CurrentY = $pdf->GetY() ;
    $pdf->SetXY($CurrentX, $CurrentY);
    $pdf->Cell($width, $height / 2, $text1, "T", $ln, $align);
    $pdf->SetXY($CurrentX, $CurrentY + 6);
    $pdf->Cell($width, $height / 2, $text2, 0, $ln, $align);
    $pdf->SetXY($CurrentX + $width, $CurrentY);
  }
?>
