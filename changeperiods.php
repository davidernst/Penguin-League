<HTML>
<HEAD>
<TITLE>Change Periods</TITLE>
</HEAD>
<BODY BGCOLOR="#FFFFFF">
<?PHP

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$result = mysql_query ("SELECT team_id FROM teams");
$result1 = mysql_query ("SELECT * FROM period");

// update wins/losses and points
for ($x=0; $x < mysql_num_rows($result); $x=$x+2)
{
	$x1 = $x+1;
	$y = "team".$x1;
	$one = mysql_result($result1, 0, $y);
	$x2 = $x+2;
	$z = "team".$x2;
	$two = mysql_result($result1, 0, $z);

	$result2 = mysql_query("SELECT run_pts, hit_pts, homer_pts, rbi_pts, steal_pts, win_pts, save_pts, k_pts, era_pts FROM current WHERE id='$one'");

	$result3 = mysql_query("SELECT run_pts, hit_pts, homer_pts, rbi_pts, steal_pts, win_pts, save_pts, k_pts, era_pts FROM current WHERE id='$two'");

	$pts1 = mysql_result($result2, 0, 'run_pts') + mysql_result($result2, 0, 'hit_pts') + mysql_result($result2, 0, 'homer_pts') + mysql_result($result2, 0, 'rbi_pts') + mysql_result($result2, 0, 'steal_pts') + mysql_result($result2, 0, 'win_pts') + mysql_result($result2, 0, 'save_pts') + mysql_result($result2, 0, 'k_pts') + mysql_result($result2, 0, 'era_pts');

	$pts2 = mysql_result($result3, 0, 'run_pts') + mysql_result($result3, 0, 'hit_pts') + mysql_result($result3, 0, 'homer_pts') + mysql_result($result3, 0, 'rbi_pts') + mysql_result($result3, 0, 'steal_pts') + mysql_result($result3, 0, 'win_pts') + mysql_result($result3, 0, 'save_pts') + mysql_result($result3, 0, 'k_pts') + mysql_result($result3, 0, 'era_pts');


	if ($pts1 > $pts2) {
		$result4 = mysql_query ("SELECT wins, total_points FROM teams WHERE team_id = '$one'");
		$result5 = mysql_query ("SELECT losses, total_points FROM teams WHERE team_id = '$two'");

		$w = mysql_result($result4, 0, 'wins');
		$l = mysql_result($result5, 0, 'losses');
		$p1 = mysql_result($result4, 0, 'total_points');
		$p2 =  mysql_result($result5, 0, 'total_points');
		
		$wnew = $w + 1;
		$lnew = $l + 1;
		$p1new = $p1 + $pts1;
		$p2new = $p2 + $pts2;
		
		mysql_query ("UPDATE teams SET wins= '$wnew', total_points = '$p1new' WHERE team_id = '$one'");

		mysql_query ("UPDATE teams SET losses= '$lnew', total_points = '$p2new' WHERE team_id = '$two'");

	} else {

		$result4 = mysql_query ("SELECT losses, total_points FROM teams WHERE team_id = '$one'");
		$result5 = mysql_query ("SELECT wins, total_points FROM teams WHERE team_id = '$two'");

		$l = mysql_result($result4, 0, 'losses');
		$w = mysql_result($result5, 0, 'wins');
		$p1 = mysql_result($result4, 0, 'total_points');
		$p2 =  mysql_result($result5, 0, 'total_points');
		
		$lnew = $l + 1;
		$wnew = $w + 1;
		$p1new = $p1 + $pts1;
		$p2new = $p2 + $pts2;
		
		mysql_query ("UPDATE teams SET losses= '$lnew', total_points = '$p1new' WHERE team_id = '$one'");

		mysql_query ("UPDATE teams SET wins= '$wnew', total_points = '$p2new' WHERE team_id = '$two'");
	}
	
}

mysql_query ("DELETE FROM old_players");
mysql_query ("INSERT old_players SELECT * FROM dick_league_players") or die (mysql_error());
mysql_query ("DELETE FROM old_pitchers");
mysql_query ("INSERT old_pitchers SELECT * FROM dick_league_pitchers") or die (mysql_error());


mysql_close($conn);

echo "<script language='javascript'>\n";
// echo "<!-\n";
echo "location.replace('periodstart.html')\n";
// echo "-->\n";
echo "</script>";
?>

</BODY>
</HTML>




