<?PHP

function inningtodec($i) {
	return floor($i) + ((10/3)*($i-floor($i)));
}

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

mysql_query ("DELETE FROM dick_league_players");
mysql_query ("DELETE FROM dick_league_pitchers");

$teams = array("orioles", "red_sox", "yankees", "devil_rays", "blue_jays", "white_sox", "indians", "tigers", "royals", "twins", "angels", "athletics", "mariners", "rangers", "braves", "marlins", "expos", "mets", "phillies", "cubs", "reds", "astros", "brewers", "pirates", "cardinals", "diamondbacks", "rockies", "dodgers", "padres", "giants");

$abrvs = array("bal", "bos", "nyy", "tam", "tor", "cha", "cle", "det", "kan", "min", "ana", "oak", "sea", "tex", "atl", "fla", "mon", "nym", "phi", "chn", "cin", "hou", "mil", "pit", "stl", "ari", "col", "los", "sdg", "sfo");

// HItters============================
$numofteams = count($teams);
for ($whichteam=0; $whichteam<$numofteams; $whichteam++)
{
$theurl = "http://sportsillustrated.cnn.com/baseball/mlb/teams/".$teams[$whichteam]."/stats/batlead_by_batting_avg.html";

$fp = fopen($theurl, "r");

do {
	$update = fgets($fp, 1024);
} while (ereg("Updated:", $update) == FALSE);

mysql_query ("UPDATE period SET updated = '$update'");


//need to add $x changes - describes which stat (see query below)
do {
	$player = fgets($fp, 1024);
	if (ereg("TData", $player) == TRUE)
	{
		$stat2 = split("/", $player);
		$the_id = $stat2[6];
		$stat3 = split(">", $player);
		$stat4 = split("<", $stat3[3]);
		$fullname = $stat4[0];
		$x=0;
		$player = fgets($fp, 1024);
		do {
			if (ereg("<td", $player) == TRUE)
			{
				$stat = split(">", $player);
				$stat1 = split("<", $stat[1]);
				//echo $x." ".$stat1[0]."<BR>";
				$parsed[$x] = $stat1[0];
				$x = $x+1;
			}
			$player = fgets($fp, 1024);
			
		} while (ereg("</tr>", $player) == FALSE);
		while (strlen($the_id) < 8 )
		{
			$the_id = "0".$the_id;
		}
		echo "Entering: ".$fullname." (".$the_id.")<BR>";
		
		//$populate = mysql_query ("INSERT INTO dick_league_players SET id='$the_id', team='BAL', full_name='$fullname', avg='$parsed[0]', bat='$parsed[2]', hit='$parsed[4]', dble='$parsed[5]', triple='$parsed[6]', homer='$parsed[7]', walk='$parsed[9]', steal='$parsed[12]', caught='$parsed[13]', run='$parsed[3]', rbi='$parsed[8]', so='$parsed[10]', games='$parsed[1]', slugging='$parsed[16]', hit_by='$parsed[11]', on_base='$parsed[15]'");

		$populate = mysql_query ("INSERT INTO dick_league_players (id, team, full_name, avg, bat, hit, dble, triple, homer, walk, steal, caught, run, rbi, so, games, slugging, hit_by, on_base) VALUES('$the_id', '$abrvs[$whichteam]', '$fullname', '$parsed[0]', '$parsed[2]', '$parsed[4]', '$parsed[5]', '$parsed[6]', '$parsed[7]', '$parsed[9]', '$parsed[12]', '$parsed[13]', '$parsed[3]', '$parsed[8]', '$parsed[10]', '$parsed[1]', '$parsed[16]', '$parsed[11]', '$parsed[15]')");
	}



} while (ereg("Team Totals", $player) == FALSE);

//	mysql_query ("INSERT INTO dick_league_pitchers VALUES ('$the_id', '$parsed[1]', '$safe_name', '$fullname', '$parsed[5]', '$parsed[6]', '$parsed[26]', '$parsed[10]', '$parsed[12]', '$parsed[13]', '$parsed[14]', '$parsed[15]', '$parsed[17]', '$parsed[20]', '$parsed[7]', '$parsed[21]', '$parsed[22]', '$parsed[23]', '$parsed[27]', '$parsed[11]', '$parsed[16]', '$parsed[28]', '$parsed[19]', '$parsed[9]', '$parsed[24]', '$parsed[18]', '$parsed[25]', '$parsed[42]', '$parsed[43]', '$parsed[44]', '$parsed[45]', '$parsed[29]', '$parsed[30]', '$parsed[31]', '$parsed[33]', '$parsed[38]', '$parsed[34]', '$parsed[35]', '$parsed[32]', '$parsed[36]', '$parsed[37]', '$parsed[37]', '$parsed[39]', '$parsed[40]', '$parsed[41]')");

fclose($fp);
}
// ==============================

// Delete the peiod's stats, preparing to recalculate them
$garbage = mysql_query ("DELETE from current");

// Check to see whether this is the first period
$result4 = mysql_query ("SELECT first FROM period");
$period = mysql_result($result4, 0, 'first');

// Get the numbers and names of the teams
$result = mysql_query ("SELECT team_id, team_name FROM teams");

for ($x=0; $x < mysql_num_rows($result); $x++)
{

	// The fantasy team number
	$y1 = $x+1;

	// Get the sum of today's stats for the players on this fantasy team
	$result3 = mysql_query ("SELECT SUM(hit) as new_hit,SUM(homer) as new_homer,SUM(steal) as new_steal,SUM(run) as new_run,SUM(rbi) as new_rbi FROM dick_league_players,player_rosters WHERE player_rosters.team_id=".mysql_result($result, $x, 'team_id')." AND player_rosters.player_id = dick_league_players.id AND player_rosters.active>0;");

	// Get the sum of today's stats for the pitchers on this fantasy team
	$result5 = mysql_query ("SELECT SUM(win) as new_win,SUM(save) as new_save,SUM(k) as new_k,SUM(er) as new_er FROM dick_league_pitchers, pitcher_rosters WHERE pitcher_rosters.team_id=".mysql_result($result, $x, 'team_id')." AND pitcher_rosters.player_id = dick_league_pitchers.id AND pitcher_rosters.active=1;");

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
		$result2 = mysql_query ("SELECT SUM(hit) as old_hit,SUM(homer) as old_homer,SUM(steal) as old_steal,SUM(run) as old_run,SUM(rbi) as old_rbi FROM old_players,player_rosters WHERE player_rosters.team_id=".mysql_result($result, $x, 'team_id')." AND player_rosters.player_id = old_players.id AND player_rosters.active>0;");

		// Get the sum of this period's baseline stats for the pitchers on this fantasy team 
		$result6 = mysql_query ("SELECT SUM(win) as old_win,SUM(save) as old_save,SUM(k) as old_k,SUM(er) as old_er FROM old_pitchers, pitcher_rosters WHERE pitcher_rosters.team_id=".mysql_result($result, $x, 'team_id')." AND pitcher_rosters.player_id = old_pitchers.id AND pitcher_rosters.active = 1");

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

?>
