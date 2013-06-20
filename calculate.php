<?PHP

function inningtodec($i) {
	return floor($i) + ((10/3)*($i-floor($i)));
}

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");


// Delete the peiod's stats, preparing to recalculate them
$garbage = mysql_query ("DELETE from current");

// Check to see whether this is the first period
$result4 = mysql_query ("SELECT first FROM period");
$period = mysql_result($result4, 0, 'first');

// Get the numbers and names of the teams
$result = mysql_query ("SELECT team_id, team_name FROM teams ORDER BY team_id");

for ($x=0; $x < mysql_num_rows($result); $x++)
{

	// The fantasy team number
	$y1 = $x+1;

	// Get the sum of today's stats for the players on this fantasy team
	$result3 = mysql_query ("SELECT SUM(hit) as new_hit,SUM(homer) as new_homer,SUM(steal) as new_steal,SUM(run) as new_run,SUM(rbi) as new_rbi FROM dick_league_players,player_rosters WHERE player_rosters.team_id=".$y1." AND player_rosters.player_id = dick_league_players.id AND player_rosters.active>0;");

	// Get the sum of today's stats for the pitchers on this fantasy team
	$result5 = mysql_query ("SELECT SUM(win) as new_win,SUM(save) as new_save,SUM(k) as new_k,SUM(er) as new_er FROM dick_league_pitchers, pitcher_rosters WHERE pitcher_rosters.team_id=".$y1." AND pitcher_rosters.player_id = dick_league_pitchers.id AND pitcher_rosters.active=1;");

	// Calculate the REAL innings pitched
	$innings_pitched = mysql_query ("SELECT dick_league_pitchers.id, pitcher_rosters.team_id, pitcher_rosters.player_id, dick_league_pitchers.inning, pitcher_rosters.active FROM dick_league_pitchers, pitcher_rosters WHERE pitcher_rosters.team_id = ".$y1." AND pitcher_rosters.player_id = dick_league_pitchers.id AND pitcher_rosters.active = 1");

	$total_innings = 0;
	for ($z=0; $z < mysql_num_rows($innings_pitched); $z++)
	{
		$total_innings += inningtodec(mysql_result($innings_pitched, $z, 'inning'));
	}

	// If this isn't the first period
	if ($period == 0) {

		// Get the sum of this period's baseline stats for the players on this fantasy team
		$result2 = mysql_query ("SELECT SUM(hit) as old_hit,SUM(homer) as old_homer,SUM(steal) as old_steal,SUM(run) as old_run,SUM(rbi) as old_rbi FROM old_players,player_rosters WHERE player_rosters.team_id=".$y1." AND player_rosters.player_id = old_players.id AND player_rosters.active>0;");

		// Get the sum of this period's baseline stats for the pitchers on this fantasy team 
		$result6 = mysql_query ("SELECT SUM(win) as old_win,SUM(save) as old_save,SUM(k) as old_k,SUM(er) as old_er FROM old_pitchers, pitcher_rosters WHERE pitcher_rosters.team_id=".$y1." AND pitcher_rosters.player_id = old_pitchers.id AND pitcher_rosters.active = 1");

		// Calculate the REAL innings pitched upto the baseline
		$old_innings_pitched = mysql_query ("SELECT old_pitchers.id, pitcher_rosters.team_id, pitcher_rosters.player_id, old_pitchers.inning, pitcher_rosters.active FROM old_pitchers, pitcher_rosters WHERE pitcher_rosters.team_id = ".$y1." AND pitcher_rosters.player_id = old_pitchers.id AND pitcher_rosters.active = 1");

		$old_total_innings = 0;
		for ($z=0; $z < mysql_num_rows($old_innings_pitched); $z++)
		{
			$old_total_innings += inningtodec(mysql_result($old_innings_pitched, $z, 'inning'));
		}
		
		// Calculate the stats for this period (if not period one)
		$y2 = (mysql_result($result3, 0, 'new_run') - mysql_result($result2, 0, 'old_run'));
		$y3 = (mysql_result($result3, 0, 'new_hit') - mysql_result($result2, 0, 'old_hit'));
		$y4 = (mysql_result($result3, 0, 'new_homer') - mysql_result($result2, 0, 'old_homer'));
		$y5 = (mysql_result($result3, 0, 'new_rbi') - mysql_result($result2, 0, 'old_rbi'));
		$y6 = (mysql_result($result3, 0, 'new_steal') - mysql_result($result2, 0, 'old_steal'));

		$y7 = (mysql_result($result5, 0, 'new_win') - mysql_result($result6, 0, 'old_win'));
		$y8 = (mysql_result($result5, 0, 'new_save') - mysql_result($result6, 0, 'old_save'));
		$y9 = (mysql_result($result5, 0, 'new_k') - mysql_result($result6, 0, 'old_k'));
		$yy1 = (mysql_result($result5, 0, 'new_er') - mysql_result($result6, 0, 'old_er'));
		
		$yy2 = $total_innings - $old_total_innings;

	} else {

		// Calculate the stats for this period (if period one)
		$y2 = mysql_result($result3, 0, 'new_run');
		$y3 = mysql_result($result3, 0, 'new_hit');
		$y4 = mysql_result($result3, 0, 'new_homer');
		$y5 = mysql_result($result3, 0, 'new_rbi');
		$y6 = mysql_result($result3, 0, 'new_steal');

		$y7 = mysql_result($result5, 0, 'new_win');
		$y8 = mysql_result($result5, 0, 'new_save');
		$y9 = mysql_result($result5, 0, 'new_k');
		$yy1 = mysql_result($result5, 0, 'new_er');
		$yy2 = $total_innings;
	}
	
	// Calculate ERA
	if ($yy2==0) {
		$y10 = 0;
	} else {
		$y10 = number_format(9*$yy1/$yy2,2);
	}
	
	// Store the sum of this period's stats for this team
	$garbage2 = mysql_query ("INSERT INTO current (id, run, hit, homer, rbi, steal, win, save, k, er, ip, era) VALUES ('$y1', '$y2', '$y3', '$y4', '$y5', '$y6', '$y7', '$y8', '$y9', '$yy1', '$yy2', '$y10')");
}

