<?PHP
  print('<center><font face="tahoma" color="black" size="3">
        You now have <b>'.$quan2.'</b>
        <a href="editproduct.php?upc='.$upc.'">
        '.$brand.', '.$descrip.'</a>');
  echo " - ".$size." in ".$cat."<br />";
  echo '</font>';

  echo '<audio autoplay=true>';
  echo '<source src="audio/Numbers/'.$quan2.'.wav" type="audio/wav">';
  echo '  Your browser does not support the audio element.';
  echo '</audio>';
?>
