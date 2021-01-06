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
$count = $con->query("select * from user where id=".$uid."")->num_rows;
if($count != 0)
{
$wallet = $con->query("select * from user where id=".$uid."")->fetch_assoc();
$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Porte-monnaie Équilibre Obtenez avec succès!","Wallet"=>$wallet['wallet']);
}
else 
{
	$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Pas utilisateur existant!");
}
}
echo json_encode($returnArr);

