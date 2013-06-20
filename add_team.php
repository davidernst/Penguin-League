<html>
<head>
<title>Success!</title>
</head>
<body bgcolor="#FFFFFF">
<?php

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$result = mysql_query ("SELECT * FROM teams");
if ($result) {
$numteams = mysql_num_rows($result)+1;
} else {
$numteams = 1;
}
mysql_query ("INSERT INTO teams SET team_id='$numteams', team_name='$team_name', team_owner='$team_owner', team_owner2='$team_owner2', email='$email', email2='$email2'");
mysql_close ($conn);

echo "Team number: ".$numteams."<BR>";
echo "Team Name:".$team_name."<BR>";
echo "Team Owner:".$team_owner."<BR>";
echo "Email:".$email."<P>";
echo "Team Owner 2:".$team_owner2."<BR>";
echo "Email 2:".$email2."<P>";

?>
This team has been successfully entered into the database.<BR>
<HR>

<A HREF="add_team.html">Add another team?</A>
<A HREF="edit_players.php">Edit players on this team?</A>

</body>
</html>
