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

<section id="dom">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Liste d'adresses utilisateur</h4>
					<div class="text-right">
					<a href="user.php" class="btn btn-primary">Retour à la liste des utilisateurs</a>
					</div>
                </div>
                <div class="card-body collapse show">
                    <div class="card-block card-dashboard">
                       
                        <table class="table table-striped table-bordered dom-jQuery-events">
                            <thead>
                                <tr>
								 <th>ID</th>
								  <th>Nom</th>
									 <th>Area</th>
									 
                                    

                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sel = $con->query("select * from address where uid=".$_GET['uid']."");
                                $i=0;
                                while($row = $sel->fetch_assoc())
                                {
                                    $i= $i + 1;
                                ?>
                                <tr>
                                    
                                    <td><?php echo $i; ?></td>
									<td><?php echo $row['name'];?></td>
									 <td><?php echo $row['area'];?></td>
									
                                  
                                   
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




          </div>
        </div>

      

      </div>
    </div>
    
    <?php 
  require 'include/js.php';
  ?>
  </body>


</html>
