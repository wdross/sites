<HTML>
<HEAD><TITLE>Usage</TITLE></HEAD>
<BODY>
<CENTER>

<TABLE id=AutoNumber1 style="BORDER-COLLAPSE: collapse" borderColor=#111111 bgcolor=purple height=12 cellSpacing=3 cellPadding=3 width=100% border=1>
<TBODY>
<TR>
<TD width=100% height=12><CENTER><font face=tahoma size=5 color=white><b><hr>U S A G E<hr></b></CENTER></font></TD></TR></TABLE>

<TABLE id=AutoNumber10 style="BORDER-COLLAPSE: collapse" borderColor=#000000
      height=12 cellSpacing=3 cellPadding=3 width=100% border=1>
      <TBODY>
<?php
include_once 'db.php';
$bingosql=mysql_query("SELECT user, ipaddress, eventdatetime, what, title FROM usages LEFT JOIN bingo ON game=shortname");
$rows = mysql_num_rows($bingosql);

while ($bingolist = mysql_fetch_array($bingosql)) {
  echo "<tr>";
  $user=$bingolist['user'];
  $ip=$bingolist['ipaddress'];
  $when=$bingolist['eventdatetime'];
  $what=$bingolist['what'];
  $game=$bingolist['title'];
  if ($user == '')
    $user=$ip;
  echo "<td>$user<td>$ip<td>$when<td>$what<td>$game";
  echo "</tr>\n";
}
?>

</center>
<BR>

</TD></TR></TABLE></center>
</BODY>
</HTML>
