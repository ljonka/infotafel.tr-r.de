var url = "https://www.transition-regensburg.de/pad/p/ED2ukldwvQ/export/txt"
var xmlhttp;
if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
}
else { // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var res = xmlhttp.responseText.split("\n");
	res.forEach(function(page, position){	
		if(page !== ""){
			setTimeout(function () {
				var iframe = document.getElementById("body_content");
				iframe.setAttribute("src", page);
				window.setTimeout(function() {
					console.log("ping");
					var iframe = document.getElementById("body_content");
					var playElem = iframe.contentWindow.document.querySelector("input.svg.play.icon-view-play");
	                                if(playElem !== null){
        	                                playElem.click();
                	                }
    				}, 5000);
			}, 15000 * position);
		}
	});
    }
}
xmlhttp.open("GET", url, true);
xmlhttp.send();

