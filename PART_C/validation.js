function myFunction() 
{

	var minYear = document.getElementById("minyear").value;
	var maxYear = document.getElementById("maxyear").value;
	var minCost = document.getElementById("mincost").value;
	var maxCost = document.getElementById("maxcost").value;
	  
  
	if (minYear > maxYear) 
	{
		alert ("Start Year is greater than End Year");
		document.getElementById("minyear").select();
		document.getElementById("minyear").focus();
		return false;
	}
	
	else if (minCost > maxCost) 
	{
		alert ("Minimum Cost is greater than Maximum Cost");
		document.getElementById("mincost").select();
		document.getElementById("mincost").focus();
		return false;
	}
	
	else 
	{
			
		return true;
	}
}
