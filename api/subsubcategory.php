<?php 
require 'db.php';
$data = json_decode(file_get_contents('php://input'), true);
if($data['category_id'] == '' or $data['subcategory_id'] == '' )
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    $cat_id = $data['category_id'];
    $subcat_id = $data['subcategory_id'];
	
$sel = $con->query("select * from subsubcategory where cat_id=".$cat_id." and subcat_id=".$subcat_id."");
$count = $con->query("select * from subsubcategory where cat_id=".$cat_id." and subcat_id=".$subcat_id." ")->num_rows;
if($count != 0)
{
	$myarray = array();
while($row = $sel->fetch_assoc())
{
     $p['id'] = $row['id'];
      $p['cat_id'] = $row['cat_id'];
      $p['subcat_id'] = $row['subcat_id'];
		$p['name'] = $row['name'];
		$p['img'] = $row['img'];
		$p['count'] = $con->query("select * from product where ssid=".$row['id']." ")->num_rows;
		$myarray[] = $p;
}
$returnArr = array("data"=>$myarray,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Subcategory List Founded!");
}
else 
{
$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"SubCategory Not Found!!!");	
}
}
echo json_encode($returnArr);
?>