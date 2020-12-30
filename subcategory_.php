<?php 
  require 'include/header.php';
  ?>
<?php 
function resizeImage($resourceType,$image_width,$image_height,$resizeWidth,$resizeHeight) {
    // $resizeWidth = 100;
    // $resizeHeight = 100;
    $imageLayer = imagecreatetruecolor($resizeWidth,$resizeHeight);
    $background = imagecolorallocate($imageLayer , 0, 0, 0);
        // removing the black from the placeholder
        imagecolortransparent($imageLayer, $background);

        // turning off alpha blending (to ensure alpha channel information
        // is preserved, rather than removed (blending with the rest of the
        // image in the form of black))
        imagealphablending($imageLayer, false);

        // turning on alpha channel information saving (to ensure the full range
        // of transparency is preserved)
        imagesavealpha($imageLayer, true);
    imagecopyresampled($imageLayer,$resourceType,0,0,0,0,$resizeWidth,$resizeHeight, $image_width,$image_height);
    return $imageLayer;
}
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
<?php if(isset($_GET['edit'])) {
$sels = $con->query("select * from subcategory_ where id=".$_GET['edit']."");
$sels = $sels->fetch_assoc();
?>
<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-form">Modifier Module</h4>
					
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form" method="post" enctype="multipart/form-data">
							<div class="form-body">
								

							<div class="form-group">
											<label for="projectinput6">Choisir une specialité</label>
											<select id="cat_change" name="spec" class="form-control" required>
												<option value="" selected="" disabled="">Choisir une specialité</option>
												<?php 
												$sk = mysqli_query($con,"select * from category");
												while($h = mysqli_fetch_assoc($sk))
												{
												?>
												<option value="<?php echo $h['id'];?>" <?php if($h['id'] == $sels['cat_id']) {echo 'selected';}?> > <?php echo $h['catname'];?></option>
												<?php } ?>
												
											</select>
										</div>

								<div class="form-group">
									<label for="projectinput6">Choisir une niveau</label>
								
										<select id="cat_change" name="niveau" class="form-control" required>
												<option value="" selected="" disabled="">Choisir une niveau</option>
												<?php 
												$sk = mysqli_query($con,"select * from subcategory where cat_id=".$sels['cat_id']."");
												while($h = mysqli_fetch_assoc($sk))
												{
												?>
												<option value="<?php echo $h['id'];?>" <?php if($h['id'] == $sels['subcat_id']) {echo 'selected';}?> > <?php echo $h['name'];?></option>
												<?php } ?>
												
									</select>
										
								</div>

								<div class="form-group">
									<label for="cname">Nom de Module </label>
									<input type="text" id="cname" value="<?php echo $sels['name'];?>" class="form-control"  name="module" required >
								</div>

								

								<div class="form-group">
									<label>Image de niveau</label>
									<input type="file" name="f_up" class="form-control-file" id="projectinput8">
								</div>
								
								<div class="form-group">
								    <img src="<?php echo $sels['img'];?>" class="media-object round-media"  style="height: 75px;"/>
								    </div>

								
							</div>

							<div class="form-actions">
								
								<button type="submit" name="up_cat" class="btn btn-raised btn-raised btn-primary">
									<i class="fa fa-check-square-o"></i> Enregistrer
								</button>
							</div>
							
							<?php 
							if(isset($_POST['up_cat'])){
							// $cname = mysqli_real_escape_string($con,$_POST['cname']);
							$cid = $_POST['spec'];

							$niveau = mysqli_real_escape_string($con,$_POST['niveau']);

							// $scname_ = mysqli_real_escape_string($con,$_POST['cname']);
							$module=mysqli_real_escape_string($con,$_POST['module']);
							
							echo $cid;
							echo $scname_;
							echo $subcatname;

	if(!empty($_FILES["f_up"]["name"]))
	{
							

        $fileName = $_FILES['f_up']['tmp_name'];
        $sourceProperties = getimagesize($fileName);
        $resizeFileName = time();
        $uploadPath = "cat/";
        $fileExt = pathinfo($_FILES['f_up']['name'], PATHINFO_EXTENSION);
        $uploadImageType = $sourceProperties[2];
        $sourceImageWidth = $sourceProperties[0];
        $sourceImageHeight = $sourceProperties[1];
		$new_width = $sourceImageWidth;
        $new_height = $sourceImageHeight;
        switch ($uploadImageType) {
            case IMAGETYPE_JPEG:
                $resourceType = imagecreatefromjpeg($fileName); 
                $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight,$new_width,$new_height);
                imagejpeg($imageLayer,$uploadPath."thump_".$resizeFileName.'.'. $fileExt);
                break;

            case IMAGETYPE_GIF:
                $resourceType = imagecreatefromgif($fileName); 
                $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight,$new_width,$new_height);
                imagegif($imageLayer,$uploadPath."thump_".$resizeFileName.'.'. $fileExt);
                break;

            case IMAGETYPE_PNG:
                
                $resourceType = imagecreatefrompng($fileName); 
                $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight,$new_width,$new_height);
                imagepng($imageLayer,$uploadPath."thump_".$resizeFileName.'.'. $fileExt);
                
                break;

            default:
                $imageProcess = 0;
                break;
        }
        
       $url = $uploadPath."thump_".$resizeFileName.".". $fileExt;
