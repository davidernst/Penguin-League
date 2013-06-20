<HTML>
<HEAD>

<TITLE>Add Player</TITLE>


</HEAD>
<BODY BGCOLOR="#FFFFFF">
<?php
echo "Team:".$dick_team;

echo "<FORM ACTION='add_player.php' METHOD=GET>";
echo "<SELECT NAME='player' SIZE=10>";

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

if (($postion=="P") OR ($postion="SP") OR ($postion="RP"))
{
	$result = mysql_query ("SELECT id, team, full_name FROM dick_league_pitchers WHERE team='$team' AND pos='$position' ORDER BY team");
} else {
	$result = mysql_query ("SELECT id, team, full_name FROM dick_league_players WHERE team='$team' AND pos='$position' ORDER BY team");
}

for ($x=0; $x < mysql_num_rows($result); $x++)
{
	$safe_name = stripSlashes(mysql_result($result, $x, "full_name"));
	echo "<OPTION>";
	echo mysql_result($result, $x, "id")." ".mysql_result($result, $x, "team")." ".mysql_result($result, $x, "full_name")." "."\n";
}

mysql_close($conn);

echo "</SELECT>";

echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team.">";
echo "<INPUT TYPE='hidden' NAME='position' VALUE=".$position.">";

?>

<INPUT TYPE=submit VALUE="Add Player">

</FORM>
<HR>


</BODY>
</HTML>
