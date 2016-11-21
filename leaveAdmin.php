<?php
/**

 */

include "inc/init.php";

if( !$user->isAdmin()) {
    header("Location: $set->url");
    exit;
}

$page->title = "Leave Management";

$presets->setActive("leaveadminpanel"); // we highlite the Leave Admin Panel link







include 'header.php';




?>

<!--<div class="container">-->
<div class="container-fluid">
<div class="row-fluid">
 <div class="span3">
   <div class="well sidebar-nav sidebar-nav-fixed">
    <ul class="nav nav-list">
      <li class="nav-header">LEAVE ADMIN</li>
      <li class='active'><a href='leaveAdmin.php'>All Leave Requests</a></li>
	  <li ><a href='leaveStats.php'>Leave Statistics</a></li>
      
    </ul>
   </div><!--/.well -->
 </div><!--/span-->
 <div class="span9">
 
<?php


//msg to the user upon interaction with the form
if(isset($page->error))
  $options->error($page->error);
else if(isset($page->success))
  $options->success($page->success);

// get all  leaves
$qdata = $db->getAll("SELECT * FROM `hi_leaves` ");





	

      echo "<table class='table table-striped table-hover'>
	   <legend>Leave Management</legend>
        <tr> <th>Employee</th><th>Applied On Date</th> <th>Leave From Date</th><th>Leave Till Date</th><th>Leave Days</th><th>Leave Type</th><th>Status</th><th>Leave Reason</th><th>Options</th><th></th><th></th></tr>";
     
	 foreach($qdata as $q){
		 
		 //get user id from leave database
	$uid = $options->html($q->userid);
	
	//use that id to get the users name from users table
	$u = $db->getRow("SELECT * FROM `".MLS_PREFIX."users` WHERE `userid` = ?i", $uid);
		 		 
		 
		 if($options->html($q->IsApproved) >0){
			$approved = "Approved"; 
		 }else {
			 $approved = "Not Approved";		 
		 }
		 
		 /*

		 */
          
		//	$id = $options->html($q->userid);
		
		
		
	echo "<form class='well form-horizontal' action='#' method='post'>
	
	
			<fieldset>";
			
			
	echo 
       "<tr> 
          <td>".$options->html($u->username)."</td> 
          <td>".$options->html($q->AppliedDate)."</td> 
          <td>".$options->html($q->LeaveFrom)."</td>
		  <td>".$options->html($q->LeaveTill)."</td>
		  <td>".$options->html($q->LeaveDays)."</td>
		  <td>".$options->html($q->LeaveType)."</td>
		  <td><mark>".$approved."</mark></td>
		  <td>".$options->html($q->Reason)."</td>
		  
		  
		  
		  <td><a  class='btn btn-primary' href='$set->url/mod.php?act=aprv&id=$u->userid&lid=$q->LeaveID&lType=$q->LeaveType&lDys=$q->LeaveDays'>Approve</a></td>
		  <td><a  class='btn'  href='$set->url/mod.php?act=deny&id=$u->userid&lid=$q->LeaveID'>Deny</a></td>
        </tr>";
		
	 }


      echo "</table>";
	  
	  echo "</fieldset>";
	  
	 echo "</form>";

?>


 </div><!--/span-->
</div><!--/row-->

</div><!--/.fluid-container-->
<!--</div><!--container-->



<?php
include 'footer.php';
?>