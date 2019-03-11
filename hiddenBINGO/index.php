<HTML>
<HEAD><TITLE>Phrase Word Bingo - Home</TITLE></HEAD>
<BODY>
<CENTER>

<TABLE id=AutoNumber1 style="BORDER-COLLAPSE: collapse" borderColor=#111111 bgcolor=purple height=12 cellSpacing=3 cellPadding=3 width=100% border=1>
<TBODY>
<TR>
<TD width=100% height=12><CENTER><font face=tahoma size=5 color=white><b><hr>P H R A S E&nbsp;&nbsp;&nbsp;W O R D&nbsp;&nbsp;&nbsp;B I N G O<hr></b></CENTER></font></TD></TR></TABLE>

<TABLE id=AutoNumber10 style="BORDER-COLLAPSE: collapse" borderColor=#000000
      height=12 cellSpacing=3 cellPadding=3 width=100% border=1>
      <TBODY>
      <TR>
      <TD><CENTER>
Which game would you like to play?<br>

<?php
include_once 'db.php';
$bingosql=mysql_query("SELECT * FROM bingo"); //  ORDER BY locate ASC
$rows = mysql_num_rows($bingosql);

while ($bingolist = mysql_fetch_array($bingosql)) {
  $short=$bingolist['shortname'];
  $title=$bingolist['title'];
  $encoded = urlencode($short);
  print('<a href="play.php?short='.$encoded.'">');
  echo "$title</a><br>";
}
?>

</center>
<BR>

</TD></TR></TABLE></center>
<a href="setupBoards.php">Setup</a>
<object align="right"><a href="about.html">About</a></object>
</BODY>
</HTML>

