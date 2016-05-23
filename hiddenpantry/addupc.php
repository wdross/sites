<HEAD>
<TITLE>Pantry - Add details</TITLE>
<SCRIPT LANGUAGE="JavaScript">
function toForm() {
document.form.brand.focus();
}
</SCRIPT>
</HEAD>
<BODY onLoad="toForm()";>

<?PHP

include_once 'header.html';
include_once 'db.php';

$quan = $_POST['quan'];
$upc = $_POST["upc"];

if(strtoupper($upc) == "REMOVE"){
  include_once 'removeinven.php';
  echo '<audio autoplay=true>';
  echo '<source src="audio/Math/Subtract.wav" type="audio/wav">';
  echo '  Your browser does not support the audio element.';
  echo '</audio>';
}
else if (substr(strtoupper($upc),0,9) == "QUANTITY ") {
  $qty = substr($upc,9);
  include_once 'addinven.php';
  echo '<audio autoplay=true>';
  echo '<source src="audio/Numbers/'.$qty.'.wav" type="audio/wav">';
  echo '  Your browser does not support the audio element.';
  echo '</audio>';
}
else if ((strtoupper($upc) == "ADD") || ($quan < 0) || (strlen($upc) <= 4)) {
  // basically a NOP, show the same screen - if we are headless this is OK
  include_once 'addinven.php';
  echo '<audio autoplay=true>';
  echo '<source src="audio/Math/Add.wav" type="audio/wav">';
  echo '  Your browser does not support the audio element.';
  echo '</audio>';
  if ($quan <= 0)
    echo "<center><b><font face='tahoma' color='red'>** You did not enter a quantity! **</center></b><br />";
  else if (strtoupper($upc) != "ADD")
    echo "<center><b><font face='tahoma' color='red'>** You did not enter a valid UPC! **</center></b><br />";
}else{
  $contlist=mysql_query("SELECT * FROM inven WHERE upc='$upc'");
  $user_check = mysql_num_rows($contlist);
  if ($user_check <= 0 and strlen($upc) > 12 and substr($upc,0,1) == "0") {
    $upc = substr($upc,-12); // shorten zero-prefix upc since it wasn't found
    $contlist=mysql_query("SELECT * FROM inven WHERE upc='$upc'");
    $user_check = mysql_num_rows($contlist);
    // even if it's not found, we'll use the short version to perform the ADD
  }

  if ($user_check <= 0 and
      strlen($upc) == 7) { //if short upc doesn't exist in database, check for one with 1 more digit
    $search = "'^$upc";
    $search .= "[0-9]$'"; // built in 2 steps, as otherwise [] looks like a subscript on $upc
    $sql_user_check = mysql_query("SELECT upc FROM inven WHERE upc regexp $search");
    $user_check = mysql_num_rows($sql_user_check);
    if ($user_check == 1) { // found a match
      $all = mysql_fetch_array($sql_user_check);
      $upc = $all['upc']; // get the exact upc that matched, so we can add 1 item
    }
  }

  while ($all = mysql_fetch_array($contlist)) {
    $quan1 = $all['quant'];
    $upc1 = $all['upc'];
    $brand = $all['brand'];
    $descrip = $all['descrip'];
    $size = $all['size'];
    $flavor = $all['flavor'];
    $cat = $all['cat'];
  }

  $quan2 = (($quan)+($quan1));

  if(($user_check > 0)){

include_once 'addinven.php';

    echo "<center><b><font face='tahoma' color='black'>Updated ".$descrip." </b><br />";

    $sql = mysql_query("UPDATE inven SET quant=(('$quan1')+('$_POST[quan]')) WHERE upc='$upc'");

    echo '<TABLE id=AutoNumber4 style="BORDER-COLLAPSE: collapse" borderColor=#111111 height=12
       cellSpacing=3 cellPadding=3 width=600 border=1>
      <TBODY>
      <TR>
      <TD width=900 height=12><CENTER>';
include_once 'showone.php';
    echo '</td></tr></table>';

    if(!$sql){
      echo '<audio autoplay=true>';
      echo '<source src="audio/Common/Im_sorry.wav" type="audio/wav">';
      echo '  Your browser does not support the audio element.';
      echo '</audio>';
      echo 'A database error occured while adding your product.';
    }

  }else{
    // brand new item, not known by our database
    echo '<audio autoplay=true>';
    echo '<source src="audio/Common/Nope.wav" type="audio/wav">';
    echo '  Your browser does not support the audio element.';
    echo '</audio>';
    if ($_SERVER['SERVER_ADDR'] == $_SERVER['REMOTE_ADDR']) {
      // Running headless, so we'll say 'Nope' then go back to the normal Add screen
      echo "<center><b><font face='tahoma' color='red'>";

      print '<A HREF="addnew.php?' . htmlspecialchars(http_build_query(array('upc' => $upc, 'quan' => $quan))) . '">';

      echo "** On the server, we assume no keyboard. **";
      echo "</A></center></b><br />";
      include_once 'addinven.php';
    }
    else {
      // running remote, allow entering that detailed information
      include_once 'addnew.php';
    }
  }
}
include_once 'footer.html';

?>
