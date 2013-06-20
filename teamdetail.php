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

$total_ers = 0;
$total_ers_pitch = 0;
// Get the name of the team
$result3 = mysql_query ("SELECT team_name FROM teams WHERE team_id =".$dick_team);

$all_positions = mysql_query ("SELECT * FROM positions ORDER BY number");

echo "<H1>".mysql_result($result3, 0, 'team_name')."</H1>";
echo "<table><tr valign=top><td>";
echo "<table border=0>";
echo "<TR bgcolor='#ccccff'>";
echo "<TH>Pos</TH><TH>Player</TH><TH>Team</TH><TH>G</TH><TH>R</TH><TH>H</TH><TH>BB</TH><TH>HR</TH><TH>RBI</TH><TH>SB</TH><TH bgcolor='#ffaaaa'>ERS</TH></TR>";

// Check to see whether this is the first period
$result4 = mysql_query ("SELECT first FROM period");
$period = mysql_result($result4, 0, 'first');

for ($p=0; $p < (mysql_num_rows($all_positions)-2); $p++)
{
	$the_position = mysql_result($all_positions, $p, 'position');
	
	// Get the stats for team $dick_team
	$duplic = mysql_query ("SELECT DISTINCT id, full_name, mlb_team, active, ers FROM dick_league_players, player_rosters WHERE player_rosters.team_id = ".$dick_team." AND player_rosters.player_id = dick_league_players.id AND player_rosters.position = '".$the_position."' ORDER BY id");
	
	// Move this? $result = mysql_query ("SELECT id, team, full_name, player_rosters.position, hit, run, rbi, steal, homer, games, player_rosters.active FROM dick_league_players,player_rosters WHERE player_rosters.team_id = ".$dick_team." AND player_rosters.player_id = dick_league_players.id AND player_rosters.position = '".$the_position."' ORDER BY id");

	for ($x=0; $x < mysql_num_rows($duplic); $x++)
	{
	
		$the_id = mysql_result($duplic, $x, 'id');
				
		$new_stats = mysql_query ("SELECT SUM(games) AS new_games, SUM(hit) AS new_hit, SUM(walk) AS new_walk, SUM(homer) AS new_homer, SUM(steal) AS new_steal, SUM(run) AS new_run, SUM(rbi) AS new_rbi FROM dick_league_players WHERE id = '".$the_id."'");

		//TEST CODE FOR ERS
		//$ers_request = mysql_query("SELECT ers FROM player_rosters WHERE player_id='$the_id'");
		$ers = mysql_result($duplic, $x, 'ers');
		
		//$y0a = mysql_result($result, $x, 'player_rosters.position');
		$y0a = $the_position;
		// Get the last name
		$pre_y0 = stripSlashes(mysql_result($duplic, $x, 'full_name'));
		//CNNSI Version:
			//$namesplit = split(",", $pre_y0);
			//$y0 = $namesplit[0];
		//ESPN Version:
			$firstspace = strpos($pre_y0, " ");
			$namelen = strlen($pre_y0);
			$y0 = substr($pre_y0, ($firstspace+1), ($namelen-$firstspace));
		$y1 = mysql_result($duplic, $x, 'mlb_team');

		if ($period == 0) {

			// Get the sum of this period's baseline stats for the players on this fantasy team
		$old_stats = mysql_query ("SELECT SUM(games) AS old_games, SUM(hit) AS old_hit, SUM(walk) AS old_walk, SUM(homer) AS old_homer, SUM(steal) AS old_steal, SUM(run) AS old_run, SUM(rbi) AS old_rbi FROM old_players WHERE id = '".$the_id."'");

			// Calculate the stats for this period (if not period one)
			$y1a = (mysql_result($new_stats, 0, 'new_games') - mysql_result($old_stats, 0, 'old_games'));
			$y2 = (mysql_result($new_stats, 0, 'new_run') - mysql_result($old_stats, 0, 'old_run'));
			$y3 = (mysql_result($new_stats, 0, 'new_hit') - mysql_result($old_stats, 0, 'old_hit'));
			$y31 = (mysql_result($new_stats, 0, 'new_walk') - mysql_result($old_stats, 0, 'old_walk'));
			$y4 = (mysql_result($new_stats, 0, 'new_homer') - mysql_result($old_stats, 0, 'old_homer'));
			$y5 = (mysql_result($new_stats, 0, 'new_rbi') - mysql_result($old_stats, 0, 'old_rbi'));
			$y6 = (mysql_result($new_stats, 0, 'new_steal') - mysql_result($old_stats, 0, 'old_steal'));

		} else {

			// Calculate the stats for this period (if period one)
			$y1a = mysql_result($new_stats, 0, 'new_games');
			$y2 = mysql_result($new_stats, 0, 'new_run');
			$y3 = mysql_result($new_stats, 0, 'new_hit');
			$y31 = mysql_result($new_stats, 0, 'new_walk');
			$y4 = mysql_result($new_stats, 0, 'new_homer');
			$y5 = mysql_result($new_stats, 0, 'new_rbi');
			$y6 = mysql_result($new_stats, 0, 'new_steal');

		}

		// Remove this part eventually and replace with a select of the current table
		// Check to see if the player is active, change bg color of table row
		if (mysql_result($duplic, $x, 'player_rosters.active') >= 1) {
			$color = "ccccff";
			$ers_color = "ffaaaa";
			$total_ers = $total_ers + $ers;
		} else {
			$color = "ffffff";
			$ers_color = "ffffff";
		}

		echo "<TR bgcolor='#".$color."' align=right>";
		echo "<TD>".$y0a."</TD>\n";
		echo "<TD>".$y0."</TD>\n";
		echo "<TD>".$y1."</TD>\n";
		echo "<TD>".$y1a."</TD>\n";
		echo "<TD>".$y2."</TD>\n";
		echo "<TD>".$y3."</TD>\n";
		echo "<TD>".$y31."</TD>\n";
		echo "<TD>".$y4."</TD>\n";
		echo "<TD>".$y5."</TD>\n";
		echo "<TD>".$y6."</TD>\n";
		//TEST ERS CODE
		echo "<TD bgcolor='#".$ers_color."'>".$ers."</TD>\n";

		echo "</TR>\n";
	}
}
echo "<TR bgcolor='ccccff' align=right>";
echo "<TD colspan=4 align=right><B>TOTALS:</B></TD>";

