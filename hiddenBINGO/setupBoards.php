<?php
include_once 'db.php';
$short = urldecode($_GET['short']);
?>
<HTML>
<SCRIPT LANGUAGE="JavaScript">
function toForm() {
  document.form.short.focus(); // ensure focus on the first text entry box
}
</SCRIPT>
<BODY onLoad="toForm()";>

<TABLE id=AutoNumber7 style="BORDER-COLLAPSE: collapse" borderColor=#009900 
      height=12 cellSpacing=3 cellPadding=3 width=600 border=3 align="center">
      <TBODY>
      <TR>
      <TD><CENTER>

<FONT FACE=TAHOMA SIZE=4<B>BINGO details</B></FONT><HR>

<TABLE id=AutoNumber5 style="BORDER-COLLAPSE: collapse" borderColor=#009900 
      height=12 cellSpacing=3 cellPadding=3 width=590 border=0 align="center">
      <TBODY>
      <TR>
<FORM  NAME="form" METHOD="POST" ACTION="postbingo.php">
</font>
<TD height=25 align=CENTER vAlign=bottom>

<?php
$sqlquery = "SELECT * FROM bingo";
if ($short !== '') {
  $sqlquery .= " WHERE shortname = '$short'";
}
$bingosql=mysql_query($sqlquery);
$rows = mysql_num_rows($bingosql);
if ($rows == 0) {
  $short='';
  $title='';
  $exclaim='';
  $free='';
  $phrases='';
  $lastupdate='';
} else {
  $bingolist=mysql_fetch_array($bingosql);
  $short=$bingolist['shortname'];
  $title=$bingolist['title'];
  $exclaim=$bingolist['exclaim'];
  $free=$bingolist['free'];
  $phrases=$bingolist['phrases'];
  $lastupdate=$bingolist['lastupdate'];
  echo "Last updated $lastupdate<br>";
}

echo "<label for='short'>Short name:</label>";
echo "<INPUT TYPE='TEXT' NAME='short' SIZE='30' value='$short'>";

echo "<br><label for='title'>Title:</label><br>";
echo "<textarea name='title' rows='1' cols='70'>";
echo "$title";
echo "</textarea>";

echo "<br><label for='exclaim'>Exclaim (what to say out loud to win):</label><br>";
echo "<textarea name='exclaim' rows='1' cols='70'>";
echo "$exclaim";
echo "</textarea>";

echo "<br><label for='free'>Free/Center cell text (blank gets a phrase):</label><br>";
echo "<textarea name='free' rows='1' cols='70'>";
echo "$free";
echo "</textarea>";

echo "<br><label for='phrases'>Phrases (1 per line, at least 24 lines):</label><br>";
echo "<textarea name='phrases' rows='25' cols='70' style='width:400px'>";
echo "$phrases";
echo "</textarea>";
?>

</td></tr>
</TABLE>

<TABLE id=AutoNumber7 style="BORDER-COLLAPSE: collapse" borderColor=#009900 
      height=12 cellSpacing=3 cellPadding=3 width=590 border=0 align="center">
      <TBODY>
      <TR>

<INPUT TYPE="SUBMIT" NAME="submit" VALUE="Update information"></TD></TR> 
</FORM>
</TABLE>
</TR></TD></TABLE>
