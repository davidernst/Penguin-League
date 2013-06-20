<?PHP

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

// actions: 1 = player
//			2 = pitcher

// dick_team, drop_player, drop_pitcher, add_player, add_pitcher, position

if ($drop_player == "X")
{
	$drop_action = 2;
	$player_to_drop = $drop_pitcher;
} else {
	$drop_action = 1;
	$player_to_drop = $drop_player;
}

if ($add_player == "X")
{
	$add_action = 2;
	$player_to_add = $add_pitcher;
} else {
	$add_action = 1;
	$player_to_add = $add_player;
}


$result = mysql_query ("INSERT INTO period_changes SET team_id='$dick_team', drop_player='$player_to_drop', add_player='$player_to_add', drop_action='$drop_action', add_action='$add_action', position='$position'");

mysql_close($conn);


echo "<script language='javascript'>\n";
// echo "<!-\n";
echo "location.replace('control.php')\n";
// echo "-->\n";
echo "</script>";


/*
+-------------+--------------+------+-----+---------+-------+
| Field       | Type         | Null | Key | Default | Extra |
+-------------+--------------+------+-----+---------+-------+
| team_id     | smallint(6)  | YES  |     | NULL    |       |
| drop_player | varchar(10)  | YES  |     | NULL    |       |
| add_player  | varchar(10)  | YES  |     | NULL    |       |
| drop_action | smallint(6)  | YES  |     | NULL    |       |
| add_action  | smallint(6)  | YES  |     | NULL    |       |
| trade_team  | smallint(6)  | YES  |     | NULL    |       |
| position    | char(2)      | YES  |     | NULL    |       |
| date_stamp  | timestamp(8) | YES  |     | NULL    |       |
+-------------+--------------+------+-----+---------+-------+
*/
?>