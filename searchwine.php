<html>
	<head>
		<title>
			Search for Wine
		</title>
		<script type="text/javascript" src= "validation.js">
		</script>
	</head>
	<body>
		<form name= "form" onsubmit= "return myFunction()" action= "pearit.php" method= "GET">
			<table border = "0" cellpadding = "5">
				<tr>
					<td bgcolor="#DCDCDC">
						Wine Name:
					</td>
					<td>
						<input type = "text" name = "winename" />
					</td>
				</tr>
				<tr>
					<td bgcolor="#DCDCDC">
						Region: 
					</td>
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
					</td>
				</tr>
				<tr>
					<td bgcolor="#DCDCDC">
						Winery Name: 
					</td>
					<td>
						<input type = "text" name = "wineryname" />
					</td>
				</tr>
				<tr>
					<td bgcolor="#DCDCDC">
						Start Year: 
					</td>
					<td>
						<input type = "text" name = "minyear" id= "minyear"/>
					</td>
					<td bgcolor="#DCDCDC">
						End Year: 
					</td>
					<td>
						<input type = "text" name = "maxyear" id= "maxyear"/>
					</td>
				</tr>
				<tr>
					<td bgcolor="#DCDCDC">
						Number of wines:  
					</td>
					<td>
						<input type = "text" name = "nowines"/>
					</td>
				</tr>
				<tr>
					<td bgcolor="#DCDCDC">
						Number of customers:  
					</td>
					<td>
						<input type = "text" name = "nocustomer"/>
					</td>
				</tr>
				<tr>
					<td bgcolor="#DCDCDC">
						Minimum Cost $: 
					</td>
					<td>
						<input type = "text" name = "mincost" id= "mincost"/>
					</td>
					<td bgcolor="#DCDCDC">
						Maximum Cost $: 
					</td>
					<td>
						<input type = "text" name = "maxcost" id= "maxcost"/>
					</td>
				</tr>
				<tr>
					<td colspan = "2" align= "center" >
						<input type = "submit" value = "Search"/>
					</td>
			</tr>
			</table>
		</form>
	</body>
</html>
