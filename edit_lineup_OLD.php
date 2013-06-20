<HTML>
<HEAD>

<TITLE>Control Panel</TITLE>

</HEAD>

<BODY BGCOLOR="#FFFFFF">
<FORM ACTION="edit_lineup2.php" METHOD=GET>

<?PHP
$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$dick_team = CHOP(SUBSTR($whichteam,0,2));
echo "<H1>Team ".$dick_team." Roster</H1>";
echo "<TABLE BGCOLOR='#FFFFCC'>";

//$result = mysql_query ("SELECT id, team, full_name, player_rosters.active, player_rosters.position FROM dick_league_players,player_rosters WHERE player_rosters.team_id = ".$dick_team." AND player_rosters.player_id = dick_league_players.id ORDER BY id");
//$result2 = mysql_query ("SELECT id, team, full_name, pitcher_rosters.active, pitcher_rosters.position FROM dick_league_pitchers,pitcher_rosters WHERE pitcher_rosters.team_id = ".$dick_team." AND pitcher_rosters.player_id = dick_league_pitchers.id ORDER BY id");

// Fixes duplicates where player played on two teams in one season
$result = mysql_query ("SELECT id, team, full_name, player_rosters.active, player_rosters.position FROM dick_league_players, player_rosters WHERE player_rosters.team_id = ".$dick_team." AND player_rosters.player_id = dick_league_players.id AND dick_league_players.team = player_rosters.mlb_team ORDER BY team");
$result2 = mysql_query ("SELECT id, team, full_name, pitcher_rosters.active, pitcher_rosters.position FROM dick_league_pitchers, pitcher_rosters WHERE pitcher_rosters.team_id = ".$dick_team." AND pitcher_rosters.player_id = dick_league_pitchers.id AND dick_league_pitchers.team = pitcher_rosters.mlb_team ORDER BY team");

for ($x=0; $x < mysql_num_rows($result); $x++)
{

	IF (mysql_result($result, $x, "player_rosters.active") >= 1) {
		$check = " CHECKED";
	} ELSE {
		$check = "";
	}

	echo "<TR><TD>";
	echo "<INPUT TYPE='checkbox' NAME='c[".$x."]' VALUE='".mysql_result($result, $x, "id")."'".$check.">";
	echo "</TD><TD>";
	echo mysql_result($result, $x, "team")."</TD><TD>".mysql_result($result, $x, "full_name")."</TD><TD>".mysql_result($result, $x, "player_rosters.position");
	echo "</TD></TR>";
}
echo "<TR><TD><HR></TD><TD><HR></TD><TD><HR></TD><TD><HR></TD></TR>";

for ($x=0; $x < mysql_num_rows($result2); $x++)
{

	IF (mysql_result($result2, $x, "pitcher_rosters.active") == 1) {
		$check = " CHECKED";
	} ELSE {
		$check = "";
	}

	echo "<TR><TD>";
	echo "<INPUT TYPE='checkbox' NAME='d[".$x."]' VALUE='".mysql_result($result2, $x, "id")."'".$check.">";
	echo "</TD><TD>";
	echo mysql_result($result2, $x, "team")."</TD><TD>".mysql_result($result2, $x, "full_name")."</TD><TD>".mysql_result($result2, $x, "pitcher_rosters.position");
	echo "</TD></TR>";
}

echo "</TABLE>";
echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team.">";
echo "<INPUT TYPE='submit' VALUE='Done'>";
?>

</FORM>
</BODY>
</HTML>


