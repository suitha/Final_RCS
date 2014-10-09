	<script>
			function myFunction() {
				document.getElementById("wine_search").reset();
			}
			
	</script>
	
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.15/angular.min.js"></script>


<?php

	//session_start();
	$connection = mysqli_connect("localhost","root","nigger","winestore");	
	//mysql_select_db("winestore",$connection);
	$result = mysqli_query($connection, "SELECT * FROM winestore");


?>

<html>
	<head>
	<link rel="stylesheet" href="style.css" type="text/css" />
	</head>
	<body>
		<table style="margin-left:529px;margin-top:100px" border="0">
		<tr><td>
		<img src="../logo.jpg" alt="Mountain View" style="width:150px;height:150px">
		</td>
		<td><h1>Wine Search</h1></td>
		</tr>
		</table>
		
		<table style="margin-left:350px;margin-top:30px" border="0">
		<form id="wine_search" method="get" style="margin-left:280px;margin-top:150px" action="Pear_DB.php"> 
			<tr>
			<td>Wine Name :</td>
			<td>
			<input type="text" name="wine_name" value="" size=20/>
			</td>
			</tr>
			
			<tr>
			<td>Region Select</td>
			<td>
			<?php
							$connect = mysqli_connect ("localhost", "root", "root25", "winestore");
		
							if(mysqli_connect_errno()){
								echo "Failed to connect to MySQL: " . mysqli_connect_error();
							}
						
							$regiondb = mysqli_query($connect, "SELECT * FROM region");
						
							echo "<select name = 'region_name'>";
								
							while ($region = mysqli_fetch_array($regiondb)){
								$region_query = $region["region_name"];
								
								echo "<option>";
								echo $region_query;
								echo "</option>";
							}
							
							echo "</select>";
						?>
			</td></tr>
			
			<tr>
			<td>Winery Name :</td>
			<td>
			<input type="text" name="winery_name" value="" size=20/>
			</td></tr>
			
			<tr>
			<td>Range of Years :</td>
			<td>
			From <input maxlength="4" min="1950" max="2000" style="width:50px" type="number" name="start_year" value="" /> to <input style="width:50px" min="1950" max="2000" maxlength="4" type="number" name="end_year" value="" size="6"/>
			</td>
			</tr>
			
			<tr>
			<td>Minimum number of wines in stock :</td>
			<td>
			<input type="number" min="0" max="9999" name="Min_wine_in_stock" value="" size="6"/>
			</td>
			</tr>
			
			<tr>
			<td>Minimum number of Customers who purchased this wine :</td>
			<td>
			<input type="number" min="0" max="9999" name="Min_customers" value="" size="6"/>
			</td>
			</tr>
			
			<tr>
			<td>Cost Range :</td>
			<td>
			Min: <input maxlength="4" min="0" max="9999" style="width:40px" type="number" name="cost_min_range"/> Max: <input maxlength="4" min="0" max="9999" style="width:40px" type="number" name="cost_max_range"/>
			</td>
			</tr>
		</table>
		
		<input style="margin-left:629px;width:120px;margin-top:10px" type="submit" name="search" value="Search"/>
		<br>
		<button style="margin-left:300px" type="reset" value='Reset'>Reset Form</button>
		</form>
		</body>
</html>
