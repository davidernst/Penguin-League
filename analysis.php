<HTML>
<BODY bgcolor="#FFFFFF">

<?php

//include charts.php to access the InsertChart function
include "charts/charts.php";

echo InsertChart ( "charts/charts.swf", "charts/charts_library", "data.php", 400, 250 );

?>

</BODY>
</HTML>