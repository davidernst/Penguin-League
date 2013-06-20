<?PHP
/*
function inningtodec($i) {
	return floor($i) + ((10/3)*($i-floor($i)));
}

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

//This is done in transferdata.php
//mysql_query ("DELETE FROM dick_league_players");
//mysql_query ("DELETE FROM dick_league_pitchers");
*/
$teams = array("braves", "marlins", "expos", "mets", "phillies", "cubs", "reds", "astros", "brewers", "pirates", "cardinals", "diamondbacks", "rockies", "dodgers", "padres", "giants");

$abrvs = array("ATL", "FLA", "MON", "NYM", "PHI", "CHC", "CIN", "HOU", "MIL", "PIT", "STL", "ARI", "COL", "LOS", "SDG", "SFO");

$numofteams = count($teams);
for ($whichteam=0; $whichteam<$numofteams; $whichteam++)
//For debugging purposes:
//for ($whichteam=0; $whichteam<1; $whichteam++)
{
	// HItters============================
	
$theurl = "http://sports.espn.go.com/mlbhist/teams/batting?team=".$abrvs[$whichteam]."&season=2004&seasonType=2";

	$fp = fopen($theurl, "r");

	$player = fread($fp, 200000);
	fclose($fp);
	$ex1 = explode("OPS</a></b></font></td></tr>", $player);
	$v0 = explode("</td><tr bgColor=#c1c1c1 align=right>", $ex1[1]);
	$v1 = ereg_replace("statsId=", "statsId=>", $v0[0]);
	$v14 = ereg_replace(" align=right", "", $v1);
	$v16 = ereg_replace(" bgColor=#efefe7", "", $v14);

	//$v25 = ereg_replace(" \([0-9]+ <a href=batting\?team=...&season=2003&seasonType=2>.{0,3}</a>\)", "", $v2);
	$v2 = explode("<tr>", $v16);
	for ($guy=1; $guy < (count($v2)); $guy++)
	{
		$v25 = ereg_replace("\">", "<\">", $v2[$guy]);
		$v3 = ereg_replace("<([^>]+)>", ",", $v25);
		$v35 = ereg_replace(" \(([^>]+)\)", "", $v3);
		$v4 = ereg_replace(",+", ",", $v35);
		$parsed = split(",", $v4);
		$the_id = $parsed[1];
		while (strlen($the_id) < 8 )
		{
			$the_id = "0".$the_id;
		}
		$p_id = $the_id;
		$p_team = $abrvs[$whichteam];
		$p_full_name = $parsed[2];
		$p_avg = $parsed[16];
		$p_bat = $parsed[4];
		$p_hit = $parsed[6];
		$p_dble = $parsed[7];
		$p_triple = $parsed[8];
		$p_homer = $parsed[9];
		$p_walk = $parsed[12];
		$p_steal = $parsed[14];
		$p_caught = $parsed[15];
		$p_run = $parsed[5];
		$p_rbi = $parsed[11];
		$p_so = $parsed[13];
		$p_games = $parsed[3];
		$p_slugging = $parsed[18];
		$p_on_base = $parsed[17];

		$populate = mysql_query ("INSERT INTO dick_league_players (id, team, full_name, avg, bat, hit, dble, triple, homer, walk, steal, caught, run, rbi, so, games, slugging, on_base) VALUES('$p_id', '$p_team', '$p_full_name', '$p_avg', '$p_bat', '$p_hit', '$p_dble', '$p_triple', '$p_homer', '$p_walk', '$p_steal', '$p_caught', '$p_run', '$p_rbi', '$p_so', '$p_games', '$p_slugging', '$p_on_base')");

	}

	// Pitchers============================
$theurl = "http://sports.espn.go.com/mlbhist/teams/pitching?team=".$abrvs[$whichteam]."&season=2004&seasonType=2";

	$fp = fopen($theurl, "r");

	$player = fread($fp, 200000);
	fclose($fp);
	$ex1 = explode("ERA</a></b></font></td></tr>", $player);
	$v0 = explode("></TD><TR bgColor=#c1c1c1 align=right>", $ex1[1]);
	$v1 = ereg_replace("statsId=", "statsId=>", $v0[0]);
	$v14 = ereg_replace(" align=right", "", $v1);
	$v16 = ereg_replace(" bgColor=#efefe7", "", $v14);
	//$v25 = ereg_replace(" \([0-9]+ <a href=pitching\?team=...&season=2003&seasonType=2>.{0,3}</a>\)", "", $v2);
	$v2 = explode("<tr>", $v16);
	for ($guy=1; $guy < (count($v2)); $guy++)
	{
		$v25 = ereg_replace("\">", "<\">", $v2[$guy]);
		$v3 = ereg_replace("<([^>]+)>", ",", $v25);
		$v35 = ereg_replace(" \(([^>]+)\)", "", $v3);
		$v4 = ereg_replace(",+", ",", $v35);
		//$v4len = strlen($v4);
		//$v5 = substr($v4, 2, ($v4len-3));
		$parsed = split(",", $v4);
		$the_id = $parsed[1];
		//if ($the_id == "6237")
		//{
		//	echo $v35."<BR>";
		//	echo $v4."<BR>";
		//}
		//echo $the_id."<BR>";
		while (strlen($the_id) < 8 )
		{
			$the_id = "0".$the_id;
		}
		$p_id = $the_id;
		$p_team = $abrvs[$whichteam];
		$p_full_name = $parsed[2];
		$p_games = $parsed[3];
		$p_era = $parsed[18];
		//$p_era = $parsed[20];
		$p_win = $parsed[5];
		$p_loss = $parsed[6];
		$p_save = $parsed[7];
		$p_inning = $parsed[9];
		//$p_inning = $parsed[11];
		$p_h = $parsed[10];
		//$p_h = $parsed[12];
		$p_bb = $parsed[13];
		//$p_bb = $parsed[15];
		$p_k = $parsed[14];
		//$p_k = $parsed[16];
		$p_hr = $parsed[12];
		//$p_hr = $parsed[14];
		$p_er = $parsed[11];
		//$p_er = $parsed[13];
		$p_start = $parsed[4];
		$p_complete = $parsed[9];
		$p_shutout = $parsed[10];
			
		$populate = mysql_query ("INSERT INTO dick_league_pitchers (id, team, full_name, pos, games, era, win, loss, save, inning, h, bb, k, hr, er, start, complete, shutout) VALUES('$p_id', '$p_team', '$p_full_name', 'P', '$p_games', '$p_era', '$p_win', '$p_loss', '$p_save', '$p_inning', '$p_h', '$p_bb', '$p_k', '$p_hr', '$p_er', '$p_start', '$p_complete', '$p_shutout')");
		//echo $p_id."-".$p_team."-".$p_full_name."-".P."-".$p_games."-".$p_era."-".$p_win."-".$p_loss."-".$p_save."-".$p_inning."-".$p_h."-".$p_bb."-".$p_k."-".$p_hr."-".$p_er."-".$p_start."-".$p_complete."-".$p_shutout."<BR>";
	}
	echo "Entering: ".$teams[$whichteam]."<BR>";
	flush();
}


