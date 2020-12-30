<?php 
  require 'include/header.php';
  ?>
  <body data-col="2-columns" class=" 2-columns ">
       <div class="layer"></div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">


      <!-- main menu-->
      <!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
      <?php include('main.php'); ?>
      <!-- Navbar (Header) Ends-->

      <div class="main-panel">
        <div class="main-content">
          <div class="content-wrapper"><!--Statistics cards Starts-->

<section id="dom">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Liste de Produit</h4>
                </div>
                <div class="card-body collapse show">
                    <div class="card-block card-dashboard">
                       
                        <table class="table table-striped table-bordered dom-jQuery-events">
                            <thead>
                                <tr>
								 <th>ID</th>
                                    <th>Nom de Produit</th>
                                    <th>Image de produit</th>
									<!-- <th>Image lieé a produi</th> -->
                                    <!-- <th>Seller Name</th> -->
                                    <th>Nome de specialité</th>
									<!-- <th>Niveau</th> -->
									<th>Nom de Module</th>

                                    <th>Description</th>
                                    <th>Méthode d'impression </th>
                                    <th>Prix</th>
                                    <!-- <th>In Stock ?</th> -->
                                    <!-- <th>Status</th> -->
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $jj = $con->query("select * from product order by id desc");
                                $i=0;
                                while($rkl = $jj->fetch_assoc())
                                {
                                    $i = $i + 1;
                                ?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $rkl['pname'];?></td>
                                    <td><img src="<?php echo $rkl['pimg'];?>" width="100" height="100"/></td>
									<!-- <td><?php $sb = explode(',',$rkl['prel']);
									
									
									foreach($sb as $bb)
									{
										if($bb == '')
										{
										}
										else 
										{
										?>
										<img src="<?php echo $bb;?>" width="100" height="100"/>
										<?php 
									}
									}
									?></td> -->
                                <!-- <td><?php echo $rkl['sname'];?></td> -->
								
                                <td><?php $cat= $con->query("select * from category where id=".$rkl['cid']."")->fetch_assoc(); echo $cat['catname'];?></td>
								<!-- <td><?php $cat= $con->query("select * from subcategory where id=".$rkl['sid']."")->fetch_assoc(); echo $cat['name'];?></td> -->

								<td><?php $cat= $con->query("select * from subcategory_ where id=".$rkl['sid_']."")->fetch_assoc(); echo $cat['name'];?></td>



                                <td><?php echo substr($rkl['psdesc'],0,100).'....';?></td>    
									<td><?php echo $rkl['pgms'];?></td>
									<td><?php echo $rkl['pprice'];?></td>
									<!-- <td><?php if($rkl['stock'] == 1) {echo 'Yes';}else{echo 'No';} ?></td> -->
                                    <!-- <td><?php if($rkl['status'] == 1) {echo 'Publish';}else{echo 'Unpublish';} ?></td> -->
                                    <td>
									<a class="primary" href="product.php?edit=<?php echo $rkl['id'];?>" data-original-title="" title="">
                                            <i class="ft-edit font-medium-3"></i>
                                        </a>
										
									<a class="danger" data-original-title=""  href="?dele=<?php echo $rkl['id'];?>" title="">
                                            <i class="ft-trash font-medium-3"></i>
                                        </a>
										
										</td>
                                   
                                </tr>
                               <?php } ?>
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
if(isset($_GET['dele']))
{
$con->query("delete from product  where id=".$_GET['dele']."");
?>
	 <script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.error('le produit sélectionné a bien été supprimé.');
    setTimeout(function()
	{
		window.location.href="productlist.php";
	},1500);
  });
  </script>
  <?php
}
?>


          </div>
        </div>

        

      </div>
    </div>
   
    <?php 
  require 'include/js.php';
  ?>
    <style>
        table
        {
            font-size:13px;
        }
    </style>
    <!-- END PAGE LEVEL JS-->
  </body>


</html>