<HTML>
<HEAD>
<TITLE>Edit Team</TITLE>
</HEAD>
<BODY BGCOLOR="#FFFFFF">
<?PHP

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$dick_team = $whichteam;
$all_positions = mysql_query ("SELECT * FROM positions ORDER BY number");

echo "<FORM ACTION='control.php' METHOD=GET>";
echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE='".$dick_team."'>";
echo "<INPUT TYPE='submit' VALUE='Done'>";
echo "<font size=4>Team ".$dick_team." Roster</font>";
echo "</FORM>";
echo "<HR>";

// Fixes duplicates where player played on two teams in one season

$result = mysql_query ("SELECT id, team, full_name, player_rosters.position FROM dick_league_players, player_rosters WHERE player_rosters.team_id = ".$dick_team." AND player_rosters.player_id = dick_league_players.id AND dick_league_players.team = player_rosters.mlb_team ORDER BY player_rosters.position");


echo "<table border=0 cellpadding=0 cellspacing=0><tr valign='top'><td>";
echo "<table border=0 cellpadding=0 cellspacing=0>";
$bgcolor="#eeeeee";
for ($x=0; $x < mysql_num_rows($result); $x++)
{
	echo "<tr valign='top' bgcolor='".$bgcolor."'><td>".mysql_result($result, $x, 'full_name')."</td>";
	echo "<td>".mysql_result($result, $x, "team")."</td>";
	echo "<td><FORM action='change_position.php' style='margin-bottom:0;'><SELECT name='position' onchange='this.form.submit()'><OPTION SELECTED>?";
	for ($p=0; $p < (mysql_num_rows($all_positions)-2); $p++)
	{
		if (mysql_result($result, $x, 'player_rosters.position') == mysql_result($all_positions, $p, 'position')) {
			$selected = " SELECTED";
		} else {
			$selected = "";
		}
		echo "<OPTION".$selected.">";
		echo mysql_result($all_positions, $p, 'position');
	}
	echo "</SELECT>";	
	echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team.">";
	echo "<INPUT TYPE='hidden' NAME='playerid' VALUE='".mysql_result($result, $x, "id")."'>";
	echo "<td><noscript><input type='submit' value='Submit'></noscript></form></td>";
	echo "<td><a href='remove_player.php?player=".mysql_result($result, $x, "id")."&team=".$dick_team."'>Remove</a></td></tr>\n";
	$bgcolor = ($bgcolor == "#eeeeee" ? "#ffffff" : "#eeeeee");
}
echo "</table>";
echo "</td><td>.</td><td>";

// PITCHERS - 4/1/08

// Fixes duplicates where player played on two teams in one season

$result = mysql_query ("SELECT id, team, full_name, pitcher_rosters.position FROM dick_league_pitchers, pitcher_rosters WHERE pitcher_rosters.team_id = ".$dick_team." AND pitcher_rosters.player_id = dick_league_pitchers.id AND dick_league_pitchers.team = pitcher_rosters.mlb_team ORDER BY pitcher_rosters.position");

//echo "<table border=0 cellpadding=0 cellspacing=0><tr><td>";
echo "<table border=0 cellpadding=0 cellspacing=0>";
$bgcolor="#eeeeee";
for ($x=0; $x < mysql_num_rows($result); $x++)
{
	echo "<tr valign='top' bgcolor='".$bgcolor."'><td>".mysql_result($result, $x, 'full_name')."</td>";
	echo "<td>".mysql_result($result, $x, "team")."</td>";
	echo "<td><FORM action='change_position_pitcher.php' style='margin-bottom:0;'><SELECT name='position' onchange='this.form.submit()'><OPTION SELECTED>?";
	for ($p=(mysql_num_rows($all_positions)-2); $p < (mysql_num_rows($all_positions)); $p++)
	{
		if (mysql_result($result, $x, 'pitcher_rosters.position') == mysql_result($all_positions, $p, 'position')) {
			$selected = " SELECTED";
		} else {
			$selected = "";
		}
		echo "<OPTION".$selected.">";
		echo mysql_result($all_positions, $p, 'position');
	}
	echo "</SELECT>";	
	echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team.">";
	echo "<INPUT TYPE='hidden' NAME='playerid' VALUE='".mysql_result($result, $x, "id")."'>";
	echo "<td><noscript><input type='submit' value='Submit'></noscript></form></td>";
	echo "<td><a href='remove_pitcher.php?player=".mysql_result($result, $x, "id")."&team=".$dick_team."'>Remove</a></td></tr>\n";
	$bgcolor = ($bgcolor == "#eeeeee" ? "#ffffff" : "#eeeeee");
}
echo "</table></td></tr>";









/*
echo "</TD><TD VALIGN='top'><font size=4>Search by Team/Position:</font>";

echo "<FORM ACTION='get_players.php' METHOD=GET>";
echo "<INPUT TYPE='hidden' NAME='whichteam' VALUE=".$dick_team.">";
$result = mysql_query ("SELECT DISTINCT team FROM dick_league_players ORDER BY team");
echo "<TABLE><TR><TD>";
echo "MLB Team:</TD><TD><SELECT NAME='team'>";
for ($x=0; $x < mysql_num_rows($result); $x++)
{
echo "<OPTION>";
echo mysql_result($result, $x, "team");
}

echo "</SELECT></TD>";

echo "</TR><TR><TD>Position:</TD><TD><SELECT NAME='position'>";

$result = mysql_query ("SELECT DISTINCT pos FROM dick_league_players ORDER BY pos");

for ($x=0; $x < mysql_num_rows($result); $x++)
{
echo "<OPTION>";
echo mysql_result($result, $x, "pos");
}
$result = mysql_query ("SELECT DISTINCT pos FROM dick_league_pitchers ORDER BY pos");

for ($x=0; $x < mysql_num_rows($result); $x++)
{
echo "<OPTION>";
echo mysql_result($result, $x, "pos");
}
echo "</SELECT></TD></TR><TR><TD></TD><TD><INPUT TYPE='submit' VALUE='Search'></TD></TR></TABLE>";

echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team.">";

echo "</FORM>";
echo "</TD></TR></TABLE>";
*/
// NEW STUFF =======================

echo "<TR><TD colspan='3'>";
echo "<TABLE><TR valign='top'><TD><FORM  id='myform' name='myform' ACTION='by_name.php' METHOD='GET'>Add Player: <input id='search' name='searchtext' size='20' />";
echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team."></TD><TD><input type='submit' id='cmdSearch' name='cmdSearch' value='Search' alt='Run Search' /></FORM>";
?>
<script type="text/javascript">
document.myform.searchtext.focus();
</script>

<?php

echo "</TD></TR>";

echo "<TR valign='top'><TD><FORM ACTION='by_name_pitch.php' METHOD='GET'>Add Pitcher:<INPUT TYPE='text' NAME='searchtext'>";
echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team."></TD><TD><INPUT TYPE='submit' VALUE='Search'></FORM></TD></TR></TABLE>";

echo "</TD></TR></TABLE>";
echo "</TD></TR></TABLE>";

?>

</BODY>
</HTML>




