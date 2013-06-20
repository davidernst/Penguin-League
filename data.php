<?php

//include charts.php to access the SendChartData function
include "charts/charts.php";

$conn = mysql_connect ("localhost:/tmp/mysql5.sock", "sharespo", "chisai");
mysql_select_db ("sharespo_dfl");

//Tutorial:
//http://www.maani.us/charts/index.php?menu=Tutorial&submenu=Chart_Data




$chart [ 'chart_type' ] = "line";

SendChartData ( $chart );

?>