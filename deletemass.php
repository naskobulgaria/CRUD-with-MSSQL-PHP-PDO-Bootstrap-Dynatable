<?php
require_once("dbconn.php");

for($i=0;$i<count($_POST["chkDel"]);$i++)
	{
		if($_POST["chkDel"][$i] != "")
		{
			$sql = "DELETE FROM EU_Fuel_Price ";
			$sql .="WHERE id = '".$_POST["chkDel"][$i]."' ";
			$q = $pdo->prepare($sql);
			$q->execute();
		}
	}

	echo "Success delete!";
	 header("Location: report.php");
?>