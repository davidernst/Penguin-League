<HTML>
<HEAD>

<TITLE>Add Player</TITLE>

<SCRIPT TYPE="text/javascript">
<!--
function submitenter(myfield,e)
{
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;

if (keycode == 13)
   {
   myfield.form.submit();
   return false;
   }
else
   return true;
}
//-->
</SCRIPT>


</HEAD>
<BODY BGCOLOR="#FFFFFF">
<?php
echo "Team:".$dick_team;

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$result = mysql_query ("SELECT id, team, full_name, pos FROM dick_league_players WHERE full_name LIKE '%".$searchtext."%' ORDER BY team");

echo "<FORM id='myform' name='myform' ACTION='add_player.php' METHOD=GET>";
echo "<SELECT id='player' NAME='player' SIZE=10 onKeyPress='return submitenter(this,event)'>";

for ($x=0; $x < mysql_num_rows($result); $x++)
{
echo "<OPTION SELECTED>";
echo mysql_result($result, $x, "id")." ".mysql_result($result, $x, "team")." ".mysql_result($result, $x, "full_name")." (".mysql_result($result, $x, "pos").") "."\n";
}

echo "</SELECT>";

echo "<INPUT TYPE='hidden' NAME='dick_team' VALUE=".$dick_team.">";
echo "<INPUT TYPE='hidden' NAME='position' VALUE='UN'>";
?>

</FORM>
<script type="text/javascript">
document.myform.player.focus();
</script>
<HR>


</BODY>
</HTML>
