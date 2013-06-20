<HTML>
<HEAD>
<TITLE>Control Panel</TITLE>
</HEAD>
<BODY BGCOLOR="#FFFFFF">
<FORM ACTION="change_position_pitcher2.php" METHOD=GET>

<?PHP

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$player_id = SUBSTR($player,0,8);

$result = mysql_query ("SELECT id, team, name, pitcher_rosters.position FROM dick_league_pitchers,pitcher_rosters WHERE pitcher_rosters.team_id = ".$dick_team." AND pitcher_rosters.player_id = dick_league_pitchers.id AND pitcher_rosters.player_id = '$player_id'");

$name = mysql_result($result, 0, 'name');
$team = mysql_result($result, 0, 'team');
$pos = mysql_result($result, 0, 'pitcher_rosters.position');

echo $team." ".$name." from ".$pos." to ";
$the_player = mysql_query ("SELECT name, team, pos FROM dick_league_pitchers WHERE id = '$player_id'");

echo "<SELECT NAME='position'>";

echo "<OPTION>SP";
echo "<OPTION>RP";

echo "</SELECT><P>";
echo "<INPUT TYPE='hidden' NAME='playerid' VALUE='$player_id'><BR>";
echo "<INPUT TYPE='hidden' NAME='dickteam' VALUE='$dick_team'><BR>";
echo "<INPUT TYPE='submit' VALUE='Change'>";

mysql_close($conn);

?>
</FORM>
</BODY>
</HTML>
