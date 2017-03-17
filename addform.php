<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Add</title>
  	 <link rel="stylesheet" type="text/css" href="cssstyle.css" id="theme" />  
<link rel="stylesheet" type="text/css" href="default.css" id="theme" />  



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<link rel="stylesheet" type="text/css" href="bootstrap/bootstrap-datepicker-1.6.4-dist/css/bootstrap-datepicker.standalone.css" /> 
<script src="bootstrap/bootstrap-datepicker-1.6.4-dist/js/bootstrap-datepicker.js"></script>
<script src="bootstrap/bootstrap-datepicker-1.6.4-dist/locales/bootstrap-datepicker.bg.min.js" charset="UTF-8"></script>
<body>
	<h3 style="text-align:center;">Add price</h3>
<div id="docContainer" class="fb-toplabel fb-100-item-column selected-object" >
 <div >   
  <div id="column1" class="column ui-sortable">
<form id="form1" name="form1" method="post" action="query.php">
<div class="form-group">
<label for="dateprice" >Date:</label>
		<input type="text" class="form-control" id="dateprice" name="dateprice">
	</div>

	<label for="name" >Company:</label>
		<div class="radio">
  <label class="radio-inline">
  <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="Shell"> Shell
</label>
</div>
<div class="radio">
  <label class="radio-inline">
  <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="PETROMIRALLES"> PETROMIRALLES
</label>
</div>

  <?php
	require_once("dbconn.php");
	 $sql2 = 'SELECT * FROM db_countries ORDER BY idcountry asc';
  $q2 = $pdo->query($sql2);
  $q2->setFetchMode(PDO::FETCH_ASSOC);
  
?>
<div class="form-group">
	<label for="sel1">Country:</label>
	<select name="country" class="form-control" id="country">
	 <option></option>
                     <?php while ($row = $q2->fetch()){ ?>
                     <option  value="<?php echo $row['idcountry']; ?>"><?php echo $row['country_name']; ?></option>
                     <?php } ?>
</select>
   </div>
   
   
<div class="form-group">
  <label for="sel1">City:</label>
  <select class="form-control" id="town" name="town">
			<option value="" selected></option>
			<option value="Andoain">Andoain</option>
			<option value="Barcelona Port">Barcelona Port</option>
			<option value="Figueres">Figueres</option>
			<option value="Irun">Irun</option>
			<option value="Navara">Navara</option>
			<option value="Oiartzun">Oiartzun</option>
			<option value="St. Andreu De La Barca">St. Andreu De La Barca</option>
  </select>
</div>
	 <div class="form-group ">
      <label class="control-label " for="price">
       Fuel Price:
      </label>
      <input class="form-control" id="price" name="price" type="text"/>
     </div>
	 	 </br>
  <button type="submit" class="btn btn-default">Submit</button>
  
</form>
</div>
</div>
</div>

<script>
$('#dateprice').datepicker({
    format: "yyyy-mm-dd",
    todayBtn: "linked",
    language: "bg",
    autoclose: true,
    todayHighlight: true
});
</script>
</body>
</html>