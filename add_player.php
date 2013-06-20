<html>
<head>
<title>Success!</title>
</head>
<body bgcolor="#FFFFFF">
<?php

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

//need to check for players availability, if they're in the baseline stats, etc.

$player_id = SUBSTR($player,0,8);
$player_team = SUBSTR($player,9,3);

if (($position=="P") OR ($position=="SP") OR ($position=="RP"))
{
	$result2 = mysql_query ("SELECT id, team, name, full_name, status, pos FROM dick_league_pitchers WHERE id = ".$player_id);
} else {
	$result2 = mysql_query ("SELECT id, team, name, full_name, status, pos FROM dick_league_players WHERE id = ".$player_id);
}

	$id = mysql_result($result2, 0, "id");
	$team = mysql_result($result2, 0, "team");
	$name = mysql_result($result2, 0, "name");
	$full_name = mysql_result($result2, 0, "full_name");
	$status = mysql_result($result2, 0, "status");
	$pos = mysql_result($result2, 0, "pos");

if (($position=="P") OR ($position=="SP") OR ($position=="RP"))
{
	mysql_query ("INSERT INTO pitcher_rosters VALUES ('$player_id', '$dick_team', '0', '$pos', '$player_team', 0)");
} else {
	mysql_query ("INSERT INTO player_rosters VALUES ('$player_id', '$dick_team', '0', '$pos', '$player_team', 0)");
}
mysql_close ($conn);

echo "Player ".$player." has been added to team ".$dick_team."\n";

echo "<script language='javascript'>\n";
// echo "<!-\n";
echo "location.replace('edit_team.php?whichteam=".$dick_team."')\n";
// echo "-->\n";
echo "</script>";

?>
</body>
</html>
