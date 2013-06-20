<HTML>
<HEAD>
<TITLE>Control Panel</TITLE>
</HEAD>
<BODY BGCOLOR="#FFFFFF">
<?PHP

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$garbage = mysql_query ("UPDATE player_rosters SET position = '$position' WHERE player_id = '$playerid' AND team_id = '$dick_team'");

$text = "edit_team.php?whichteam=".$dick_team;

echo "<script language='javascript'>\n";
// echo "<!-\n";
echo "location.replace('$text')\n";
// echo "-->\n";
echo "</script>";

mysql_close($conn);
?>

</BODY>
</HTML>
