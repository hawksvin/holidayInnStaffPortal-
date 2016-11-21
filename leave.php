<?php
/**

 */

include "inc/init.php";

if(!$user->islg()){
	header("Location: ".$set->url);
	exit;
}

if(isset($_GET['id']) && $user->group->canedit && $user->exists($_GET['id'])) {
	$uid = (int)$_GET['id'];
	//$can_edit = 1;
}else{
	$uid = $user->data->userid;
	//$can_edit = 0;
}
$u = $db->getRow("SELECT * FROM `".MLS_PREFIX."users` WHERE `userid` = ?i", $uid);

$presets->setActive("leavepanel"); // we highlite the Leave Panel link

$page->title = "Leave Panel for ". $options->html($u->username);

$act = isset($_GET['act']) ? $_GET['act'] : NULL;

if($_POST) {
	
	if($act == "add"){
		
		
		$userid = $uid;  // get user id
		
		$AppliedDate = $_POST['AppliedDate'];
		
		$LeaveFrom = $_POST['LeaveFrom'];
			
		$LeaveTill = $_POST['LeaveTill'];
		
		$LeaveType = $_POST['LeaveType'];
		
		$Reason = $_POST['Reason'];
		
		$leaveBal = 0;
		
		
		//calculating date differences
		
		$date1 = new DateTime($LeaveFrom);
		$date2 = new DateTime($LeaveTill);
		 
		 $diff = $date2->diff($date1)->format("%a");
		 
		 //check if the user still has anyLeave balances before submitting

		 
		 
		 //get Leave balances from Database
		 
		 $bL = $db->getRow("SELECT * FROM `".MLS_PREFIX."balances` WHERE `userid` = ?i", $userid);
		 
		 //$leaveBal = $bL->BalCL;
		 
	if(($LeaveType == 'CL') && ($diff > 0 && $diff <= $bL->BalCL)){
		
		if($db->query("INSERT INTO hi_leaves (userid,AppliedDate,LeaveFrom,LeaveTill,LeaveDays,LeaveType, Reason) VALUES ('$userid','$AppliedDate','$LeaveFrom','$LeaveTill','$diff','$LeaveType', '$Reason')")){
			
		$page->success = "Leave requested successfully !";	
			
		}else{
			
			$page->error = "OOps! Sorry Leave Request not submitted, An Error Occured :( ";
			
		}
		
	}else if (($LeaveType == 'EL') && ($diff > 0 && $diff <= $bL->BalEL)){
		
		if($db->query("INSERT INTO hi_leaves (userid,AppliedDate,LeaveFrom,LeaveTill,LeaveDays,LeaveType, Reason) VALUES ('$userid','$AppliedDate','$LeaveFrom','$LeaveTill','$diff','$LeaveType', '$Reason')")){
			
		$page->success = "Leave requested successfully !";	
			
		}else{
			
			$page->error = "OOps! Sorry Leave Request not submitted, An Error Occured :( ";
			
		}	
		
	}else if (($LeaveType == 'RH') && ($diff > 0 && $diff <= $bL->BalRH)){
		
		if($db->query("INSERT INTO hi_leaves (userid,AppliedDate,LeaveFrom,LeaveTill,LeaveDays,LeaveType, Reason) VALUES ('$userid','$AppliedDate','$LeaveFrom','$LeaveTill','$diff','$LeaveType', '$Reason')")){
			
		$page->success = "Leave requested successfully !";	
			
		}else{
			
			$page->error = "OOps! Sorry Leave Request not submitted, An Error Occured :( ";
			
		}
			
		
	}else if (($LeaveType == 'ML') && ($diff > 0 && $diff <= $bL->BalML)) {
		
		if($db->query("INSERT INTO hi_leaves (userid,AppliedDate,LeaveFrom,LeaveTill,LeaveDays,LeaveType, Reason) VALUES ('$userid','$AppliedDate','$LeaveFrom','$LeaveTill','$diff','$LeaveType', '$Reason')")){
			
		$page->success = "Leave requested successfully !";	
			
		}else{
			
			$page->error = "OOps! Sorry Leave Request not submitted, An Error Occured :( ";
			
		}
		
	
	}else {
		
		$page->error = "Sorry You Cannot Take <mark>$diff</mark> Day(s)!, Please Check Your <a href='balance.php'>Leave Balances</a> :( ";
			
	}
		

		
	}
	
	

}





include 'header.php';

?>

<div class="container">
<div class="container-fluid">
<div class="row-fluid">
 <div class="span4">
   <div class="well sidebar-nav sidebar-nav-fixed">
    <ul class="nav nav-list">
      <li class="nav-header">LEAVE OPTIONS</li>
      <li class='active'><a href='?'> Leave Request</a></li>
      <li><a href='leaveApproved.php'> Approved Leaves</a></li>
	  <li><a href='history.php'>Leave History</a></li>
	  <li><a href='balance.php'> Leave Balances</a></li>
    </ul>
   </div><!--/.well -->
 </div><!--/span-->
 <div class="span6">
 
<?php
//msg to the user upon interaction with the form
if(isset($page->error))
  $options->error($page->error);
else if(isset($page->success))
  $options->success($page->success);



echo "
  <form class='form-horizontal' action='?act=add' method='post'>
      <fieldset>

      <legend>Leave Request</legend>";
	  
	// script to get current time and date
	
	$now = new DateTime();
	
	//mySQL date time format
	//echo $now->format('Y-m-d H:i:s');
	
	$appliedDatenow = $now->format('Y-m-d');
	
	
	
	//Start Date
	echo "
      <div class='control-group'>
        
        <div class='controls'>
          <input id='AppliedDate' name='AppliedDate' type='hidden' value='$appliedDatenow' class='input-xlarge'>
        </div>
      </div>";
	  
	    echo "
      <div class='control-group'>
        <label class='control-label' for=''>"."Leave From Date"."</label>
        <div class='controls'>
          <input id='LeaveFrom' name='LeaveFrom' type='date'  value='' class='input-xlarge' required>
        </div>
      </div>";
	  
 echo "
      <div class='control-group'>
        <label class='control-label' for=''>"."Leave Till Date"."</label>
        <div class='controls'>
          <input id='LeaveTill' name='LeaveTill' value='' type='date' class='input-xlarge' required>
        </div>
      </div>";
	
	


  echo "
      <div class='control-group'>
        <label class='control-label' for='leaveType'>"."Leave Type"."</label>
        <div class='controls'>
          <select id='leavetype' name='LeaveType' class='input-xlarge'>
			
            
            <option value='CL' selected='selected'>Casual Leave</option>
			<option value='EL'>Earned Leave</option>
			<option value='RH'>Restricted Holiday</option>
			<option value='ML'>Medical Leave</option>
			
			
			
          </select>
        </div>
      </div>";

  echo "
      <div class='control-group'>
        <label class='control-label' for=''>"."Reason For Leave"."</label>
        <div class='controls'>
          <textarea id='Reason' placeholder='Please provide reason for Requesting this Leave' name='Reason' class='input-xlarge' maxlength='255' required></textarea>
        </div>
      </div>";
  


echo "<div class='control-group'>
        <div class='controls'>
          <button class='btn btn-primary'>Request</button>
        </div>
      </div>

      </fieldset>
  </form>";

?>


 </div><!--/span-->
</div><!--/row-->

</div><!--/.fluid-container-->
</div><!--container-->



<?php
include 'footer.php';
?>