<?php

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$result = mysql_query ("SELECT team_id, team_name, team_owner, team_owner2, email, email2 FROM teams");
echo "<TABLE border=0 WIDTH='100%'>";
for ($x=0; $x < mysql_num_rows($result); $x++)
{
	echo "<TR bgcolor='#ccccff'>";
	echo "<TD>".mysql_result($result, $x, 'team_id')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'team_name')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'team_owner')."<BR>";
	echo mysql_result($result, $x, 'team_owner2')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'email')."<BR>";
	echo mysql_result($result, $x, 'email2')."</TD></TR>";
}

echo "</TABLE>";
?>
