<HTML xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
  <meta name="viewport" content="width=750">
  <script type="text/javascript" src="game.js" async></script>
  <link rel="shortcut icon" href="../favicon.ico" type="image/ico" />
  <link rel="icon" href="../favicon.ico" />
  <link rel="stylesheet" type="text/css" href="style.css" />
<?php
include_once 'db.php';

$short = urldecode($_GET['short']);
$bingosql=mysql_query("SELECT * FROM bingo WHERE shortname='$short'");
$rows = mysql_num_rows($bingosql);
$avail = 0; // available phrases
if ($rows == 1) {
  $bingolist = mysql_fetch_array($bingosql);
  $title=$bingolist['title'];
  $exclaim=$bingolist['exclaim'];
  $free=$bingolist['free'];
  $phrases=$bingolist['phrases'];

  $separator = "\r\n";
  $line = strtok($phrases, $separator);
  $numphrases = 0;
  while ($line !== false) {
    // do something with $line, if not a blank one
    if ($line !== '') {
      $numphrases=$numphrases+1;
      $lines[$numphrases]=$line;
      $play[$numphrases]=$line;
    }
    $line = strtok( $separator );
  }
  $avail=$numphrases;
}
if ($avail > 0) {
  $lastupdate=$bingolist['lastupdate'];
  echo "<TITLE>$title bingo</TITLE>";
?>
</head>
<BODY>

<?php
  echo "<center><h3>'$title' bingo:</h3></center>";
?>
<p>Click on each cell when you hear the phrase.
<TABLE class="card" id="card0" border="1" cellspacing="0">
<TBODY>
<?php
  for ($x = 1; $x < 6; $x++) {
    echo "<tr>";
    for ($y = 1; $y < 6; $y++) {
      if ($x == 3 && $y == 3 && $free !== '') {
        echo "<td class='freecell'>$free<br>(free&nbsp;square)</td>";
      } else {
        if ($avail == 0) {
          // we ran out of phrases, restock the list
          for ($w = 1; $w < $numphrases; $w++) {
            $play[$w] = $lines[$w];
          }
          $avail = $numphrases;
        }
        $w = rand(1,$numphrases);
        while ($play[$w] == '') {
          $w = rand(1,$numphrases);
        }
        echo "<td>$play[$w]</td>";
        $play[$w]='';    // wipe it out, not available
        $avail=$avail-1; // one less to choose from
      }
    }
    echo "</tr>\n";
  }
  echo "</TABLE>\n";
  echo "<p>Holler '$exclaim' when you fill 5 in a row!</p>\n";
  if ($numphrases < 25) {
    echo "<p>Not enough phrases are configured, so we had to reuse some of them.</p>\n";
  }
  $remote = $_SERVER['REMOTE_ADDR'];
  echo "<p>Playing from IP $remote";

  // $user = trim(mysql_real_escape_string($_POST["free"]));
  // ipaddress is $remote
  $when = date("Y/m/d H:i:s"); // now
  $what = "PLAY";                // user, ipaddress, when, what
  mysql_query("INSERT INTO usages (ipaddress, eventdatetime, what) VALUES('$remote','$when','$what')")
                        or die (mysql_error());

} else {
  echo "No valid game found: '$short' has $avail phrases";
}
?>

<?php
  $encoded = urlencode($short);
  echo "<br><a href=setupBoards.php?short=$encoded>Change the settings for this game</a> (it has $numphrases phrases and was last changed $lastupdate)";
?>
</BODY>
</HTML>

