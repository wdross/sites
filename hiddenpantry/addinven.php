<?php
echo '<' . '?xml version="1.0" encoding="UTF-8" ?' . '>';
?>
<HEAD>
<TITLE>Pantry - Add</TITLE>
<SCRIPT LANGUAGE="JavaScript">
function closeWin()
{
myWindow.close();
}
function toForm() {
document.form.upc.focus();
// Replace upc in the script with the field name of which you want to place the focus.
}
</script>
</HEAD>

<BODY onLoad="toForm()";>

<meta http-equiv="refresh"
content="300;url=removeinven.php"/>

<?php
include_once 'header.html';
  // When undefined, default to qty of 1.
  // Allows addupc.php to define $qty and include this to default the qty to a new value
  if (empty($qty))
    $qty = "1";
?>

<center>

<TABLE id=AutoNumber1 style="BORDER-COLLAPSE: collapse" borderColor=#111111 bgcolor=purple height=12 cellSpacing=3 cellPadding=3 width=600 border=1>
<TBODY>
<TR>
<TD width=100% height=12><CENTER><font face=tahoma size=4 color=white><b><hr>PANTRY MANAGEMENT INTERFACE<hr></b></CENTER></font></TD></TR></TABLE>

<TABLE id=AutoNumber2 style="BORDER-COLLAPSE: collapse" borderColor=#111111 bgcolor=green height=12 cellSpacing=3 cellPadding=3 width=600 border=1>
<TBODY>
<TR>
<TD width=100% height=12><CENTER><font face=tahoma size=4 color=white><B>ADD INVENTORY</B></CENTER></font></TD></TR></TABLE>

<FORM  NAME="form" METHOD="POST" ACTION="addupc.php">

<TABLE id=AutoNumber3 style="BORDER-COLLAPSE: collapse" borderColor=#111111 bgcolor=white height=12 cellSpacing=3 cellPadding=3 width=600 border=1>
<TBODY>
<TR>
<TD width=100% height=12><CENTER><br><br>
<INPUT TYPE="TEXT" NAME="quan" SIZE="2" value="
<?php
  echo $qty;
?>
"> Quantity<BR><br><br>
<INPUT TYPE='TEXT' NAME='upc' ID= 'upc' VALUE='' SIZE='15'> UPC<BR><BR><br><br>

<center><a href="https://play.google.com/store/apps/details?id=com.tecit.android.barcodekbd.demo" onClick="closeWin()">Install Barcode Keyboard Demo for Droid</a></center><BR><BR><br>
<BR>
<INPUT TYPE="SUBMIT" NAME="submit" VALUE="Submit">
<INPUT TYPE="RESET" onclick="; toForm();">
<p>
</FORM>

</td></tr></table>



</body></head></html>



<!-- Script Size:  1.46 KB -->
