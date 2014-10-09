<?php
	echo "<html><head><title>Wines</title></head>\n";
	
	$connection = mysqli_connect("localhost", "root", "root25");
	mysqli_select_db($connection, "winestore");
	
	$result = mysqli_query($connection, "SELECT * FROM wine");
	echo "<body><pre>\n";
	
	while ($row=mysqli_fetch_row($result))
	{
		for($i=0 ;$i<mysqli_num_fields($result);$i++)
			echo $row[$i]. "";
			echo "\n";
	}
	
	while($row = mysqli_fetch_array($result)){
		echo $row['FirstName']. "" . $row['LastName'];
		echo "<br>";
	}
	echo "</pre></body></html>";
	mysqli_close($connection);
	?>