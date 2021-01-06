<?php 
require 'db.php';
$data = json_decode(file_get_contents('php://input'), true);
if($data['name'] == '' or $data['email'] == '' or $data['mobile'] == '' or $data['imei']==''  or $data['password'] == '' or $data['ccode'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Quelque chose s'est mal passé!");
}
else
{
    
    $name = strip_tags(mysqli_real_escape_string($con,$data['name']));
    $email = strip_tags(mysqli_real_escape_string($con,$data['email']));
    $mobile = strip_tags(mysqli_real_escape_string($con,$data['mobile']));
	$ccode = strip_tags(mysqli_real_escape_string($con,$data['ccode']));
    $imei = strip_tags(mysqli_real_escape_string($con,$data['imei']));
     $password = strip_tags(mysqli_real_escape_string($con,$data['password']));
     
     
     
    $checkmob = $con->query("select * from user where mobile='".$mobile."'");
    $checkemail = $con->query("select * from user where mobile='".$email."'");
   
    if($checkmob->num_rows != 0)
    {
        $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Numéro de portable déjà utilisé!");
    }
     else if($checkemail->num_rows != 0)
    {
        $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Adresse e-mail déjà utilisée!");
    }
    else
    {
       
        $timestamp = date("Y-m-d H:i:s");
        
        $con->query("insert into user(`name`,`imei`,`email`,`mobile`,`rdate`,`password`,`ccode`)values('".$name."','".$imei."','".$email."','".$mobile."','".$timestamp."','".$password."','".$ccode."')");
    
        $returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Inscription réussie!");
    }
    
    
}

echo json_encode($returnArr);