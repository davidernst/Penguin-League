<HTML>
<HEAD>
<TITLE>Control Panel</TITLE>

</HEAD>
<BODY BGCOLOR="#FFFFFF">
<?PHP

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

//$dick_team = CHOP(SUBSTR($whichteam,0,2));
$dick_team = $whichteam;

echo "<FORM ACTION='control.php' METHOD=GET>";
echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team.">";
echo "<INPUT TYPE='submit' VALUE='Done'>";
echo "<font size=4>Team ".$dick_team." Roster</font>";
echo "</FORM>";
echo "<HR>";

echo "<TABLE BGCOLOR='#FFFFCC'><TR><TD ALIGN='center' ROWSPAN=2><font size=4>Players:</font>";
echo "<FORM ACTION='remove_player.php' METHOD=GET>";
echo "<SELECT NAME='player' SIZE=15>";
//$result = mysql_query ("SELECT id, team, full_name FROM dick_league_players, player_rosters WHERE player_rosters.team_id = ".$dick_team." AND player_rosters.player_id = dick_league_players.id ORDER BY team");

// Fixes duplicates where player played on two teams in one season
$result = mysql_query ("SELECT id, team, full_name FROM dick_league_players, player_rosters WHERE player_rosters.team_id = ".$dick_team." AND player_rosters.player_id = dick_league_players.id AND dick_league_players.team = player_rosters.mlb_team ORDER BY team");

for ($x=0; $x < mysql_num_rows($result); $x++)
{
	echo "<OPTION>";
	echo mysql_result($result, $x, "id")." ".mysql_result($result, $x, "team")." ".mysql_result($result, $x, "full_name")." "."\n";
}
echo "</SELECT>";
echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team."><BR>";
echo "<INPUT TYPE='submit' VALUE='Remove Player'>";
echo "</FORM>";

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
echo "</TD>";

// NEW STUFF =======================

echo "<TD ALIGN='center' ROWSPAN=2><font size=4>Pitchers:</font>";
echo "<FORM ACTION='remove_pitcher.php' METHOD=GET>";
echo "<SELECT NAME='pitcher' SIZE=15>";
$result = mysql_query ("SELECT id, team, full_name FROM dick_league_pitchers, pitcher_rosters WHERE pitcher_rosters.team_id = ".$dick_team." AND pitcher_rosters.player_id = dick_league_pitchers.id AND dick_league_pitchers.team = pitcher_rosters.mlb_team ORDER BY team");

for ($x=0; $x < mysql_num_rows($result); $x++)
{
echo "<OPTION>";
echo mysql_result($result, $x, "id")." ".mysql_result($result, $x, "team")." ".mysql_result($result, $x, "full_name");
}
echo "</SELECT>";
echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team."><BR>";
echo "<INPUT TYPE='submit' VALUE='Remove Pitcher'>";
echo "</FORM>";
echo "</TD>";
echo "</TR><TR><TD><font size=4>Search by Name:</font>";
echo "<TABLE><TR><TD><FORM  id='frmSearch' ACTION='by_name.php' METHOD=GET><FONT SIZE=1>Players:</FONT><BR><input id='search' name='searchtext' size='20' onfocus='actb(this,event,customarray);' autocomplete='off' /><INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team."></TD><TD><input type='submit' id='cmdSearch' name='cmdSearch' value='Search' alt='Run Search' /></TD></TR></FORM>";
echo "<TR><TD><FORM ACTION='by_name_pitch.php' METHOD=GET><FONT SIZE=1>Pitchers:</FONT><BR><INPUT TYPE='text' NAME='searchtext'><INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team."></FORM></TD><TD><INPUT TYPE='submit' VALUE='Search'></TD></TR></TABLE>";

echo "</TD></TR></TABLE>";

echo "<TABLE BGCOLOR='#FFFFCC'><TR><TD>";

echo "<FORM ACTION='change_position.php' METHOD=GET>";
echo "<SELECT NAME='player' SIZE=10>";

//$result = mysql_query ("SELECT id, team, full_name, player_rosters.position FROM dick_league_players,player_rosters WHERE player_rosters.team_id = ".$dick_team." AND player_rosters.player_id = dick_league_players.id ORDER BY team");

// Fixes duplicates where player played on two teams in one season
$result = mysql_query ("SELECT id, team, full_name, player_rosters.position FROM dick_league_players, player_rosters WHERE player_rosters.team_id = ".$dick_team." AND player_rosters.player_id = dick_league_players.id AND dick_league_players.team = player_rosters.mlb_team ORDER BY team");


for ($x=0; $x < mysql_num_rows($result); $x++)
{
echo "<OPTION>";

$position = mysql_result($result, $x, "player_rosters.position");

if ($position == "C") {
	$position = ".C";
}
echo mysql_result($result, $x, "id")." ".mysql_result($result, $x, "team")." ".$position." ".mysql_result($result, $x, "full_name");
}
echo "</SELECT>";
echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team."><BR>";
echo "<INPUT TYPE='submit' VALUE='Change Player Position'>";
echo "</FORM>";

echo "</TD>";

// Pitchers
echo "<TD>";

echo "<FORM ACTION='change_position_pitcher.php' METHOD=GET>";
echo "<SELECT NAME='player' SIZE=10>";

$result = mysql_query ("SELECT id, team, full_name, pitcher_rosters.position FROM dick_league_pitchers,pitcher_rosters WHERE pitcher_rosters.team_id = ".$dick_team." AND pitcher_rosters.player_id = dick_league_pitchers.id ORDER BY team");

for ($x=0; $x < mysql_num_rows($result); $x++)
{
echo "<OPTION>";

$position = mysql_result($result, $x, "pitcher_rosters.position");

if ($position == "P") {
	$position = ".P";
}
echo mysql_result($result, $x, "id")." ".mysql_result($result, $x, "team")." ".$position." ".mysql_result($result, $x, "full_name");
}
echo "</SELECT>";
echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team."><BR>";
echo "<INPUT TYPE='submit' VALUE='Change Pitcher Position'>";
echo "</FORM>";

echo "</TD>";
echo "</TR></TABLE>";

mysql_close($conn);
?>

</BODY>
</HTML>




