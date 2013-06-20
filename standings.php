<?php

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$result = mysql_query ("SELECT team_id, team_name, wins, losses, total_points FROM teams ORDER by wins DESC, total_points DESC");
echo "<TABLE border=0>";
echo "<TH>#</TH><TH>Team</TH><TH>W</TH><TH>L</TH><TH>Points</TH>";
for ($x=0; $x < mysql_num_rows($result); $x++)
{
	echo "<TR bgcolor='#ccccff'>";
	echo "<TD>".mysql_result($result, $x, 'team_id')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'team_name')."</TD>";
	echo "<TD align=right>".mysql_result($result, $x, 'wins')."</TD>";
	echo "<TD align=right>".mysql_result($result, $x, 'losses')."</TD>";
	echo "<TD align=right>".mysql_result($result, $x, 'total_points')."</TD>";
}

echo "</TABLE>";
?>
