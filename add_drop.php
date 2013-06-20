<HTML>
<HEAD>
<TITLE>Control Panel</TITLE>
</HEAD>
<BODY BGCOLOR="#FFFFFF">
<?PHP

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$dick_team = CHOP(SUBSTR($whichteam,0,2));
echo "<H1>Team ".$dick_team." Roster</H1>";

echo "<FORM ACTION='control.php' METHOD=GET>";
echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team.">";
echo "<INPUT TYPE='submit' VALUE='Done'>";
echo "</FORM>";
echo "<HR>";

// Drop Player
echo "<H2>Drop:</H2>";
echo "<FORM ACTION='rosterchange1.php' METHOD=GET>";
echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team.">";
$result = mysql_query ("SELECT id, team, full_name FROM dick_league_players, player_rosters WHERE player_rosters.team_id = ".$dick_team." AND player_rosters.player_id = dick_league_players.id AND dick_league_players.team = player_rosters.mlb_team ORDER BY team");
echo "Player: <SELECT NAME='drop_player'>";
echo "<OPTION VALUE='X'>Select a Player";
for ($x=0; $x < mysql_num_rows($result); $x++)
{
echo "<OPTION VALUE='".mysql_result($result, $x, "id")."'>";
echo mysql_result($result, $x, "full_name");
}
echo "</SELECT>";
//echo "<INPUT TYPE='submit' VALUE='Drop Player'>";
//echo "</FORM>";
echo "<P>";

// Drop Pitcher
//echo "<FORM ACTION='rosterchange2.php' METHOD=GET>";
//echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team.">";
$result = mysql_query ("SELECT id, team, full_name FROM dick_league_pitchers, pitcher_rosters WHERE pitcher_rosters.team_id = ".$dick_team." AND pitcher_rosters.player_id = dick_league_pitchers.id AND dick_league_pitchers.team = pitcher_rosters.mlb_team ORDER BY team");
echo "Pitcher: <SELECT NAME='drop_pitcher'>";
echo "<OPTION VALUE='X'>Select a Pitcher";
for ($x=0; $x < mysql_num_rows($result); $x++)
{
echo "<OPTION VALUE='".mysql_result($result, $x, "id")."'>";
echo mysql_result($result, $x, "full_name");
}
echo "</SELECT>";
//echo "<INPUT TYPE='submit' VALUE='Drop Pitcher'>";
//echo "</FORM>";
echo "<P><HR>";

// Add Player
echo "<H2>Add:</H2>";

//echo "<FORM ACTION='rosterchange3.php' METHOD=GET>";
//echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team.">";
$result = mysql_query ("SELECT id, team, full_name FROM dick_league_players ORDER BY team, full_name");
echo "Player: <SELECT NAME='add_player'>";
echo "<OPTION VALUE='X'>Select a Player";
for ($x=0; $x < mysql_num_rows($result); $x++)
{
echo "<OPTION VALUE='".mysql_result($result, $x, "id")."'>";
echo mysql_result($result, $x, "team")." ".mysql_result($result, $x, "full_name");
}
echo "</SELECT>";

echo "<P>";

// Add Pitcher
//echo "<FORM ACTION='rosterchange4.php' METHOD=GET>";
//echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team.">";
$result = mysql_query ("SELECT id, team, full_name FROM dick_league_pitchers ORDER BY team, full_name");
echo "Pitcher: <SELECT NAME='add_pitcher'>";
echo "<OPTION VALUE='X'>Select a Pitcher";
for ($x=0; $x < mysql_num_rows($result); $x++)
{
echo "<OPTION VALUE='".mysql_result($result, $x, "id")."'>";
echo mysql_result($result, $x, "team")." ".mysql_result($result, $x, "full_name");
}
echo "</SELECT>";
echo "<P>";
$result = mysql_query ("SELECT position FROM positions");
echo "Position: <SELECT NAME='position'>";
for ($x=0; $x < mysql_num_rows($result); $x++)
{
echo "<OPTION>";
echo mysql_result($result, $x, "position");
}
echo "</SELECT>";
echo "<P>";
echo "<INPUT TYPE='submit' VALUE='Submit Transaction'>";
echo "</FORM>";
echo "<P><HR>";

// Trade Player
echo "<H2>Trade:</H2>";
echo "<FORM ACTION='rosterchange5.php' METHOD=GET>";
//echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team.">";
$result = mysql_query ("SELECT id, team, full_name FROM dick_league_players, player_rosters WHERE player_rosters.team_id = ".$dick_team." AND player_rosters.player_id = dick_league_players.id AND dick_league_players.team = player_rosters.mlb_team ORDER BY team");
echo "Player: <SELECT NAME='player'>";
for ($x=0; $x < mysql_num_rows($result); $x++)
{
echo "<OPTION VALUE='".mysql_result($result, $x, "id")."'>";
echo mysql_result($result, $x, "full_name");
}
echo "</SELECT>";

echo " to ";
$result = mysql_query ("SELECT team_id, team_name FROM teams WHERE team_id <>".$dick_team);

echo "<SELECT NAME='team'>";
for ($x=0; $x < mysql_num_rows($result); $x++)
{
echo "<OPTION VALUE='".mysql_result($result, $x, "team_id")."'>";
echo mysql_result($result, $x, "team_name");
}
echo "</SELECT>";

echo "<INPUT TYPE='submit' VALUE='Trade Player'>";
echo "</FORM>";
echo "<P>";

// Trade Pitcher
echo "<FORM ACTION='rosterchange6.php' METHOD=GET>";
echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team.">";
$result = mysql_query ("SELECT id, team, full_name FROM dick_league_pitchers, pitcher_rosters WHERE pitcher_rosters.team_id = ".$dick_team." AND pitcher_rosters.player_id = dick_league_pitchers.id AND dick_league_pitchers.team = pitcher_rosters.mlb_team ORDER BY team");
echo "Pitcher: <SELECT NAME='pitcher'>";
for ($x=0; $x < mysql_num_rows($result); $x++)
{
echo "<OPTION VALUE='".mysql_result($result, $x, "id")."'>";
echo mysql_result($result, $x, "full_name");
}
echo "</SELECT>";

echo " to ";
$result = mysql_query ("SELECT team_id, team_name FROM teams WHERE team_id <>".$dick_team);

echo "<SELECT NAME='team'>";
for ($x=0; $x < mysql_num_rows($result); $x++)
{
echo "<OPTION VALUE='".mysql_result($result, $x, "team_id")."'>";
echo mysql_result($result, $x, "team_name");
}
echo "</SELECT>";

echo "<INPUT TYPE='submit' VALUE='Trade Pitcher'>";
echo "</FORM>";
echo "<P><HR>";



mysql_close($conn);
?>

</BODY>
</HTML>




