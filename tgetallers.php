<H2>Players</H2>
<TABLE><TR>
<TH>Name</TH><TH>Team</TH><TH>POS</TH><TH>R</TH><TH>H</TH><TH>HR</TH><TH>RBI</TH><TH>SB</TH><TH><FONT COLOR="#ff0000">ERS</FONT></TH>
</TR>
<?PHP
$limit=700;


$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$result = mysql_query ("SELECT ers.id, ers.rating, dick_league_players.id, name, team, pos, run, hit, homer, rbi, steal FROM ers, dick_league_players WHERE dick_league_players.id = ers.id ORDER by ers.rating DESC LIMIT ".$limit);

for ($x=0; $x < mysql_num_rows($result); $x++)
{
	echo "<TR bgcolor='#ccccff'>";
	echo "<TD>".mysql_result($result, $x, 'name')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'team')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'pos')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'run')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'hit')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'homer')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'rbi')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'steal')."</TD>";
	echo "<TD><FONT COLOR='#ff0000'>".mysql_result($result, $x, 'ers.rating')."</FONT></TD>";
	echo "</TR>";
}
?>
</TABLE>
<H2>Pitchers</H2>
<TABLE><TR>
<TH>Name</TH><TH>Team</TH><TH>POS</TH><TH>W</TH><TH>S</TH><TH>K</TH><TH>ER</TH><TH>IP</TH><TH>ERA</TH><TH><FONT COLOR="#ff0000">ERS</FONT></TH>
</TR>
<?PHP

// PITCHERS

$result = mysql_query ("SELECT ers_pitch.id, ers_pitch.rating, dick_league_pitchers.id, name, team, pos, win, save, k, er, inning, era FROM ers_pitch, dick_league_pitchers WHERE dick_league_pitchers.id = ers_pitch.id ORDER by ers_pitch.rating DESC LIMIT ".$limit);

for ($x=0; $x < mysql_num_rows($result); $x++)
{
	echo "<TR bgcolor='#ccccff'>";
	echo "<TD>".mysql_result($result, $x, 'name')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'team')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'pos')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'win')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'save')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'k')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'er')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'inning')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'era')."</TD>";
	echo "<TD><FONT COLOR='#ff0000'>".mysql_result($result, $x, 'ers_pitch.rating')."</FONT></TD>";
	echo "</TR>";
}

mysql_close ($conn);
?>
</TABLE>
