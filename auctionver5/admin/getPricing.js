function setPricing(amount){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById('idealPrice').innerHTML = xmlhttp.responseText;
		} // if ready state
	};

	xmlhttp.open("POST","display-pricing.php", false);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("amount=" + amount);   
}