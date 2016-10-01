function auctionEnd(auctionID){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById('notification').innerHTML = "<center><h3>Bidding for this Item has ended</h3></center>";
				document.getElementById('submitbid').disabled = true;
				document.getElementById('bid').disabled = true;
		} // if ready state
	};

	xmlhttp.open("POST","auctionend.php", false);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("auctionID=" + auctionID);   
}