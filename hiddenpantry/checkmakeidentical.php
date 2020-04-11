<?php
  $makeidentical = $_POST["makeidentical"];
  if ($makeidentical != "") {
    // user is asking us to make all the 12-digit barcodes that start with our prefix
    // to have their "brand" set to our "brand", making them all the same:
    $myprefix=substr($upc,0,6);
    $myupdate = "UPDATE inven SET brand='$brand' WHERE SUBSTR(upc,1,6)='$myprefix'";

    $sql = mysql_query($myupdate);
    if(!$sql){
      echo "A database error occurred executing: $myupdate";
    }
  }
?>
