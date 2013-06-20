<?PHP

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

mysql_query ("DELETE FROM ers");
mysql_query ("DELETE FROM ers_pitch");

$result4 = mysql_query ("SELECT first FROM period");
$period = mysql_result($result4, 0, 'first');

if ($period == 0) {
	// HITTERS' ERS
	// QUERY FOR ERS YEAR-LONG CALCULATION

	$result = mysql_query ("SELECT max(run) as mrun, max(hit+walk) as mhit, max(homer) as mhomer, max(rbi) as mrbi, max(steal) as msteal FROM dick_league_players");
} else {

	// HITTERS' ERS
	// QUERY FOR ERS PERIOD-SPECIFIC CALCULATION

	$result = mysql_query ("SELECT max(dick_league_players.run-old_players.run) as mrun, max((dick_league_players.hit+dick_league_players.walk)-(old_players.hit+old_players.walk)) as mhit, max(dick_league_players.homer-old_players.homer) as mhomer, max(dick_league_players.rbi-old_players.rbi) as mrbi, max(dick_league_players.steal-old_players.steal) as msteal FROM dick_league_players, old_players");
}

$mrun=mysql_result($result, 0, 'mrun');
$mhit=mysql_result($result, 0, 'mhit');
$mhomer=mysql_result($result, 0, 'mhomer');
$mrbi=mysql_result($result, 0, 'mrbi');
$msteal=mysql_result($result, 0, 'msteal');

$resultx = mysql_query ("SELECT player_id FROM player_rosters");

for ($x=0; $x < mysql_num_rows($resultx); $x++)
{
	$player_id = mysql_result($resultx, $x, 'player_id');

	$result2 = mysql_query ("SELECT id, run, hit, walk, homer, rbi, steal FROM dick_league_players WHERE id=$player_id");

	$id = mysql_result($result2, 0, 'id');
	$run = mysql_result($result2, 0, 'run');
	$hit = mysql_result($result2, 0, 'hit');
	$walk = mysql_result($result2, 0, 'walk');
	$homer = mysql_result($result2, 0, 'homer');
	$rbi = mysql_result($result2, 0, 'rbi');
	$steal = mysql_result($result2, 0, 'steal');

	$ers = 100*(($run/$mrun) + (($hit+$walk)/$mhit) + ($homer/$mhomer) + ($rbi/$mrbi) + ($steal/$msteal));

	mysql_query ("UPDATE player_rosters SET ers = '$ers' WHERE player_id='$player_id'");
}

// PITCHERS' ERS
if ($period == 0) {
	$result = mysql_query ("SELECT max(dick_league_pitchers.win-old_pitchers.win) as mwin, max(dick_league_pitchers.save-old_pitchers.save) as msave, max(dick_league_pitchers.k-old_pitchers.k) as mk, max((dick_league_pitchers.inning-old_pitchers.inning)/sqrt(dick_league_pitchers.er-old_pitchers.er)) as mera FROM dick_league_pitchers, old_pitchers");
} else {
	$result = mysql_query ("SELECT max(win) as mwin, max(save) as msave, max(k) as mk, max(inning/sqrt(er)) as mera FROM dick_league_pitchers");
}

echo mysql_num_rows($result)." ";
	$mwin=mysql_result($result, 0, 'mwin');
	$msave=mysql_result($result, 0, 'msave');
	$mk=mysql_result($result, 0, 'mk');
	$mera=mysql_result($result, 0, 'mera');

echo mysql_num_rows($result2);

$resultx = mysql_query ("SELECT player_id FROM pitcher_rosters");

for ($x=0; $x < mysql_num_rows($resultx); $x++)
{
	$player_id = mysql_result($resultx, $x, 'player_id');

	$result2 = mysql_query ("SELECT id, win, save, k, (inning/sqrt(er)) as pera FROM dick_league_pitchers WHERE id=$player_id");

	$id = mysql_result($result2, 0, 'id');
	$win = mysql_result($result2, 0, 'win');
	$save = mysql_result($result2, 0, 'save');
	$k = mysql_result($result2, 0, 'k');
	$era = mysql_result($result2, 0, 'pera');

	$ers = 100*(($win/$mwin) + ($save/$msave) + ($k/$mk) + ($pera/$mera));

	mysql_query ("UPDATE pitcher_rosters SET ers = '$ers' WHERE player_id='$player_id'");
}

mysql_close ($conn);
?>
