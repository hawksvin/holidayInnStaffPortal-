<?php


// we generate the navbar components in case they weren't before
if($page->navbar == array())
    $page->navbar = $presets->GenerateNavbar();

if(!$user->islg()) // if it's not logged in we hide the user menu
    unset($page->navbar[count($page->navbar)-1]);


?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $page->title; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="<?php echo $set->url; ?>/css/bootstrap.min.css">
        <!-- join the dark side :) -->
        <!-- <link rel="stylesheet" href="<?php echo $set->url; ?>/css/darkstrap.min.css">-->
        <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }			

			//style sheet for full calender
			
			#trash{
				width:32px;
				height:32px;
				float:left;
				padding-bottom: 15px;
				position: relative;
			}
		
			#wrap {
				width: 1100px;
				margin: 0 auto;
			}		
		
			#external-events {
				float: left;
				width: 150px;
				padding: 0 10px;
				border: 1px solid #ccc;
				background: #eee;
				text-align: left;
			}
		
			#external-events h4 {
				font-size: 16px;
				margin-top: 0;
				padding-top: 1em;
			}
			
			#script-warning {
				display: none;
				background: #eee;
				border-bottom: 1px solid #ddd;
				padding: 0 10px;
				line-height: 40px;
				text-align: center;
				font-weight: bold;
				font-size: 12px;
				color: red;
			}
		
			#external-events .fc-event {
				margin: 10px 0;
				cursor: pointer;
				font-size: 11px;
			}
		
			#external-events p {
				margin: 1.5em 0;
				font-size: 11px;
				color: #666;
			}
		
			#external-events p input {
				margin: 0;
				vertical-align: middle;
			}

			#calendar {
				float: right;
				width: 900px;
				font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
				font-size: 14px;
			}		
			
			
		//Style sheet for D3 Graph plotting
			
			.axis path{
				fill:none;
				stroke: black;
			}
			
			.axis {
				font-size:8pt;
				font-family:sans-serif;
			}
			
			.tick {
				fill:none;

				stroke:black;
			}
		




				
        </style>
		
        <link rel="stylesheet" href="<?php echo $set->url; ?>/css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="<?php echo $set->url; ?>/css/main.css">
		
		
		<!--Full callender libraries import -->
		<link href='css/fullcalendar.css' rel='stylesheet' />
		<link href='css/fullcalendar.print.css' rel='stylesheet' media='print' />
		<script src='js/moment.min.js'></script>
		<script src='js/jquery.min.js'></script>
		<script src='js/jquery-ui.min.js'></script>
		<script src='js/fullcalendar.min.js'></script>
		<!-- /Full callender libraries import -->
		
		
		<!--D3 Library For Plotting Graphs-->
		<script src="js/d3.js"></script>	

        <script src="<?php echo $set->url; ?>/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	

	<!--Script for fullCalender.io -->
	<script>
	
	
	$(document).ready(function() {
		
		var moment = $('#calender').fullCalendar('getDate');

		//var zone = "05:30";  //Change this to your timezone

	$.ajax({
		url: 'process.php',
        type: 'POST', // Send post data
        data: 'type=fetch',
        async: false,
        success: function(s){
        	json_events = s;
        }
	});


		/* initialize the calendar
		-----------------------------------------------------------------*/

		$('#calendar').fullCalendar({
			
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			
			defaultDate: moment,
			navLinks: true, // can click day/week names to navigate views
			
			//weekNumbers: true,
			//weekNumbersWithinDays: true,
			//weekNumberCalculation: 'ISO',
			
			eventLimit: true,
			events: JSON.parse(json_events),
			//events: [{"id":"14","title":"New Event","start":"2015-01-24T16:00:00+04:00","allDay":false}],
			//utc: true,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			}
		});


	});
	

</script>	


