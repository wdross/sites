<?php
$opts = array('http' => array(
    'method'  => 'GET',
    'header'  => "Content-Type: text/xml\r\n".
        "Authorization: Basic YWRtaW46ZWRnZTg0Mzg=\r\n"
  )
);

$context  = stream_context_create($opts);
$url = 'http://192.168.1.1/traffic_meter.htm';

$i = 0;
do {
  $i = $i + 1;
  $result = file_get_contents($url, false, $context);
  if ($result === false)
    usleep(50000); // 50ms == 50,000us
} while (($i < 10) && ($result === false));

if ($result === false)
  echo "file_get_contents() didn't work after ".$i." attempts";
else {
  // Find the row with this month's information
  $result = substr($result,strpos($result,"This month"));
  // throw away 4 cells of information
  for ($i = 1; $i <= 4; $i++) {
    $result = substr($result,strpos($result,"<td")+3);
  }
  // get rid of the paragraph & formatting
  $result = substr($result,strpos($result,"<p"));
  $result = substr($result,strpos($result,">")+1);
  // information I need it the number before the "/"
  $MB = substr($result,0,strpos($result,"/")-1);
  $used = $MB/50000*100.0; // % used
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Ross Internet data useage</title>

	<!-- 1. Add these JavaScript inclusions in the head of your page -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.js"></script>
	<script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>

	<!-- 2. Add the JavaScript to initialize the chart on document ready -->
<script>
	var chart; // global

$(document).ready(function() {
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container',
			defaultSeriesType: 'bar'
		},
		title: {
			text: 'Ross Internet data usage'
		},
		yAxis: {
			title: { text: "Percentage" },
			min: 0,
			max: 100
		},
		legend: {
		    enabled: false
		},
		xAxis: {
			categories: [
<?php
  echo "'Data (".$MB."MB of 50000MB used)',";
  // what is today's date (day within month)
  $today = getdate(); // associative array
  // how many days in this month?
  $DaysInMonth = cal_days_in_month(CAL_GREGORIAN, $today['mon'], $today['year']);
  echo "'Month (".$today['mday']." of ".$DaysInMonth." days elapsed)'],\n";
?>
			title: { text: null }
		},
	        series: [
		{
		    name: 'Current',
	            data: [
<?php
  // data used and month used ratios?  Spit them out
  $mused = $today['mday']/$DaysInMonth*100.0;
  echo $used.",".$mused."],\n";
  if ($used + 10 < $mused) // at least 10% less
    echo "color: '#00FF00'\n"; // green
  else if ($used < $mused) // not over
    echo "color: 'Yellow'\n";
  else
    echo "color: 'Red'\n"; // too much used
?>
	        }]
	    });
    });
</script>

</head>
<body>
	<!-- 3. Add the container -->
	<div id="container" style="width: 100%; height: 400px; margin: 0 auto"></div>
<?php
if ($i > 1)
  echo $i;
}
?>

</body>
</html>
