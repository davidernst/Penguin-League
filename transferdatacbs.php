<?PHP

function inningtodec($i) {
	return floor($i) + ((10/3)*($i-floor($i)));
}

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$history_month = date("m");
$history_date = date("d");

mysql_query ("DELETE FROM dick_league_players");
mysql_query ("DELETE FROM dick_league_pitchers");

$delete_todays_history = mysql_query ("DELETE from players_history WHERE month = '$history_month' AND date = '$history_date'");
$delete_todays_history = mysql_query ("DELETE from pitchers_history WHERE month = '$history_month' AND date = '$history_date'");

//$teams = array("orioles", "red_sox", "yankees", "devil_rays", "blue_jays", "white_sox", "indians", "tigers", "royals", "twins", "angels", "athletics", "mariners", "rangers");

//$abrvs = array("BAL", "BOS", "NYY", "TAM", "TOR", "CHW", "CLE", "DET", "KAN", "MIN", "ANA", "OAK", "SEA", "TEX");

//$numofteams = count($teams);
//for ($whichteam=0; $whichteam<$numofteams; $whichteam++)
//For debugging purposes:
//for ($whichteam=0; $whichteam<2; $whichteam++)
//{
	// Hitters============================

$theurl = "http://www.cbssports.com/mlb/stats/playersort/MLB/AVGU/ALL/ALL/regularseason/2012?&print_rows=9999";

	$fp = fopen($theurl, "r");
	
	//$player = fread($fp, 200000);
	while(!feof($fp))
	{
		$output = fgets($fp, 200000);
		$player = $player.$output;
	}
	
	fclose($fp);
	$ex1 = explode(">OPS</span></a></td></tr>", $player);
	$v0 = explode("<tr class=\"footer pagination\"><td colspan=\"18\">", $ex1[1]);
	$v2 = preg_split("<tr class=\"row.\"  align=\"right\">", $v0[0]);
        echo count($v2);
	for ($guy=1; $guy < (count($v2)); $guy++)
	{
		$v4 = explode("<td ", $v2[$guy]);

		$the_id1 = explode("playerpage/", $v4[1]);
		$the_id2 = explode("/", $the_id1[1]);
		$the_id3 = explode("\">", $the_id2[1]);
		$the_name = explode("<", $the_id3[1]);

		$the_team1 = explode("page/", $v4[3]);
		$the_team2 = explode("/", $the_team1[1]);

		$the_pos1 = explode(">", $v4[2]);
		$the_pos2 = explode("<", $the_pos1[1]);

		for ($stat=4; $stat < 16; $stat++)
		{
			$parsed1 = explode("<", $v4[$stat]);
			$parsed2 = explode(">", $parsed1[0]);
			$parsed[$stat] = $parsed2[1];
		}

		$the_id = $the_id2[0];
		while (strlen($the_id) < 8 )
		{
			$the_id = "0".$the_id;
		}
		$p_id = $the_id;
		$p_team = $the_team2[0];
		$p_full_name = addslashes($the_name[0]);
		$p_pos = $the_pos2[0];
		$p_avg = $parsed[4];			//done
		$p_bat = $parsed[5];			//done
		$p_hit = $parsed[7];			//done
		$p_dble = $parsed[8];			//done
		$p_triple = $parsed[9];			//done
		$p_homer = $parsed[10];			//done
		$p_walk = $parsed[14];			//done
		$p_steal = $parsed[12];			//done
		$p_caught = $parsed[13];		//done
		$p_run = $parsed[6];			//done
		$p_rbi = $parsed[11];			//done
		$p_so = $parsed[15];			//done
		$p_games = 0;					//No longer included in the basic stats
		$p_slugging = $parsed[17];		//done
		$p_on_base = $parsed[16];		//done

		if (($p_pos=="CF") OR ($p_pos=="LF") OR ($p_pos=="RF"))
		{
			$p_pos = "OF";
		}
		
		$populate = mysql_query ("INSERT INTO dick_league_players (id, team, full_name, pos, avg, bat, hit, dble, triple, homer, walk, steal, caught, run, rbi, so, games, slugging, on_base) VALUES('$p_id', '$p_team', '$p_full_name', '$p_pos', '$p_avg', '$p_bat', '$p_hit', '$p_dble', '$p_triple', '$p_homer', '$p_walk', '$p_steal', '$p_caught', '$p_run', '$p_rbi', '$p_so', '$p_games', '$p_slugging', '$p_on_base')");

		$rid = $history_month.$history_date.$p_id;

		$populate_history = mysql_query ("INSERT INTO players_history SET rid = '$rid', month = '$history_month', date = '$history_date', id = '$p_id', team = '$p_team', full_name = '$p_full_name', avg = '$p_avg', bat = '$p_bat', hit = '$p_hit', dble = '$p_dble', triple = '$p_triple', homer = '$p_homer', walk = '$p_walk', steal = '$p_steal', caught = '$p_caught', run = '$p_run', rbi = '$p_rbi', so = '$p_so', games = '$p_games', slugging = '$p_slugging', on_base = '$p_on_base'");
	}
	// Pitchers============================

