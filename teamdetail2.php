<HTML>
<HEAD>

<TITLE>Penguin League</TITLE>

</HEAD>
<BODY bgcolor="#ffffff">
<?PHP

function inningtodec($i) {
	return floor($i) + ((10/3)*($i-floor($i)));
}

function dectoinning($i) {
	return floor($i) + number_format(3*($i-floor($i))/10,1);
}

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

// Get the name of the team
$result3 = mysql_query ("SELECT team_name FROM teams WHERE team_id =".$dick_team);

$all_positions = mysql_query ("SELECT * FROM positions ORDER BY number");

echo "<H1>".mysql_result($result3, 0, 'team_name')."</H1>";
echo "<table><tr valign=top><td>";
echo "<table border=0>";
echo "<TR bgcolor='#ccccff'>";
echo "<TH>Pos</TH><TH>Player</TH><TH>Team</TH><TH>G</TH><TH>R</TH><TH>H</TH><TH>HR</TH><TH>RBI</TH><TH>SB</TH></TR>";

for ($p=0; $p < (mysql_num_rows($all_positions)-2); $p++)
{
	$the_position = mysql_result($all_positions, $p, 'position');
	
	// Get the stats for team $dick_team
	$result = mysql_query ("SELECT id, team, name, player_rosters.position, hit, run, rbi, steal, homer, games, player_rosters.active FROM dick_league_players,player_rosters WHERE player_rosters.team_id = ".$dick_team." AND player_rosters.player_id = dick_league_players.id AND player_rosters.position = '".$the_position."' ORDER BY id");

	// Check to see whether this is the first period
	$result4 = mysql_query ("SELECT first FROM period");
	$period = mysql_result($result4, 0, 'first');

	for ($x=0; $x < mysql_num_rows($result); $x++)
	{
		$y0a = mysql_result($result, $x, 'player_rosters.position');
		$y0 = mysql_result($result, $x, 'name');
		$y1 = mysql_result($result, $x, 'team');

		if ($period == 0) {

			// Get the sum of this period's baseline stats for the players on this fantasy team
			$result2 = mysql_query ("SELECT id, team, name, player_rosters.position, hit, run, rbi, steal, homer, games, player_rosters.active FROM old_players,player_rosters WHERE player_rosters.team_id = ".$dick_team." AND player_rosters.player_id = old_players.id AND player_rosters.position = '".$the_position."' ORDER BY id");

			// Calculate the stats for this period (if not period one)
			$y1a = (mysql_result($result, $x, 'games') - mysql_result($result2, $x, 'games'));
			$y2 = (mysql_result($result, $x, 'run') - mysql_result($result2, $x, 'run'));
			$y3 = (mysql_result($result, $x, 'hit') - mysql_result($result2, $x, 'hit'));
			$y4 = (mysql_result($result, $x, 'homer') - mysql_result($result2, $x, 'homer'));
			$y5 = (mysql_result($result, $x, 'rbi') - mysql_result($result2, $x, 'rbi'));
			$y6 = (mysql_result($result, $x, 'steal') - mysql_result($result2, $x, 'steal'));

		} else {

			// Calculate the stats for this period (if period one)
			$y1a = mysql_result($result, $x, 'games');
			$y2 = mysql_result($result, $x, 'run');
			$y3 = mysql_result($result, $x, 'hit');
			$y4 = mysql_result($result, $x, 'homer');
			$y5 = mysql_result($result, $x, 'rbi');
			$y6 = mysql_result($result, $x, 'steal');

		}

		// Remove this part eventually and replace with a select of the current table
		// Check to see if the player is active, change bg color of table row
		if (mysql_result($result, $x, 'player_rosters.active') >= 1) {
			$color = "ccccff";
		} else {
			$color = "ffffff";
		}

		echo "<TR bgcolor='#".$color."' align=right>";
		echo "<TD>".$y0a."</TD>\n";
		echo "<TD>".$y0."</TD>\n";
		echo "<TD>".$y1."</TD>\n";
		echo "<TD>".$y1a."</TD>\n";
		echo "<TD>".$y2."</TD>\n";
		echo "<TD>".$y3."</TD>\n";
		echo "<TD>".$y4."</TD>\n";
		echo "<TD>".$y5."</TD>\n";
		echo "<TD>".$y6."</TD>\n";
		echo "</TR>\n";
	}
}
echo "<TR bgcolor='ccccff' align=right>";
echo "<TD colspan=4 align=right><B>TOTALS:</B></TD>";

// Get the team totals for hitting
$totals = mysql_query ("SELECT id, run, hit, homer, rbi, steal, win, save, k, er, ip, era FROM current WHERE id=".$dick_team);
echo "<TD><B>".mysql_result($totals, 0, 'run')."</B></TD>";
echo "<TD><B>".mysql_result($totals, 0, 'hit')."</B></TD>";
echo "<TD><B>".mysql_result($totals, 0, 'homer')."</B></TD>";
echo "<TD><B>".mysql_result($totals, 0, 'rbi')."</B></TD>";
echo "<TD><B>".mysql_result($totals, 0, 'steal')."</B></TD>";
echo "</tr></table></td><td>";

