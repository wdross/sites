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

if(($quan < 0)){
  echo "<center><b><font face='tahoma' color='red'>** You did not enter a quantity! **</center></b><br />";

}else if($upc == "REMOVE"){
  include_once 'removeinven.php';
  echo '<embed src="audio/Math/Subtract.wav" width=2 height=0 autostart=true>';
}else if($upc == "ADD"){
  // basically a NOP, show the same screen - if we are headless this is OK
  include_once 'addinven.php';
  echo '<embed src="audio/Math/Add.wav" width=2 height=0 autostart=true>';
}else if((strlen($upc) <= 4)){
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
      echo '<embed src="audio/Common/Im_sorry.wav" width=2 height=0 autostart=true>';
      echo 'A database error occured while adding your product.';
    }

  }else{
    echo '<embed src="audio/Common/Nope.wav" width=2 height=0 autostart=true>';
    include_once 'addnew.php';
  }
}
include_once 'footer.html';

?>
