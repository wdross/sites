<?php
$loclist=mysql_query("SELECT * FROM locations");

while ($loc = mysql_fetch_array($loclist)) {
  if (strlen($loc['locate']) > 0 &&
      ($loc['locate'] != "Pantry")) {
    echo '<option>'; echo $loc['locate']; echo '</option>';
  }
}
?>