// RUN
$rank = mysql_query ("SELECT run, id FROM current ORDER by run ASC");

$team = 0;
while ($team < mysql_num_rows($rank))
{
	$value = mysql_result($rank,$team, run);
	$cnt = mysql_query("SELECT count(run) as num FROM current WHERE run = $value");
	$cnt_results = mysql_result($cnt, 0, num);
	$pts = $team + 1 +(($cnt_results-1)/2);
	for ($z=0; $z < $cnt_results; $z++)
	{
		$team_id = mysql_result($rank, $team, 'id');
		$aaa = mysql_query ("UPDATE current SET run_pts = '$pts' WHERE id = '$team_id'");
		$team += 1;
	}
}

// HIT
$rank = mysql_query ("SELECT hit, id FROM current ORDER by hit ASC");

$team = 0;
while ($team < mysql_num_rows($rank))
{
	$value = mysql_result($rank,$team, hit);
	$cnt = mysql_query("SELECT count(hit) as num FROM current WHERE hit = $value");
	$cnt_results = mysql_result($cnt, 0, num);
	$pts = $team + 1 +(($cnt_results-1)/2);
	for ($z=0; $z < $cnt_results; $z++)
	{
		$team_id = mysql_result($rank, $team, 'id');
		$aaa = mysql_query ("UPDATE current SET hit_pts = '$pts' WHERE id = '$team_id'");
		$team += 1;
	}
}

// HOMER
$rank = mysql_query ("SELECT homer, id FROM current ORDER by homer ASC");

$team = 0;
while ($team < mysql_num_rows($rank))
{
	$value = mysql_result($rank,$team, homer);
	$cnt = mysql_query("SELECT count(homer) as num FROM current WHERE homer = $value");
	$cnt_results = mysql_result($cnt, 0, num);
	$pts = $team + 1 +(($cnt_results-1)/2);
	for ($z=0; $z < $cnt_results; $z++)
	{
		$team_id = mysql_result($rank, $team, 'id');
		$aaa = mysql_query ("UPDATE current SET homer_pts = '$pts' WHERE id = '$team_id'");
		$team += 1;
	}
}

// RBI
$rank = mysql_query ("SELECT rbi, id FROM current ORDER by rbi ASC");

