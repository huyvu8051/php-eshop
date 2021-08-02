<?php
    include 'includes/session.php';
    $conn = $pdo->open();

    $output = '';
    
    if (isset($_POST['order_id'])) {

        try{
			$order_id = $_POST['order_id'];
            $stmt2 = $conn->prepare("SELECT * FROM order_details LEFT JOIN products ON products.id=order_details.product_id WHERE order_id=:order_id");
            $stmt2->execute(['order_id'=>$order_id]);
            $total = 0;
            foreach($stmt2 as $row){
            $subtotal = $row['price']*$row['quantity'];
            $total += $subtotal;
            $image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
            // print_r($row);
            $output.="
                <tr>
                    <td>".$row['name']."</td>
                    <td><img src='".$image."' width='30px' height='30px'></td>
                    <td>&#36;".number_format($row['price'])."</td>
                    <td>".$row['quantity']."</td>
                    <td>&#36;".number_format($subtotal)."</td>
                </tr>
                ";
            }
            $output.="
            <td colspan='4' align='right'><b>Total</b></td>
            <td><span id='total'>&#36;".number_format($total)."</span></td>
            ";

		}
		catch(PDOException $e){
			$output .= $e->getMessage();
		}
    }
    $pdo->close();
	echo json_encode($output);
    
?>