<?php
  error_reporting(E_ALL); ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once("dbconn.php");


	$idzapis = $_POST['id'];
	 
	$dateprice1 = $_POST['dateprice'];
	$dateprice = date("Y-m-d", strtotime($dateprice1));
	$company_name = $_POST['inlineRadioOptions'];
	$country = $_POST['country'];
	$town = $_POST['town'];
	$price = $_POST['price'];

 
 
try {
    $sql = "UPDATE EU_Fuel_Price SET manual_datetime = :manual_datetime,
					company_name = :company_name,
					country = :country,
					town = :town,
					price = :price
					WHERE id = :id";
					
				$stmt = $pdo->prepare($sql);
				
				$stmt->bindParam(':manual_datetime', $dateprice, PDO::PARAM_STR);
				$stmt->bindParam(':company_name', $company_name, PDO::PARAM_STR);
				$stmt->bindParam(':country', $country, PDO::PARAM_STR);
				$stmt->bindParam(':town', $town, PDO::PARAM_STR);
				$stmt->bindParam(':price', $price, PDO::PARAM_STR);
				$stmt->bindParam(':id', $idzapis, PDO::PARAM_INT);
				$stmt->execute();
				if($stmt) {	
					echo "<!DOCTYPE html>
							<head>
								<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
								</head>
							<title>Success record</title>
							<body>
							
								<script>
										
										window.alert('Success record!');
										
								</script>
								<p style='text-align: center;margin:100px 0 0 0;'>Redirecting</p>

					<script>
						window.location = 'index.php';		
					</script>
							</body>
							</html>";}
						
					else{echo"Error!";}

} catch (Exception $e) {
    die("Oh noes! There's an error in the query!");
}
			
		
?>