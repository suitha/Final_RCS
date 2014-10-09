<?php

	
	$connection = mysqli_connect("localhost", "root", "root25", "winestore");
	
	if(mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	$result = mysqli_query($connection, "SELECT * FROM customer WHERE surname = 'Patton'");
	
	while($row = mysqli_fetch_array($result)){
		echo $row['firstname']. " " . $row['surname']. " is from " . $row['state'];
		echo "<br>";
	}
	

	mysqli_close($connection);
	?>