$theurl = "http://www.cbssports.com/mlb/stats/playersort/MLB/ERAU/ALL/ALL/regularseason/2012?&_1:col_1=15&_1:col_2=15&print_rows=9999";

	$fp = fopen($theurl, "r");
	
	//$player = fread($fp, 200000);
        $player = "";
	while(!feof($fp))
	{
		$output = fgets($fp, 200000);
		$player = $player.$output;
	}
	
	fclose($fp);
	$ex1 = explode(">WHIP</span></a></td></tr>", $player);
	$v0 = explode("<tr class=\"footer pagination\"><td colspan=\"19\">", $ex1[1]);
	$v2 = preg_split("<tr class=\"row.\"  align=\"right\">", $v0[0]);
        echo count($v2);
	for ($guy=1; $guy < (count($v2)); $guy++)
	{
		$v4 = explode("<td ", $v2[$guy]);

		$the_id1 = explode("playerpage/", $v4[1]);
		$the_id2 = explode("/", $the_id1[1]);
		$the_id3 = explode("\">", $the_id2[1]);
		$the_name = explode("<", $the_id3[1]);

		$the_team1 = explode("page/", $v4[3]);
		$the_team2 = explode("/", $the_team1[1]);

		$the_pos1 = explode(">", $v4[2]);
		$the_pos2 = explode("<", $the_pos1[1]);

		for ($stat=4; $stat < 19; $stat++)
		{
			$parsed1 = explode("<", $v4[$stat]);
			$parsed2 = explode(">", $parsed1[0]);
			$parsed[$stat] = $parsed2[1];
		}

		$the_id = $the_id2[0];
		while (strlen($the_id) < 8 )
		{
			$the_id = "0".$the_id;
		}
		$p_id = $the_id;
		$p_team = $the_team2[0];
		$p_full_name = $the_name[0];
		$p_pos = $the_pos2[0];
		$p_games = $parsed[4];			// Done
		$p_era = $parsed[15];			// Done
		$p_win = $parsed[7];			// Done
		$p_loss = $parsed[8];			// Done
		$p_save = $parsed[9];			// Done
		$p_inning = $parsed[6];			// Done
		$p_h = $parsed[11];				// Done
		$p_bb = $parsed[16];			// Done
		$p_k = $parsed[17];				// Done
		$p_hr = $parsed[13];			// Done
		$p_er = $parsed[14];			// Done
		$p_start = $parsed[5];			// Done
		$p_complete = 0;				// No longer included in the basic stats
		$p_shutout = 0;		// No longer included in the basic stats
			
		$populate = mysql_query ("INSERT INTO dick_league_pitchers (id, team, full_name, pos, games, era, win, loss, save, inning, h, bb, k, hr, er, start, complete, shutout) VALUES('$p_id', '$p_team', '$p_full_name', '$p_pos', '$p_games', '$p_era', '$p_win', '$p_loss', '$p_save', '$p_inning', '$p_h', '$p_bb', '$p_k', '$p_hr', '$p_er', '$p_start', '$p_complete', '$p_shutout')");

		$rid = $history_month.$history_date.$p_id;

		$populate_history = mysql_query ("INSERT INTO pitchers_history SET rid = '$rid', month = '$history_month', date = '$history_date', id = '$p_id', team = '$p_team', full_name = '$p_full_name', pos = '$p_pos', games = '$p_games', era = '$p_era', win = '$p_win', loss = '$p_loss', save = '$p_save', inning = '$p_inning', h = '$p_h', bb = '$p_bb', k = '$p_k', hr = '$p_hr', er = '$p_er', start = '$p_start', complete = '$p_complete', shutout = '$p_shutout'");
		
		//echo $p_id."-".$p_team."-".$p_full_name."-".P."-".$p_games."-".$p_era."-".$p_win."-".$p_loss."-".$p_save."-".$p_inning."-".$p_h."-".$p_bb."-".$p_k."-".$p_hr."-".$p_er."-".$p_start."-".$p_complete."-".$p_shutout."<BR>";
	}
	echo "Complete!";
//}

include ("transferdatacbs2.php");


?>