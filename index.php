<table border=0>
<TR><TH>#</TH><TH>Team</TH><TH>R</TH><TH>H+BB</TH><TH>HR</TH><TH>RBI</TH><TH>SB</TH><TH>W</TH><TH>S</TH><TH>K</TH><TH>ERA</TH><TH>PTS</TH><TH colspan=2>ERS</TH></TR>
<?PHP

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$result = mysql_query ("SELECT team_id, team_name FROM teams");

$cnt = 1;

for ($x=0; $x < mysql_num_rows($result); $x++)
{
	// Get the team matchups for db 'period'
	$marker = $x + 1;
	$mtext = "team".$marker;
	$mresults = mysql_query ("SELECT ".$mtext." FROM period");
	$team = mysql_result($mresults, 0, $mtext);
	$result2 = mysql_query("SELECT id, run, hit, homer, rbi, steal, win, save, k, era, run_pts, hit_pts, homer_pts, rbi_pts, steal_pts, win_pts, save_pts, k_pts, era_pts FROM current WHERE id='$team'");

	$ers_result = mysql_query("SELECT SUM(ers) AS total_ers FROM player_rosters WHERE player_rosters.team_id = '$team' AND player_rosters.active > 0");

	$ers_pitch_result = mysql_query("SELECT SUM(ers) AS total_ers FROM pitcher_rosters WHERE pitcher_rosters.team_id = '$team' AND pitcher_rosters.active > 0");

	$run = mysql_result($result2, 0, 'run');
	$hit = mysql_result($result2, 0, 'hit');
	$homer = mysql_result($result2, 0, 'homer');
	$rbi = mysql_result($result2, 0, 'rbi');
	$steal = mysql_result($result2, 0, 'steal');
	$win = mysql_result($result2, 0, 'win');
	$save = mysql_result($result2, 0, 'save');
	$k = mysql_result($result2, 0, 'k');
	$era = mysql_result($result2, 0, 'era');
	
	$total_ers = mysql_result($ers_result, 0, 'total_ers');
	$total_ers_pitch = mysql_result($ers_pitch_result, 0, 'total_ers');
	
	$pts = number_format(mysql_result($result2, 0, 'run_pts') + mysql_result($result2, 0, 'hit_pts') + mysql_result($result2, 0, 'homer_pts') + mysql_result($result2, 0, 'rbi_pts') + mysql_result($result2, 0, 'steal_pts') + mysql_result($result2, 0, 'win_pts') + mysql_result($result2, 0, 'save_pts') + mysql_result($result2, 0, 'k_pts') + mysql_result($result2, 0, 'era_pts'),1);
	
	$result3 = mysql_query ("SELECT team_id, team_name FROM teams WHERE team_id = '$team'");
	echo "<TR bgcolor='#ccccff'><TD>".mysql_result($result3, 0, 'team_id')."</TD>";
	echo "<TD><A HREF = 'teamdetail.php?dick_team=".$team."'>".mysql_result($result3, 0, 'team_name')."</A></TD>\n";
	echo "<TD align=right>".$run."</TD>\n";
	echo "<TD align=right>".$hit."</TD>\n";
	echo "<TD align=right>".$homer."</TD>\n";
	echo "<TD align=right>".$rbi."</TD>\n";
	echo "<TD align=right>".$steal."</TD>\n";
	echo "<TD align=right>".$win."</TD>\n";
	echo "<TD align=right>".$save."</TD>\n";
	echo "<TD align=right>".$k."</TD>\n";
	echo "<TD align=right>".$era."</TD>\n";
	echo "<TD align=right>".$pts."</TD>\n";
	echo "<TD align=right bgcolor='#eeeeee'>".$total_ers."</TD>\n";
	echo "<TD align=right bgcolor='#eeeeee'>".$total_ers_pitch."</TD>\n";
	echo "</TR>\n";
	
	if ($cnt == 1) {
		$cnt = 2;
	} else {
		$cnt = 1;
		echo "<TR></TR>";
	}
}
echo "</TABLE>";
$result = mysql_query("SELECT updated from period");
$theDate = mysql_result($result, 0, 'updated');
echo $theDate;

