<?php
require_once('../DS1631.php');

// Set the JSON header
header("Content-type: text/json");

// The x value is the current JavaScript time, which is the Unix time multiplied by 1000.
$x = time() * 1000;
// The y value is our temperature
$ds1631 = new DS1631();
$y = $ds1631->f();

// Create a PHP array and echo it as JSON
$ret = array($x, $y);
echo json_encode($ret);
?>