$team = 0;
while ($team < mysql_num_rows($rank))
{
	$value = mysql_result($rank,$team, rbi);
	$cnt = mysql_query("SELECT count(rbi) as num FROM current WHERE rbi = $value");
	$cnt_results = mysql_result($cnt, 0, num);
	$pts = $team + 1 +(($cnt_results-1)/2);
	for ($z=0; $z < $cnt_results; $z++)
	{
		$team_id = mysql_result($rank, $team, 'id');
		$aaa = mysql_query ("UPDATE current SET rbi_pts = '$pts' WHERE id = '$team_id'");
		$team += 1;
	}
}

// STEAL
$rank = mysql_query ("SELECT steal, id FROM current ORDER by steal ASC");

$team = 0;
while ($team < mysql_num_rows($rank))
{
	$value = mysql_result($rank,$team, steal);
	$cnt = mysql_query("SELECT count(steal) as num FROM current WHERE steal = $value");
	$cnt_results = mysql_result($cnt, 0, num);
	$pts = $team + 1 +(($cnt_results-1)/2);
	for ($z=0; $z < $cnt_results; $z++)
	{
		$team_id = mysql_result($rank, $team, 'id');
		$aaa = mysql_query ("UPDATE current SET steal_pts = '$pts' WHERE id = '$team_id'");
		$team += 1;
	}
}

// WIN
$rank = mysql_query ("SELECT win, id FROM current ORDER by win ASC");

$team = 0;
while ($team < mysql_num_rows($rank))
{
	$value = mysql_result($rank,$team, win);
	$cnt = mysql_query("SELECT count(win) as num FROM current WHERE win = $value");
	$cnt_results = mysql_result($cnt, 0, num);
	$pts = $team + 1 +(($cnt_results-1)/2);
	for ($z=0; $z < $cnt_results; $z++)
	{
		$team_id = mysql_result($rank, $team, 'id');
		$aaa = mysql_query ("UPDATE current SET win_pts = '$pts' WHERE id = '$team_id'");
		$team += 1;
	}
}

// SAVE
$rank = mysql_query ("SELECT save, id FROM current ORDER by save ASC");

$team = 0;
while ($team < mysql_num_rows($rank))
{
	$value = mysql_result($rank,$team, save);
	$cnt = mysql_query("SELECT count(save) as num FROM current WHERE save = $value");
	$cnt_results = mysql_result($cnt, 0, num);
	$pts = $team + 1 +(($cnt_results-1)/2);
	for ($z=0; $z < $cnt_results; $z++)
	{
		$team_id = mysql_result($rank, $team, 'id');
		$aaa = mysql_query ("UPDATE current SET save_pts = '$pts' WHERE id = '$team_id'");
		$team += 1;
	}
}

// K
$rank = mysql_query ("SELECT k, id FROM current ORDER by k ASC");

$team = 0;
while ($team < mysql_num_rows($rank))
{
	$value = mysql_result($rank,$team, k);
	$cnt = mysql_query("SELECT count(k) as num FROM current WHERE k = $value");
	$cnt_results = mysql_result($cnt, 0, num);
	$pts = $team + 1 +(($cnt_results-1)/2);
	for ($z=0; $z < $cnt_results; $z++)
	{
		$team_id = mysql_result($rank, $team, 'id');
		$aaa = mysql_query ("UPDATE current SET k_pts = '$pts' WHERE id = '$team_id'");
		$team += 1;
	}
}


// ERA
$rank = mysql_query ("SELECT era, id FROM current ORDER by era DESC");

$team = 0;
while ($team < mysql_num_rows($rank))
{
	$value = mysql_result($rank,$team, era);
	$cnt = mysql_query("SELECT count(era) as num FROM current WHERE era = ".$value);
	$cnt_results = mysql_result($cnt, 0, num);
	$pts = $team + 1 +(($cnt_results-1)/2);
	for ($z=0; $z < $cnt_results; $z++)
	{
		$team_id = mysql_result($rank, $team, 'id');
		$aaa = mysql_query ("UPDATE current SET era_pts = '$pts' WHERE id = '$team_id'");
		$team += 1;
	}
}

echo "Done!";
?>