$con->query("update subcategory_ set name='".$module."',subcat_id='".$niveau."',catimg='".$url."',cat_id=".$cid." where id=".$_GET['edit']."");
 
}
else 
{
    $con->query("update subcategory_ set name='".$module."',subcat_id='".$niveau."',cat_id=".$cid." where id=".$_GET['edit']."");
}
?>
						
							<script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.info('Mise à jour du module réussie !!');
	setTimeout(function()
	{
		window.location.href="subcategorylist_.php";
	},1500);
    
  });
  </script>
  <?php 
							}
							?>
						</form>
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
					<h4 class="card-title" id="basic-layout-form">Ajouter une Module</h4>
					
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form" method="post" enctype="multipart/form-data">
							<div class="form-body">
								
							<div class="form-group">
											<label for="projectinput6">Choisir une specialité</label>
											<select id="cat_change" name="catname" class="form-control" required>
												<option value="" selected="" disabled="">Choisir une specialité</option>
												<?php 
												$sk = mysqli_query($con,"select * from category");
												while($h = mysqli_fetch_assoc($sk))
												{
												?>
												<option value="<?php echo $h['id'];?>"><?php echo $h['catname'];?></option>
												<?php } ?>
												
											</select>
										</div>

								<div class="form-group">
									<label for="projectinput6">Choisir une niveau</label>
									<select id="sub_list" name="subcatname" class="form-control" required>
										<option value="" selected="" disabled="">Choisir une niveau</option>
										
									</select>
								</div>
								
								<div class="form-group">
									<label for="cname">Nom de Module </label>
									<input type="text" id="cname" class="form-control"  name="cname" required >
								</div>

								

								<div class="form-group">
									<label>Image de niveau</label>
									<input type="file" name="f_up" class="form-control-file" id="projectinput8">
								</div>

								
							</div>

							<div class="form-actions">
								
								<button type="submit" name="sub_cat" class="btn btn-raised btn-raised btn-primary">
									<i class="fa fa-check-square-o"></i> Enregistrer
								</button>
							</div>
							
							<?php 
							if(isset($_POST['sub_cat'])){
							$scname_ = mysqli_real_escape_string($con,$_POST['cname']);

							// $scname_ = mysqli_real_escape_string($con,$_POST['cname']);
							$subcatname=mysqli_real_escape_string($con,$_POST['subcatname']);
							$cid = $_POST['catname'];

							// echo $scname_;
							// echo $subcatname;

							// return $cid;
							
        $fileName = $_FILES['f_up']['tmp_name'];
        $sourceProperties = getimagesize($fileName);
        $resizeFileName = time();
        $uploadPath = "product/";
        $fileExt = pathinfo($_FILES['f_up']['name'], PATHINFO_EXTENSION);
        $uploadImageType = $sourceProperties[2];
        $sourceImageWidth = $sourceProperties[0];
        $sourceImageHeight = $sourceProperties[1];
		$new_width = $sourceImageWidth;
        $new_height = $sourceImageHeight;
        switch ($uploadImageType) {
            case IMAGETYPE_JPEG:
                $resourceType = imagecreatefromjpeg($fileName); 
                $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight,$new_width,$new_height);
                imagejpeg($imageLayer,$uploadPath."thump_".$resizeFileName.'.'. $fileExt);
                break;

            case IMAGETYPE_GIF:
                $resourceType = imagecreatefromgif($fileName); 
                $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight,$new_width,$new_height);
                imagegif($imageLayer,$uploadPath."thump_".$resizeFileName.'.'. $fileExt);
                break;

            case IMAGETYPE_PNG:
                
                $resourceType = imagecreatefrompng($fileName); 
                $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight,$new_width,$new_height);
                imagepng($imageLayer,$uploadPath."thump_".$resizeFileName.'.'. $fileExt);
                
                break;

            default:
                $imageProcess = 0;
                break;
        }
        
        $url = $uploadPath."thump_".$resizeFileName.".". $fileExt;
		$con->query("insert into subcategory_(`cat_id`,`subcat_id`,`name`,`catimg`)values(".$cid.",'".$subcatname."','".$scname_."','".$url."')");
?>
						
							 <script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s
    
    toastr.info('Insérer le module avec succès !!!');
   
  });
  </script>
  <?php 
							}
							?>
						</form>
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
    
    <script>
   $(document).on('change','#cat_change',function()
	{
		var value = $(this).val();
		
		$.ajax({
			type:'post',
			url:'getsub.php',
			data:
			{
				catid:value
			},
			success:function(data)
			{
				$('#sub_list').html(data);
			}
		});
	});
	</script>
	

  </body>


</html>