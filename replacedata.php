<?PHP

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

while (strlen($cbsplayerid) < 8 )
{
	$cbsplayerid = "0".$cbsplayerid;
}

$result = mysql_query ("SELECT full_name FROM dick_league_players WHERE id =".$cbsplayerid);

$full_name = mysql_result($result, 0, 'full_name');

$result2 = mysql_query ("DELETE FROM dick_league_players WHERE id =".$cbsplayerid);

$URLbase="http://bigleaguers.yahoo.com/mlbpa/players/";
$URL=$URLbase.$yahooplayerid;

$fp = fopen($URL, "r");
//$player = fread($fp, 200000);

do {
	$theline = fgets($fp, 1024);
} while (strstr($theline, "2004</td>") == FALSE);

//$fp = readfile($URL);

for ($x=0; $x < 18; $x++)
{
	$theline = fgets($fp, 1024);
	$ex1 = explode(">", $theline);
	$ex2 = explode("<", $ex1[1]);
	$ex3[$x] = $ex2[0];
	echo $ex3[$x]."<P>";
}

/*
$ex1 = explode("2004</td>", $player);
echo $ex1[1]."<p>";
$ex2 = explode("ysprow2", $ex1[1]);
echo $ex2[0]."<p>";
$ex3 = explode("</td>", $ex2[0]);
*/

$p_id = $cbsplayerid;
$p_team = $ex3[0];
$p_full_name = $full_name;
$p_avg = $ex3[13];
$p_bat = $ex3[2];
$p_hit = $ex3[4];
$p_dble = $ex3[5];
$p_triple = $ex3[6];
$p_homer = $ex3[7];
$p_walk = $ex3[9];
$p_steal = $ex3[11];
$p_caught = $ex3[12];
$p_run = $ex3[3];
$p_rbi = $ex3[8];
$p_so = $ex3[10];
$p_games = $ex3[1];
$p_slugging = $ex3[15];
$p_on_base = $ex3[14];

$populate = mysql_query ("INSERT INTO dick_league_players (id, team, full_name, avg, bat, hit, dble, triple, homer, walk, steal, caught, run, rbi, so, games, slugging, on_base) VALUES('$p_id', '$p_team', '$p_full_name', '$p_avg', '$p_bat', '$p_hit', '$p_dble', '$p_triple', '$p_homer', '$p_walk', '$p_steal', '$p_caught', '$p_run', '$p_rbi', '$p_so', '$p_games', '$p_slugging', '$p_on_base')");
/*
echo "Done!";
echo "<script language='javascript'>\n";
// echo "<!-\n";
echo "location.replace('control.php')\n";
// echo "-->\n";
echo "</script>";
*/

?>