<?php
require_once("../RecursosAPI/categorias.php");
?>

<!DOCTYPE HTML>
<html>

<head>
	<script>
		window.onload = function() {

			var chart = new CanvasJS.Chart("chartContainer", {
				title: {
					text: ""
				},
				axisY: {
					title: "Numero de publicaciones",
					lineColor: "#4F81BC",
					tickColor: "#4F81BC",
					labelFontColor: "#4F81BC"
				},
				axisY2: {
					title: "Porcentaje",
					suffix: "%",
					lineColor: "#C0504E",
					tickColor: "#C0504E",
					labelFontColor: "#C0504E"
				},
				data: [{
					type: "column",
					dataPoints: [
						<?php
						foreach (SortByChildsLenghts($array_categorias) as $data) {
							echo '{ label: ' . '"' . $data[0]["nombre_categoria_principal"] . '", ' . 'y: ' . count($data) . '},';
						}
						?>
					]
				}]
			});
			chart.render();
			createPareto();

			function createPareto() {
				var dps = [];
				var yValue, yTotal = 0,
					yPercent = 0;

				for (var i = 0; i < chart.data[0].dataPoints.length; i++)
					yTotal += chart.data[0].dataPoints[i].y;

				for (var i = 0; i < chart.data[0].dataPoints.length; i++) {
					yValue = chart.data[0].dataPoints[i].y;
					yPercent += (yValue / yTotal * 100);
					dps.push({
						label: chart.data[0].dataPoints[i].label,
						y: yPercent
					});
				}

				chart.addTo("data", {
					type: "line",
					yValueFormatString: "0.##\"%\"",
					dataPoints: dps
				});
				chart.data[1].set("axisYType", "secondary", false);
				chart.axisY[0].set("maximum", yTotal);
				chart.axisY2[0].set("maximum", 100);
			}

		}
	</script>
</head>

<body>
	<div id="chartContainer" style="height: 300px; width: 100%;"></div>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>

</html>