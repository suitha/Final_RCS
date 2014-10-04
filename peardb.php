<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Search results</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<?php

	set_include_path('C:/wamp/bin/php/php5.5.12/pear');
	require_once "HTML/Template/IT.php";
	require_once "DB.php";
	require_once "db2.inc";

	$template = new HTML_Template_IT (".");
	$template -> loadTemplatefile("PEAR_IT.tpl", true, true);
	$username = "root";
	$password = "root25";
	$hostname = "localhost";
	$dbname = "winestore";
	#require_once ("C:/wamp/bin/php/php5.5.12/pear/DB.php");
	#ini_set ('display_errors', true);
	
	$dsn = "mysql://{$username}:{$password}@{$hostname}/{$dbname}";
	#$DB = new DB();
	$connection=@DB::connect($dsn);
	
	 /* if (@DB ::isError($connection))
      die($connection->getMessage( )); */
 

	#$connection = mysqli_connect("localhost", "root", "123456", "winestore");

	$winename = $_GET['winename'];
	$wineregion = $_GET['region_name'];
	$wineryname = $_GET ['wineryname'];
	$minyear = $_GET ['minyear'];
	$maxyear = $_GET ['maxyear'];
	$noWine = $_GET ['nowines'];
	$noCust = $_GET ['nocustomer'];
	$mincost = $_GET ['mincost'];
	$maxcost = $_GET ['maxcost'];


	//$query = $_GET['name'];      

	if ($minyear == NULL)
		$minyear = "1970";

	if ($maxyear == NULL)
		$maxyear = "1999";

	if ($mincost == NULL)
		$mincost = "5";

	if ($maxcost == NULL)
		$maxcost = "30";
		
	if($wineregion == "All")
		$wineregion = "";	
		
	
	#if ($noWine== NULL)
		#$noWine = "999";
	 
	/*$raw_results = mysqli_query($connection, "SELECT * FROM wine
		WHERE (`wine_name` LIKE '%".$query."%')") or die(mysql_error());*/
		
		/*$raw_result = "Select * FROM wine INNER JOIN wine_type ON(wine.wine_type = wine_type.wine_type_id)";*/
		
		$raw_result = "	SELECT DISTINCT customer.cust_id, wine.wine_id, wine.wine_name, grape_variety.variety, 
		wine.wine_type, wine.year,inventory.on_hand, wine.winery_id, 
		wine.description, winery.winery_name, region.region_name, 
		inventory.cost, count(wine.wine_id) AS cust
			from wine 
					INNER JOIN wine_variety
						ON wine_variety.wine_id = wine.wine_id
					INNER JOIN grape_variety
						ON grape_variety.variety_id = wine_variety.variety_id
					INNER JOIN winery
						ON wine.winery_id = winery.winery_id
					INNER JOIN region
						ON winery.region_id = region.region_id
					INNER JOIN inventory 
						ON wine.wine_id = inventory.wine_id
					INNER JOIN items
						ON wine.wine_id = items.wine_id
					INNER JOIN customer	
						ON items.cust_id = customer.cust_id
				
			
			WHERE wine.wine_name like '%".$winename."%' 
			and wine.year between '". $minyear ."' and '". $maxyear . "'
			and region.region_name like '%".$wineregion."%'
			and winery.winery_name like '%".$wineryname."%'
			and inventory.on_hand >= '". $noWine . "'
			#and customer.cust_id >= '".$noCust."'
			and inventory.cost between '". $mincost ."' and '". $maxcost . "'
			
			
			GROUP BY wine.wine_id 
			HAVING count(wine.wine_id) >= '$noCust'
			ORDER BY wine.wine_id
			
			";
			//"SELECT * FROM `wine` WHERE wine.wine_name like '%".$winename."%' Order By wine.year ASC, wine.wine_name";
			

										
						
		 $raw_results = $connection->query($raw_result);
		 
		 /* if (@DB::isError($raw_results))
			die ($raw_results->getMessage( )); */
		
		
		
		#$raw_results = mysqli_query ($connection, $raw_result);
		echo "<table border= '1'>
				<tr>
					<td>Wine ID</td>
					<td>Wine Name</td>
					<td>Wine Variety</td>
					<td>Year</td>
					<td>Winery Name</td>
					<td>Region Name</td>
					<td>Stock</td>
					<td>No. of Customer</td>
					<td>Cost</td>
				</tr>" ;
		
		while($regionrow = $raw_results->fetchRow(DB_FETCHMODE_ASSOC)){
		#while($row = mysqli_fetch_array($raw_results)){
			
			/*foreach($row as $wine_id)
				print "$wine_id";
			foreach($row as $wine_name)
				print "$winename";
			
			print "\n";
			print "SK";*/
			
			$template->setCurrentBlock("WINESTORE");	
			$template->setVariable("WINE_ID", $regionrow['wine_id']);
			$template->setVariable("WINE_NAME", $regionrow['wine_name']);
			$template->setVariable("VARIETY", $regionrow['variety']);
			$template->setVariable("YEAR", $regionrow['year']);
			$template->setVariable("WINERY_NAME", $regionrow['winery_name']);
			$template->setVariable("REGION", $regionrow['region_name']);
			$template->setVariable("STOCK", $regionrow['on_hand']);
			$template->setVariable("CUSTOMER", $regionrow['cust']);
			$template->setVariable("COST", $regionrow['cost']);
		
			$template->parseCurrentBlock();
					
		}
		echo "</table>";
		 $template -> show();
		 #mysqli_close($connection);

       #$connection -> disconnect();
         
    
   
?>
</body>
</html>