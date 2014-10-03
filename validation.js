function myFunction() {

  var minYear = document.getElementById("minyear").value;
  var maxYear = document.getElementById("maxyear").value;
  var minCost = document.getElementById("mincost").value;
  var maxCost = document.getElementById("maxcost").value;
  
  var message = document.getElementById('confirmMessage');
  var message1 = document.getElementById('confirmMessage1');
  var goodColor = "#66cc66";
  var badColor = "#ff6666";
  
  if (minYear > maxYear) 
{
alert ("Min Year is greater than Max Year");
document.getElementById("minyear").select();
document.getElementById("minyear").focus();
return false;
}
if (minCost > maxCost) 
{
alert ("Min Cost is greater than Max Cost");
document.getElementById("mincost").select();
document.getElementById("mincost").focus();
return false;
}
  else {
		
	
		return true;
  }
}
