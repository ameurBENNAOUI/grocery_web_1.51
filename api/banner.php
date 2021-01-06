<?php 
require 'db.php';
$sel = $con->query("select * from banner");
while($row = $sel->fetch_assoc())
{
    $myarray[] = $row;
}
$returnArr = array("data"=>$myarray,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Liste des bannières fondée!");
echo json_encode($returnArr);
?>