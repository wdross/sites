<HTML><HEAD>
<TITLE>A look into the Freezer</TITLE>
</HEAD>
<script src="http://code.highcharts.com/highcharts.js">
</script>
<BODY>
<?php
require_once('DS1631.php');

echo "The current freezer temperature is ";
$ds1631 = new DS1631();

echo $ds1631->f();
echo "&deg;F<br>\n";
?>
</BODY>
