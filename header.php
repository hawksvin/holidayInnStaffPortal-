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

        <script src="<?php echo $set->url; ?>/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		
	<script>

	$(document).ready(function() {

		$('#calendar').fullCalendar({
			defaultDate: '2016-09-12',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			
			//Dummy Data should get this data from a database through json
			events: [
				{
					title: 'Irvin EL',
					start: '2016-09-07T10:30:00',
					end: '2016-09-10T12:30:00'
				},
				{
					title: 'Mr Tanaka RH',
					start: '2016-09-07',
					
				},
				{
					id: 999,
					title: 'Ms Chimedza ML',
					start: '2016-09-09'
				},
				{
					id: 999,
					title: 'Tendai CL',
					start: '2016-09-16T10:30:00',
					end: '2016-09-17T12:30:00'
				},
				{
					title: 'Vivian CL',
					start: '2016-09-11',
					
				},
				{
					title: 'Munya EL',
					start: '2016-09-12',
					
				},
				{
					title: 'Xavier ML',
					start: '2016-09-12'
				},
				{
					title: 'Jane ML',
					start: '2016-09-12'
				},
				{
					title: 'Ms T CL',
					start: '2016-09-12'
				},
				{
					title: 'HolidayInn Holiday EL',
					start: '2016-09-12'
				},
				{
					title: 'Birthday Party CL',
					start: '2016-09-13'
				},
				{
					title: 'Click for Google',
					url: 'http://google.com/',
					start: '2016-09-28'
				}
			]
		});
		
	});

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
