<?php

include_once 'db.php';

$upc = $_POST['upc'];
$quant = $_POST['quant'];
$brand = mysql_real_escape_string($_POST['brand']);
$descrip = mysql_real_escape_string($_POST['descrip']);
$size = mysql_real_escape_string($_POST['size']);
$flavor = mysql_real_escape_string($_POST['flavor']);
$cat = $_POST['cat'];
$sameas = mysql_real_escape_string($_POST['sameas']);

if (strlen($sameas) > 12 and substr($sameas,0,1) == "0") {
  $sameas = substr($sameas,-12); // shorten zero-prefix upc, cause they shouldn't be that long!
}

$sql_check = mysql_query("SELECT upc FROM inven WHERE upc='$sameas'");
$user_check = mysql_num_rows($sql_check);

if($user_check == 0){
  if ($sameas != '') {
    echo "<center><b><font face='tahoma' color='black'>$sameas not present, SAME AS not updated</b><br />";
  }
  $sameas = '';
}

$sql = mysql_query("UPDATE  inven SET quant='$quant', brand='$brand', descrip='$descrip', size='$size',
                   flavor='$flavor', cat='$cat', sameas='$sameas' WHERE upc='$upc'");


if(!$sql){
  echo 'A database update error occurred . Please contact support.';
}

include_once 'checkmakeidentical.php';

echo '<center><br>';
echo '<font face=verdana size=4 color=red><b>';
echo 'You have just updated<font color=black size=2><br> ' . $brand . ', ' . $descrip . ' - ' . $size . ' </font><br>Successfully';
echo '</font></b></center>';
echo '<br>';
include_once 'reportzero.php';

?>
