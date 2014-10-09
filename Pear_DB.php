<?php
//set_include_path('C:\wamp\bin\php\php5.5.12\pear');
set_include_path('C:/wamp/bin/php/php5.5.12/pear');
//require_once "HTML/Template/IT.php";
require_once "DB.php";
//require "../db.inc";
require "db2.inc";

$dsn = "mysql://{$username}:{$password}@{$hostName}/{$databaseName}";
			$DB = new DB();
			$connection=$DB->connect($dsn);

$wine_name = $_GET['wine_name'];
// $region = $_GET['region'];
$winery_name = $_GET['winery_name'];
$start_year = $_GET['start_year'];
$end_year = $_GET['end_year'];
$min_winestock = $_GET['Min_wine_in_stock'];
$min_customers = $_GET['Min_customers'];
$min_cost = $_GET['cost_min_range'];
$max_cost = $_GET['cost_max_range'];
	
/* $template=new HTML_Template_IT("./templates");
$template->loadTemplatefile("Template.tpl",true,true);
$username="root";
$password="nigger";
$hostname="localhost";
$dbname="winestore";
$dsn="mysql://{$username}:{$password}@{$hostname}/{$dbname}";

$connection = @DB::connect($dsn); */



	 
$query= "SELECT wine.wine_id,  wine_name,variety,year,winery_name,region_name,on_hand,cost, 
		count(wine.wine_id) AS No_Cust
		FROM 
		wine,winery,region,wine_variety,grape_variety,inventory
		WHERE 
		wine.winery_id=winery.winery_id
		AND winery.region_id = region.region_id
		AND wine_variety.wine_id = wine.wine_id
		AND wine_variety.variety_id = grape_variety.variety_id
		AND wine.wine_id = inventory.wine_id
		
		AND wine_name LIKE '%".$wine_name."%'
		AND winery_name LIKE '%".$winery_name."%' 
		AND on_hand >= '".$min_winestock."'
		AND (year BETWEEN '".$start_year."' AND '".$end_year."')
		AND (cost BETWEEN '".$min_cost."' AND '".$max_cost."')				
		
		GROUP BY wine.wine_id 
								HAVING count(wine.wine_id) >= '$min_customers'
								ORDER BY wine.wine_id ";
  
$result=$connection->query($query);

  echo "<table style='margin-left:130px;margin-top:10px' border='1'>";
		  echo "<tr><th>Wine Name</th>
				<th>Wine Variety</th>
				<th>Year</th>
				<th>Winery Name</th>
				<th>Region Name</th>
				<th>Bottles in Stock</th>
				<th>Minimum Cost</th>
				<th>No of People Who Purchased the Wine</th></tr>";
		
//while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
    
		while ($result->fetchInto($row, DB_FETCHMODE_ASSOC)){
		/* 
			$template->setCurrentBlock("RESULT_DETAILS");	
	
			$template->setVariable("WINENAME", $regionrow["wine_name"]);
			$template->setVariable("WINE_VARIETY", $regionrow["variety"]);
			$template->setVariable("YEAR", $regionrow["year"]);
			$template->setVariable("WINERY_NAME", $regionrow["winery_name"]);
			$template->setVariable("REGION_NAME", $regionrow["region_name"]);
			$template->setVariable("ON_HAND", $regionrow["on_hand"]);
			$template->setVariable("MIN_COST", $regionrow["cost"]);
			$template->setVariable("MIN_CUSTOMERS", $regionrow["No_cust"]);
			 
			$template->parseCurrentBlock(); 	 */ 
			/*  echo "<tr><td style='text-align:center'>".$row[0]."</td>";
			  echo "<td style='text-align:center'>".$row[1]."</td>";
			  echo "<td>".$row[2]."</td>";
			  echo "<td style='text-align:center'>".$row[3]."</td>";
			  echo "<td style='text-align:center'>".$row[4]."</td>";
			  echo "<td style='text-align:center'>".$row[5]."</td>";
			  echo "<td style='text-align:center'>".$row[6]."</td>";
			  echo "<td style='text-align:center'>".$row['No_Cust']."</td>"; */
			  
			  //change the top thing to
			  echo "<tr><td style='text-align:center'>".$row["wine_id"]."</td>";
			  echo "<td style='text-align:center'>".$row["wine_name"]."</td>";
			  
			  //According to the database table and the data you are extracting..i gave two examples above..you continue till  echo "<td style='text-align:center'>".$row['No_Cust']."</td>";
		}
     

	// $template->show();

		 
		  echo "</td></tr>";
		  echo "</table>"

?>
