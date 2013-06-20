<HTML>
<HEAD>
<TITLE>Control Panel</TITLE>
</HEAD>
<BODY BGCOLOR="#FFFFFF">
<?PHP

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$garbage = mysql_query ("DELETE from player_rosters WHERE player_rosters.player_id = '$player' AND team_id = '$team'");

mysql_close($conn);

echo "<script language='javascript'>\n";
// echo "<!-\n";
echo "location.replace('edit_team.php?whichteam=".$team."')\n";
// echo "-->\n";
echo "</script>";
?>

</BODY>
</HTML>




