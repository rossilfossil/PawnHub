function setAuctionType(type){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById('itemList').innerHTML = ""
		} // if ready state
	};

	xmlhttp.open("POST","set_auction_type.php", false);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("type=" + type);   
}