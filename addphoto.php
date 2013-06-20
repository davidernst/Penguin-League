<?php session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';

$securimage = new Securimage();

if ($securimage->check($_POST['captcha_code']) == false) {
  // the code was incorrect
  // you should handle the error so that the form processor doesn't continue

  // or you can use the following code if there is no validation or you do not know how
  echo "The security code entered was incorrect.<br /><br />";
  echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
  exit;
}

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");
/*
while (strpos($add_player,"0") == "0")
{
	$player_length = strlen($add_player)-1;
	$add_player = substr($add_player, 1, $player_length);
}
*/

$add_player = 0 + $add_player;

$result = mysql_query ("INSERT INTO photo SET cbs_id='".$add_player."', reason='".$explain."'");

mysql_close($conn);

echo "<script language='javascript'>\n";
// echo "<!-\n";
echo "location.replace('index.shtml')\n";
// echo "-->\n";
echo "</script>";

?>