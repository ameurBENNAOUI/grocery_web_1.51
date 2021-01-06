<?php 
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
header('Content-type: text/json');
// error_log(int(implode(",", $data)), 0);
// error_log(strval($data), 0);
// $returnArr = array("ResponseCode"=>$data);	

// echo json_encode($returnArr);





if ($data["st"]=="c0"){

	
	$sel = $con->query("select * from category");
	$myarray = array();
	while($row = $sel->fetch_assoc())
	{
		$p['id'] = $row['id'];
		$p['catname'] = $row['catname'];
		$p['catimg'] = $row['catimg'];
		$p['count'] = $con->query("select * from subcategory where cat_id=".$row['id']."")->num_rows;
		$myarray[] = $p;
	}
	$returnArr = array("data"=>$myarray,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Liste des catégories fondée!","st"=>"c1","idc"=>0);
	echo json_encode($returnArr);


}
elseif ($data["st"]=="c1"){
	
	// echo json_encode($data);
	
	if($data['purview'] == '')
	{
		$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Quelque chose s'est mal passé!");
	}
	else
	{
		$cat_id = $data['purview'];
		
		// $cat_id =2;
		$sel = $con->query("select * from subcategory where cat_id=".$cat_id."");
		$myarray = array();
		while($row = $sel->fetch_assoc())
		{
			$p['id'] = $row['id'];
			$p['catname'] = $row['name'];
			$p['catimg'] = $row['img'];
			// $p['count'] = $con->query("select * from subcategory where cat_id=".$row['id']."")->num_rows;
			$p['count']=5;
			$myarray[] = $p;
		}
		$returnArr = array("data"=>$myarray,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Liste des catégories fondée!","st"=>"c2","idc"=>$cat_id );
		echo json_encode($returnArr);
		// $sel = $con->query("select * from subcategory where cat_id=".$cat_id." ");
		// $count = $con->query("select * from subcategory where cat_id=".$cat_id." ")->num_rows;
		// if($count != 0)
		// {
		// 	$myarray = array();
		// 	while($row = $sel->fetch_assoc())
		// 	{
		// 		$p['id'] = $row['id'];
		// 		$p['cat_id'] = $row['cat_id'];
		// 			$p['name'] = $row['name'];
		// 			$p['img'] = $row['img'];
		// 			$p['count'] = $con->query("select * from product where sid=".$row['id']."")->num_rows;
		// 			$myarray[] = $p;
		// 	}
		// 	$returnArr = array("data"=>$myarray,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"SubListe des catégories fondée!","st"=>"c1","idc"=>$cat_id);
		// }
		// else 
		// {
		// 	$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"SubCategory Not Found!!!");	
		// }

	}
	// echo json_encode($returnArr);

}




///////////////////////////////////////////////////////////

?>