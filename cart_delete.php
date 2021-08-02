<?php
	//
	// delete product in cart
	//
	include 'includes/session.php';

	$conn = $pdo->open();

	$output = array('error'=>false);
	$id = $_POST['id'];
	// check user was login
	if(isset($_SESSION['user'])){
		// delete product in db
		try{
			$stmt = $conn->prepare("DELETE FROM cart WHERE id=:id");
			$stmt->execute(['id'=>$id]);
			$output['message'] = 'Deleted';
			
		}
		catch(PDOException $e){
			$output['message'] = $e->getMessage();
		}
	}
	else{
		// delete product in session
		foreach($_SESSION['cart'] as $key => $row){
			if($row['productid'] == $id){
				unset($_SESSION['cart'][$key]);
				$output['message'] = 'Deleted';
			}
		}
	}

	$pdo->close();
	echo json_encode($output);

?>