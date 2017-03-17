<?php
require_once("dbconn.php");


if(isset($_GET['delete_id']))
{
 $sql="DELETE FROM EU_Fuel_Price WHERE id=".$_GET['delete_id'];
$q = $pdo->prepare($sql);
$q->execute();
 header("Location: report.php");
}
 
?>