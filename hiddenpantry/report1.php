<?PHP

include_once 'db.php';
include_once 'header.html';
include_once 'reportheader.html';

$sql = mysql_query(
"ALTER TABLE inven ORDER BY cat ASC, descrip ASC, brand ASC");
echo "<hr>";
$deflist=mysql_query(
        "SELECT upc, quant, brand, descrip, size, flavor, cat FROM inven");
while ($all = mysql_fetch_array($deflist)) {
   $results[$all['cat']][] = array ('upc' => $all['upc'], 'quant' => $all['quant'], 'brand' => $all['brand'], 'descrip' => $all['descrip'], 'size' => $all['size'], 'flavor' => $all['flavor']);
}

//print_r($results);
error_reporting(0);
echo '<center><TABLE id=AutoNumber22 style="BORDER-COLLAPSE: collapse" borderColor=#000000 
      height=12 cellSpacing=3 cellPadding=3 width=600 border=1>
      <TBODY>
      <TR><TD>';

foreach ($results as $catName => $catData)
{
   print('<center><TABLE id=AutoNumber20 style="BORDER-COLLAPSE: collapse" borderColor=#000000 
      bgcolor=purple height=12 cellSpacing=3 cellPadding=3 width=600 border=1>
      <TBODY>
      <TR><TD>
		<b><font face=arial size=2 color=white>'.$catName.'</b><br/></font></td></tr></table></center>'."\n");
   $subtotal = 0;
   foreach ($catData as $itemNum => $itemData)
   {
error_reporting(1);
      // if you want to access the row data in this loop, use the following method:
      print('<center><TABLE id=AutoNumber21 style="BORDER-COLLAPSE: collapse" borderColor=#000000 
      height=12 cellSpacing=3 cellPadding=3 width=600 border=0>
      <TBODY>
      <TR><TD width="90%"><font face=arial size=2>
	<A HREF="editproduct.php?upc='.$itemData['upc'].'">edit</A> - ' .
      $itemData['descrip'].', '.$itemData['brand'].', '.$itemData['size'].',
      '.$itemData['flavor'].'</td><td width="10%">'.$itemData['quant'].'<br/></td></tr></table></center>'."\n"); 
      // etc. (you must code the field names in hard coded this way)
      //foreach ($itemData as $fieldName => $value)
      $subtotal = $subtotal + $itemData['quant'];
   }
   print('<TABLE id=AutoNumber21 style="BORDER-COLLAPSE: collapse" borderColor=#000000 
      height=12 cellSpacing=3 cellPadding=3 width=600 border=0>
      <TBODY><tr><td align="right">'.$subtotal.' Total</td></tr></table>');
}
echo '</td></tr></table></center>';

include_once 'footer.html';

?>

