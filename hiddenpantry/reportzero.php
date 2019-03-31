<?PHP
session_start();

include_once 'db.php';
include_once 'header.html';
include_once 'reportheader.html';

$query="WHERE total=0";
if (isset($_GET['all'])) // ANYTHING sent to all= will result in showing all entries
  $query="";

if (isset($_GET['category'])) {
  $_SESSION["category"]=urldecode($_GET['category']);
}
if (isset($_SESSION["category"]) && (strlen($_SESSION["category"])>0))
  $query="WHERE cat='".$_SESSION["category"]."'";
else
  unset($_SESSION["category"]); // now we can just check isset() below

echo "<center>";
$handle = fopen("lastbackup.txt", "r");
if ($handle) {
  while (($line = fgets($handle)) !== false) {
    echo "Last backup $line";
    break; // one and done!
  }
  fclose($handle);
}

echo "<hr>";

mysql_query("DROP TEMPORARY TABLE IF EXISTS tally");
$tt = mysql_query("CREATE TEMPORARY TABLE tally
  SELECT
  (CASE WHEN sameas = '' THEN upc ELSE sameas END) AS same,
  SUM(quant) AS total,
  (SELECT brand   FROM inven WHERE upc = same) AS brand,
  (SELECT descrip FROM inven WHERE upc = same) AS descrip,
  (SELECT size    FROM inven WHERE upc = same) AS size,
  (SELECT flavor  FROM inven WHERE upc = same) AS flavor,
  (SELECT cat     FROM inven WHERE upc = same) AS cat
FROM inven
GROUP BY same");

$select = "SELECT same, total, brand, descrip, size, flavor, cat FROM tally ".$query." ORDER BY cat ASC, descrip ASC, brand ASC";
// echo $select; // uncomment to debug select expression
$deflist = mysql_query($select);

while ($all = mysql_fetch_array($deflist)) {
   $results[$all['cat']][] = array ('upc' => $all['same'], 'quant' => $all['total'], 'brand' => $all['brand'], 'descrip' => $all['descrip'], 'size' => $all['size'], 'flavor' => $all['flavor']);
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
		<b><font face=arial size=2 color=white>'.$catName.'</b></td>
                <td width="25%"><a href="reportzero.php?category='); // make right-side cell for changing search focus
   if (isset($_SESSION["category"]))
     print('">Show all'); // showing a restricted list, give way to reset
   else
     print(urlencode($catName).'">Show all of these'); // showing all categories, give way to focus on one
   print('</a></font></td></tr></table></center>'."\n");
   foreach ($catData as $itemNum => $itemData)
   {
      if ((strpos($query,"total=")==false) && ($itemData['quant']==0))
        $color="red";
      else
        $color="white";
error_reporting(1);
      print('<center><TABLE id=AutoNumber21 style="BORDER-COLLAPSE: collapse" borderColor=#000000 
      bgcolor='.$color.' height=12 cellSpacing=3 cellPadding=3 width=600 border=0>
      <TBODY>
      <TR><TD><font face=arial size=2>
	<A HREF="editproduct.php?upc='.$itemData['upc'].'">edit</A> - ' .
      $itemData['descrip'].', '.$itemData['brand'].', '.$itemData['size'].',
      '.$itemData['flavor'].' - '.$itemData['quant'].'<br/></td></tr></table></center></font>'."\n"); 
   }
}
echo '</td></tr></table></center>';

mysql_query("DROP TEMPORARY TABLE tally");

include_once 'footer.html';

?>
