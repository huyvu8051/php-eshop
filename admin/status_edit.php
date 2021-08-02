<?php
    //
    // edit order status
    //
    include 'includes/session.php';
    $conn = $pdo->open();
	// if login
	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$status = $_POST['order_status'];

        // echo $id.$status;

		try{
            
			$stmt = $conn->prepare("UPDATE orders SET status=:status WHERE id=:id");
			$stmt->execute(['status'=>$status, 'id'=>$id]);
			$_SESSION['success'] = true;
			$_SESSION['success'] = 'Update successfully';
			
		}
		catch(PDOException $e){
			echo "error: " . $e->getMessage();
            $output['error'] = true;
			$output['error'] = 'Cannot order';
		}

	}
    $pdo->close();
    header('location: orders.php');

?>