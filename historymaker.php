<?PHP

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$result = mysql_query ("SELECT team_id, team_name FROM teams");

$theurl = "http://penguin.sharespot.org";

	$fp = fopen($theurl, "r");
	
	//$player = fread($fp, 200000);
	while(!feof($fp))
	{
		$output = fgets($fp, 200000);
		$player = $player.$output;
	}
	
	fclose($fp);

$player = str_replace("images/penguinsmall.jpg", "../images/penguinsmall.jpg", $player);

for ($x=1; $x <= mysql_num_rows($result); $x++)
{
		$y="'".$x.".html'";
		$player = str_replace("'teamdetail.php?dick_team=".$x."'", $y, $player);
}
	
$myFile = "/home/sharespo/www/penguin/results/".$period."/index.html";
$fh = fopen($myFile, 'w') or die("can't open file");

fwrite($fh, $player);

fclose($fh);


for ($x=1; $x <= mysql_num_rows($result); $x++)
{
	$player = "";
	
	$theurl = "http://penguin.sharespot.org/teamdetail.php?dick_team=".$x;
	$fp = fopen($theurl, "r");
	
	while(!feof($fp))
	{
		$output = fgets($fp, 200000);
		$player = $player.$output;
	}
	
	fclose($fp);

$myFile = "results/".$period."/".$x.".html";
$fh = fopen($myFile, 'w') or die("can't open file");

fwrite($fh, $player);

fclose($fh);
}


echo "<script language='javascript'>\n";
echo "location.replace('changeperiods.php')\n";
echo "</script>";

	
?>