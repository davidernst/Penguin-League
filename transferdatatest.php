<?PHP

function inningtodec($i) {
	return floor($i) + ((10/3)*($i-floor($i)));
}

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

mysql_query ("DELETE FROM dick_league_players");
mysql_query ("DELETE FROM dick_league_pitchers");

$teams = array("orioles", "red_sox", "yankees", "devil_rays", "blue_jays", "white_sox", "indians", "tigers", "royals", "twins", "angels", "athletics", "mariners", "rangers");

$abrvs = array("BAL", "BOS", "NYY", "TAM", "TOR", "CHW", "CLE", "DET", "KAN", "MIN", "ANA", "OAK", "SEA", "TEX");

$numofteams = count($teams);
for ($whichteam=0; $whichteam<$numofteams; $whichteam++)
//For debugging purposes:
//for ($whichteam=0; $whichteam<2; $whichteam++)
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

/*
	$v3 = ereg_replace("<([^>]+)>", ",", $v25);
	$v4 = ereg_replace(",+", ",", $v3);
	$v4len = strlen($v4);
	$v5 = substr($v4, 2, ($v4len-3));
	$parsed = split(",", $v5);
	for ($stat=0; $stat < (count($parsed)/19); $stat++)
	{
		$which_player = $stat*19;
		$the_id = $parsed[($which_player)];
		while (strlen($the_id) < 8 )
		{
			$the_id = "0".$the_id;
		}
		$p_id = $the_id;
		$p_team = $abrvs[$whichteam];
		$p_full_name = $parsed[$which_player+1];
		$p_avg = $parsed[$which_player+15];
		$p_bat = $parsed[$which_player+3];
		$p_hit = $parsed[$which_player+5];
		$p_dble = $parsed[$which_player+6];
		$p_triple = $parsed[$which_player+7];
		$p_homer = $parsed[$which_player+8];
		$p_walk = $parsed[$which_player+11];
		$p_steal = $parsed[$which_player+13];
		$p_caught = $parsed[$which_player+14];
		$p_run = $parsed[$which_player+4];
		$p_rbi = $parsed[$which_player+10];
		$p_so = $parsed[$which_player+12];
		$p_games = $parsed[$which_player+2];
		$p_slugging = $parsed[$which_player+17];
		$p_on_base = $parsed[$which_player+16];
			
		$populate = mysql_query ("INSERT INTO dick_league_players (id, team, full_name, avg, bat, hit, dble, triple, homer, walk, steal, caught, run, rbi, so, games, slugging, on_base) VALUES('$p_id', '$p_team', '$p_full_name', '$p_avg', '$p_bat', '$p_hit', '$p_dble', '$p_triple', '$p_homer', '$p_walk', '$p_steal', '$p_caught', '$p_run', '$p_rbi', '$p_so', '$p_games', '$p_slugging', '$p_on_base')");
	}
*/
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

include ("transferdata2.php");
?>
