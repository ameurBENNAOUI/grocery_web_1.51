<?php 
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
header('Content-type: text/json');
// error_log(int(implode(",", $data)), 0);
// error_log(strval(is_array($data)), 0);





if ($data==null or is_array($data)){

	
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
	$returnArr = array("data"=>$myarray,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Category List Founded!","st"=>"c0","idc"=>"");
	echo json_encode($returnArr);


}
else{
	if($data['category_id'] == '')
	{
		$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
	}
	else
	{
		$cat_id = $data['category_id'];
		
		
		$sel = $con->query("select * from subcategory where cat_id=".$cat_id." ");
		$count = $con->query("select * from subcategory where cat_id=".$cat_id." ")->num_rows;
		if($count != 0)
		{
			$myarray = array();
			while($row = $sel->fetch_assoc())
			{
				$p['id'] = $row['id'];
				$p['cat_id'] = $row['cat_id'];
					$p['name'] = $row['name'];
					$p['img'] = $row['img'];
					$p['count'] = $con->query("select * from product where sid=".$row['id']."")->num_rows;
					$myarray[] = $p;
			}
			$returnArr = array("data"=>$myarray,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Subcategory List Founded!","st"=>"c1","idc"=>$cat_id);
		}
		else 
		{
			$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"SubCategory Not Found!!!");	
		}
	}
	echo json_encode($returnArr);

}



///////////////////////////////////////////////////////////

?>