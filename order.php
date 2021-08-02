<?php
    //
    // Order
    //
    include 'includes/session.php';
    $conn = $pdo->open();
	// if login
	if(isset($_POST['address'])){
		$address = $_POST['address'];
		try{
            $now = date('Y-m-d');
            
			$stmt = $conn->prepare("INSERT INTO orders (user_id, create_date, address, status) VALUES (:user_id, :create_date, :address, :status)");
			$stmt->execute(['user_id'=>$user['id'],'create_date'=>$now, 'address'=>$address, 'status'=>'progress' ]);
			
            $order_id = $conn->lastInsertId();

            $stmt2 = $conn->prepare("SELECT * FROM cart WHERE user_id=:user_id");
            $stmt2->execute(['user_id'=>$user['id']]);
            while ($row = $stmt2->fetch()) {
                $stmt3 = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)");
                $stmt3->execute(['order_id'=>$order_id,'product_id'=>$row['product_id'], 'quantity'=>$row['quantity']]);
            }
            $stmt3 = $conn->prepare("DELETE FROM cart WHERE user_id=:user_id");          
			$stmt3->execute(['user_id'=>$user['id']]);
            header('location: profile.php');
		}
		catch(PDOException $e){
			echo "error: " . $e->getMessage();
            $output['error'] = true;
			$output['message'] = 'Cannot order';
		}

	}
    $pdo->close();

?>