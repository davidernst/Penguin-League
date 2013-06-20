<HTML>
<HEAD>
<TITLE>Set</TITLE>
</HEAD>
<BODY BGCOLOR="#FFFFFF">
<?PHP

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$result = mysql_query ("SELECT team_id FROM teams");

$periodset = "UPDATE period SET ";

for ($x=0; $x < mysql_num_rows($result); $x++)
{
	$y = $x+1;
	$periodset = $periodset."team".$y." = ".$team[$y].",";
}

if ($first == "on") {
	$periodset = $periodset."first = 1";
} else {
	$periodset = $periodset."first = 0";
}

mysql_query ($periodset);

echo "<script language='javascript'>\n";
// echo "<!-\n";
echo "location.replace('control.php')\n";
// echo "-->\n";
echo "</script>";

mysql_close($conn);
?>

</BODY>
</HTML>
