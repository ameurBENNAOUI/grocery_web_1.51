<?php 
require 'db.php';
$data = json_decode(file_get_contents('php://input'), true);

if($data['keyword'] != '')
{
    
    $cid = $data['keyword'];
    
     $counter = $con->query("select * from product where pname like '%".$cid."%' and status=1");
    if($counter->num_rows != 0)
    {
    $query = $con->query("select * from product where pname like '%".$cid."%' and status=1");
    $result = array();
    
    while($row = $query->fetch_assoc())
    {
        
    $result['id'] = $row['id'];
	$result['cat_id'] = $row['cid'];
	$result['subcat_id'] = $row['sid'];
    $result['product_name'] = $row['pname'];
    $result['product_image'] = $row['pimg'];
	$result['product_related_image'] = $row['prel'];
    $result['seller_name'] = $row['sname'];
    $result['short_desc'] = $row['psdesc'];
    $a = explode('$;',$row['pgms']);
    //print_r($a[0]);
    $ab = explode('$;',$row['pprice']);
    $k=array();
    for($i=0;$i<count($a);$i++)
    {
        $k[$i] = array("product_type"=>$a[$i],"product_price"=>$ab[$i]);
    }
    
    $result['price'] = $k;
    $result['stock'] = $row['stock'];
	$result['discount'] = $row['discount'];
    $pp[] = $result;
    }
    $returnArr = array("data"=>$pp,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Liste de course Obtenez avec succès!");
    }
    else
    {
        $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Coure non trouvé!");
    }
echo json_encode($returnArr);
}
else
{
echo "dont touch";
}