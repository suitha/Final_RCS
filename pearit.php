<?php

   	set_include_path('C:/wamp/bin/php/php5.5.12/pear');
	include "HTML/Template/IT.php";
	include "db2.inc";

  if (!($connection = @ mysql_connect("localhost", "root", "root25")))
     die("Cannot connect");

  if (!(mysql_select_db("winestore", $connection)))
     showerror();
	 
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

  if (!($regionresult = @ mysql_query ("SELECT DISTINCT customer.cust_id, wine.wine_id, wine.wine_name, grape_variety.variety, 
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
			
			", $connection)))
     showerror();

  $template = new HTML_Template_IT(".");
  // $template->loadTemplatefile("ex2_6.tpl", true, true);
  $template->loadTemplatefile("Pear_IT.tpl", true, true);
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
		
		while ($regionrow = mysql_fetch_array($regionresult)){
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
 /*  while ($regionrow = mysql_fetch_array($regionresult))
  {
     $template->setCurrentBlock("WINESTORE");
     $template->setVariable("REGIONNAME", $regionrow["region_name"]);

    /*  if (!($wineryresult =
         @ mysql_query ("SELECT * FROM winery
                         WHERE region_id = {$regionrow["region_id"]}",
                         $connection)))
        showerror(); */
/* 
     while ($wineryrow = mysql_fetch_array($regionresult))
     {
        #$template->setCurrentBlock("WINERY");
        $template->setVariable("WINERYNAME", $wineryrow["winery_name"]);
        $template->parseCurrentBlock();
     }
     $template->setCurrentBlock("REGION");
     $template->parseCurrentBlock();
  } */ 

  echo "</table>";
  $template->show();

?>
