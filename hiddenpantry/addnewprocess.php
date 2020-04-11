<?PHP

include_once 'addinven.php';
include_once 'db.php';

$quan = $_POST['quant'];
$upc = $_POST["upc"];
$brand = mysql_real_escape_string($_POST["brand"]);
$descrip = mysql_real_escape_string($_POST["descrip"]);
$size = $_POST["size"];
$flavor = mysql_real_escape_string($_POST["flavor"]);
$cat = $_POST["cat"];
$sameas = $_POST["sameas"];

echo $upc;
echo "<BR>";

if (strlen($upc) > 12 and substr($upc,0,1) == "0") {
  $upc = substr($upc,-12); // shorten zero-prefix upc, cause they shouldn't be that long!
}

if ($sameas != "") {
  if (strlen($sameas) > 12 and substr($sameas,0,1) == "0") {
    $sameas = substr($sameas,-12); // shorten zero-prefix upc, cause they shouldn't be that long!
  }
  if ($upc != $sameas) {
    $sql_check = mysql_query("SELECT upc FROM inven WHERE upc='$sameas'");
    $user_check = mysql_num_rows($sql_check);
    if($user_check == 0){
      echo "<center><b><font face='tahoma' color='black'>$sameas not present, SAME AS not saved; you'll have to edit this one!</b><br />";
      $sameas = "";
    }
  }
}

//check that upc does not already exist
$sql_user_check = mysql_query("SELECT upc FROM inven WHERE upc='$upc'");
$user_check = mysql_num_rows($sql_user_check);

if(($user_check == 0)){
  echo "<center><b><font face='tahoma' color='black'>Updated ".$descrip." </b><br />";

  $sql = mysql_query("INSERT INTO inven (quant, upc, brand, descrip, size, flavor, cat, sameas)
                      VALUES('$quan', '$upc', '$brand', '$descrip', '$size', '$flavor',
                      '$cat', '$sameas')")
                      or die (mysql_error());

  echo "<center><font face='tahoma' color='black' size='2'><b>".$quan." </b> ".$brand.", ".$descrip." - ".$size." Added to database.<br />";

  if(!$sql){
    echo 'A database error occurred while adding your product.';
  }

include_once 'checkmakeidentical.php';

}else{
  echo "<center><b><font face='tahoma' color='red'>Item is already in database!</b><br><br /></center>";
}  
?>
