
<?php 

require 'include/dbconfig.php';

$pid = $_POST['pid'];
$c = $con->query("select * from orders where id=".$pid."")->fetch_assoc();
$uinfo = $con->query("select * from address where id=".$c['address_id']."")->fetch_assoc();
$user = $con->query("select * from user where id=".$c['uid']."")->fetch_assoc();
 

?>
<input type='button' id='btn' class="btn btn-primary text-right" value='Impression' onclick='printDiv();' style="float:right;">
<div id="divprint">
<h5><b>Commande ID :- <?php echo $pid;?></b></h5>
<h5><b>Nom du client :- <?php echo $uinfo['name'];?></b></h5>
<h5><b>Mobile client :- <?php echo $user['mobile'];?></b></h5>
<h5><b>Addresse :- <?php echo $uinfo['hno'].','.$uinfo['society'].','.$uinfo['area'].'-'.$uinfo['pincode'];?></b></h5>
<!-- <h5><b>Landmark:- <?php echo $uinfo['landmark'];?></b></h5> -->

<h5><b>Mode de paiement :- <?php echo $c['p_method'];?></b></h5>

<h5><b>Date de livraison :- <?php echo str_replace('--','',$c['ddate']);?></b></h5>
<!-- <h5><b>Delivery Slot :- <?php echo $c['timesloat'];?></b></h5> -->
<?php 
if( $c['p_method'] == 'Payez maintenant' or $c['p_method'] == 'Ramasse moi-même')
{
}
else
{
	?>
	<h5><b>Transaction Id :- <?php echo $c['tid'];?></b></h5>
	<?php 
}
?>
<div class="table-responsive">
<table class="table">
<tr>
<th>ID</th>
<th>Nom de Cours</th>
<th>Image de Cours</th>
<th>Remise</th>
<th>Impression methode</th>
<th>Prix</th>
<th>Qty</th>
<th>Totale</th>
</tr>
<?php 
$prid = explode('$;',$c['pid']);
$qty = explode('$;',$c['qty']);
$ptype = explode('$;',$c['ptype']);
$pprice = explode('$;',$c['pprice']);
$pcount = count($qty);

$op = 0;
$subtotal = 0;
	 $ksub = array();
	 
for($i=0;$i<$pcount;$i++)
{
	$op = $op + 1;
$pinfo = $con->query("select * from product where id=".$prid[$i]."")->fetch_assoc();
$discount = $pprice[$i] * $pinfo['discount']*$qty[$i] /100;
	?>
<tr>
<td><?php echo $op;?></td>
<td><?php echo $pinfo['pname'];?></td>
<td><img src="<?php echo $pinfo['pimg'];?>" width="100px"/></td>
<td><?php echo $pinfo['discount'];?></td>
<td><?php echo $ptype[$i];?></td>
<td><?php echo $pprice[$i];?></td>
<td><?php echo $qty[$i];?></td>
<td><?php echo ($pprice[$i] * $qty[$i]) - $discount;?></td>
</tr>
<?php


        $ksub [] = $subtotal  + ($qty[$i] * $pprice[$i]) - $discount;
        
} ?>
</table>
</div>
<?php
$subtotal = number_format((float)array_sum($ksub), 2, '.', '');
$tax = number_format((float) $subtotal * $c['tax']/100, 2, '.', '');
$coupon = $c['cou_amt'];
 $wallet = $c['wal_amt'];
?>
<ul class="list-group">
  <li class="list-group-item">
    <span class="badge bg-primary float-right budge-own" ><?php echo $c['p_method'];?></span> Mode de paiement
  </li>
  <li class="list-group-item">
    <span class="badge bg-info float-right budge-own" ><?php echo $subtotal?></span> Prix sous-total
  </li>
  
   <li class="list-group-item">
    <span class="badge bg-info float-right budge-own" ><?php echo $tax;?></span> Taxe
  </li>
 
  
  <?php 
  if($wallet != 0)
  {
  ?>
   <li class="list-group-item">
    <span class="badge bg-info float-right budge-own" ><?php echo $wallet;?></span> Total Montant client

  </li>
  <?php } ?>
  
  <li class="list-group-item">
    <span class="badge bg-info float-right budge-own" ><?php echo $c['total']- (($subtotal+$tax) - ($coupon + $wallet));?></span> Frais de livraison
  </li>
  
   <li class="list-group-item">
    <span class="badge bg-info float-right budge-own" ><?php echo $c['total'];?></span> Amounte
  </li>
  <li class="list-group-item">
    <span class="badge bg-warning float-right budge-own" ><?php echo $c['status'];?></span> Statut de la commande
  </li>
 
</ul>
</div>