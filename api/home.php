<?php 

require 'db.php';
$data = json_decode(file_get_contents('php://input'), true);
 
$uid = $data['uid'];


if($uid == '')
{
	$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Quelque chose s'est mal passé essaie encore !");
}
else 
{ 
	$v = array();
	$cp = array(); 
	$d = array();
	$p = array();
	$sec = array();
$sel = $con->query("select * from banner");
while($row = $sel->fetch_assoc())
{
    $v[] = $row;
}

$sels = $con->query("select * from category limit 6");
while($rows = $sels->fetch_assoc())
{
    $p['id'] = $rows['id'];
		$p['catname'] = $rows['catname'];
		$p['catimg'] = $rows['catimg'];
		$p['count'] = $con->query("select * from subcategory where cat_id=".$rows['id']."")->num_rows;
		$cp[] = $p;
}

$result = array();
$prod = $con->query("select * from product where cid=0 and sid=0 and sid_=0 and status=1  order by id desc limit 5 ");
	while($row = $prod->fetch_assoc())
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
	$result['discount'] = $row['discount'];
    $result['stock'] = $row['stock'];
    $d[] = $result;
	}
    

$uid=$data['uid'];

$slist = $con->query("select * from last_visit where uid = ".$uid."")->num_rows;
if($slist !=0)
{
    $u_year = $con->query("select * from last_visit where uid = ".$uid." LIMIT 1")->fetch_assoc();
    // $u_year["purview_id"];
    // $u_year["year_id"];
    $u_models = $con->query("select * from subcategory_ where cat_id = ".$u_year["purview_id"]." and subcat_id= ".$u_year["year_id"]." ");

    // print_r($u_models->fetch_assoc());

    $plist = $con->query("select * from home where status = 1");
    
    $sev = array();
       while($rp = $u_models->fetch_assoc())
       {
        // print_r($rp['subcat_id']);
        // print_r($rp['cat_id']);


         $rpq =  $con->query("select * from product where status=1 and sid=".$rp['subcat_id']." and cid=".$rp['cat_id']." and sid_=".$rp['id']."  order by id desc");
         $section = array();
       $sep = array();
         while($rps = $rpq->fetch_assoc())
         {
           $section['id'] = $rps['id'];
           $result['cat_id'] = $rps['cid'];
       $result['subcat_id'] = $rps['sid'];
       $section['product_name'] = $rps['pname'];
       $section['product_image'] = $rps['pimg'];
       $section['product_related_image'] = $rps['prel'];
       $section['seller_name'] = $rps['sname'];
       $section['short_desc'] = $rps['psdesc'];
       $a = explode('$;',$rps['pgms']);
       //print_r($a[0]);
       $ab = explode('$;',$rps['pprice']);
       $k=array();
       for($i=0;$i<count($a);$i++)
       {
           $k[$i] = array("product_type"=>$a[$i],"product_price"=>$ab[$i]);
       }
       
       $section['price'] = $k;
       $section['discount'] = $rps['discount'];
       $section['stock'] = $rps['stock'];
       $sep[] = $section;
       }
       $sev['title'] = $rp['name'];
       $sev['product_data'] = $sep;
       $sec[] = $sev;
       }



}
else 
{
    
}

$udata = $con->query("select * from user where id=".$uid."")->fetch_assoc();
$date_time = $udata['rdate'];
	
$remain = $con->query("select * from noti where date >='".$date_time."'")->num_rows;

	
	$read = $con->query("select * from uread where uid=".$uid."")->num_rows;
	$r_noti = $remain - $read;
	$curr = $con->query("select * from setting")->fetch_assoc();
	$wallet = $con->query("select * from user where id=".$uid."")->fetch_assoc();
	$kp = array('Banner'=>$v,'Catlist'=>$cp,'Productlist'=>$d,"Remain_notification"=>$r_noti,"Main_Data"=>$curr,"dynamic_section"=>$sec,"Wallet"=>$wallet['wallet']);
	
	$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Les données sont réussies!","ResultData"=>$kp);
}
echo json_encode($returnArr);
