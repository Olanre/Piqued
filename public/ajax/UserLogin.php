<?php

/********************************
	File is the login form for 
	users 
	@author Olanre Okunlola
	@date July 12 2014
*/

?>
<script type="text/javascript">
  (function() {
	var po = document.createElement('script');
	po.type = 'text/javascript'; po.async = true;
	po.src = 'https://apis.google.com/js/client:plusone.js?onload=render';
	var s = document.getElementsByTagName('script')[0];
	s.parentNode.insertBefore(po, s);
  })();

  function render() {
	gapi.signin.render('customBtn2', {
	  'callback': 'signinCallback',
	  'clientid': '340794045910-lo9l7r9mks288t1u57rosgjq9j55edj3.apps.googleusercontent.com',
	  'cookiepolicy': 'single_host_origin',
	  'requestvisibleactions': 'http://schema.org/AddAction',
	  'scope': 'https://www.googleapis.com/auth/plus.login email'
	});
  }
  
  </script>
  <style type="text/css">
	#customBtn2 {
	  display: inline-block;
	  background: #dd4b39;
	  color: white;
	  width: 330px;
	  border-radius: 6px;
	  white-space: nowrap;
	}
	#customBtn2:hover {
	  background: #e74b37;
	  cursor: hand;
	}
	</style>
<script src = "https://plus.google.com/js/client:plusone.js"></script>
<div id = "login_error"> </div>
 
<form id="login_form" method="post">
	<div >
		<input type="text"  onkeyup="checkFormValue( this)"  name="user" id="user" placeholder="Your Username" />
	</div>
	
	<div >
		<input type="password"  onkeyup="checkFormValue( this)" name="pass" id="pass" placeholder="Password" />
	</div>
	<a href="#contact"> <span style="color: #700000;font-weight:300"> Help! Can't access my account </span></a><br>
	<input type="button" value="Sign In" onclick="loginUser('login_form')">
</form>
<!-- In the callback, you would hide the gSignInWrapper element on a successful sign in -->
	
	<hr>
	<br>
	<div class="fb-login-button" onlogin="fbLogin()" data-scope="public_profile,email,user_photos,user_friends,user_birthday,user_events" data-max-rows="1" data-size="xlarge" data-show-faces="false" data-auto-logout-link="false"> Connect with Facebook </div>
	<br>
	<div id="gSignInWrapper">
		<div id="customBtn2" class="customGPlusSignIn">
		  <span class="icon"></span>
		  <span class="buttonText">Connect with Google</span>
		</div>
	</div>							
	<br>

<?php

/***************************************
	Please remember to include the section
	to reset password if forgotten or 
	they do not remember their username
***************************************/