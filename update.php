<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Редакция на запис</title>
<link rel="stylesheet" type="text/css" href="cssstyle.css" id="theme" />  
<link rel="stylesheet" type="text/css" href="default.css" id="theme" />  

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="/erp/js/jspkg-archive/jquery.dynatable.js"></script>
<link rel="stylesheet" href="/erp/js/jspkg-archive/jquery.dynatable.css">
<link rel="stylesheet" type="text/css" href="../../bootstrap/bootstrap-datepicker-1.6.4-dist/css/bootstrap-datepicker.standalone.css" /> 
<script src="../../bootstrap/bootstrap-datepicker-1.6.4-dist/js/bootstrap-datepicker.js"></script>
<script src="../../bootstrap/bootstrap-datepicker-1.6.4-dist/locales/bootstrap-datepicker.bg.min.js" charset="UTF-8"></script>

	</head>
<body>
<?php
   error_reporting(E_ALL); ini_set('display_errors', 1);

 require_once("dbconn.php");

	if(isset($_GET['id']))
{
$id=$_GET['id'];

	$result = $pdo->prepare("SELECT EU_Fuel_Price.id, manual_datetime,EU_Fuel_Price.company_name,EU_Fuel_Price.country,EU_Fuel_Price.town,EU_Fuel_Price.price,db_countries.idcountry,db_countries.country_name as countryname FROM EU_Fuel_Price LEFT JOIN db_countries ON EU_Fuel_Price.id=db_countries.idcountry WHERE EU_Fuel_Price.id = :id");
	$result->bindParam(':id', $id, PDO::PARAM_STR);
	$result->execute();
	
	
		 while($row=$result->fetch(PDO::FETCH_ASSOC)){
?>
<h3 style="text-align:center;">Редакция на запис</h3>
<div class="row">
<form class="form-horizontal" method="post" action="saveupdate.php">
  <div class="col-xs-9">
  <div class="form-group">
    <label for="id" class="col-sm-2 control-label">Номер ред</label>
    <div class="col-sm-10">
<input class="form-control" type="text" name="id" value="<?php echo $row['id']; ?>" readonly>
	</div>
  </div>
  </div>
  <div class="col-xs-9">
 
  <div class="form-group">
    <label for="manual_datetime" class="col-sm-2 control-label">Дата събитие</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="dateprice" name="dateprice" value="<?php echo $row['manual_datetime']; ?>">
    </div>
  </div></div>
  <div class="col-xs-9">
  <div class="form-group">
    <label for="company_name" class="col-sm-2 control-label">Име на фирма</label>
    <div class="col-sm-10">
      <label for="name" ></label>
		<div class="radio">
  <label class="radio-inline">
   <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="Shell" <?php echo ($row['company_name'] == "Shell" ? 'checked="checked"': ''); ?> /> Shell
</label>
</div>
<div class="radio">
  <label class="radio-inline">
   <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="PETROMIRALLES" <?php echo ($row['company_name'] == "PETROMIRALLES" ? 'checked="checked"': ''); ?> /> PETROMIRALLES
</label>
</div>
    </div>
  </div></div>
  
  <div class="col-xs-9">
  <div class="form-group">
    <label for="country_name" class="col-sm-2 control-label">Държава</label>
    <div class="col-sm-10">
    
	  <select name="country" class="form-control" id="country">
					
                     
                     <option value="<?php echo $row['idcountry']; ?>" selected><?php echo $row['countryname']; ?></option>
							 <?php
                                                $result2 = $pdo->prepare("SELECT idcountry,country_name as country_name2 FROM db_countries order by country_name asc");
                                                $result2->execute();
                                                       while($row2=$result2->fetch(PDO::FETCH_ASSOC)){
                                                      ?>
                                                        <option value="<?php echo $row2['idcountry']; ?>"><?php echo $row2['country_name2']; ?></option>
                                                  <?php
                                                      } ?>				
					</select>
	  
    </div>
  </div></div>
  <div class="col-xs-9">
  <div class="form-group">
  <label for="town" class="col-sm-2 control-label">Град</label>
  <div class="col-sm-10">
  <select class="form-control" id="town" name="town">
			<option value="<?php echo $row['town']; ?>" selected><?php echo $row['town']; ?></option>
			<option value=""></option>
			<option value="Andoain">Andoain</option>
			<option value="Barcelona Port">Barcelona Port</option>
			<option value="Figueres">Figueres</option>
			<option value="Irun">Irun</option>
			<option value="Navara">Navara</option>
			<option value="Oiartzun">Oiartzun</option>
			<option value="St. Andreu De La Barca">St. Andreu De La Barca</option>
  </select>
  </div>
</div>
  </div>
  
  <div class="col-xs-9">
  <div class="form-group">
    <label for="price" class="col-sm-2 control-label">Цена</label>
    <div class="col-sm-10">
      <input class="form-control" id="price" name="price" value="<?php echo $row['price']; ?>" >
    </div>
  </div></div>
   <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" name="submit" class="btn btn-default">Запис</button>
    </div>
  </div>
</div>
</form>
<?php
}
}
?>
<script>
$('#dateprice').datepicker({ 
    format: "yyyy-mm-dd",
    todayBtn: "linked",
    clearBtn: true,
    language: "bg",
    orientation: "bottom auto",
    todayHighlight: true
});
</script>
</body>
</html>
