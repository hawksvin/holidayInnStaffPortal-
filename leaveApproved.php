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

include 'header.php';


?>

<div class="container">
<div class="container-fluid">
<div class="row-fluid">
 <div class="span4">
   <div class="well sidebar-nav sidebar-nav-fixed">
    <ul class="nav nav-list">
      <li class="nav-header">LEAVE OPTIONS</li>
      <li ><a href='leave.php'> Leave Request</a></li>
      <li class='active'><a href='LeaveApproved.php'> Approved Leaves</a></li>
	  <li><a href='balance.php'> Leave Balances </a></li>
    </ul>
   </div><!--/.well -->
 </div><!--/span-->
 <div class="span6">
 
<?php

// get all approved leaves
$qdata = $db->getAll("SELECT * FROM `hi_leaves` WHERE `userid` = $uid and `IsApproved`= 1");

$verified = "";
$approved = '';


	 
	 

      echo "<table class='table table-striped'>
	   <legend>Approved Leaves</legend>
        <tr> <th>Leave ID</th><th>Applied On Date</th> <th>Leave From Date</th><th>Leave Till Date</th><th>Leave Days</th><th>Leave Type</th><th>Verified</th><th>Approved</th><th>Leave Reason</th></tr>";
     
	 foreach($qdata as $q){
		 
		 if($options->html($q->IsVerified) >0){
			$verified = "Yes"; 
		 }else {
			 $verified = "No";		 
		 }
		 
		 
		 if($options->html($q->IsApproved) >0){
			$approved = "Yes"; 
		 }else {
			 $approved = "No";		 
		 }
		 
		 /*
		 $leaveFrm = $options->html($q->LeaveFrom);
		 $leaveTl = $options->html($q->LeaveTill);
		 
		 $date1 = new DateTime($leaveFrm);
		 $date2 = new DateTime($leaveTl);
		 
		 $diff = $date2->diff($date1)->format("%a");
		 */
           
	echo 
       "<tr> 
          <td>".$options->html($q->LeaveID)."</td> 
          <td>".$options->html($q->AppliedDate)."</td> 
          <td>".$options->html($q->LeaveFrom)."</td>
		  <td>".$options->html($q->LeaveTill)."</td>
		  <td>".$options->html($q->LeaveDays)."</td>
		  <td>".$options->html($q->LeaveType)."</td>
		  <td>".$verified."</td>
		  <td>".$approved."</td>
		  <td>".$options->html($q->Reason)."</td>
        </tr>";
	 }


      echo "</table>";

?>


 </div><!--/span-->
</div><!--/row-->

</div><!--/.fluid-container-->
</div><!--container-->



<?php
include 'footer.php';
?>