$update = date("l, F d, Y");
mysql_query ("UPDATE period SET updated = '$update'");

// ==============================

// Delete the period's stats, preparing to recalculate them
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
	$result3 = mysql_query ("SELECT SUM(hit) as new_hit,SUM(walk) as new_walk,SUM(homer) as new_homer,SUM(steal) as new_steal,SUM(run) as new_run,SUM(rbi) as new_rbi FROM dick_league_players,player_rosters WHERE player_rosters.team_id=".mysql_result($result, $x, 'team_id')." AND player_rosters.player_id = dick_league_players.id AND player_rosters.active>0;");

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
		$result2 = mysql_query ("SELECT SUM(hit) as old_hit,SUM(walk) as old_walk, SUM(homer) as old_homer,SUM(steal) as old_steal,SUM(run) as old_run,SUM(rbi) as old_rbi FROM old_players,player_rosters WHERE player_rosters.team_id=".mysql_result($result, $x, 'team_id')." AND player_rosters.player_id = old_players.id AND player_rosters.active>0;");

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
		$y31 = (mysql_result($result3, 0, 'new_walk') - mysql_result($result2, 0, 'old_walk'));
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
		$y31 = mysql_result($result3, 0, 'new_walk');
		$y4 = mysql_result($result3, 0, 'new_homer');
		$y5 = mysql_result($result3, 0, 'new_rbi');
		$y6 = mysql_result($result3, 0, 'new_steal');

		$y7 = mysql_result($result5, 0, 'new_win');
		$y8 = mysql_result($result5, 0, 'new_save');
		$y9 = mysql_result($result5, 0, 'new_k');
		$yy1 = mysql_result($result5, 0, 'new_er');
		$yy2 = $total_innings;
	}
	
	//hits plus walks
	$y331 = $y3+$y31;
	
	// Calculate ERA
	if ($yy2==0) {
		$y10 = 0;
	} else {
		$y10 = number_format(9*$yy1/$yy2,2);
	}
	
	// Store the sum of this period's stats for this team
	//$y331 is the sum of hits and walks
	$garbage2 = mysql_query ("INSERT INTO current (id, run, hit, homer, rbi, steal, win, save, k, er, ip, era) VALUES ('$y1', '$y2', '$y331', '$y4', '$y5', '$y6', '$y7', '$y8', '$y9', '$yy1', '$yy2', '$y10')");
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
