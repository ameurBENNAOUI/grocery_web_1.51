 <?php 
  require 'include/header.php';
  ?>
  <body data-col="2-columns" class=" 2-columns ">
      <div class="layer"></div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">


     
      <?php include('main.php'); ?>
      <!-- Navbar (Header) Ends-->

      <div class="main-panel">
        <div class="main-content">
          <div class="content-wrapper"><!--Statistics cards Starts-->
<?php if(isset($_GET['edit'])) {
$sels = $con->query("select * from template where id=".$_GET['edit']."");
$sels = $sels->fetch_assoc();
?>
<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-form">Modifier la notification</h4>
					
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form" method="post" enctype="multipart/form-data" autocomplete="off">
							<div class="form-body">
								

								

								<div class="form-group">
									<label for="cname">Message</label>
									<input type="text" id="cname" value="<?php echo $sels['message'];?>" class="form-control"  name="msg" required >
								</div>

									<div class="form-group">
									<label for="cname">Titre</label>
									<input type="text" id="dcharge" value="<?php echo $sels['title'];?>" class="form-control"  name="title"   >
								</div>

							<div class="form-group">
									<label for="cname">sélectionner l'image (facultatif)</label>
									<input type="file" id="dcharge"  class="form-control"  name="url"   >
									<?php 
									if( $sels['url'] == 'no_url')
									{
									}
									else 
									{
										?>
										<img src="<?php echo $sels['url'];?>" width="100" height="100"/>
										<?php 
									}
									?>
								</div>
								
							

								
							</div>

							<div class="form-actions">
								
							<input type="submit" name="up_quiz" class="btn btn-raised btn-raised btn-primary" value="Enregistrer"/>
							</div>
							
							
						</form>
						
						<?php 
							if(isset($_POST['up_quiz'])){
							$msg = mysqli_real_escape_string($con,$_POST['msg']);
	    $url = $_FILES["url"]["name"];
	   $title = mysqli_real_escape_string($con,$_POST['title']);
	   if(empty($url))
	   {
	       
	   $con->query("update template set message='".$msg."',title='".$title."' where id=".$_GET['edit'].""); 

	   }
	   else 
	   {
	    $target_dir = "cat/";
$url = $target_dir . basename($_FILES["url"]["name"]);
$imageFileType = strtolower(pathinfo($url,PATHINFO_EXTENSION));
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
	?>
	 <script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.error('Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.');
    setTimeout(function()
	{
		window.location.href="template.php";
	},1500);
  });
  </script>
	<?php 
   
    
}
else 
{
	move_uploaded_file($_FILES["url"]["tmp_name"], $url);
}
$con->query("update template set message='".$msg."',title='".$title."',url='".$url."' where id=".$_GET['edit'].""); 
	   }
	   
	   
	    
	 
    
?>
						
							<script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.info('Mise à jour de la notification réussie !!');
	setTimeout(function()
	{
		window.location.href="templatelist.php";
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

		
	</div>
<?php } else { ?>
<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-form">Ajouter une notification</h4>
					
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form" method="post" enctype="multipart/form-data" autocomplete="off">
							<div class="form-body">
								

								

								<div class="form-group">
									<label for="cname">Message</label>
									<input type="text" id="cname" class="form-control" placeholder="Entrez le message"  name="msg" required >
								</div>
								
								<div class="form-group">
									<label for="cname">TITRE</label>
									<input type="text" id="dcharge"  class="form-control" placeholder="Entrez le titre"  name="title"  >
								</div>
 
									<div class="form-group">
									<label for="cname">Sélectionnez l'image (facultatif)</label>
									<input type="file" id="dcharge"  class="form-control"   name="url"  >
								</div>


							

								
							</div>

							<div class="form-actions">
								
								
								<input type="submit" name="sav_quiz" class="btn btn-raised btn-raised btn-primary" value="Enregistrer"/>
							</div>
							
							
						</form>
						
						
						<?php 
							if(isset($_POST['sav_quiz'])){
							$msg = mysqli_real_escape_string($con,$_POST['msg']);
	    $url = $_FILES["url"]["name"];
	   $title = mysqli_real_escape_string($con,$_POST['title']);
	   
	   if(empty($url))
	   {
	        $url = 'no_url';
	   }
	   else 
	   {
		   
		   $target_dir = "cat/";
$url = $target_dir . basename($_FILES["url"]["name"]);
$imageFileType = strtolower(pathinfo($url,PATHINFO_EXTENSION));
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
	?>
	 <script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.error('Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.');
    setTimeout(function()
	{
		window.location.href="template.php";
	},1500);
  });
  </script>
	<?php 
   
    
}
else 
{
	move_uploaded_file($_FILES["url"]["tmp_name"], $url);
}
	   }
	   
	  
	    
	  
      $con->query("insert into template(`message`,`url`,`title`)values('".$msg."','".$url."','".$title."')");

							?>
						
							 <script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.info('Insérez la notification avec succès !!!');
   
  });
  </script>
  <?php 
							}
							?>
					</div>
				</div>
			</div>
		</div>

		
	</div>
	<?php } ?>





          </div>
        </div>

        

      </div>
    </div>
    
   <?php 
  require 'include/js.php';
  ?>
    
 
  </body>


</html>