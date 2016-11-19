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
      <li ><a href='LeaveApproved.php'> Approved Leaves</a></li>
	  <li class='active'><a href='balance.php'> Leave Balances </a></li>
    </ul>
   </div><!--/.well -->
 </div><!--/span-->
 <div class="span6">
 
<?php

// get all approved leaves
$bdata = $db->getAll("SELECT * FROM `hi_balances` WHERE `userid`= $uid ");

      echo "<table class='table table-striped'>
	   <legend>Leave Balances</legend>
        <tr> <th>Year</th><th>Balance CL</th> <th>Balance EL</th><th>Balance RH</th><th>Balance ML</th></tr>";
     
	 foreach($bdata as $b){
		 

	echo 
       "<tr> 
          <td>".$options->html($b->Year)."</td> 
          <td>".$options->html($b->BalCL)."</td> 
          <td>".$options->html($b->BalEL)."</td>
		  <td>".$options->html($b->BalRH)."</td>
		  <td>".$options->html($b->BalML)."</td>

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