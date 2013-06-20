<html><head></head><body bgcolor="#FFFFFF">

<?php
	$conn = mysql_connect ("db2.hostme.com", "digithos", "p2Rm4Igo");
  	if (!$conn) {
  		echo "An error occurred in connection.\n";
  		exit;
  	}
  	mysql_select_db ("digithos");
  	
  	$result = mysql_query ("SELECT player_id, team_id, active from player_rosters where active='1' order by team_id");
	
	for ($x=0; $x < mysql_num_rows($result); $x++)
	{
		$the_id = mysql_result($result, $x, "player_id");
		$result2 = mysql_query ("SELECT id, name, hit, homer, steal, run, rbi from dick_league_players where id='".$the_id."'");
		$team = mysql_result($result, $x, "team_id");
		$name = mysql_result($result2, 0, "name");
		$hit = mysql_result($result2, 0, "hit");
		$run = mysql_result($result2, 0, "run");
		$homer = mysql_result($result2, 0, "homer");
		$rbi = mysql_result($result2, 0, "rbi");
		$steal = mysql_result($result2, 0, "steal");
		echo $team.",".$name.",".$the_id.",".$run.",".$hit.",".$homer.",".$rbi.",".$steal."<BR>";
	}




?>
</body></html>