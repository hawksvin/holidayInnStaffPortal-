<?php
/**

 */

include "inc/init.php";

//include "get-events.php";

// include db process file for full callender
//include('process.php');

$page->title = "Welcome to ". $set->site_name;

$presets->setActive("home"); // we highlith the home link


include 'header.php';


echo "
<div class=\"container\">

<div class=\"hero-unit\">

	<h3> Who's Off Today?</h3> 
	
	<hr/>
	
	<div id='wrap'>

		<div id='external-events'>
		
			<h6>Key</h6>
			
			<div class='fc-event'>Employee</div>
			
			<p>
				CL - Casual Leave
			</p>
			
			<p>
				EL - Earned Leave
			</p>
			<p>
				RH - Restricted Holiday
			</p>
			<p>
				ML - Medical Leave
			</p>
			
		
		</div>
		
		<div id='script-warning'>
			<code>get-events.php</code> must be running.
		</div>

		<div id='calendar'></div>

		<div style='clear:both'></div>

		

	</div>";
		

echo "</div>


</div> <!-- /container -->";
include 'footer.php';

?>


