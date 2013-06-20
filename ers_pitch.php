<?PHP

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

mysql_query ("DELETE FROM ers");
mysql_query ("DELETE FROM ers_pitch");

// HITTERS' ERS
$result = mysql_query ("SELECT max(run) as mrun, max(hit+walk) as mhit, max(homer) as mhomer, max(rbi) as mrbi, max(steal) as msteal FROM dick_league_players");

$mrun=mysql_result($result, 0, 'mrun');
$mhit=mysql_result($result, 0, 'mhit');
$mhomer=mysql_result($result, 0, 'mhomer');
$mrbi=mysql_result($result, 0, 'mrbi');
$msteal=mysql_result($result, 0, 'msteal');

$result2 = mysql_query ("SELECT id, run, hit, walk, homer, rbi, steal FROM dick_league_players");

for ($x=0; $x < mysql_num_rows($result2); $x++)
{
	$id = mysql_result($result2, $x, 'id');
	$run = mysql_result($result2, $x, 'run');
	$hit = mysql_result($result2, $x, 'hit');
	$hit = mysql_result($result2, $x, 'walk');
	$homer = mysql_result($result2, $x, 'homer');
	$rbi = mysql_result($result2, $x, 'rbi');
	$steal = mysql_result($result2, $x, 'steal');

	$ers = 100*(($run/$mrun) + ($hit/$mhit) + ($homer/$mhomer) + ($rbi/$mrbi) + ($steal/$msteal));

	mysql_query ("INSERT INTO ers SET id = '$id', rating = '$ers'");
}

// PITCHERS' ERS

$result = mysql_query ("SELECT max(win) as mwin, max(save) as msave, max(k) as mk, max(inning/sqrt(er)) as mera FROM dick_league_pitchers");

echo mysql_num_rows($result)." ";

$mwin=mysql_result($result, 0, 'mwin');
$msave=mysql_result($result, 0, 'msave');
$mk=mysql_result($result, 0, 'mk');
$mera=mysql_result($result, 0, 'mera');

echo mysql_num_rows($result2);

$result2 = mysql_query ("SELECT id, win, save, k, (inning/sqrt(er)) as pera FROM dick_league_pitchers");

for ($x=0; $x < mysql_num_rows($result2); $x++)
{
	$id = mysql_result($result2, $x, 'id');
	$win = mysql_result($result2, $x, 'win');
	$save = mysql_result($result2, $x, 'save');
	$k = mysql_result($result2, $x, 'k');
	$era = mysql_result($result2, $x, 'pera');

	$ers = 100*(($win/$mwin) + ($save/$msave) + ($k/$mk) + ($pera/$mera));

	mysql_query ("INSERT INTO ers_pitch SET id = '$id', rating = '$ers'");
}

mysql_close ($conn);
?>