<!--Script for the Sentiment Analysis Chart-->
<script>

		function draw(data) {

			var margin = 50,
			width = 700,
			height = 50;

			var posWidth = d3.mean(data, function(d) {return d.pos })*1000;

			//Positive Chart
			var posChartSvg = d3.select('#posChart').append('svg').attr('width', 1000).attr('height', 22);
			var g = posChartSvg.append("posChartSvg:g");

			g.append('rect')
			.style('stroke', 'blue')
			.style('fill', 'white');

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
			.style('fill', 'blue')
			.style("opacity",0.7)
			.attr("width", posWidth);




			//Negative Chart
			var negChartSvg = d3.select('#negChart').append('svg').attr('width', 1000).attr('height', 22);

			var negWidth = d3.mean(data, function(d) {return d.neg })*1000;

			var negG = negChartSvg.append("negChartSvg:g");
			negG.append('rect')
			.style('stroke', 'red')
			.style('fill', 'white');

			negG.select('rect')
			.data(data)
			.enter();

			negG.select('rect')
			.attr('height', 20)
			.attr('width', 0)
			.attr("transform", "translate(50,0)");



			//transition animation

			negG.select('rect')
			.transition()
			.delay(100)
			.duration(3000)
			.style('fill','red')
			.style("opacity",0.7)
			.attr("width", negWidth); 



			//Neutral Chart 
			var neuChartSvg = d3.select('#neuChart').append('svg').attr('width', 1000).attr('height', 22);

			var neuWidth = d3.mean(data, function(d) {return d.neu })*1000;

			var neu = neuChartSvg.append("neuChartSvg:g");
			neu.append('rect')
			.style('stroke', 'red')
			.style('fill', 'white');

			neu.select('rect')
			.data(data)
			.enter();

			neu.select('rect')
			.attr('height', 20)
			.attr('width', 0)
			.attr("transform", "translate(50,0)");





			//transition
			neu.select('rect')
			.transition()
			.delay(100)
			.duration(3000)
			.style('fill','orange')
			.style("opacity",0.7)
			.attr("width", neuWidth); 




			//drawing the x-axis
			var x_extent = d3.extent(data, function(d){return d.pos});

			var x_scale = d3.scale.linear()
			//.range([margin,width-margin])
			.range([margin,width-margin])
			.domain(x_extent);

			var x_axis = d3.svg.axis().scale(x_scale);

			d3.select("#neuChart")
			.append("svg")
			.attr('width', 1000).attr('height', 50)
			.append("g")
			.attr("class", "x axis")
			.attr("transform", "translate(0," + (height-margin) + ")")
			.call(x_axis);

			d3.select(".x.axis")
			.append("text")
			.text("Sentiment Analysis Scores (Using Naive Bayes Algorithm)")
			.attr("x", (width / 2) - margin)
			.attr("y", margin / 1.5);


			//legend

			var legendMenu = d3.select("#neuChart").append("svg").attr('width', 1000).attr('height', 60);

			var lgnd = legendMenu.append( "legendMenu:g")

			// Nagative Menu Icon
			lgnd.append('rect')
			.style('stroke', 'red')
			.style('fill', 'red')
			.attr('height', 10)
			.attr('width', 10)
			.attr("transform", "translate(50,0)");

			// Negative Menu Label
			lgnd.append("text")
			.text("Negative")
			.attr("x", 65)
			.attr("y", 10);


			//Positive Menu Icon
			lgnd.append('rect')
			.style('stroke', 'blue')
			.style('fill', 'blue')
			.attr('height', 10)
			.attr('width', 10)
			.attr("transform", "translate(50,20)");

			//Positive Menu Label
			lgnd.append("text")
			.text("Positive")
			.attr("x", 65)
			.attr("y", 30);


			//Neutral Menu Icon
			lgnd.append('rect')
			.style('stroke', 'orange')
			.style('fill', 'orange')
			.attr('height', 10)
			.attr('width', 10)
			.attr("transform", "translate(50,40)");

			//Neutral Menu Label
			lgnd.append("text")
			.text("Neutral")
			.attr("x", 65)
			.attr("y", 50);

}

</script>

	

    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]--> 

       

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="<?php echo $set->url; ?>"><?php echo $set->site_name; ?></a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-left">
<?php
// we generate a simple menu this may need to be adjusted depending on your needs
// but it should be ok for most common items
foreach ($page->navbar as $key => $v) {

    if ($v[0] == 'item') {
    
        echo "<li".($v[1]['class'] ? " class='".$v[1]['class']."'" : "").">
            <a href='".$v[1]['href']."'>".$v[1]['name']."</a></li>";
    
    } else if($v[0] == 'dropdown') {

        echo "<li class='dropdown".
            // extra classes 
            ($v['class'] ? " ".$v['class'] : "")."'".
            // extra style
            ($v['style'] ? " style='".$v['style']."'" : "").">
            
            <a href='#' class='dropdown-toggle' data-toggle='dropdown'>".$v['name']." <b class='caret'></b></a>
            <ul class='dropdown-menu'>";
        foreach ($v[1] as $k => $v) 
            echo "<li".
                
                ($v['class'] ? " class='".$v['class']."'" : "").">

                <a href='".$v['href']."'>".$v['name']."</a></li>";                                
        echo "</ul></li>";

    }
    
}

echo "</ul>";

if(!$user->islg()) { 

echo "<span class='pull-right'>
        <a href='$set->url/register.php' class='btn btn-primary btn-small'>Sign Up</a>
        <!-- <a href='$set->url/login.php' class='btn btn-small'>Login</a> -->
        <a href='#loginModal' data-toggle='modal' class='btn btn-small'>Login</a>
    </span>
    ";
}

echo "

            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>";




if($user->data->banned) {
  
    // we delete the expired banned
    $_unban = $db->getAll("SELECT `userid` FROM `".MLS_PREFIX."banned` WHERE `until` < ".time());
    if($_unban) 
        foreach ($_unban as $_usr) {
            $db->query("DELETE FROM `".MLS_PREFIX."banned` WHERE `userid` = ?i", $_usr->userid);
            $db->query("UPDATE `".MLS_PREFIX."users` SET `banned` = '0' WHERE `userid` = ?i", $_usr->userid);             
        }


    $_banned = $user->getBan();
    if($_banned)
    $options->error("You were banned by <a href='$set->url/profile.php?u=$_banned->by'>".$user->showName($_banned->by)."</a> for `<i>".$options->html($_banned->reason)."</i>`.
        Your ban will expire in ".$options->tsince($_banned->until, "from now.")."
        ");


    


}



if($user->islg() && $set->email_validation && ($user->data->validated != 1)) {
    $options->fError("Your account is not yet acctivated ! Please check your email !");
}

if(file_exists('install.php')) {
    $options->fError("You have to delete the install.php file before you start using this app.");
}




if(isset($_SESSION['success'])){
    $options->success($_SESSION['success']);
    unset($_SESSION['success']);
}
if(isset($_SESSION['error'])){
    $options->error($_SESSION['error']);
    unset($_SESSION['error']);

}
flush(); // we flush the content so the browser can start the download of css/js
