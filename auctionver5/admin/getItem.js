function getItem(){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById('itemlist2').innerHTML = xmlhttp.responseText
 			$('#itemModal').openModal();
		} // if ready state
	};

	xmlhttp.open("POST","itemlistmodal.php", false);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send();   
}