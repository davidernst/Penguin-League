<?PHP

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

// dick_team, player, team

$result = mysql_query ("INSERT INTO period_changes SET team_id='$dick_team', id='$player', action='5', trade_team='$team'");

mysql_close($conn);


echo "<script language='javascript'>\n";
// echo "<!-\n";
echo "location.replace('control.php')\n";
// echo "-->\n";
echo "</script>";

?>