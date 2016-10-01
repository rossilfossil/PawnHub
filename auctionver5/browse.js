function browseItem(a,b,c,x){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById('container').innerHTML = xmlhttp.responseText;
		} // if ready state
	};

	xmlhttp.open("POST","display-browse.php", false);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("a=" + a + "&b=" + b + "&c=" + c + "&x=" + x);   
}