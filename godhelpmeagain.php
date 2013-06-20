<html><head></head><body bgcolor="#FFFFFF">

<?php
	$conn = mysql_connect ("db2.hostme.com", "digithos", "p2Rm4Igo");
  	if (!$conn) {
  		echo "An error occurred in connection.\n";
  		exit;
  	}
  	mysql_select_db ("digithos");
  	
  	$result = mysql_query ("SELECT player_id, team_id, active from pitcher_rosters where active='1' order by team_id");
	
	for ($x=0; $x < mysql_num_rows($result); $x++)
	{
		$the_id = mysql_result($result, $x, "player_id");
		$result2 = mysql_query ("SELECT id, name, win, save, inning, k, er from dick_league_pitchers where id='".$the_id."'");
		$team = mysql_result($result, $x, "team_id");
		$name = mysql_result($result2, 0, "name");
		$win = mysql_result($result2, 0, "win");
		$save = mysql_result($result2, 0, "save");
		$inning = mysql_result($result2, 0, "inning");
		$k = mysql_result($result2, 0, "k");
		$er = mysql_result($result2, 0, "er");
		echo $team.",".$name.",".$the_id.",".$win.",".$save.",".$inning.",".$k.",".$er."<BR>";
	}




?>
</body></html>