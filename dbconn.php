<?php
$host2 = "localhost";//your host adress
$user2 = "";//your username from the database
$password2 = "";//your password
$database2 = "";//your database
  
try {
		 $pdo = new PDO("sqlsrv:Server=$host2;database=$database2", $user2, $password2); 
		  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die('Could not connect to the database:' . $e);
}
?>