// Get the team totals for hitting
$totals = mysql_query ("SELECT id, run, hit, homer, rbi, steal, win, save, k, er, ip, era FROM current WHERE id=".$dick_team);
echo "<TD><B>".mysql_result($totals, 0, 'run')."</B></TD>";
echo "<TD colspan=2 align='center'><B>".mysql_result($totals, 0, 'hit')."</B></TD>";
echo "<TD><B>".mysql_result($totals, 0, 'homer')."</B></TD>";
echo "<TD><B>".mysql_result($totals, 0, 'rbi')."</B></TD>";
echo "<TD><B>".mysql_result($totals, 0, 'steal')."</B></TD>";
echo "<TD bgcolor='#ffaaaa'><B>".$total_ers."</B></TD>";

echo "</tr></table></td><td>";

echo "<table border=0>";
echo "<TR bgcolor='#ccccff'>";
echo "<TH>Pos</TH><TH>Player</TH><TH>Team</TH><TH>G</TH><TH>GS</TH><TH>W</TH><TH>S</TH><TH>K</TH><TH>ER</TH><TH>IP</TH><TH>ERA</TH><TH bgcolor='#ffaaaa'>ERS</TH></TR>";

for ($p=(mysql_num_rows($all_positions)-2); $p < mysql_num_rows($all_positions); $p++)
{
	$the_position = mysql_result($all_positions, $p, 'position');
	
	// Get the stats for team $dick_team
	$duplic = mysql_query ("SELECT DISTINCT id, full_name, mlb_team, active, ers FROM dick_league_pitchers, pitcher_rosters WHERE pitcher_rosters.team_id = ".$dick_team." AND pitcher_rosters.player_id = dick_league_pitchers.id AND pitcher_rosters.position = '".$the_position."' ORDER BY id");
	
	//$result = mysql_query ("SELECT id, team, full_name, pitcher_rosters.position, win, save, k, er, inning, games, start, pitcher_rosters.active FROM dick_league_pitchers, pitcher_rosters WHERE pitcher_rosters.team_id = ".$dick_team." AND pitcher_rosters.player_id = dick_league_pitchers.id AND pitcher_rosters.position = '".$the_position."' ORDER BY id");

	for ($x=0; $x < mysql_num_rows($duplic); $x++)
	{
	
		$the_id = mysql_result($duplic, $x, 'id');
		
		//TEST CODE FOR ERS
		//$ers_request = mysql_query("SELECT rating FROM ers_pitch WHERE id='$the_id'");
		$ers = mysql_result($duplic, $x, 'ers');


		$new_stats = mysql_query ("SELECT SUM(games) AS new_games, SUM(win) AS new_win, SUM(save) AS new_save, SUM(k) AS new_k, SUM(er) AS new_er, SUM(start) AS new_start FROM dick_league_pitchers WHERE id = '".$the_id."'");

		$new_ip_result = mysql_query ("SELECT inning FROM dick_league_pitchers WHERE id = '".$the_id."'");
		$total_new_ip = 0;
		for ($z=0; $z < mysql_num_rows($new_ip_result); $z++)
		{
			$ip = mysql_result($new_ip_result, $z, 'inning');
			$total_new_ip = $total_new_ip + inningtodec($ip);
		}

		//$y0a = mysql_result($result, $x, 'player_rosters.position');
		$y0a = $the_position;
		// Get the last name
		$pre_y0 = stripSlashes(mysql_result($duplic, $x, 'full_name'));
		//CNNSI Version:
			//$namesplit = split(",", $pre_y0);
			//$y0 = $namesplit[0];
		//ESPN Version:
			$firstspace = strpos($pre_y0, " ");
			$namelen = strlen($pre_y0);
			$y0 = substr($pre_y0, ($firstspace+1), ($namelen-$firstspace));
		$y1 = mysql_result($duplic, $x, 'mlb_team');
	
		if ($period == 0) {

			// Get the sum of this period's baseline stats for the players on this fantasy team
			$old_stats = mysql_query ("SELECT SUM(games) AS old_games, SUM(win) AS old_win, SUM(save) AS old_save, SUM(k) AS old_k, SUM(er) AS old_er, SUM(start) AS old_start FROM old_pitchers WHERE id = '".$the_id."'");
		
			$old_ip_result = mysql_query ("SELECT inning FROM old_pitchers WHERE id = '".$the_id."'");
			$total_old_ip = 0;
			for ($z=0; $z < mysql_num_rows($old_ip_result); $z++)
			{
				$ip = mysql_result($old_ip_result, $z, 'inning');
				$total_old_ip = $total_old_ip + inningtodec($ip);
			}
		
		
			// Calculate the stats for this period (if not period one)
			$y1a = (mysql_result($new_stats, 0, 'new_games') - mysql_result($old_stats, 0, 'old_games'));
			$y1b = (mysql_result($new_stats, 0, 'new_start') - mysql_result($old_stats, 0, 'old_start'));
			$y2 = (mysql_result($new_stats, 0, 'new_win') - mysql_result($old_stats, 0, 'old_win'));
			$y3 = (mysql_result($new_stats, 0, 'new_save') - mysql_result($old_stats, 0, 'old_save'));
			$y4 = (mysql_result($new_stats, 0, 'new_k') - mysql_result($old_stats, 0, 'old_k'));
			$y5 = (mysql_result($new_stats, 0, 'new_er') - mysql_result($old_stats, 0, 'old_er'));
			$y6 = number_format($total_new_ip - $total_old_ip,1);
			$y6a = $total_new_ip - $total_old_ip;
			$y8 = dectoinning($y6);
		
		} else {

			// Calculate the stats for this period (if period one)
			$y1a = mysql_result($new_stats, 0, 'new_games');
			$y1b = mysql_result($new_stats, 0, 'new_start');
			$y2 = mysql_result($new_stats, 0, 'new_win');
			$y3 = mysql_result($new_stats, 0, 'new_save');
			$y4 = mysql_result($new_stats, 0, 'new_k');
			$y5 = mysql_result($new_stats, 0, 'new_er');
			$y6 = $total_new_ip;
			$y6a = $total_new_ip;
			$y8 = dectoinning($y6);
		}
	
		// Calculate ERA
		if ($y6 == 0) {
			$y7 = 0;
		} else {
			$y7 = number_format(9*$y5/$y6a,2);
		}
		
		// Check to see if the player is active, change bg color of table row
		if (mysql_result($duplic, $x, 'pitcher_rosters.active') >= 1) {
			$color = "ccccff";
			$ers_color = "ffaaaa";
			$total_ers_pitch = $total_ers_pitch + $ers;
		} else {
			$color = "ffffff";
			$ers_color = "ffffff";
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
		echo "<TD bgcolor='".$ers_color."'>".$ers."</TD>\n";

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
echo "<TD bgcolor='#ffaaaa'><B>".$total_ers_pitch."</B></TD>";

mysql_close ($conn);
?>

</tr></table></td></tr></TABLE>
</BODY>
</HTML>
