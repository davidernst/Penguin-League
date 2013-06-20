<?php

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$teamresult = mysql_query ("SELECT team_id, team_name FROM teams ORDER BY team_id");

//$actions = array("none", "DROP", "DROP", "ADD", "ADD", "TRADE", "TRADE");
for ($x=0; $x < mysql_num_rows($teamresult); $x++)
{

	$theid = mysql_result($teamresult, $x, 'team_id');
	$theteam = mysql_result($teamresult, $x, 'team_name');
	$result = mysql_query ("SELECT * FROM period_changes WHERE team_id = '$theid'");
	echo $theteam."<BR>";
	echo "<TABLE><TR><TH>Date</TH><TH>Drop</TH><TH>Add</TH></TR>";
	for ($y=0; $y < mysql_num_rows($result); $y++)
	{
		$drop_action = mysql_result($result, $y, 'drop_action');
		$drop_player = mysql_result($result, $y, 'drop_player');
		$the_date = mysql_result($result, $y, 'date_stamp');
		$year = substr($the_date, 0, 4);
		$month = substr($the_date, 4, 2);
		$day = substr($the_date, 6, 2);
		$date_data = mktime(0,0,0,$month, $day, $year);
		$formatted_date = date("M d", $date_data);
		$add_action = mysql_result($result, $y, 'add_action');
		$add_player = mysql_result($result, $y, 'add_player');
		
		if ($drop_action = "1")
		{
			$drop_result = mysql_query ("SELECT full_name, team FROM dick_league_players WHERE id = '$drop_player'");
		} else {
			$drop_result = mysql_query ("SELECT full_name, team FROM dick_league_pitchers WHERE id = '$drop_player'");
		}
		
		if ($add_action = "1")
		{
			$add_result = mysql_query ("SELECT full_name, team FROM dick_league_players WHERE id = '$add_player'");
		} else {
			$add_result = mysql_query ("SELECT full_name, team FROM dick_league_pitchers WHERE id = '$add_player'");
		}

		$drop_player_info = mysql_result($drop_result, 0, 'full_name')." (".mysql_result($drop_result, 0, 'team').")";
		$add_player_info = mysql_result($add_result, 0, 'full_name')." (".mysql_result($add_result, 0, 'team').")";

		echo "<TR bgcolor='#ccccff'>";
		echo "<TD>".$formatted_date."</TD>";
		echo "<TD>".$drop_player_info."</TD>";
		echo "<TD>".$add_player_info."</TD>";
		echo "</TR>";
	}
	echo "</TABLE>";
	echo "<P>";
}
?>
