<?php
$quan = $_POST['quan'];
$upc = $_POST["upc"];

if ($upc == "")
  $upc = $_GET['upc']; // maybe this was not a POST invocation
if ($quan == "")
  $quan = $_GET['quan'];

      echo '<TABLE id=AutoNumber5 style="BORDER-COLLAPSE: collapse" borderColor=#111111 bgcolor=black
      height=12 cellSpacing=3 cellPadding=3 width=600 border=1 align="center">
      <TBODY>
      <TR>
      <TD width=600 height=12><CENTER>';

	echo "<center><b><font face='tahoma' color='red'>".$upc." does not exist in database!</b><br /></center>";
      echo '</td></tr></table>';
?>
<HTML>
<BODY>
<SCRIPT>
function checkform() {
    if(document.form.cat.value == "") {
        alert("Please select a valid category");
        return false;
    } else {
        return true;
    }
}
</SCRIPT>

<TABLE id=AutoNumber7 style="BORDER-COLLAPSE: collapse" borderColor=#009900 
      height=12 cellSpacing=3 cellPadding=3 width=600 border=3 align="center">
      <TBODY>
      <TR>
      <TD><CENTER>

<FONT FACE=TAHOMA SIZE=4 color=red><B> Add a new item to the database</B></FONT><HR>

<?php
ini_set('default_socket_timeout',10);
$content = file_get_contents('http://www.upcdatabase.com/item/'.$upc);

preg_match('#<tr><td>Description</td><td></td><td>(.*)</td></tr>#', $content, $match);
$desc = $match[1];

preg_match('#<tr><td>Size/Weight</td><td></td><td>(.*)</td></tr>#', $content, $match);
$size = $match[1];

//echo "Description: $desc - Size/Weight: $size\n";
?>

<TABLE id=AutoNumber5 style="BORDER-COLLAPSE: collapse" borderColor=#009900 
      height=12 cellSpacing=3 cellPadding=3 width=590 border=0 align="center">
      <TBODY>
      <TR>
<FORM  NAME="form" METHOD="POST" ACTION="addnewprocess.php">

</font>
<TD  width="25%"  height=25 align=right vAlign=bottom>UPC: &nbsp </TD>
<TD  width="75%"  height=25 align=LEFT vAlign=bottom><INPUT TYPE="TEXT" NAME="upc" SIZE="15" value="<?php echo $upc; ?>"></td></tr> 
<TR><TD  width="25%"  height=25 align=right vAlign=bottom>BRAND: &nbsp </TD>
<TD  width="75%"  height=25 align=left vAlign=bottom><INPUT TYPE="TEXT" NAME="brand" SIZE="20" autofocus></td></tr>
<TR><TD  width="25%"  height=25 align=right vAlign=bottom> DESCRIPTION: &nbsp </TD>
<TD  width="75%"  height=25 align=left vAlign=bottom><INPUT TYPE="TEXT" NAME="descrip" SIZE="30" value="<?php echo $desc; ?>"></TD></TR>
<TR><TD  width="100%"  height=25 align=center vAlign=bottom COLSPAN=2><font size=2>
When typing a description try to keep it as simple as possible.</font></TD></TR>
<TR><TD  width="25%"  height=25 align=right vAlign=bottom> SIZE: &nbsp </TD>
<TD  width="75%"  height=25 align=left vAlign=bottom><INPUT TYPE="TEXT" NAME="size" SIZE="15" value="<?php echo $size; ?>"></TD></TR>
<TR><TD  width="25%"  height=25 align=right vAlign=bottom> FLAVOR: &nbsp </TD>
<TD  width="75%"  height=25 align=left vAlign=bottom><INPUT TYPE="TEXT" NAME="flavor" SIZE="10"></TD></TR>
<TR><TD  width="25%"  height=25 align=right vAlign=bottom> CATEGORY: &nbsp </TD>
<TD  width="75%"  height=25 align=left vAlign=bottom><select name="cat">
<option selected></option>
<?php
include_once 'selectlist.php';
?>

<TR><TD  width="25%"  height=25 align=right vAlign=bottom> QOH: &nbsp </TD>
<TD  width="75%"  height=25 align=left vAlign=bottom><INPUT TYPE="TEXT" NAME="quant" SIZE="15" value="<?php echo $quan; ?>"></TD></TR>


<TR><TD  width="25%"  height=25 align=right vAlign=bottom> Same AS: &nbsp </TD>
<TD  width="75%"  height=25 align=left vAlign=bottom><INPUT TYPE="TEXT" NAME="sameas" SIZE="20" value=""></TD></TR>

</select></TD></TR></TABLE>


<TABLE id=AutoNumber8 style="BORDER-COLLAPSE: collapse" borderColor=#111111 
      height=12 cellSpacing=3 cellPadding=3 width=590 border=0 align="center">
      <TBODY>
      <TR>
      <TD><CENTER><br>
<INPUT TYPE="SUBMIT" NAME="submit" VALUE="Add new item to database now" onClick="return checkform()"></TD></TR>
</FORM>
</TABLE>
</TR></TD></TABLE>
