<!DOCTYPE html>
<html>  
<title>Fuel prices</title>    
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="jspkg-archive/jquery.dynatable.js"></script>
<link rel="stylesheet" href="jspkg-archive/jquery.dynatable.css">
<link rel="stylesheet" type="text/css" href="bootstrap/bootstrap-datepicker-1.6.4-dist/css/bootstrap-datepicker.standalone.css" /> 
<script src="bootstrap/bootstrap-datepicker-1.6.4-dist/js/bootstrap-datepicker.js"></script>
<script src="bootstrap/bootstrap-datepicker-1.6.4-dist/locales/bootstrap-datepicker.bg.min.js" charset="UTF-8"></script>
<script>
	function ClickCheckAll(vol)
	{
	
		var i=1;
		for(i=1;i<=document.deletemass.hdnCount.value;i++)
		{
			if(vol.checked == true)
			{
				eval("document.deletemass.chkDel"+i+".checked=true");
			}
			else
			{
				eval("document.deletemass.chkDel"+i+".checked=false");
			}
		}
	}

	function onDelete()
	{
		if(confirm('Do you want to delete?')==true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
</script>
</head>
<body>

    <div id="custom-bootstrap-menu" class="navbar navbar-default " role="navigation">
    <div class="container-fluid">
        <div class="navbar-header"><a class="navbar-brand" href="index.php">CRUDBG v4</a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-menubuilder"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse navbar-menubuilder">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="index.php">Home</a>
                </li>
               
                <li><a href="addform.php">New record</a>
                </li>
                <li><a href="report.php">Report</a>
                </li>
            </ul>
        </div>
    </div>
</div>
		
   
    <div class="col-md-1"></div><h2>Report</h2>
     <form method="post" action="" class="form-inline">
	 <div class="row">
	  <div class="col-md-1"></div>
     
	 <div class="col-md-8">
       <div class="form-inline">
	   <div class="form-group">
	  <label for="searchqyery">Search by keyword:</label>
      <input type="text" id="searchqyery" name="searchqyery" class="form-control" autocomplete="on" spellcheck="false" placeholder="">
		</div>
		<div class="form-group">
			      
			 <div id="sandbox-container" >
			  <label for="range" >Date period - from</label>
			<div class="input-daterange input-group" id="datepicker">
				<input type="text" class="input-sm form-control" name="otdata" />
				<span class="input-group-addon">to</span>
				<input type="text" class="input-sm form-control" name="dodata" />
			</div>
			</div>
			</div>
			</div> 
		</div>
		<span><input type="submit" name="submit" value="Search"></span>
		
	</div>
	
	 
         <div class="col-md-1"></div> 
		 <div class="form-group">
		
		 </div>
       </div >
</form>
   
    
	
	<div style="width:100%; position:absolute; left:0px;">
<?PHP 
error_reporting(E_ALL); ini_set('display_errors', 'On');
require_once("dbconn.php");

 
    $ot = filter_input(INPUT_POST, 'otdata', FILTER_SANITIZE_MAGIC_QUOTES);
	$do = filter_input(INPUT_POST, 'dodata', FILTER_SANITIZE_MAGIC_QUOTES);
	$myotdate = date("Y-m-d 00:00:00.000", strtotime($ot));//here change the format because in Microsoft SQL server dates are in this format
	$mydodate = date("Y-m-d 23:59:59.999", strtotime($do));
 	$nomer = isset($_POST['searchqyery']) ? $_POST['searchqyery'] : '';
	
		
	$vnomer = "%".$nomer."%";//keyword
		$_SESSION['otdata'] = filter_input(INPUT_POST, 'otdata', FILTER_SANITIZE_MAGIC_QUOTES); 
	 
		$_SESSION['dodata'] = filter_input(INPUT_POST, 'dodata', FILTER_SANITIZE_MAGIC_QUOTES); 
	 
	
	
	if (empty ($_POST['submit']))//this if show last 50 rows
	{
		$getrows = $pdo->query('Select COUNT(*) FROM EU_Fuel_Price')->fetchColumn();
	/* Set the number of results to display on each page. */
$rowsPerPage = 20;


try
{
		
	/* Order target data by ID and select only items (by row number) to display on a given page. 
	   The query asks for one "extra" row as an indicator that another page of data exists. */
	$tsql = "SELECT * FROM 
				(SELECT  ROW_NUMBER() OVER(ORDER BY id desc) 
				AS RowNumber,EU_Fuel_Price.id, 
				convert(VARCHAR(24),manual_datetime,113) as manual_datetime,EU_Fuel_Price.company_name,EU_Fuel_Price.country,EU_Fuel_Price.town,EU_Fuel_Price.price,db_countries.idcountry,db_countries.country_name as country_name
					 
			FROM EU_Fuel_Price 
			INNER JOIN db_countries ON EU_Fuel_Price.country=db_countries.idcountry )
			AS TEST 
			WHERE RowNumber BETWEEN ? AND ? + 1";

	$sth = $pdo->prepare($tsql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

	/* Determine which row numbers to display. */
	if(isset($_GET['lowRowNum']) && isset($_GET['highRowNum']))
	{
		$lowRowNum = $_GET['lowRowNum'];
		$highRowNum = $_GET['highRowNum'];
	}
	else
	{
		$lowRowNum = 1;
		$highRowNum = $rowsPerPage;
	}

	/* Execute the query with parameter values. */
	$sth->execute(array($lowRowNum, $highRowNum));
	
	$numRows = $sth->rowCount(); 

	if($numRows <= 0) 
	{ 
		echo "No data in the database</br>"; 
	} 
	else 
	{ 
echo '<form name="deletemass" action="deletemass.php" method="post">';
echo '<h3>Show records '.$getrows.'</h3>';
echo '<a href="#" id="test" onClick="javascript:fnExcelReport();">Export in Excel</a>';

		print("<table id='tbreport' class='table table-hover table-condensed'>
				<thead>
			   <tr class='headertb'>
			
				<th>N</th>
				<th>Date</th>
				<th>Name</th>
				<th>Coutry</th>
				<th>Town</th>
				<th>Price</th>
				<th>Edit</th>
				<th>Delete</th>
				<th></th>
				</tr>
				</thead>");
			
		/*Display all but the last of the rows in the result set.*/ 
		for($i=0; $i<$numRows-1; $i++) 
		{ 
		try{
			$row = $sth->fetch(PDO::FETCH_BOTH); 
			
			echo "<tbody><tr>";
			echo '<td>'.$row['id'].'</td>';
			echo '<td>'.$row['manual_datetime'].'</td>';
			echo '<td>'.$row['company_name'].'</td>';
			echo '<td>'.$row['country_name'].'</td>';
			echo '<td>'.$row['town'].'</td>';
			echo '<td>'.$row['price'].'</td>';
			echo '<td><a href=update.php?id='.$row['id'].'>Edit</a></td>';
			echo '<td><a href=delete.php?delete_id='.$row['id'].' onclick="return confirm(\'Are you sure?\');" >Delete</a></td>';
			echo '<td><input type="checkbox" name="chkDel[]" value='.$row['id'].'></td>';
			 echo '</tr></tbody>';
		 
					} catch (PDOException $e) {
				echo 'Connection failed: ' . $e->getMessage();
			}
		}
		
		/*Display the last row in the result set if 
		  there isn't another page of results.*/ 
		if($numRows <=20) 
			
		{ 
			$row = $sth->fetch(PDO::FETCH_BOTH); 
			
			echo "<tbody><tr>";
			echo '<td>'.$row['id'].'</td>';
			echo '<td>'.$row['manual_datetime'].'</td>';
			echo '<td>'.$row['company_name'].'</td>';
			echo '<td>'.$row['country_name'].'</td>';
			echo '<td>'.$row['town'].'</td>';
			echo '<td>'.$row['price'].'</td>';
			echo '<td><a href=update.php?id='.$row['id'].'>Edit</a></td>';
			echo '<td><a href=delete.php?delete_id='.$row['id'].' onclick="return confirm(\'Are you sure?\');" >Delete</a></td>';
			echo '<td><input type="checkbox" name="chkDel[]" value='.$row['id'].'></td>';
			 echo '</tr></tbody>';
			
		} 
		
		echo '</form>';
		echo '<div style="float:right;"><input type="submit" name="btnDelete" value="Delete"></div>';
		print("</table></br></br>"); 
		/* If there are previous results, 
			display the Previous Page link. */ 
		if($lowRowNum > 1) 
		{ 
			$prev_page_high = $lowRowNum - 1; 
			$prev_page_low = $prev_page_high - $rowsPerPage + 1; 
			$prevPage = "?lowRowNum=$prev_page_low&".
						 "highRowNum=$prev_page_high"; 
			print("<a href=$prevPage><< Предишна страница</a>".
				   "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"); 
		} 
		/* If there are more results, display the Next Page link.   
		   We know there are more results if the query returned 11 rows. */ 
		if($numRows >= 21) 
		{        
			$next_page_low = $highRowNum + 1; 
			$next_page_high = $next_page_low + $rowsPerPage - 1; 
			$nextPage = "?lowRowNum=$next_page_low&".
						 "highRowNum=$next_page_high"; 
			print("<a href=$nextPage>Следваща страница >></a>"); 
		} 
	}
}
catch(Exception $e)
{ 
	die( print_r( $e->getMessage() ) ); 
}
	}
	else if (empty ($nomer))//this if show only period 
	{
		
	$sth = $pdo->prepare("SELECT *, EU_Fuel_Price.id, 
				convert(VARCHAR(24),manual_datetime,113) as start_manual_datetime, convert(VARCHAR(24),manual_datetime,104) as end_manual_datetime,EU_Fuel_Price.company_name,EU_Fuel_Price.country,EU_Fuel_Price.town,EU_Fuel_Price.price,db_countries.idcountry,db_countries.country_name as country_name FROM EU_Fuel_Price INNER JOIN db_countries ON EU_Fuel_Price.country=db_countries.idcountry WHERE  manual_datetime >= :otdata and manual_datetime <= :dodata ORDER BY manual_datetime DESC");
					
					$sth->bindParam(':otdata', $myotdate, PDO::PARAM_STR);
					$sth->bindParam(':dodata', $mydodate, PDO::PARAM_STR);
					
						 $sth->execute();
						 
						 
						 echo '<form name="deletemass" action="deletemass.php" method="post">';
	 echo '<h3>Date range only</h3>';
echo '<a href="#" id="test" onClick="javascript:fnExcelReport();">Export to Excel</a>';
               echo '<table id="tbreport" class="table table-hover table-condensed">
			   <thead>
			   <tr class="headertb">
			   <th >N</th>
			 	<th>Date</th>
				<th>Name</th>
				<th>Coutry</th>
				<th>Town</th>
				<th>Price</th>
				<th>Edit</th>
				<th>Delete</th>
				<th ></th>
			   </tr></thead>';
			   echo '<tbody>';

       while($row=$sth->fetch(PDO::FETCH_ASSOC)){
			  
           
			 echo '<tr>';
			 echo '<td>'.$row['id'].'</td>';
			 echo '<td>'.$row['start_manual_datetime'].'</td>';
			 echo '<td>'.$row['company_name'].'</td>';
			 echo '<td>'.$row['country_name'].'</td>';
			 echo '<td>'.$row['town'].'</td>';
			 echo '<td>'.$row['price'].'</td>';
	
	  echo '<td><a href=update.php?id='.$row['id'].'>Edit</a></td>';
	  echo '<td><a href=delete.php?delete_id='.$row['id'].' onclick="return confirm(\'Are you sure?\');"  >Delete</a></td>';
	  echo '<td><input type="checkbox" name="chkDel[]" value='.$row['id'].'></td>';
	  echo '</tr></tbody>';
        }
		echo '</form>';
		echo '<div style="float:right;"><input type="submit" name="btnDelete" value="Delete"></div>';
        echo '</table>';
		echo '</br>';
			
	}	
	
	else if (!empty ($nomer))//this if search for keyword
	{
	 $sth = $pdo->prepare("SELECT *, EU_Fuel_Price.id as idn, 
				convert(VARCHAR(24),manual_datetime,113) as start_manual_datetime, convert(VARCHAR(24),manual_datetime,104) as end_manual_datetime, EU_Fuel_Price.company_name, EU_Fuel_Price.country, EU_Fuel_Price.town, EU_Fuel_Price.price, db_countries.idcountry, db_countries.country_name as country_name FROM EU_Fuel_Price INNER JOIN db_countries ON EU_Fuel_Price.country=db_countries.idcountry 
	 WHERE manual_datetime >= '{$mydodate2}' 
	 AND manual_datetime <= '{$mydodate2}' AND company_name LIKE ? OR town LIKE ? OR country LIKE ? order by id DESC");//това е начин за заявка с масив
	 
	$sth->execute(array("%$vnomer%","%$vnomer%","%$vnomer%")); 
	
	echo '<form name="deletemass" action="deletemass.php" method="post">';
	 echo '<h3>Report only for  '.$nomer.'</h3>';
echo '<a href="#" id="test" onClick="javascript:fnExcelReport();">Export in Excel</a>';
               echo '<table id="tbreport" class="table table-hover table-condensed">
			   <thead>
			   <tr class="headertb">
			   <th >N</th>
				<th>Date</th>
				<th>Name</th>
				<th>Coutry</th>
				<th>Town</th>
				<th>Price</th>
				<th>Edit</th>
				<th>Delete</th>
				<th ></th>
			   </tr></thead>';
			   echo '<tbody>';

       while($row=$sth->fetch(PDO::FETCH_ASSOC)){
			             
			 echo '<tr>';
			 echo '<td>'.$row['idn'].'</td>';
			 echo '<td>'.$row['start_manual_datetime'].'</td>';
			 echo '<td>'.$row['company_name'].'</td>';
			 echo '<td>'.$row['country_name'].'</td>';
			 echo '<td>'.$row['town'].'</td>';
			 echo '<td>'.$row['price'].'</td>';
	
	  echo '<td><a href=update.php?id='.$row['idn'].'>Edit</a></td>';
	  echo '<td><a href=delete.php?delete_id='.$row['idn'].' onclick="return confirm(\'Are you sure?\');"  >Delete</a></td>';
	  echo '<td><input type="checkbox" name="chkDel[]" value='.$row['idn'].'></td>';
	  echo '</tr></tbody>';
        }
		echo '</form>';
		echo '<div style="float:right;"><input type="submit" name="btnDelete" value="Delete"></div>';
        echo '</table>';
		echo '</br>';
			
	
	}
	
	else{echo"Error.";}
	
		
	
unset($pdo);
?></div>

            </div>
        </div>
		<script>
	$('#tbreport').dynatable({
  table: {
    defaultColumnIdStyle: 'trimDash'
  },
  features: {
    paginate: false,
    search: false,
    recordCount: false,
    perPageSelect: false
  }
});
	</script>
	<script>
$('#sandbox-container .input-daterange').datepicker({
    format: "yyyy-mm-dd",
    todayBtn: "linked",
    clearBtn: true,
    language: "bg",
    orientation: "bottom auto",
    todayHighlight: true
});
</script>
<script>
function fnExcelReport() {
    var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';

    tab_text = tab_text + '<x:Name>Sheet</x:Name>';

    tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';

    tab_text = tab_text + "<table border='1px'>";
    tab_text = tab_text + $('#tbreport').html();
    tab_text = tab_text + '</table></body></html>';

    var data_type = 'data:application/vnd.ms-excel';
    
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");
    
    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
        if (window.navigator.msSaveBlob) {
            var blob = new Blob([tab_text], {
                type: "application/csv;charset=utf-8;"
            });
            navigator.msSaveBlob(blob, 'Test file.xls');
        }
    } else {
        $('#test').attr('href', data_type + ', ' + encodeURIComponent(tab_text));
        $('#test').attr('download', 'Test file.xls');
    }

}
</script>

</body>
</html>
