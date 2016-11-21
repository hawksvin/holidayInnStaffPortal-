<?php

include "inc/init.php";

if( !$user->isAdmin()) {
    header("Location: $set->url");
    exit;
}

$page->title = "Leave Management";

$presets->setActive("leaveadminpanel"); // we highlite the Leave Admin Panel link


include 'header.php';


 // get total ML, RH, EL and CL from database and create a JSON file
 
 $cldata = $db->getAll("SELECT * FROM `hi_leaves` WHERE `LeaveType` = 'CL' and `IsApproved`= 1");
 
 $eldata = $db->getAll("SELECT * FROM `hi_leaves` WHERE `LeaveType` = 'EL' and `IsApproved`= 1");
  
 $rhdata = $db->getAll("SELECT * FROM `hi_leaves` WHERE `LeaveType` = 'RH' and `IsApproved`= 1");
   
 $mldata = $db->getAll("SELECT * FROM `hi_leaves` WHERE `LeaveType` = 'ML' and `IsApproved`= 1");
	

 $cltotal = count($cldata);	
 $eltotal = count($eldata);	
 $rhtotal = count($rhdata);
 $mltotal = count($mldata);	

 
//create json file data.json in directory
 
$fp = fopen('data.json','w');


$Ldata = array();

$e = array();

$e['RH'] = $rhtotal;
$e['CL'] = $cltotal;
$e['EL'] = $eltotal;
$e['ML'] = $mltotal;

array_push($Ldata, $e);

$jsonOutputData = json_encode($Ldata);

//write output data to json file 
fwrite($fp, $jsonOutputData);

fclose($fp); //close file connection

?>

<!--<div class="container">-->
<div class="container-fluid">
<div class="row-fluid">
 <div class="span3">
   <div class="well sidebar-nav sidebar-nav-fixed">
    <ul class="nav nav-list">
      <li class="nav-header">LEAVE ADMIN</li>
      <li ><a href='leaveAdmin.php'>All Leave Requests</a></li>
	  <li class='active'><a href='leaveStats.php'>Leave Statistics</a></li>
      
    </ul>
   </div><!--/.well -->
 </div><!--/span-->
 <div class="span9">
 
 <!--Script for Plotting Leave Graphs-->
