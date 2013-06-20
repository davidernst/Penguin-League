<?php

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

$delete_players_query = mysql_query ("TRUNCATE TABLE dick_league_players");
$delete_pitchers_query = mysql_query ("TRUNCATE TABLE dick_league_pitchers");

$query_players = "INSERT INTO dick_league_players (id, team, full_name, pos, bat, hit, homer, walk, steal, run, rbi, games) SELECT players_history.id, players_history.team, players_history.full_name, players_history.pos, players_history.bat, players_history.hit, players_history.homer, players_history.walk, players_history.steal, players_history.run, players_history.rbi, players_history.games FROM players_history WHERE players_history.month = '$month' AND players_history.date = '$date'";

$query_pitchers = "INSERT INTO dick_league_pitchers (id, team, full_name, pos, games, win, save, inning, k, er, start) SELECT pitchers_history.id, pitchers_history.team, pitchers_history.full_name, pitchers_history.pos, pitchers_history.games, pitchers_history.win, pitchers_history.save, pitchers_history.inning, pitchers_history.k, pitchers_history.er, pitchers_history.start FROM pitchers_history WHERE pitchers_history.month = '$month' AND pitchers_history.date = '$date'";



$copy_players_query = mysql_query($query_players);

if($copy_players_query){echo " Players rollback to ".$month."/".$date." is successful ";}
else {echo mysql_error();}

echo "<br>-----<br>";
$copy_pitchers_query = mysql_query($query_pitchers);

if($copy_pitchers_query){echo " Pitchers rollback to ".$month."/".$date." is successful ";}
else {echo mysql_error();}

?>