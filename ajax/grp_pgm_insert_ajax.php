<?
include '../inc/connect.php';

if (isset($_POST['grp']) && isset($_POST['pgm']))
{
  $grp = $_POST['grp'];
  $pgm = $_POST['pgm'];

  $sql = "INSERT INTO SYSGRPPGM (GRPID,SYSID,PGMID) (SELECT '$grp','LETTER',PGMID FROM SYSPGM WHERE SYSID='LETTER' AND PGMID LIKE '$pgm%')";
  echo $sql."\r\n";
  $db -> query_array ($sql);
}
