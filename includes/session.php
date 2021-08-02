<?php
	include 'includes/conn.php';
	session_start();
	// if session user role is admin then redirect into admin page
	if(isset($_SESSION['admin'])){
		header('location: admin/products.php');
	}

	// if session user role is user then get user infomation into $user variable
	if(isset($_SESSION['user'])){
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
			$stmt->execute(['id'=>$_SESSION['user']]);
			$user = $stmt->fetch();
		}
		catch(PDOException $e){
			echo "err: " . $e->getMessage();
		}

		$pdo->close();
	}
?>