<?php 
require 'db.php';
$data = json_decode(file_get_contents('php://input'), true);
if($data['mobile'] == ''  or $data['password'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Quelque chose s'est mal passé!");
}
else
{
    $mobile = strip_tags(mysqli_real_escape_string($con,$data['mobile']));
    $imei = strip_tags(mysqli_real_escape_string($con,$data['imei']));
    $password = strip_tags(mysqli_real_escape_string($con,$data['password']));
    
$chek = $con->query("select * from user where (mobile='".$mobile."' or email='".$mobile."') and status = 1 and password='".$password."'");
$status = $con->query("select * from user where status = 1");
if($status->num_rows !=0)
{
if($chek->num_rows != 0)
{
    $c = $con->query("select * from user where (mobile='".$mobile."' or email='".$mobile."')  and status = 1 and password='".$password."'");
    $c = $c->fetch_assoc();

    // $dc = $con->query("select * from area_db where name='".$c['area']."'");
    // $vb = $dc->fetch_assoc();
    // $returnArr = array("user"=>$c,"d_charge"=>$vb['dcharge'],"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Connectez-vous avec succès!");

    // $dc = $con->query("select * from area_db where name='".$c['area']."'");
    // $vb = $dc->fetch_assoc();
    $returnArr = array("user"=>$c,"d_charge"=>null,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Connectez-vous avec succès!");


}
else
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Email / numéro de portable ou mot de passe invalide !!!");
}
}
else  
{
	 $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Votre statut est désactivé !!!");
}
}

echo json_encode($returnArr);