//Magpie RSS

	// MagpieRSS used to read site News RSS feed and pipe it here
	// The following files are needed in the same directory as this page:
	// rss_cache.inc
	// rss_fetch.inc
	// rss_parse.inc
	// rss_utils.inc
	// extlib directory
	
	include('rss_fetch.inc');
	
	// Turn Magpie caching off
	define("MAGPIE_CACHE_ON", false);
	
	// Set error reporting for this
	error_reporting(E_ERROR);

        // -------------FOX SPORTS---------------
	// Fetch RSS feed
	$rss = fetch_rss('http://feeds.feedburner.com/foxsports/rss/mlb');
	if ($rss)
	{
	 // Split the array to show first 50
	 $items = array_slice($rss->items, 0, 50);
	 
 	 $magpie_out = $magpie_out.'<tr><td><table width="100%" cellspacing="0" cellpadding="0" bgcolor=#FFFFFF border="0">';
	 $magpie_out = $magpie_out.'<tr><td><h4>Fox Sports</h4></td></tr>';

	 // Cycle through each item and echo
	 foreach ($items as $item ) 
	 {
	  //$magpie_out = $magpie_out.'<tr><td><hr noshade size="1"></td></tr>'; 
	  $magpie_out = $magpie_out.'<tr><td><font size="2"><b><a href="'.$item['link'].'">'.$item['title'];
          //.'</a></b> - '.$item['description'].'</font></td></tr>';
	 }
	 $magpie_out = $magpie_out.'<tr><td><hr noshade size="1"></td></tr>';
	 //$magpie_out = $magpie_out.'<tr><td><a href="'.$url.'news/weblog/">More News ...</a></td></tr>';
	 $magpie_out = $magpie_out.'</table></td></tr>';
	 
	} else {
	  echo '<h2>Error:</h2><p>'.magpie_error().'</p>';
	}

        // -------------YAHOO SPORTS---------------
	// Fetch RSS feed
	$rss = fetch_rss('http://sports.yahoo.com/mlb/rss.xml');
	if ($rss)
	{
	 // Split the array to show first 50
	 $items = array_slice($rss->items, 0, 50);
	 
 	 $magpie_out = $magpie_out.'<tr><td><table width="100%" cellspacing="0" cellpadding="0" bgcolor=#FFFFFF border="0">';
	 $magpie_out = $magpie_out.'<tr><td><h4>Yahoo Sports</h4></td></tr>';

	 // Cycle through each item and echo
	 foreach ($items as $item ) 
	 {
	  //$magpie_out = $magpie_out.'<tr><td><hr noshade size="1"></td></tr>'; 
	  $magpie_out = $magpie_out.'<tr><td><font size="2"><b><a href="'.$item['link'].'">'.$item['title'];
          //.'</a></b> - '.$item['description'].'</font></td></tr>';
	 }
	 $magpie_out = $magpie_out.'<tr><td><hr noshade size="1"></td></tr>';
	 //$magpie_out = $magpie_out.'<tr><td><a href="'.$url.'news/weblog/">More News ...</a></td></tr>';
	 $magpie_out = $magpie_out.'</table></td></tr>';
	 
	} else {
	  echo '<h2>Error:</h2><p>'.magpie_error().'</p>';
	}

        // -------------CBS SPORTS---------------
	// Fetch RSS feed
	$rss = fetch_rss('http://cbs.sportsline.com/partners/feeds/rss/mlb_news');
	if ($rss)
	{
	 // Split the array to show first 50
	 $items = array_slice($rss->items, 0, 50);
	 
 	 $magpie_out = $magpie_out.'<tr><td><table width="100%" cellspacing="0" cellpadding="0" bgcolor=#FFFFFF border="0">';
	 $magpie_out = $magpie_out.'<tr><td><h4>CBS Sports</h4></td></tr>';

	 // Cycle through each item and echo
	 foreach ($items as $item ) 
	 {
	  //$magpie_out = $magpie_out.'<tr><td><hr noshade size="1"></td></tr>'; 
	  $magpie_out = $magpie_out.'<tr><td><font size="2"><b><a href="'.$item['link'].'">'.$item['title'];
          //.'</a></b> - '.$item['description'].'</font></td></tr>';
	 }
	 $magpie_out = $magpie_out.'<tr><td><hr noshade size="1"></td></tr>';
	 //$magpie_out = $magpie_out.'<tr><td><a href="'.$url.'news/weblog/">More News ...</a></td></tr>';
	 $magpie_out = $magpie_out.'</table></td></tr>';
	 
	} else {
	  echo '<h2>Error:</h2><p>'.magpie_error().'</p>';
	}

        // -------------MLB.COM---------------
	// Fetch RSS feed
	$rss = fetch_rss('http://mlb.mlb.com/partnerxml/gen/news/rss/mlb.xml');
	if ($rss)
	{
	 // Split the array to show first 50
	 $items = array_slice($rss->items, 0, 50);
	 
 	 $magpie_out = $magpie_out.'<tr><td><table width="100%" cellspacing="0" cellpadding="0" bgcolor=#FFFFFF border="0">';
	 $magpie_out = $magpie_out.'<tr><td><h4>MLB.COM</h4></td></tr>';

	 // Cycle through each item and echo
	 foreach ($items as $item ) 
	 {
	  //$magpie_out = $magpie_out.'<tr><td><hr noshade size="1"></td></tr>'; 
	  $magpie_out = $magpie_out.'<tr><td><font size="2"><b><a href="'.$item['link'].'">'.$item['title'];
          //.'</a></b> - '.$item['description'].'</font></td></tr>';
	 }
	 $magpie_out = $magpie_out.'<tr><td><hr noshade size="1"></td></tr>';
	 //$magpie_out = $magpie_out.'<tr><td><a href="'.$url.'news/weblog/">More News ...</a></td></tr>';
	 $magpie_out = $magpie_out.'</table></td></tr>';
	 
	} else {
	  echo '<h2>Error:</h2><p>'.magpie_error().'</p>';
	}

        // -------------ESPN SPORTS---------------
	// Fetch RSS feed
	$rss = fetch_rss('http://sports.espn.go.com/espn/rss/mlb/news');
	if ($rss)
	{
	 // Split the array to show first 50
	 $items = array_slice($rss->items, 0, 50);
	 
 	 $magpie_out = $magpie_out.'<tr><td><table width="100%" cellspacing="0" cellpadding="0" bgcolor=#FFFFFF border="0">';
	 $magpie_out = $magpie_out.'<tr><td><h4>ESPN</h4></td></tr>';

	 // Cycle through each item and echo
	 foreach ($items as $item ) 
	 {
	  //$magpie_out = $magpie_out.'<tr><td><hr noshade size="1"></td></tr>'; 
	  $magpie_out = $magpie_out.'<tr><td><font size="2"><b><a href="'.$item['link'].'">'.$item['title'];
          //.'</a></b> - '.$item['description'].'</font></td></tr>';
	 }
	 $magpie_out = $magpie_out.'<tr><td><hr noshade size="1"></td></tr>';
	 //$magpie_out = $magpie_out.'<tr><td><a href="'.$url.'news/weblog/">More News ...</a></td></tr>';
	 $magpie_out = $magpie_out.'</table></td></tr>';
	 
	} else {
	  echo '<h2>Error:</h2><p>'.magpie_error().'</p>';
	}


// Restore original error reporting value
@ini_restore('error_reporting');

echo $magpie_out;

mysql_close ($conn);
?>