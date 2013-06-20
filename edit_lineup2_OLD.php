<HTML>
<HEAD>

<TITLE>Control Panel</TITLE>

</HEAD>
<BODY BGCOLOR="#FFFFFF">

<?PHP
$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

//$result = mysql_query ("SELECT id, player_rosters.active FROM dick_league_players,player_rosters WHERE player_rosters.team_id = ".$dick_team." AND player_rosters.player_id = dick_league_players.id ORDER BY id");

$result = mysql_query ("SELECT id, player_rosters.active, player_rosters.position FROM dick_league_players, player_rosters WHERE player_rosters.team_id = ".$dick_team." AND player_rosters.player_id = dick_league_players.id AND dick_league_players.team = player_rosters.mlb_team ORDER BY team");


for ($x=0; $x < mysql_num_rows($result); $x++)
{
	IF ($c[$x] != "") {
		$active = "1";
	} ELSE {
		$active = "0";
	}

	mysql_query ("UPDATE player_rosters SET active = ".$active." WHERE player_id = ".mysql_result($result, $x, "id"));
}

//$result2 = mysql_query ("SELECT id, pitcher_rosters.active FROM dick_league_pitchers,pitcher_rosters WHERE pitcher_rosters.team_id = ".$dick_team." AND pitcher_rosters.player_id = dick_league_pitchers.id ORDER BY id");

$result2 = mysql_query ("SELECT id, pitcher_rosters.active, pitcher_rosters.position FROM dick_league_pitchers, pitcher_rosters WHERE pitcher_rosters.team_id = ".$dick_team." AND pitcher_rosters.player_id = dick_league_pitchers.id AND dick_league_pitchers.team = pitcher_rosters.mlb_team ORDER BY team");


for ($x=0; $x < mysql_num_rows($result2); $x++)
{
	IF ($d[$x] != "") {
		$active = "1";
	} ELSE {
		$active = "0";
	}
	
	mysql_query ("UPDATE pitcher_rosters SET active = ".$active." WHERE player_id = ".mysql_result($result2, $x, "id"));
}

mysql_close ($conn);

echo "<script language='javascript'>\n";
// echo "<!-\n";
echo "location.replace('control.php')\n";
// echo "-->\n";
echo "</script>";
?>

</BODY>
</HTML>
