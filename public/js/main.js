/***************************************************
* First Page Section   					     		*
****************************************************/
/********************************
	Function to serialize a given
	form and return the string
*/
function serialize_form( form_id, form_type ){
	if( form_type == 1){
		var user = document.getElementById('username').value;
		var password = document.getElementById('password').value;
		var age = document.getElementById('age').value;
		var sex = document.getElementById('sex').value;
		var email = document.getElementById('email').value;
		
		var string = "&username="+user+"&password="+password+"&Age="+age+"&Sex="+sex+"&email="+email;
	}else if (form_type == 2){
		var user = document.getElementById('user').value;
		var password = document.getElementById('pass').value;
		var string = "&username="+user+"&password="+password;
	}
	return string;


}

/**********************
Check the value submitted in the form
to ensure a value has been inserted 
and it does not contain errors
*/
function checkFormValue( element){
	var value = element.value;
	if( isEmpty(value) || isBlank(value)){
		
		element.style.borderColor ='#FF0000';
		document.getElementById("error").innerHTML = "<span style='color:red'> Highlighted field(s) required! <span>";
		
	}
	
	if(element.name == "Age"){
		if(parseInt(value) < 13){
			alert(" You must be over 13 years old to register");
		}
	
	}

}

// checks that is a string is blank
function isBlank(str) {
    return (!str || /^\s*$/.test(str));
}

//checks that a string is empty
function isEmpty(str) {
    return (!str || 0 === str.length);
}

/** Send a request to the server to 
	add the given user
*/
function registerUser( id){

	var xmlhttp;
	var params = serialize_form(id, 1);
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
	//hande based on various response codesss
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 ) {
           if(xmlhttp.status == 200){
			var text = xmlhttp.responseText;
				if( text.indexOf("Oh No!") == -1 ){
					document.getElementById("inner").innerHTML = xmlhttp.responseText;
					loginshow();
				}else{
					document.getElementById("error").innerHTML = text;
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

    xmlhttp.open("GET", "/controls/register.php?"+params, true);
    xmlhttp.send();

}

function goSignUp(){
/**
var xmlhttp;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
	//hande based on various response codesss
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 ) {
           if(xmlhttp.status == 200){
			var text = xmlhttp.responseText;
				document.getElementById('ModalBod').innerHTML = text;
				$('#myModal').modal();
           }
           else if(xmlhttp.status == 400) {
              alert('There was an error 400')
           }
           else {
               alert('something else other than 200 was returned ' + xmlhttp.status);
			   document.getElementById("login_error").innerHTML = xmlhttp.responseText;
           }
        }
    }

    xmlhttp.open("GET", "/ajax/UserLogin.php", true);
    xmlhttp.send();
*/
$('#myModal').modal();
}

/*** ********************
	Function to show the login tab
**/
function loginshow(){
	var login = document.getElementById("Login");
	login.setAttribute("style", "display:block");
	document.getElementById("intro_statement").innerHTML = "";
}


/** Send a request to the server to 
	add the given user
*/
function loginUser( id){

	var xmlhttp;
	var params = serialize_form(id, 2);
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
	//hande based on various response codesss
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 ) {
           if(xmlhttp.status == 200){
			var text = xmlhttp.responseText;
				if( text.indexOf("Oh No!") == -1 ){
					document.getElementById("Login").innerHTML = xmlhttp.responseText;
					window.location.reload();
					
				}else{
					document.getElementById("login_error").innerHTML = text;
				}
           }
           else if(xmlhttp.status == 400) {
              alert('There was an error 400')
           }
           else {
               alert('something else other than 200 was returned ' + xmlhttp.status);
			   document.getElementById("login_error").innerHTML = xmlhttp.responseText;
           }
        }
    }

    xmlhttp.open("GET", "/controls/login.php?"+params, true);
    xmlhttp.send();

}

/**
Facebook Authenication callback method
*/
function fbLogin(){
/* make the API call */
	var resp = "";
	FB.api(
		"/v2.0/me",
		function (response) {
		  if (response && !response.error) {
			/* handle the result */
			//alert(JSON.stringify(response));
			resp = JSON.stringify(response);
			fbPicture(resp);
			//alert(resp);
			
		  }else{
			//alert(response);
		  }
		}
	);
	
}

