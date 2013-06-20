<HTML>
<HEAD>
<TITLE>Control Panel</TITLE>
</HEAD>
<BODY BGCOLOR="#FFFFFF">
<?PHP

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

echo "<FORM ACTION='addphoto.php' METHOD=POST>";

echo "<H2>Change photo to:</H2>";

$result = mysql_query ("SELECT id, team, full_name FROM dick_league_players ORDER BY team, full_name");
echo "Player: <SELECT NAME='add_player'>";
//echo "<OPTION VALUE='0'>Select a Player";
for ($x=0; $x < mysql_num_rows($result); $x++)
{
echo "<OPTION VALUE='".mysql_result($result, $x, "id")."'>";
echo mysql_result($result, $x, "team")." ".mysql_result($result, $x, "full_name");
}
echo "</SELECT>";
echo "<P>";
echo "Reason:<BR>";
echo "<textarea name='explain' rows='6' cols='60'>";

echo "</textarea>";
echo "<P>";
?>

<img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" />
<input type="text" name="captcha_code" size="10" maxlength="6" />
<a href="#" onclick="document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>


<?php
echo "<P>";
echo "<INPUT TYPE='submit' VALUE='Change Photo'>";

echo "</FORM>";


mysql_close($conn);
?>

</BODY>
</HTML>