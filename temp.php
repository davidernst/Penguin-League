<?php

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$result = mysql_query("SELECT * FROM temp3");

for ($x=10000; $x < 20000; $x++)
{
$rid = mysql_result($result, $x, 'rid');
$month = mysql_result($result, $x, 'month');
$date = mysql_result($result, $x, 'date');
		$p_id = mysql_result($result, $x, 'id');
		$p_team = mysql_result($result, $x, 'team');
		$p_full_name = mysql_result($result, $x, 'full_name');
		$p_pos = mysql_result($result, $x, 'pos');
		$p_avg = mysql_result($result, $x, 'avg');
		$p_bat = mysql_result($result, $x, 'bat');
		$p_hit = mysql_result($result, $x, 'hit');
		$p_dble = mysql_result($result, $x, 'dble');
		$p_triple = mysql_result($result, $x, 'triple');
		$p_homer = mysql_result($result, $x, 'homer');
		$p_walk = mysql_result($result, $x, 'walk');
		$p_steal = mysql_result($result, $x, 'steal');
		$p_caught = mysql_result($result, $x, 'caught');
		$p_run = mysql_result($result, $x, 'run');
		$p_rbi = mysql_result($result, $x, 'rbi');
		$p_so = mysql_result($result, $x, 'so');
		$p_games = mysql_result($result, $x, 'games');
		$p_slugging = mysql_result($result, $x, 'slugging');
		$p_on_base = mysql_result($result, $x, 'on_base');

		$populate_history = mysql_query ("INSERT IGNORE players_history SET rid = '$rid', month = '$month', date = '$date', id = '$p_id', team = '$p_team', full_name = '$p_full_name', avg = '$p_avg', bat = '$p_bat', hit = '$p_hit', dble = '$p_dble', triple = '$p_triple', homer = '$p_homer', walk = '$p_walk', steal = '$p_steal', caught = '$p_caught', run = '$p_run', rbi = '$p_rbi', so = '$p_so', games = '$p_games', slugging = '$p_slugging', on_base = '$p_on_base'");
	
}
?>