<?php 
 
 require 'db.php';
$data = json_decode(file_get_contents('php://input'), true);
$uid = $data['uid'];

if ($uid == '')
{
$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Quelque chose s'est mal passé essaie encore !");
}
else 
	{
		
		$udata = $con->query("select * from user where id=".$uid."")->fetch_assoc();
	$date_time = $udata['rdate'];
$sel = $con->query("select * from noti where date >='".$date_time."' order by id desc");
if($sel->num_rows != 0)
{
$myarray = array();
$p = array();
while($row = $sel->fetch_assoc())
{
    $count = $con->query("select * from uread where uid=".$uid." and nid=".$row['id']."")->num_rows;
    $myarray['id'] = $row['id'];
    $myarray['title'] = $row['title'];
    $myarray['img'] = $row['img'];
    $myarray['msg'] = $row['msg'];
    $myarray['date'] = $row['date'];
    $myarray['IS_READ'] = $count;
    $p[] = $myarray;
}
$returnArr = array("data"=>$p,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Liste des notifications créée!");
}
else 
{
	$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Notification non fondée !!");
}
	}
echo json_encode($returnArr);
?>