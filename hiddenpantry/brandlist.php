<?php
echo '<datalist id="brands">';
$mycount=0;
if (strlen($upc) == 12) {
  // the GROUP BY removes duplicate entries
  $brandlist=mysql_query("SELECT brand FROM inven WHERE LENGTH(upc)=12 AND SUBSTR(upc,1,6)='".substr($upc,0,6)."' GROUP BY brand");
  while ($loc = mysql_fetch_array($brandlist)) {
    if (strlen($loc['brand']) > 0) {
      echo '<option>'; echo $loc['brand']; echo '</option>';
      $mycount=$mycount+1;
      $singlebrand=$loc['brand'];
    }
  }
}
echo '</datalist>';
if ($mycount != 1)
  $singlebrand = ""; // wipe it out if not just one
?>
