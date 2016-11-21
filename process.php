<?php
//include('config.php');
//include "inc/init.php";

include "inc/init.php";

$type = $_POST['type'];

if($type == 'fetch')
{
	$events = array();
	
	$edata = $db->getAll("SELECT * FROM `hi_leaves` WHERE `IsApproved`= 1");
	
	
	foreach($edata as $c)
	{
	$e = array();
	//get user id from leave database
	$uid = $options->html($c->userid);
	
	//use that id to get the users name from users table
	$u = $db->getRow("SELECT * FROM `".MLS_PREFIX."users` WHERE `userid` = ?i", $uid);
	
	

    $e['id'] = $options->html($c->LeaveID);
	
    $e['title'] = $options->html($u->username).' - '.$options->html($c->LeaveType).' : '.$options->html($c->Reason);
	
	$e['url'] = 'http://localhost/staffPortal/profile.php?u='.$uid;
	
    $e['start'] = $options->html($c->LeaveFrom);
    $e['end'] = $options->html($c->LeaveTill);

   // $allday = ($options->html($c->allDay) == "true") ? true : false;
    $e['allDay'] = 'true';

    array_push($events, $e);
	}
	echo json_encode($events);
}


?>