echo "<table border=0>";
echo "<TR bgcolor='#ccccff'>";
echo "<TH>Pos</TH><TH>Player</TH><TH>Team</TH><TH>G</TH><TH>GS</TH><TH>W</TH><TH>S</TH><TH>K</TH><TH>ER</TH><TH>IP</TH><TH>ERA</TH></TR>";

for ($p=(mysql_num_rows($all_positions)-2); $p < mysql_num_rows($all_positions); $p++)
{
	$the_position = mysql_result($all_positions, $p, 'position');
	
	// Get the stats for team $dick_team
	$result = mysql_query ("SELECT id, team, name, pos, win, save, k, er, inning, games, start, pitcher_rosters.active FROM dick_league_pitchers, pitcher_rosters WHERE pitcher_rosters.team_id = ".$dick_team." AND pitcher_rosters.player_id = dick_league_pitchers.id AND pitcher_rosters.position = '".$the_position."' ORDER BY id");

	for ($x=0; $x < mysql_num_rows($result); $x++)
	{
		$y0a = mysql_result($result, $x, 'pos');
		$y0 = mysql_result($result, $x, 'name');
		$y1 = mysql_result($result, $x, 'team');
	
		if ($period == 0) {

			// Get the sum of this period's baseline stats for the players on this fantasy team
			$result2 = mysql_query ("SELECT id, team, name, pos, win, save, k, er, inning, games, start, pitcher_rosters.active FROM old_pitchers,pitcher_rosters WHERE pitcher_rosters.team_id = ".$dick_team." AND pitcher_rosters.player_id = old_pitchers.id AND pitcher_rosters.position = '".$the_position."' ORDER BY id");
		
			// Calculate the stats for this period (if not period one)
			$y1a = (mysql_result($result, $x, 'games') - mysql_result($result2, $x, 'games'));
			$y1b = (mysql_result($result, $x, 'start') - mysql_result($result2, $x, 'start'));
			$y2 = (mysql_result($result, $x, 'win') - mysql_result($result2, $x, 'win'));
			$y3 = (mysql_result($result, $x, 'save') - mysql_result($result2, $x, 'save'));
			$y4 = (mysql_result($result, $x, 'k') - mysql_result($result2, $x, 'k'));
			$y5 = (mysql_result($result, $x, 'er') - mysql_result($result2, $x, 'er'));
			$y6 = number_format(inningtodec(mysql_result($result, $x, 'inning')) - inningtodec(mysql_result($result2, $x, 'inning')),1);
			$y8 = dectoinning($y6);
		
		} else {

			// Calculate the stats for this period (if period one)
			$y1a = mysql_result($result, $x, 'games');
			$y1b = mysql_result($result, $x, 'start');
			$y2 = mysql_result($result, $x, 'win');
			$y3 = mysql_result($result, $x, 'save');
			$y4 = mysql_result($result, $x, 'k');
			$y5 = mysql_result($result, $x, 'er');
			$y8 = mysql_result($result, $x, 'inning');
			$y6 = inningtodec(mysql_result($result, $x, 'inning'));
		}
	
		// Calculate ERA
		if ($y6 == 0) {
			$y7 = 0;
		} else {
			$y7 = number_format(9*$y5/$y6,2);
		}
		
		// Check to see if the player is active, change bg color of table row
		if (mysql_result($result, $x, 'pitcher_rosters.active') == 1) {
			$color = "ccccff";
		} else {
			$color = "ffffff";
		}

		echo "<TR bgcolor='#".$color."' align=right>";
		echo "<TD>".$y0a."</TD>\n";
		echo "<TD>".$y0."</TD>\n";
		echo "<TD>".$y1."</TD>\n";
		echo "<TD>".$y1a."</TD>\n";
		echo "<TD>".$y1b."</TD>\n";
		echo "<TD>".$y2."</TD>\n";
		echo "<TD>".$y3."</TD>\n";
		echo "<TD>".$y4."</TD>\n";
		echo "<TD>".$y5."</TD>\n";
		echo "<TD>".number_format($y8,1)."</TD>\n";
		echo "<TD>".$y7."</TD>\n";
		echo "</TR>\n";
	}
}

echo "<TR bgcolor='ccccff' align=right>";
echo "<TD colspan=5 align=right><B>TOTALS:</B></TD>";

// Get the team totals for hitting
echo "<TD><B>".mysql_result($totals, 0, 'win')."</B></TD>";
echo "<TD><B>".mysql_result($totals, 0, 'save')."</B></TD>";
echo "<TD><B>".mysql_result($totals, 0, 'k')."</B></TD>";
echo "<TD><B>".mysql_result($totals, 0, 'er')."</B></TD>";
echo "<TD><B>".number_format(dectoinning(mysql_result($totals, 0, 'ip')),1)."</B></TD>";
echo "<TD><B>".mysql_result($totals, 0, 'era')."</B></TD>";

mysql_close ($conn);
?>

</tr></table></td></tr></TABLE>
</BODY>
</HTML>
