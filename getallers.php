<TABLE>
<font size='1'>
<TR>
<TH><a href="getallers.php?sortfield=full_name">Name</a></TH><TH><a href="getallers.php?sortfield=team">Team</a></TH><TH><a href="getallers.php?sortfield=pos,ersbat">POS</a></TH><TH><FONT COLOR='#0000FF'><a href="getallers.php?sortfield=games">G</a></FONT></TH><TH><FONT COLOR='#0000FF'><a href="getallers.php?sortfield=bat">AB</a></FONT></TH><TH><a href="getallers.php?sortfield=run">R</a></TH><TH>H+BB</TH><TH><a href="getallers.php?sortfield=homer">HR</a></TH><TH><a href="getallers.php?sortfield=rbi">RBI</a></TH><TH><a href="getallers.php?sortfield=steal">SB</a></TH><TH><FONT COLOR="#ff0000"><a href="getallers.php?sortfield=ers.rating">ERS</a></FONT></TH><TH><FONT COLOR='#0000FF'><a href="getallers.php?sortfield=ersgames">ERS/G</a></FONT></TH><TH><FONT COLOR='#0000FF'><a href="getallers.php?sortfield=ersbat">ERS/AB</a></FONT></TH>
</TR>
<?PHP
$limit=2000;


$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

?>
<TABLE>
<font size='1'>
<TR>
<TH>Name</TH><TH>Team</TH><TH>POS</TH><TH><FONT COLOR='#0000FF'>Starts</FONT></TH><TH>W</TH><TH>S</TH><TH>K</TH><TH>ER</TH><TH>IP</TH><TH>ERA</TH><TH><FONT COLOR="#ff0000">ERS</FONT></TH><TH><FONT COLOR='#0000FF'>ERS/Start</FONT></TH>
</TR>
<?PHP

// PITCHERS

$result = mysql_query ("SELECT ers_pitch.id, ers_pitch.rating, dick_league_pitchers.id, full_name, team, pos, win, save, k, er, inning, era, start, ers_pitch.rating/start AS ersstart FROM ers_pitch, dick_league_pitchers WHERE dick_league_pitchers.id = ers_pitch.id ORDER by pos, ers_pitch.rating DESC LIMIT ".$limit);

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
	echo "<TD><FONT COLOR='#0000FF'>".mysql_result($result, $x, 'start')."</FONT></TD>";
	echo "<TD>".mysql_result($result, $x, 'win')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'save')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'k')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'er')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'inning')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'era')."</TD>";
	echo "<TD><FONT COLOR='#ff0000'>".mysql_result($result, $x, 'ers_pitch.rating')."</FONT></TD>";
	echo "<TD><FONT COLOR='#0000FF'>".mysql_result($result, $x, 'ersstart')."</FONT></TD>";

	echo "</TR>";
}

mysql_close ($conn);
?>
</font>
</TABLE>
</font>
