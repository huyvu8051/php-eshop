<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content">
	        <div class="row">
	        	<div class="col-sm-12">
	        		<?php
	        			if(isset($_SESSION['error'])){
	        				echo "
	        					<div class='alert alert-danger'>
	        						".$_SESSION['error']."
	        					</div>
	        				";
	        				unset($_SESSION['error']);
	        			}
						$catId = "";
						if(isset($_GET['cat'])) {
							$catId = $_GET['cat'];
						}
						$conn = $pdo->open();
						$stmt2 = $conn->prepare("SELECT * FROM category WHERE id = :cat_id");
						$stmt2->execute(['cat_id'=>$catId]);
						$row2 = $stmt2->fetch();
						echo "<h2>All '".$row2['name']."' products</h2>";
	        		?>
		       		<?php
		       			$month = date('m');
		       			$conn = $pdo->open();

		       			try{
		       			 	$inc = 3;	
						    $stmt = $conn->prepare("SELECT products.*, category.name AS catname, category.id AS catid FROM products, category WHERE products.category_id = category.id AND products.category_id = :cat_id");
						    $stmt->execute(['cat_id'=>$catId]);
						    foreach ($stmt as $row) {
						    	$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
						    	$inc = ($inc == 3) ? 1 : $inc + 1;
	       						if($inc == 1) echo "<div class='row'>";
	       						echo "
	       							<div class='col-sm-4'>
	       								<div class='box box-solid'>
		       								<div class='box-body prod-body'>
		       									<img src='".$image."' width='100%' height='230px' class='thumbnail'>
		       									<h3><a href='product.php?product=".$row['slug']."'>".$row['name']."</a></h3>
		       									<h5><a href='category.php?cat=".$row['catid']."'><b>".$row['catname']."</b></a></h5>
		       								</div>
		       								<div class='box-footer'>
		       									<h4><b>&#36; ".number_format($row['price'])."</b></h4>
		       								</div>
	       								</div>
	       							</div>
	       						";
	       						if($inc == 3) echo "</div>";
						    }
						    if($inc == 1) echo "<div class='col-sm-4'></div><div class='col-sm-4'></div></div>"; 
							if($inc == 2) echo "<div class='col-sm-4'></div></div>";
						}
						catch(PDOException $e){
							echo "There is some problem in connection: " . $e->getMessage();
						}

						$pdo->close();

		       		?> 
	        	</div>
	        </div>
	      </section>
	     
	    </div>
	  </div>
  
  	<?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
</body>
</html>