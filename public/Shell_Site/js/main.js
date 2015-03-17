/********************************
	Function to serialize a given
	form and return the string
*/
function serialize_form( form_id ){
	return $(form_id).serialize();
}

function registerUser( id){
	var xmlhttp;
	var params = serialize_form(id);
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 ) {
           if(xmlhttp.status == 200){
			var text = xmlhttp.responseText;
				alert(text);
				if( text.indexOf("Oh No!") != -1 ){
					document.getElementById("register_inner").innerHTML = xmlhttp.responseText;
				}else{
					$(text).insertBefore.(id);
				}
           }
           else if(xmlhttp.status == 400) {
              alert('There was an error 400')
           }
           else {
               alert('something else other than 200 was returned ' + xmlhttp.status);
			   document.getElementById("register_inner").innerHTML = xmlhttp.responseText;
           }
        }
    }

    xmlhttp.open("GET", "http://localhost/Node/controls/register.php?"+params, true);
    xmlhttp.send();

}

