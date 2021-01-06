<?php 
require 'db.php';
$data = json_decode(file_get_contents('php://input'), true);
if($data['email'] == '' or $data['ccode'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Quelque chose s'est mal passé!");
}
else
{
    
    $search = $con->query("select * from user where mobile='".$data['email']."' and ccode='".$data['ccode']."'");
    if($search->num_rows != 0)
    {
        
 $returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Otp envoyer avec succès !!!");
    }
    else
  {
      $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Numéro de portable non enregistré !!");
  }
}
echo json_encode($returnArr);
?>