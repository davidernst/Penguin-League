<table border=0>
<th>Game</th><th>Matchup</th>
<tr bgcolor='#ccccff'>
<td>GAME 1: Sun. Mar. 31 – Sun. Apr. 21</td>
<td>1 vs. 2; 3 vs. 4; 5 vs. 6; 7 vs. 8; 9 vs. 10</td>
</tr>
<tr bgcolor='#ccccff'>
<td>GAME 2: Mon. April 22 — Thur. May 11</td>
<td>1 vs. 3; 2 vs. 4; 5 vs. 8; 6 vs. 9; 7 vs. 10</td>
</tr>
<tr bgcolor='#ccccff'>
<td>GAME 3: Fri. May 12 — Thur. May 30</td>
<td>1 vs. 4; 2 vs. 5; 3 vs.10; 6 vs. 8; 7 vs. 9</td>
</tr>
<tr bgcolor='#ccccff'>
<td>GAME 4: Fri. May 31 — Wed. June 19</td>
<td>1 vs. 5; 2 vs. 6; 3 vs. 9; 4 vs. 7; 8 vs. 10</td>
</tr>
<tr bgcolor='#ccccff'>
<td>GAME 5: Thur. June 20 - Thur. July 9</td>
<td>1 vs. 6; 2 vs. 7; 3 vs. 8; 4 vs.10; 5 vs. 9</td>
</tr>
<tr bgcolor='#ccccff'>
<td>GAME 6: Fri. July 10 — Thur. August 1</td>
<td>1 vs. 7; 2 vs. 8; 3 vs. 6; 4 vs. 9; 5 vs. 10</td>
</tr>
<tr bgcolor='#ccccff'>
<td>GAME 7: Fri. Aug. 2 - Wed. Aug. 21</td>
<td>1 vs. 8; 2 vs. 9; 3 vs. 7; 4 vs. 5; 6 vs. 10</td>
</tr>
<tr bgcolor='#ccccff'>
<td>GAME 8: Thur. Aug. 22 - Tues. Sep. 10</td>
<td>1 vs. 9; 2 vs.10; 3 vs. 5; 4 vs. 8; 6 vs. 7</td>
</tr>
<tr bgcolor='#ccccff'>
<td>GAME 9: Wed. Sep. 11 - Sat. Sep. 29</td>
<td>1 vs.10; 2 vs. 3; 4 vs. 6; 5 vs. 7; 9 vs. 8</td>
</tr>
</table>
<p>
<b>Post-Season Gala:</b> Saturday, October 26, 2013
<p>
<?php

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$result = mysql_query ("SELECT team_id, team_name FROM teams ORDER by team_id");


echo "<TABLE border=0>";
echo "<TH>#</TH><TH>Team</TH>";
for ($x=0; $x < mysql_num_rows($result); $x++)
{
	echo "<TR bgcolor='#ccccff'>";
	echo "<TD>".mysql_result($result, $x, 'team_id')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'team_name')."</TD>";
}

echo "</TABLE>";
