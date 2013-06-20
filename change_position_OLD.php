<HTML>
<HEAD>
<TITLE>Control Panel</TITLE>
</HEAD>
<BODY BGCOLOR="#FFFFFF">
<FORM ACTION="change_position2.php" METHOD=GET>

<?PHP

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$player_id = SUBSTR($player,0,8);

$result = mysql_query ("SELECT id, team, name, player_rosters.position FROM dick_league_players,player_rosters WHERE player_rosters.team_id = ".$dick_team." AND player_rosters.player_id = dick_league_players.id AND player_rosters.player_id = '$player_id'");

$name = mysql_result($result, 0, 'name');
$team = mysql_result($result, 0, 'team');
$pos = mysql_result($result, 0, 'player_rosters.position');

echo $team." ".$name." from ".$pos." to ";
$the_player = mysql_query ("SELECT name, team, pos FROM dick_league_players WHERE id = '$player_id'");

$all_positions = mysql_query ("SELECT * FROM positions ORDER BY number");
echo "<SELECT NAME='position'>";

for ($p=0; $p < (mysql_num_rows($all_positions)-2); $p++)
{
	echo "<OPTION>";
	echo mysql_result($all_positions, $p, 'position');
}
echo "</SELECT><P>";
echo "<INPUT TYPE='hidden' NAME='playerid' VALUE='$player_id'><BR>";
echo "<INPUT TYPE='hidden' NAME='dickteam' VALUE='$dick_team'><BR>";
echo "<INPUT TYPE='submit' VALUE='Change'>";

mysql_close($conn);

?>
</FORM>
</BODY>
</HTML>
