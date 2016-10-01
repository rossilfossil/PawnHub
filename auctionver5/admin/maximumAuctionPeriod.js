function setMaxDate(enddate){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById('enddate').max = xmlhttp.responseText;
		} // if ready state
	};

	xmlhttp.open("POST","maximumDate.php", false);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("enddate=" + enddate);   
}