function fbPicture(resp){

FB.api(
    "/v2.0/me/picture",
    function (response) {
      if (response && !response.error) {
        /* handle the result */
		resp += JSON.stringify(response);
		sLn(resp, "fb");
		//alert(resp);
      }else{
		sLn(resp, "fb");
	  }
    }
);

}


/*
Google+ Authenication callback method
*/
function signinCallback(authResult) {
  if (authResult['status']['signed_in']) {
    // Update the app to reflect a signed in user
    // Hide the sign-in button now that the user is authorized, for example:
    document.getElementById('gSignInWrapper').setAttribute('style', 'display: none');
	
	// This sample assumes a client object has been created.
	// To learn more about creating a client, check out the starter:
	//  https://developers.google.com/+/quickstart/javascript
	gapi.client.load('plus', 'v1', apiClientLoaded);


  } else {
    // Update the app to reflect a signed out user
    // Possible error values:
    //   "user_signed_out" - User is signed-out
    //   "access_denied" - User denied access to your app
    //   "immediate_failed" - Could not automatically log in the user
    console.log('Sign-in state: ' + authResult['error']);
  }
}

/**
* Sets up an API call after the Google API client loads.
*/
function apiClientLoaded() {
	gapi.client.plus.people.get({userId: 'me'}).execute(handleEmailResponse);
}

/**
* Response callback for when the API client receives a response.
*
* @param resp The API response object with the user email and profile information.
*/
function handleEmailResponse(resp) {
    var primaryEmail;
	var resp;
    for (var i=0; i < resp.emails.length; i++) {
      if (resp.emails[i].type === 'account') primaryEmail = resp.emails[i].value;
   }
    resp = JSON.stringify(resp);
    //document.getElementById('responseContainer').value = 'Primary email: ' + primaryEmail + '\n\nFull Response:\n' + resp;
	
	sLn(resp, "gog");
}

/***********************************
* Call to log the user in using social 
* media information, redirect the pageX
* when done
*/
function sLn( info, type){
   var xmlhttp;
   //var location = getLocation();
	var params =  "&data="+encodeURIComponent(info)+"&type="+type;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
	//hande based on various response codesss
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 ) {
           if(xmlhttp.status == 200){
			var text = xmlhttp.responseText;
				if( text.indexOf("Oh No!") == -1 ){
					window.location.reload();
					
				}else{
					document.getElementById("login_error").innerHTML = text;
				}
           }
           else if(xmlhttp.status == 400) {
              alert('There was an error 400')
           }
           else {
               alert('something else other than 200 was returned ' + xmlhttp.status);
			   document.getElementById("login_error").innerHTML = xmlhttp.responseText;
           }
        }
    }
	
	//alert(location);
    xmlhttp.open("GET", "/controls/slogin.php?"+params, true);
    xmlhttp.send();
}

var x = document.getElementById("login_error");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    return "&Latitude=" + position.coords.latitude + 
    "&Longitude=" + position.coords.longitude;	
}

/***************************************************
* Main Page Section   					     		*
****************************************************/
function logout(){
	var xmlhttp;
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	//hande based on various response codesss
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 ) {
		   if(xmlhttp.status == 200){
				var text = xmlhttp.responseText;
				window.location.reload();

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

	xmlhttp.open("GET", "/controls/logout.php?", true);
	xmlhttp.send();

}

function newTag() {
    alert("Yum" + $('#newTag').val);
	
}

$(function(){

	/** $('#slide-submenu').on('click',function() {			        
		$(this).closest('.list-group').fadeOut('slide',function(){
			$('.mini-submenu').fadeIn();	
		});
		
	  });

	$('.mini-submenu').on('click',function(){		
		$(this).next('.list-group').toggle('slide');
		$('.mini-submenu').hide();
	}) */
	$("#menu-toggle").click(function(e) {
		e.preventDefault();
		$("#wrapper").toggleClass("active");
	});
});

