<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Wine results</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css"/>
	</head>
	<body>

		<?php

			set_include_path('C:/wamp/bin/php/php5.5.12/pear');
			require_once "HTML/Template/IT.php";
			require "db2.inc";
		  
			// Connect to the MySQL server
			if (!($connection = @ mysql_connect($hostName, $username, $password)))
				die("Cannot connect");
				
			if (!(mysql_select_db($databaseName, $connection)))
				showerror( );
			 
			 
			$winename = $_GET['winename'];
			$wineregion = $_GET['region_name'];
			$wineryname = $_GET ['wineryname'];
			$minyear = $_GET ['minyear'];
			$maxyear = $_GET ['maxyear'];
			$noWine = $_GET ['nowines'];
			$noCust = $_GET ['nocustomer'];
			$mincost = $_GET ['mincost'];
			$maxcost = $_GET ['maxcost'];
				
				
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
				
			// Run the query on the connection
			if (!($result = @ mysql_query ("SELECT DISTINCT  customer.cust_id, wine.wine_id, wine.wine_name,grape_variety.variety, 
											wine.wine_type, wine.year,inventory.on_hand, wine.winery_id, wine.description, winery.winery_name, region.region_name, inventory.cost, count(wine.wine_id) AS cust
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
												ORDER BY wine.wine_id", $connection)))
													
													showerror( );
			 
			// Create a new template, and specify that the template files are 
			$template = new HTML_Template_IT(".");
		  
			// Load the winestore template file
			$template->loadTemplatefile("Pear_IT.tpl", true, true);

			$rows = @mysql_num_rows($result);
			
			//Check if data exist
			if ($rows> 0)
			{
				
				while ($row = mysql_fetch_array($result))
				{
					// Work with the winestore block
					$template->setCurrentBlock("WINESTORE");
					
					// Assign the row data to the template placeholders
					 $template->setVariable("WINEID", $row["wine_id"]);
					 $template->setVariable("WINENAME", $row["wine_name"]);
					 $template->setVariable("WINEVARIETY", $row["variety"]);
					 $template->setVariable("YEAR", $row["year"]);
					 $template->setVariable("WINERYNAME", $row["winery_name"]);
					 $template->setVariable("REGION", $row["region_name"]);
					 $template->setVariable("STOCK", $row["on_hand"]);
					 $template->setVariable("CUSTOMER", $row["cust"]);
					 $template->setVariable("COST", $row["cost"]);
				
					// Parse the current block
					$template->parseCurrentBlock( );
				}
			  
				// Output the web page
				$template->show( );
		  
			}
		  
			else
			{
				header('Refresh:5; url=searchwine.php');
				echo "<h1>No records match your search criteria</h1>";
			}
		?>
	
	</body>
</html>
