<?php 

require 'include/dbconfig.php';

$cid = $_POST['catid'];

$c = $con->query("select * from subcategory_ where subcat_id=".$cid."");
?>
<option value="">Select A Subcategory</option>
<?php 

while($row = $c->fetch_assoc())
{
	?>
	<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
	<?php 
}