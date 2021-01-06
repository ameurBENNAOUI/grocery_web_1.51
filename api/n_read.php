<?php 
 
 require 'db.php';
$data = json_decode(file_get_contents('php://input'), true);
$uid = $data['uid'];
$nid = $data['nid'];

if ($uid == '' or $nid == '')
{
$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Quelque chose s'est mal passé essaie encore !");
}
else 
{
	$sel = $con->query("select * from uread where uid=".$uid." and nid=".$nid."")->num_rows;
	if($sel != 0 )
	{
	    
	    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Notification déjà lue !!");
	    
		
		
	}
	else 
	{
	   $con->query("insert into uread(`uid`,`nid`)values(".$uid.",".$nid.")");
	   $udata = $con->query("select * from user where id=".$uid."")->fetch_assoc();
	$date_time = $udata['rdate'];
	
$remain = $con->query("select * from noti where date >='".$date_time."'")->num_rows;

	$read = $con->query("select * from uread where uid=".$uid."")->num_rows;
	$r_noti = $remain - $read;
	    
		$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"notification lu avec succès!","Remain_notification"=>$r_noti);
	}
}
echo json_encode($returnArr);
mysqli_close($con);
?>