<?php //Query 

  error_reporting(E_ALL); ini_set('display_errors', 1);

 require_once("dbconn.php");

    /*** INSERT data ***/
	
	
	$manual_datetime = $_POST['dateprice'];
	$company_name = $_POST['inlineRadioOptions'];
	$country = $_POST['country'];
	$town = $_POST['town'];
	$price = $_POST['price'];
			
  
	$sql = "INSERT INTO paerp.dbo.EU_Fuel_Price(manual_datetime,company_name,country,town,price) VALUES (:manual_datetime,:company_name,:country,:town,:price)";
	 
											  
	$stmt = $pdo->prepare($sql);
												  
	$stmt->bindParam(':manual_datetime', $manual_datetime, PDO::PARAM_STR);  
	$stmt->bindParam(':company_name', $company_name, PDO::PARAM_STR); 
	$stmt->bindParam(':country', $country, PDO::PARAM_STR); 
	$stmt->bindParam(':town', $town, PDO::PARAM_STR); 
	$stmt->bindParam(':price', $price, PDO::PARAM_STR); 
	$stmt->execute();
	if($stmt)
	{
	
	echo "<!DOCTYPE html>
		<head>
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
			</head>
		<title>Success record</title>
		<body>
		
			<script type='text/javascript'>
					
					window.alert('Success record!');
					
			</script>
			<script type='text/javascript'>
					
					 setTimeout(location.href = 'index.php', 2000);
					
			</script>
		</body>
		</html>";
		}
	
	
    $pdo = null;
?>