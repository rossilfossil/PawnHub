function bidCount(ctr){
	// alert(ctr)
	// return;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			if(xmlhttp.responseText != 0){
				alert(xmlhttp.responseText);
				// document.getElementById('tableContent').innerHTML = xmlhttp.responseText;
				// Materialize.toast(xmlhttp.responseText, 4000,'black')
				myTimer(xmlhttp.responseText);
			}
		} // if ready state
	};

	xmlhttp.open("POST","bidCount.php", false);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("ctr=" + ctr);   
}