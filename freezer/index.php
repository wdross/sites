<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Recent freezer temperatures</title>

	<!-- 1. Add these JavaScript inclusions in the head of your page -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.js"></script>
	<script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>

	<!-- 2. Add the JavaScript to initialize the chart on document ready -->
<script>
	var chart; // global

	/**
	 * Request data from the server, add it to the graph and set a timeout to request again
	 */
	function requestData() {
		$.ajax({
			url: 'live-server-data.php',
			success: function(point) {
				var series = chart.series[0],
				    shift = series.data.length > 60; // shift if the series is too long

				// add the point
				chart.series[0].addPoint(eval(point), true, shift);

				// call it again after 4 seconds
				setTimeout(requestData, 4000);
			},
			cache: false
		});
	}

$(document).ready(function() {
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container',
			defaultSeriesType: 'spline',
			events: {
				load: requestData
			}
		},
		title: {
			text: 'Recent freezer temperatures'
		},
		xAxis: {
			type: 'datetime',
			tickPixelInterval: 150,
			maxZoom: 20 * 1000
		},
		yAxis: {
			minPadding: 0.2,
			maxPadding: 0.2,
			title: {
				text: 'F',
				margin: 40
			}
		},
		legend: {
		    enabled: false
		},
	        series: [{
	            name: 'Deg F',
	            data: [
<?php
// Load older data when special variable is set (?history on the end of the URL)
if (isset($_GET["history"]) and (($handle = fopen("history.csv", "r")) !== FALSE)) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if (count($data) >= 2) { // valid lines have 2 or more columns of data
            echo "[" . $data[0] . "," . $data[1] . "],\n";
        }
    }
    fclose($handle);
}

// Open the CSV maintained by the background Python script and load
// our array of data with the information stored in there (since midnight)
if (($handle = fopen("freezer.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if (count($data) >= 2) { // valid lines have 2 or more columns of data
            echo "[" . $data[0] . "," . $data[1] . "],\n";
        }
    }
    fclose($handle);
}
?>
	            ]
	        }]
	    });
    });
</script>

</head>
<body>
	<!-- 3. Add the container -->
	<div id="container" style="width: 100%; height: 400px; margin: 0 auto"></div>

</body>
</html>
