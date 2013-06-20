<?php
$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$all_positions = mysql_query ("SELECT * FROM positions ORDER BY number");

$set_to_non_active = mysql_query ("UPDATE player_rosters SET active = 0 WHERE team_id = ".$dick_team);
$set_to_non_active2 = mysql_query ("UPDATE pitcher_rosters SET active = 0 WHERE team_id = ".$dick_team);

// Infield
for ($p=0; $p < (mysql_num_rows($all_positions)-3); $p++)
{
	$the_position = mysql_result($all_positions, $p, 'position');
	$doit = mysql_query ("UPDATE player_rosters SET active = 1 WHERE player_id = ".$$the_position);
}

// OF
for ($p=0; $p < 20; $p++)
{
	if ($of[$p]!="")
	{
		$doit = mysql_query ("UPDATE player_rosters SET active = 1 WHERE player_id = ".$of[$p]);
	}
}

// DH
$doit = mysql_query ("UPDATE player_rosters SET active = 2 WHERE player_id = ".$dh);

// SP
for ($p=0; $p < 20; $p++)
{
	if ($sp[$p]!="")
	{
		$doit = mysql_query ("UPDATE pitcher_rosters SET active = 1 WHERE player_id = ".$sp[$p]);
	}
}

// RP
for ($p=0; $p < 20; $p++)
{
	if ($rp[$p]!="")
	{
		$doit = mysql_query ("UPDATE pitcher_rosters SET active = 1 WHERE player_id = ".$rp[$p]);
	}
}

mysql_close ($conn);

echo "<script language='javascript'>\n";
// echo "<!-\n";
echo "location.replace('control.php')\n";
// echo "-->\n";
echo "</script>";


?>