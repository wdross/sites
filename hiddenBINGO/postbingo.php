<?PHP

// This is in response to requesting an "Add" of a new category

include_once 'db.php';

$short = trim(mysql_real_escape_string($_POST["short"]));
$title = trim(mysql_real_escape_string($_POST["title"]));
$exclaim = trim(mysql_real_escape_string($_POST["exclaim"]));
$free = trim(mysql_real_escape_string($_POST["free"]));
$phrases = trim(mysql_real_escape_string($_POST["phrases"]));
$lastupdate = date("Y/m/d H:i:s"); // now

  $remote = $_SERVER['REMOTE_ADDR'];

  // $user = trim(mysql_real_escape_string($_POST["free"]));
  // ipaddress is $remote
  // $when = $lastupdate


if (strlen($short) > 0) {
  //check that Category does not already exist
  $sql_user_check = mysql_query("SELECT shortname FROM bingo WHERE shortname='$short'");
  $user_check = mysql_num_rows($sql_user_check);

  if ($user_check == 0) {
    $sql = mysql_query("INSERT INTO bingo (shortname, title, exclaim, free, phrases, lastupdate) VALUES('$short','$title','$exclaim','$free','$phrases','$lastupdate')")
                        or die (mysql_error());
    if(!$sql){
      echo "A database error occured while adding category '.$cat.'.";
    }
    else {
      echo "<center><font face='tahoma' color='black' size='2'><b>".$short." added to database from IP $remote.<br />";
      $what = "CREATE";
    }
  }else{
    // already exists, so let's perform an update
    $sqlquery = "UPDATE bingo SET title='$title', exclaim='$exclaim', free='$free', phrases='$phrases', lastupdate='$lastupdate' WHERE shortname='$short'";
    $sql = mysql_query($sqlquery);
    if (!$sql) {
      echo "<center><b><font face='tahoma' color='red'>Game <b>".$short."</b> FAILED TO UPDATE!</b><br><br /></center>";
      echo $sqlquery;
    } else {
      echo "<center><b><font face='tahoma' color='red'>Game <b>".$short."</b> created!</b><br><br /></center>";
      $what = "EDIT";
    }
  }
  mysql_query("INSERT INTO usages (ipaddress, eventdatetime, what, game) VALUES('$remote','$lastupdate','$what','$short')")
                        or die (mysql_error());
}
// else quietly ignore empty/whitespace request
include_once 'index.php';
?>
