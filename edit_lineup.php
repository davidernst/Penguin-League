<HTML>
<HEAD>

<TITLE>Dick League</TITLE>

</HEAD>
<BODY bgcolor="#ffffff">

<?php
$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$result3 = mysql_query ("SELECT team_name FROM teams WHERE team_id =".$dick_team);

echo "<H2>".mysql_result($result3, 0, 'team_name')."</H2>";

$all_positions = mysql_query ("SELECT * FROM positions ORDER BY number");
echo "<form action='edit_lineup2.php' method='post'>";
echo "<table border='0'>";
// Leave out OF, SP and RP - They are handled with pop-ups
for ($p=0; $p < (mysql_num_rows($all_positions)-3); $p++)
{
	$the_position = mysql_result($all_positions, $p, 'position');
	
	$duplic = mysql_query ("SELECT DISTINCT id, full_name, mlb_team, active FROM dick_league_players, player_rosters WHERE player_rosters.team_id = ".$dick_team." AND player_rosters.player_id = dick_league_players.id AND player_rosters.position = '".$the_position."' ORDER BY id");

	echo "<tr bgcolor='#CCCCFF'>";
	echo "<td>".$the_position."</td>";
	for ($x=0; $x < mysql_num_rows($duplic); $x++)
	{
	
		$the_id = mysql_result($duplic, $x, 'id');
		$pre_y0 = stripSlashes(mysql_result($duplic, $x, 'full_name'));
		$y1 = mysql_result($duplic, $x, 'mlb_team');
		$active = mysql_result($duplic, $x, 'active');
		if ($active==1)
		{
			$checked=" checked";
		} else {
			$checked="";
		}
		echo "<td><input type='radio' name='".$the_position."' value='".$the_id."'".$checked.">".$pre_y0." (".$y1.")<br>";
	}
	echo "</td></tr>";
}

echo "<tr bgcolor='#CCCCFF'><td>OF</td><td colspan='2'>";
	$of = mysql_query ("SELECT DISTINCT id, full_name, mlb_team, active FROM dick_league_players, player_rosters WHERE player_rosters.team_id = ".$dick_team." AND player_rosters.player_id = dick_league_players.id AND player_rosters.position = 'OF' ORDER BY mlb_team");
	for ($y=0; $y < mysql_num_rows($of); $y++)
	{
		$the_id = mysql_result($of, $y, 'id');
		$pre_y0 = stripSlashes(mysql_result($of, $y, 'full_name'));
		$y1 = mysql_result($of, $y, 'mlb_team');
		$active = mysql_result($of, $y, 'active');
		if ($active==1)
		{
			$checked=" checked";
		} else {
			$checked="";
		}
		echo "<input type='checkbox' name='of[".$y."]' value='".$the_id."'".$checked.">".$pre_y0." (".$y1.")<br>";
	}
echo "</td></tr>";
echo "<tr bgcolor='#CCCCFF'><td>";
	$of = mysql_query ("SELECT DISTINCT id, full_name, mlb_team, active FROM dick_league_players, player_rosters WHERE player_rosters.team_id = ".$dick_team." AND player_rosters.player_id = dick_league_players.id ORDER BY mlb_team");
echo "DH</td>";
echo "<td colspan='2'><select name='dh'>";
for ($y=0; $y < mysql_num_rows($of); $y++)
{
	$the_id = mysql_result($of, $y, 'id');
	$pre_y0 = stripSlashes(mysql_result($of, $y, 'full_name'));
	$y1 = mysql_result($of, $y, 'mlb_team');
	$active = mysql_result($of, $y, 'active');
	if ($active==2)
	{
		$selected=" selected";
	} else {
		$selected="";
	}
	echo "<option value='".$the_id."'".$selected.">".$pre_y0." (".$y1.")</option>";
}
echo "</select><br>";

echo "</td></tr>";

echo "<tr bgcolor='#FFFFCC'><td>SP</td><td colspan='2'>";
	$of = mysql_query ("SELECT DISTINCT id, full_name, mlb_team, active FROM dick_league_pitchers, pitcher_rosters WHERE pitcher_rosters.team_id = ".$dick_team." AND pitcher_rosters.player_id = dick_league_pitchers.id AND pitcher_rosters.position = 'SP' ORDER BY mlb_team");
	for ($y=0; $y < mysql_num_rows($of); $y++)
	{
		$the_id = mysql_result($of, $y, 'id');
		$pre_y0 = stripSlashes(mysql_result($of, $y, 'full_name'));
		$y1 = mysql_result($of, $y, 'mlb_team');
		$active = mysql_result($of, $y, 'active');
		if ($active==1)
		{
			$checked=" checked";
		} else {
			$checked="";
		}
		echo "<input type='checkbox' name='sp[".$y."]' value='".$the_id."'".$checked.">".$pre_y0." (".$y1.")<br>";
	}
echo "</td></tr>";

echo "<tr bgcolor='#FFFFCC'><td>RP</td><td colspan='2'>";
	$of = mysql_query ("SELECT DISTINCT id, full_name, mlb_team, active FROM dick_league_pitchers, pitcher_rosters WHERE pitcher_rosters.team_id = ".$dick_team." AND pitcher_rosters.player_id = dick_league_pitchers.id AND pitcher_rosters.position = 'RP' ORDER BY mlb_team");
	for ($y=0; $y < mysql_num_rows($of); $y++)
	{
		$the_id = mysql_result($of, $y, 'id');
		$pre_y0 = stripSlashes(mysql_result($of, $y, 'full_name'));
		$y1 = mysql_result($of, $y, 'mlb_team');
		$active = mysql_result($of, $y, 'active');
		if ($active==1)
		{
			$checked=" checked";
		} else {
			$checked="";
		}
		echo "<input type='checkbox' name='rp[".$y."]' value='".$the_id."'".$checked.">".$pre_y0." (".$y1.")<br>";
	}
echo "</td></tr></table>";
echo "<input type='hidden' name='dick_team' value=".$dick_team.">";
echo "<input type='submit'>";
echo "</form>";
?>
</BODY>
</HTML>