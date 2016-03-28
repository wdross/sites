<HTML><HEAD><TITLE>A look into the Freezer</TITLE>
<BODY>
<?php
require_once('DS1631.php');

echo "The current freezer temperature is ";
$ds1631 = new DS1631();

echo $ds1631->f();
echo "&deg;F";
?>
</BODY>
