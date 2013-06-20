<TABLE><TR VALIGN='top'><TD>
<H2>Players</H2>
<TABLE><TR>
<TH>Name</TH><TH>Team</TH><TH>POS</TH><TH>R</TH><TH>H+BB</TH><TH>HR</TH><TH>RBI</TH><TH>SB</TH><TH><FONT COLOR="#ff0000">ERS</FONT></TH>
</TR>
<?PHP
$limit=20;


$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

//$result = mysql_query ("SELECT ers.id, ers.rating, dick_league_players.id, full_name, team, pos, run, hit, walk, homer, rbi, steal FROM ers, dick_league_players WHERE dick_league_players.id = ers.id ORDER by ers.rating DESC LIMIT ".$limit);

$result = mysql_query ("SELECT player_rosters.player_id, player_rosters.ers, player_rosters.position, dick_league_players.id, full_name, team, pos, run, hit, walk, homer, rbi, steal FROM player_rosters, dick_league_players WHERE dick_league_players.id = player_rosters.player_id ORDER by player_rosters.ers DESC LIMIT ".$limit);

for ($x=0; $x < mysql_num_rows($result); $x++)
{
	$the_id = mysql_result($result, $x, 'id');

	$position = mysql_result($result, 0, 'position');

	$hitwalk = mysql_result($result, $x, 'hit') + mysql_result($result, $x, 'walk');
	echo "<TR bgcolor='#ccccff'>";
	echo "<TD>".mysql_result($result, $x, 'full_name')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'team')."</TD>";
	echo "<TD>".$position."</TD>";
	echo "<TD ALIGN='RIGHT'>".mysql_result($result, $x, 'run')."</TD>";
	echo "<TD ALIGN='RIGHT'>".$hitwalk."</TD>";
	echo "<TD ALIGN='RIGHT'>".mysql_result($result, $x, 'homer')."</TD>";
	echo "<TD ALIGN='RIGHT'>".mysql_result($result, $x, 'rbi')."</TD>";
	echo "<TD ALIGN='RIGHT'>".mysql_result($result, $x, 'steal')."</TD>";
	echo "<TD ALIGN='RIGHT'><FONT COLOR='#ff0000'>".mysql_result($result, $x, 'player_rosters.ers')."</FONT></TD>";
	echo "</TR>";
}
?>
</TABLE>
</TD><TD>
<H2>Starting Pitchers</H2>
<TABLE><TR>
<TH>Name</TH><TH>Team</TH><TH>POS</TH><TH>W</TH><TH>S</TH><TH>K</TH><TH>ER</TH><TH>IP</TH><TH>ERA</TH><TH><FONT COLOR="#ff0000">ERS</FONT></TH>
</TR>
<?PHP

// STARTING PITCHERS

$result = mysql_query ("SELECT pitcher_rosters.player_id, pitcher_rosters.ers, dick_league_pitchers.id, full_name, team, pitcher_rosters.position, win, save, k, er, inning, era FROM pitcher_rosters, dick_league_pitchers WHERE dick_league_pitchers.id = pitcher_rosters.player_id AND pitcher_rosters.position = 'SP' ORDER by pitcher_rosters.ers DESC LIMIT ".$limit);

for ($x=0; $x < mysql_num_rows($result); $x++)
{
	$the_id = mysql_result($result, $x, 'id');

	$position = mysql_result($result, 0, 'position');


	echo "<TR bgcolor='#ccccff'>";
	echo "<TD>".mysql_result($result, $x, 'full_name')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'team')."</TD>";
	echo "<TD>".$position."</TD>";
	echo "<TD ALIGN='RIGHT'>".mysql_result($result, $x, 'win')."</TD>";
	echo "<TD ALIGN='RIGHT'>".mysql_result($result, $x, 'save')."</TD>";
	echo "<TD ALIGN='RIGHT'>".mysql_result($result, $x, 'k')."</TD>";
	echo "<TD ALIGN='RIGHT'>".mysql_result($result, $x, 'er')."</TD>";
	echo "<TD ALIGN='RIGHT'>".number_format(mysql_result($result, $x, 'inning'),1)."</TD>";
	echo "<TD ALIGN='RIGHT'>".mysql_result($result, $x, 'era')."</TD>";
	echo "<TD ALIGN='RIGHT'><FONT COLOR='#ff0000'>".mysql_result($result, $x, 'pitcher_rosters.ers')."</FONT></TD>";
	echo "</TR>";
}

?>
</TABLE>
</TD><TD>
<H2>Relief Pitchers</H2>
<TABLE><TR>
<TH>Name</TH><TH>Team</TH><TH>POS</TH><TH>W</TH><TH>S</TH><TH>K</TH><TH>ER</TH><TH>IP</TH><TH>ERA</TH><TH><FONT COLOR="#ff0000">ERS</FONT></TH>
</TR>
<?PHP

// RELIEF PITCHERS

$result = mysql_query ("SELECT pitcher_rosters.player_id, pitcher_rosters.ers, dick_league_pitchers.id, full_name, team, pitcher_rosters.position, win, save, k, er, inning, era FROM dick_league_pitchers, pitcher_rosters WHERE dick_league_pitchers.id = pitcher_rosters.player_id AND pitcher_rosters.position = 'RP' ORDER by pitcher_rosters.ers DESC LIMIT ".$limit);

for ($x=0; $x < mysql_num_rows($result); $x++)
{
	$the_id = mysql_result($result, $x, 'id');

	$position = mysql_result($result, 0, 'position');


	echo "<TR bgcolor='#ccccff'>";
	echo "<TD>".mysql_result($result, $x, 'full_name')."</TD>";
	echo "<TD>".mysql_result($result, $x, 'team')."</TD>";
	echo "<TD>".$position."</TD>";
	echo "<TD ALIGN='RIGHT'>".mysql_result($result, $x, 'win')."</TD>";
	echo "<TD ALIGN='RIGHT'>".mysql_result($result, $x, 'save')."</TD>";
	echo "<TD ALIGN='RIGHT'>".mysql_result($result, $x, 'k')."</TD>";
	echo "<TD ALIGN='RIGHT'>".mysql_result($result, $x, 'er')."</TD>";
	echo "<TD ALIGN='RIGHT'>".number_format(mysql_result($result, $x, 'inning'),1)."</TD>";
	echo "<TD ALIGN='RIGHT'>".mysql_result($result, $x, 'era')."</TD>";
	echo "<TD ALIGN='RIGHT'><FONT COLOR='#ff0000'>".mysql_result($result, $x, 'pitcher_rosters.ers')."</FONT></TD>";
	echo "</TR>";
}

mysql_close ($conn);
?>
</TABLE>
</TD></TR></TABLE>