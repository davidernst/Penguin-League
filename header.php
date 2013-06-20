<table border="0" cellpadding="3">
<TR BGCOLOR="#CCCCCC">

<?php

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$result1 = mysql_query ("SELECT cbs_id, reason FROM photo ORDER BY photo_index");
$numofrows = mysql_num_rows($result1);
$lastentry = $numofrows-1;

$photo_id = mysql_result($result1, $lastentry, "cbs_id");
$photo_id2 = $photo_id;

while (strlen($photo_id) < 8 )
{
	$photo_id = "0".$photo_id;
}

$result = mysql_query ("SELECT id, team, full_name FROM dick_league_players WHERE id='".$photo_id."'");

$photo_path = "http://images.sportsline.com/images/baseball/mlb/players/60x80/".$photo_id2.".jpg";

$link_path = "http://www.sportsline.com/mlb/players/playerpage/".$photo_id2;

echo "<TD ROWSPAN='2' ALIGN='CENTER'><a href='".$link_path."'><img src='".$photo_path."' width='60' height='80' align='top'></a><BR><FONT SIZE='2'>The player of the moment is <BR><FONT COLOR='#0000FF'>".mysql_result($result, 0, 'full_name')."</FONT></FONT></TD>";

?>

<TD colspan="5" align="left" background="images/penguinsmall.jpg"><H1>PL 2013</H1><FONT SIZE="2"><-- Brought to you by...</FONT><br><br><br><br><br><br>
</TD>
<TD ROWSPAN="2" VALIGN="TOP">
Results:<BR>
<FONT SIZE="1">

<a href="http://penguin.sharespot.org/results/1/">Period 1</a><br>
<a href="http://penguin.sharespot.org/results/2/">Period 2</a><br>
<a href="http://penguin.sharespot.org/results/3/">Period 3</a><br>

<?php
/*
*/
?>




</FONT>
</TD>
</TR>
<TR BGCOLOR="#CCCCCC">
<TD align="center"><a href="photo.php">Add Photo</a></TD>
<TD align="center"><a href="photoarchive.php">Photo Archive</a></TD>
<TD align="center"><a href="standings.shtml">Standings</a></TD>
<TD align="center"><a href="ers.shtml">ERS</a></TD>
<TD align="center"><a href="schedule.shtml">Schedule</a></TD>
</TR>
</TABLE>
<TABLE>
<TR><TD>
<FONT SIZE='2' color='#0000FF'>
<?php

echo mysql_result($result1, $lastentry, "reason");

?>
</FONT>
</TD></TR>
</TABLE>