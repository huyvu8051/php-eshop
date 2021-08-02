<?php
	//
	// check login
	//

	include 'includes/session.php';
	$conn = $pdo->open();
	// if login
	if(isset($_POST['login'])){
		// get email password
		$email = $_POST['email'];
		$password = $_POST['password'];

		try{
			// find email in db
			$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE email = :email");
			$stmt->execute(['email'=>$email]);
			$row = $stmt->fetch();
			// if email exist
			if($row['numrows'] > 0){
				// check status = 1 is active, = 0 is inactive
				if($row['status']){
					// compare hash password
					if(password_verify($password, $row['password'])){
						// check user role
						$stmt2 = $conn->prepare("SELECT * FROM user_role WHERE user_id = :user_id");
						$stmt2->execute(['user_id'=>$row['id']]);
						$row2 = $stmt2->fetch();
						if($row2['role_id'] == 2){
							$_SESSION['admin'] = $row['id'];
						}
						else{
							$_SESSION['user'] = $row['id'];
						}
					}
					else{
						$_SESSION['error'] = 'Incorrect Password';
					}
				}
				else{
					$_SESSION['error'] = 'Account not activated.';
				}
			}
			else{
				$_SESSION['error'] = 'Email not found';
			}
		}
		catch(PDOException $e){
			echo "error: " . $e->getMessage();
		}

	}
	else{
		$_SESSION['error'] = 'Input login credentails first';
	}

	$pdo->close();

	header('location: login.php');

?>