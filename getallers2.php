
<TABLE>
<font size='1'>
<TR>
<TH>Name</TH><TH>Team</TH><TH>POS</TH><TH>R</TH><TH>H+BB</TH><TH>HR</TH><TH>RBI</TH><TH>SB</TH><TH><FONT COLOR="#ff0000">ERS</FONT></TH>
</TR>
<?PHP
$limit=700;


$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$result = mysql_query ("SELECT ers.id, ers.rating, dick_league_players.id, full_name, team, pos, bat, run, hit, walk, homer, rbi, steal FROM ers, dick_league_players WHERE dick_league_players.id = ers.id ORDER by ers.rating DESC LIMIT ".$limit);

for ($x=0; $x < mysql_num_rows($result); $x++)
{

$id = mysql_result($result, $x, 'ers.id');
$result2 = mysql_query ("SELECT player_id, position FROM player_rosters WHERE player_rosters.player_id = '$id'");

if (mysql_num_rows($result2) > 0) {
	$color = "#000000";
	$position = mysql_result($result2, 0, 'position');

} else {
	$color = "#ff0000";
	$position = mysql_result($result, $x, 'pos');
}

	$hitwalk = mysql_result($result, $x, 'hit') + mysql_result($result, $x, 'walk');

	echo "<TR bgcolor='#ccccff'>";
	echo "<TD><FONT COLOR=".$color.">".mysql_result($result, $x, 'full_name')."</COLOR></TD>";
	echo "<TD>".mysql_result($result, $x, 'team')."</TD>";
	echo "<TD>".$position."</TD>";
	echo "<TD>".mysql_result($result, $x, 'run')/mysql_result($result, $x, 'bat')."</TD>";
	echo "<TD>".$hitwalk."</TD>";
	echo "<TD>".mysql_result($result, $x, 'homer')/mysql_result($result, $x, 'bat')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'rbi')/mysql_result($result, $x, 'bat')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'steal')/mysql_result($result, $x, 'bat')."</TD>";
	echo "<TD><FONT COLOR='#ff0000'>".mysql_result($result, $x, 'ers.rating')/mysql_result($result, $x, 'bat')."</FONT></TD>";
	echo "</TR>";
}

?>
</font>
</TABLE>

<TABLE>
<font size='1'>
<TR>
<TH>Name</TH><TH>Team</TH><TH>POS</TH><TH>W</TH><TH>S</TH><TH>K</TH><TH>ER</TH><TH>IP</TH><TH>ERA</TH><TH><FONT COLOR="#ff0000">ERS</FONT></TH>
</TR>
<?PHP

// PITCHERS

$result = mysql_query ("SELECT ers_pitch.id, ers_pitch.rating, dick_league_pitchers.id, full_name, team, pos, win, save, k, er, inning, era FROM ers_pitch, dick_league_pitchers WHERE dick_league_pitchers.id = ers_pitch.id ORDER by ers_pitch.rating DESC LIMIT ".$limit);

for ($x=0; $x < mysql_num_rows($result); $x++)
{

$id = mysql_result($result, $x, 'ers_pitch.id');
$result2 = mysql_query ("SELECT player_id, position FROM pitcher_rosters WHERE pitcher_rosters.player_id = '$id'");

if (mysql_num_rows($result2) > 0) {
	$color = "#000000";
	$position = mysql_result($result2, 0, 'position');
} else {
	$color = "#ff0000";
	$position = mysql_result($result, $x, 'pos');
}
	echo "<TR bgcolor='#ccccff'>";
	echo "<TD><FONT COLOR=".$color.">".mysql_result($result, $x, 'full_name')."</COLOR></TD>";
	echo "<TD>".mysql_result($result, $x, 'team')."</TD>";
	echo "<TD>".$position."</TD>";
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
</font>
</TABLE>
</font>
