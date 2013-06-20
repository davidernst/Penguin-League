<HTML>
<HEAD>

<TITLE>Control Panel</TITLE>

<script type="text/javascript">
<!--

function validate_form ( )
{
    valid = true;

    if ( document.change_periods.period.value == "" )
    {
        alert ( "Identify the period that is ending, stupid." );
        valid = false;
    }

    return valid;
}

//-->
</script>

</HEAD>
<BODY BGCOLOR="#FFFFFF">

<H1>Penguin League Control Panel</H1>
<HR>
Reload Stats:<BR>
<TABLE><TR><TD>
<FORM ACTION="transferdata.php" METHOD=GET>
<INPUT TYPE="submit" VALUE="ESPN">
</FORM>
</TD><TD>
<FORM ACTION="espn_calculate.php" METHOD=GET>
<INPUT TYPE="submit" VALUE="ESPN Calculate">
</FORM>
</TD></TR>

<TR>
<TD>
<FORM ACTION="cnnsitransferdata.php" METHOD=GET>
<INPUT TYPE="submit" VALUE="CNNSI">
</FORM>
</TD>
<TD>
</TD>
</TR>

<TR>
<TD>
<FORM ACTION="transferdatacbs.php" METHOD=GET>
<INPUT TYPE="submit" VALUE="CBS">
</FORM>
</TD>
<TD>
<FORM ACTION="replacedatacalc.php" METHOD=GET>
<INPUT TYPE="submit" VALUE="CBS Calculate">
</FORM>
</TD>
</TR>
<TR>
<TD>
<FORM ACTION="replacedata.php" METHOD=GET>
<INPUT TYPE="submit" VALUE="Get Yahoo Player Data">
</TD>
<TD>
Yahoo ID: <input type="text" name="yahooplayerid" size="12"><BR>
CBS ID: <input type="text" name="cbsplayerid" size="12">
</TD>
</FORM>

</TR>
</TABLE>
<HR>
<FORM ACTION="edit_team.php" METHOD=GET>

<INPUT TYPE="submit" VALUE="Edit Team Roster">
<SELECT NAME="whichteam">

<?php

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$result = mysql_query ("SELECT team_id, team_name FROM teams ORDER BY team_id");

for ($x=0; $x < mysql_num_rows($result); $x++)
{
echo "<OPTION value = '".mysql_result($result, $x, "team_id")."'>";
echo mysql_result($result, $x, "team_id")." ".mysql_result($result, $x, "team_name");
}
echo "</SELECT></FORM>";

echo "<HR>";

echo "<FORM ACTION='edit_lineup.php' METHOD=GET>";
echo "<INPUT TYPE='submit' VALUE='Edit Team Line-Up'>";
echo "<SELECT NAME='dick_team'>";


for ($x=0; $x < mysql_num_rows($result); $x++)
{
echo "<OPTION value=".mysql_result($result, $x, 'team_id').">";
echo mysql_result($result, $x, "team_id")." ".mysql_result($result, $x, "team_name");
}
echo "</SELECT></FORM>";

echo "<HR>";

echo "<FORM ACTION='add_drop.php' METHOD=GET>";
echo "<INPUT TYPE='submit' VALUE='Add/Drop/Trade'>";
echo "<SELECT NAME='whichteam'>";


for ($x=0; $x < mysql_num_rows($result); $x++)
{
echo "<OPTION>";
echo mysql_result($result, $x, "team_id")." ".mysql_result($result, $x, "team_name");
}
echo "</SELECT></FORM>";

mysql_close($conn);
?>

<HR>
<FORM ACTION="add_team.html" METHOD=GET>

<INPUT TYPE="submit" VALUE="Add League Team">
</FORM>

<HR>
<FORM NAME="change_periods" ACTION="historymaker.php" METHOD=GET onsubmit="return validate_form()">

<INPUT TYPE="submit" VALUE="Change Periods"> Period <input type="text" name="period" size="3"> web pages will be archived, updates wins/losses and points, makes today's stats the baseline stats, and asks for the match-ups for the next period.
</FORM>
<HR>
<FORM ACTION="rollback.html" METHOD=GET>

<INPUT TYPE="submit" VALUE="Roll Back">
This will roll back the stats to a specified date.
</FORM>
<HR>
</BODY>
</HTML>
