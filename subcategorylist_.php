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
                    <h4 class="card-title">Niveaux List</h4>
                </div>
                <div class="card-body collapse show">
                    <div class="card-block card-dashboard">
                       
                        <table class="table table-striped table-bordered dom-jQuery-events">
                            <thead>
                                <tr>
								 <th>ID</th>
								 <th>Nom de Spécialité</th>
                                    <th>Nom de Niveau</th>
                                    <th>Nom de Modul</th>
                                    <th>Image de Modul</th>
									<th>Total des Cours</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sel = $con->query("select * from subcategory_");
                                $i=0;
                                while($row = $sel->fetch_assoc())
                                {
                                    $i= $i + 1;
                                ?>
                                <tr>
                                    
                                    <td><?php echo $i; ?></td>
									<td><?php $cname = $con->query("select * from category where id=".$row['cat_id']."")->fetch_assoc(); echo $cname['catname']; ?>
                                    <td><?php $cname = $con->query("select * from subcategory where id=".$row['subcat_id']."")->fetch_assoc(); echo $cname['name'];  ?>

                                    <td><?php echo $row['name'];?></td>
                                    <td><img class="media-object round-media" src="<?php echo $row['catimg'];?>" alt="Generic placeholder image" style="height: 75px;"></td>
                                    <td><?php echo $con->query("select * from product where cid=".$row['cat_id']." and sid=".$row['subcat_id']." and sid_=".$row['id']." ")->num_rows;?></td>
									<td>
									<a class="primary"  href="subcategory_.php?edit=<?php echo $row['id'];?>" data-original-title="" title="">
                                            <i class="ft-edit font-medium-3"></i>
                                        </a>
										
									<a class="danger" href="?dele=<?php echo $row['id'];?>" data-original-title="" title="">
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
$con->query("delete from subcategory_ where id=".$_GET['dele']."");
?>
	<script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.error('selected subcategory_ deleted successfully.');
    setTimeout(function()
	{
		window.location.href="subcategorylist_.php";
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
    
  </body>


</html>