function yesNoFunc(){
	
	request = new XMLHttpRequest;

	request.open('GET','http://yesno.wtf/api', true);
	
	request.onload = function() {
		if (request.status >= 200 && request.status < 400){
			data = JSON.parse(request.responseText).image;
			console.log(data);
			console.log(request.responseText);		
			document.getElementById("yesno").innerHTML = '<center><img src = "'+data+'"  title="GIF via Giphy"></center>';
		} 

		else {
			console.log('API returned an error');
		}
	};

	request.onerror = function() {
		console.log('connection error');
	};

	request.send();
}







function giphy(){
	
	q = document.getElementById('search_string').value; // search query
		
	request = new XMLHttpRequest;

	request.open('GET', 'http://api.giphy.com/v1/gifs/translate?s='+q+'&api_key=dc6zaTOxFJmzC&ftm', true);

	request.onload = function() {
		if (request.status >= 200 && request.status < 400){
			
			data = JSON.parse(request.responseText).data.images.fixed_height.url;

			console.log(data);
			
			if(data == typeof(undefined) || data == null){
			document.getElementById("giphyme").innerHTML = '<center><p>GIF Image Not Found</center>';	
			}
			
			else{
			document.getElementById("giphyme").innerHTML = '<center><img src = "'+data+'"  title="GIF via Giphy"></center>';
			}
		}

		else {
			console.log('reached giphy, but API returned an error');
		}
	};

	request.onerror = function() {
		console.log('connection error');
	};

	request.send();
}







function showtickets() {

	var zendesk_uname = document.getElementById('z_uname').value;
	var zendesk_api = document.getElementById('z_api').value;
	var zendesk_subdomain = document.getElementById('z_subdomain').value;
		

        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } 

        else {        
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {                
            	document.getElementById("ztickets").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","zform.php?uname="+zendesk_uname+"&api="+zendesk_api+"&subdomain="+zendesk_subdomain,true);
        xmlhttp.send();

}