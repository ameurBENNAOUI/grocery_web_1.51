<?php 
require 'db.php';
$data = json_decode(file_get_contents('php://input'), true);
if($data['purview'] == '' or $data['year'] == '' )
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Quelque chose s'est mal passé!");
}
else
{
	$uid=$data['uid'];

	$cat_id = $data['purview'];
	$sub_cat_id = $data['year'];

	if(intval($uid)!=0){
		$count = $con->query("select * from last_visit where uid=".$uid." ")->num_rows;
		if ($count!=0){
			$con->query("update `last_visit` set `purview_id`=".$cat_id.",`year_id`=".$sub_cat_id." WHERE `uid`=1");
		}
		else{
			$con->query("insert into `last_visit`(`uid`, `purview_id`, `year_id`) values (".$uid.",".$cat_id.",".$sub_cat_id.")");
		}
	}
	
	
$sel = $con->query("select * from subcategory_ where cat_id=".$cat_id." and subcat_id=".$sub_cat_id."  ");
$count = $con->query("select * from subcategory_ where cat_id=".$cat_id." and subcat_id=".$sub_cat_id." ")->num_rows;
if($count != 0)
{
	$myarray = array();
while($row = $sel->fetch_assoc())
{
    $p['id'] = $row['id'];
	$p['cat_id'] = $row['cat_id'];
	$p['name'] = $row['name'];
	$p['img'] = $row['catimg'];
	$p['count'] = $con->query("select * from product where sid=".$row['id']."")->num_rows;
	$myarray[] = $p;
}
$returnArr = array("data"=>$myarray,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Sous-liste des catégories fondées!");
}
else 
{
$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Sous-catégorie introuvable !!!");	
}
}
echo json_encode($returnArr);
?>