<script>

		function draw(data) {

			var margin = 50,
			width = 700,
			height = 50;

			var clWidth = d3.mean(data, function(d) {return d.CL })*10;

			//Casual Leaves Chart
			var clChartSvg = d3.select('#clChart').append('svg').attr('width', 1000).attr('height', 22);
			var g = clChartSvg.append("clChartSvg:g");

			g.append('rect')
			.style('stroke', '#00C7D4')
			.style('fill', '#00C7D4');

			g.select('rect')
			.data(data)
			.enter();

			g.select('rect')
			.attr('height', 20)
			.attr('width', 0)
			.attr("transform", "translate(50,0)");

			//transition animation
			g.select('rect')
			.transition()
			.delay(100)
			.duration(3000)
			.style('fill', '#00C7D4')
			.style("opacity",0.7)
			.attr("width", clWidth);




			//Erned Leave Chart
			var elChartSvg = d3.select('#elChart').append('svg').attr('width', 1000).attr('height', 22);

			var elWidth = d3.mean(data, function(d) {return d.EL })*10; //get earned leave data from json file

			var eL = elChartSvg.append("elChartSvg:g");
			eL.append('rect')
			.style('stroke', '#48AA43')
			.style('fill', '#48AA43');

			eL.select('rect')
			.data(data)
			.enter();

			eL.select('rect')
			.attr('height', 20)
			.attr('width', 0)
			.attr("transform", "translate(50,0)");

			//transition animation
			eL.select('rect')
			.transition()
			.delay(100)
			.duration(3000)
			.style('fill','#48AA43')
			.style("opacity",0.7)
			.attr("width", elWidth); 


			
			
			

			//Medical Leave Chart
			var mlChartSvg = d3.select('#mlChart').append('svg').attr('width', 1000).attr('height', 22);

			var mlWidth = d3.mean(data, function(d) {return d.ML })*10;

			var ml = mlChartSvg.append("mlChartSvg:g");
			ml.append('rect')
			.style('stroke', '#A2A2AC')
			.style('fill', '#A2A2AC');

			ml.select('rect')
			.data(data)
			.enter();

			ml.select('rect')
			.attr('height', 20)
			.attr('width', 0)
			.attr("transform", "translate(50,0)");


			//transition
			ml.select('rect')
			.transition()
			.delay(100)
			.duration(3000)
			.style('fill','#A2A2AC')
			.style("opacity",0.7)
			.attr("width", mlWidth); 
			
			
			
			
			
			//restricted Holiday chart
			var resHolChartSvg = d3.select('#resHol').append('svg').attr('width', 1000).attr('height', 22);

			var resWidth = d3.mean(data, function(d) {return d.RH })*10;

			var res = resHolChartSvg.append("resHolChartSvg:g");
			res.append('rect')
			.style('stroke', '#FF30D0')
			.style('fill', '#FF30D0');

			res.select('rect')
			.data(data)
			.enter();

			res.select('rect')
			.attr('height', 20)
			.attr('width', 0)
			.attr("transform", "translate(50,0)");

			//transition
			res.select('rect')
			.transition()
			.delay(100)
			.duration(3000)
			.style('fill','#FF30D0')
			.style("opacity",0.7)
			.attr("width", resWidth); 
			
			
			


			//drawing the x-axis
			var x_extent = d3.extent(data, function(d){return d.pos});

			var x_scale = d3.scale.linear()
			//.range([margin,width-margin])
			.range([margin,width-margin])
			.domain(x_extent);

			var x_axis = d3.svg.axis().scale(x_scale);

			d3.select("#mlChart")
			.append("svg")
			.attr('width', 1000).attr('height', 50)
			.append("g")
			.attr("class", "x axis")
			.attr("transform", "translate(0," + (height-margin) + ")")
			.call(x_axis);

			d3.select(".x.axis")
			.attr("x", (width / 2) - margin)
			.attr("y", margin / 1.5);


			//legend

			var legendMenu = d3.select("#mlChart").append("svg").attr('width', 1000).attr('height', 80);

			var lgnd = legendMenu.append( "legendMenu:g")

			
			
			// Earned Leave Menu Icon
			lgnd.append('rect')
			.style('stroke', '#48AA43')
			.style('fill', '#48AA43')
			.attr('height', 10)
			.attr('width', 10)
			.attr("transform", "translate(50,0)");

			// Earned Leave Menu Label
			lgnd.append("text")
			.text("Earned Leave")
			.attr("x", 65)
			.attr("y", 10);


			
			
			//Casual Leave Menu Icon
			lgnd.append('rect')
			.style('stroke', '#00C7D4')
			.style('fill', '#00C7D4')
			.attr('height', 10)
			.attr('width', 10)
			.attr("transform", "translate(50,20)");

			//Casual Leave Menu Label
			lgnd.append("text")
			.text("Casual Leaves")
			.attr("x", 65)
			.attr("y", 30);

			
			
			//Medical Leave Menu Icon
			lgnd.append('rect')
			.style('stroke', '#A2A2AC')
			.style('fill', '#A2A2AC')
			.attr('height', 10)
			.attr('width', 10)
			.attr("transform", "translate(50,40)");

			//Medical Leave Menu Label
			lgnd.append("text")
			.text("Medical Leaves")
			.attr("x", 65)
			.attr("y", 50);
			
			
			
			//Restricted Holiday
			
			lgnd.append('rect')
			.style('stroke', '#FF30D0')
			.style('fill', '#FF30D0')
			.attr('height', 10)
			.attr('width', 10)
			.attr("transform", "translate(50,60)");

			//Restricted Holiday Label
			lgnd.append("text")
			.text("Restricted Holidays")
			.attr("x", 65)
			.attr("y", 70);		
}

</script>
 
	<legend>Leave Statistics</legend> 
	
		<!--stats chart goes here-->
		
		<div id="leaveStatsChart">
			<div id = "clChart"></div>
			<div id = "elChart"></div>
			<div id="resHol"></div>
			<div id = "mlChart"></div>
			
		</div>
		
 </div><!--/span-->
</div><!--/row-->

		<!--Script to Plot D3 graph-->
		<script>
			d3.json("data.json", draw);
		</script>	

</div><!--/.fluid-container-->
<!--</div><!--container-->



<?php
include 'footer.php';
?>