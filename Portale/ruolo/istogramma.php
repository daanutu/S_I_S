<?php
include_once '../../db.php';
include_once '../completesidebar.php';
echo "<script src='../panel.js'></script>";
?>
<div class='row'>
	<div class='col-8 col-m-12 col-sm-12' style='margin-left: auto;margin-right: auto;margin-top: 10%;'>
		<div style="max-width: 920px; margin: 0px auto;">
			<b>START&nbsp;DATE&nbsp;<input size="10" type="text" value="2021-04-01" name="strdt" id="strdt">&nbsp;END&nbsp;DATE&nbsp;<input size="10" type="text" value="2021-04-30" name="enddt" id="enddt">&nbsp;<input type="button" class="login__button" value="Update" onClick="update()"></b>
		</div>
		<div id="chartContainer" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
		<div id="debug"></div>
	</div>
</div>
<script src="../js/canvasjs/jquery-1.11.1.min.js"></script>
<script src="../js/canvasjs/canvasjs.min.js"></script>
<script type='text/javascript' src="../js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<link href="../js/jquery-ui-1.12.1.custom/jquery-ui.css" rel="stylesheet">
<script>
	var chart = null;
	var dataPoints = [];
	var strtime = jQuery('#strdt').val();
	if (strtime == null) strtime = "";
	var endtime = jQuery('#enddt').val();
	if (endtime == null) endtime = "";
	window.onload = function() {
		chart = new CanvasJS.Chart("chartContainer", {
			animationEnabled: true,
			zoomEnabled: true,
			backgroundColor: "#F5F5F5",
			culture: "it",
			theme: "light1",
			title: {
				text: "Allarmi per giorno"
			},
			axisY: {
				title: "Allarmi",
				titleFontSize: 24
			},
			data: [{
				type: "column",
				color: "#eb4d4b",
				yValueFormatString: "#,### Allarmi",
				dataPoints: dataPoints
			}]
		});
		$.getJSON("../../api/gethistxday.php?strtime=" + strtime + "&endtime=" + endtime, callback);
	}

	function callback(data) {
		console.log("inizio callback");
		var unit = 0;
		for (var i = 0; i < data.dps.length; i++) {
			//console.log(data.dps[i].date);
			//console.log(data.dps[i].units);
			unit = parseInt(data.dps[i].units);
			//console.log(unit);
			dataPoints.push({
				x: new Date(data.dps[i].date),
				y: unit
			});
			//unit++;
		}
		chart.render();
		console.log("fine callback");
	}

	function update() {
		console.log("inizio update");
		strtime = jQuery('#strdt').val();
		if (strtime == null) strtime = "";
		endtime = jQuery('#enddt').val();
		if (endtime == null) endtime = "";
		console.log(strtime);
		console.log(endtime);
		chart = null;
		dataPoints = [];
		chart = new CanvasJS.Chart("chartContainer", {
			animationEnabled: true,
			zoomEnabled: true,
			backgroundColor: "#F5F5F5",
			culture: "it",
			theme: "light1",
			title: {
				text: "Allarmi per giorno"
			},
			axisY: {
				title: "Allarmi",
				titleFontSize: 24
			},
			data: [{
				type: "column",
				color: "#eb4d4b",
				yValueFormatString: "#,### Allarmi",
				dataPoints: dataPoints
			}]
		});
		$.getJSON("../../api/gethistxday.php?strtime=" + strtime + "&endtime=" + endtime, callback);
		console.log("fine update");
	}
	jQuery(function() {
		jQuery("#strdt").datepicker({
			showOn: "button",
			buttonImage: "../js/jquery-ui-1.12.1.custom/images/calendar.gif",
			buttonImageOnly: true,
			buttonText: "Select date"
		});
		jQuery("#strdt").datepicker("option", "dateFormat", "yy-mm-dd");
		jQuery("#enddt").datepicker({
			showOn: "button",
			buttonImage: "../js/jquery-ui-1.12.1.custom/images/calendar.gif",
			buttonImageOnly: true,
			buttonText: "Select date"
		});
		jQuery("#enddt").datepicker("option", "dateFormat", "yy-mm-dd");
	});
</script>