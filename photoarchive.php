<?php

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$result1 = mysql_query ("SELECT cbs_id, reason, dateandtime FROM photo ORDER BY photo_index");

echo "<TABLE border=0>";
echo "<TR><TH>Photo</TH><TH>Comment</TH></TR>";
for ($x=(mysql_num_rows($result1)-1); $x >= 0; $x-=1)
{
        $photo_id = mysql_result($result1, $x, "cbs_id");
        $dateandtime = mysql_result($result1, $x, "dateandtime");
        $photo_id2 = $photo_id;

        while (strlen($photo_id) < 8 )
        {
	        $photo_id = "0".$photo_id;
        }

        $result = mysql_query ("SELECT id, team, full_name FROM dick_league_players WHERE id='".$photo_id."'");
        $photo_path = "http://images.sportsline.com/images/baseball/mlb/players/60x80/".$photo_id2.".jpg";
        $link_path = "http://www.sportsline.com/mlb/players/playerpage/".$photo_id2;

	echo "<TR bgcolor='#ccccff' valign='top'>";
	echo "<TD><a href='".$link_path."'><img src='".$photo_path."'></a></TD>";
	echo "<TD><font size='2'><a href='".$link_path."'>".mysql_result($result, 0, 'full_name')."</a>";
        echo "<BR>".mysql_result($result1, $x, 'reason')."</font>";
        echo "</TR>";
}

echo "</TABLE>";
?>