
		<!-- For Google sign in -->
		  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
		  <script type="text/javascript">
		  (function() {
			var po = document.createElement('script');
			po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/client:plusone.js?onload=render';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(po, s);
		  })();

		  function render() {
			gapi.signin.render('customBtn', {
			  'callback': 'signinCallback',
			  'clientid': '340794045910-lo9l7r9mks288t1u57rosgjq9j55edj3.apps.googleusercontent.com',
			  'cookiepolicy': 'single_host_origin',
			  'requestvisibleactions': 'http://schema.org/AddAction',
			  'scope': 'https://www.googleapis.com/auth/plus.login email'
			});
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
			#customBtn {
			  display: inline-block;
			  background: #dd4b39;
			  color: white;
			  width: 330px;
			  border-radius: 6px;
			  white-space: nowrap;
			}
			#customBtn:hover {
			  background: #e74b37;
			  cursor: hand;
			}
			
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
			
			span.label {
			  font-weight: 500;
			}
			span.icon {
			  background: url('/+/images/branding/btn_red_32.png') transparent 5px 50% no-repeat;
			  display: inline-block;
			  vertical-align: middle;
			  width: 35px;
			  height: 35px;
			  border-right: #bb3f30 1px solid;
			}
			span.buttonText {
			  display: inline-block;
			  vertical-align: middle;
			  padding-left: 35px;
			  padding-right: 35px;
			  font-family:arial;
			  font-size:17px;
			  font-weight:bold;
			  /* Use the Roboto font that is loaded in the <head> */
			  font-family: 'Roboto',arial,sans-serif;
			}
		  </style>

		
		 <script src = "https://plus.google.com/js/client:plusone.js"></script>

		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=305041029674324&version=v2.0";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		
			
			<div id = "intro">
				<!-- Header -->
				<header id="header">

					<!-- Logo -->
						<h1 id="logo"><a href="#">Welcome to The Node</a></h1>
					
					<!-- Nav -->
						<nav id="nav">
							<ul>
								<li><a id="nav1" class="myButton1" href="#intro"><b>Intro</b></a></li>
								<li><a id="nav2" class="myButton1" href="#one"><b>Purpose</b></a></li>
								<li><a id="nav3" class="myButton1" href="#two"><b>Getting Started</b></a></li>
								<li><a id="nav4"  class="myButton1" href="#work"><b>Mobile</b></a></li>
								<li><a id="nav5" class="myButton1" href="#contact"> <span style="color:blue;font-weight:600"> <b> Sign Up </b> </span></a></li>
								<li><a id="nav6" onclick="goSignUp()"  class="button special"> <b> Login </b> </a></li>
							</ul>
						</nav>

				</header>
			</div>
			
			
		
			<div id = "content">
			
				<!-- Intro 
				<section id="intro" class="main style1 dark fullscreen">
					<div class="content container small">
						<header>
							<h2>This is Node</h2>
						</header>
						<div id= "intro_statement">
							<p>A brand new app designed to connect you to events and people around you.<br />
							View events happening around you, follow event feeds, connect with friends, groups and submit live feeds. <br/> </p>
						</div>
						<div id="Login" >
								
								<?php
									#get the login form
									#include('/ajax/UserLogin.php'); ?>
								<div id = "login_error"> </div>
								<div class="fb-login-button" onlogin="fbLogin()" data-scope="public_profile,email,user_photos,user_location,user_birthday,user_events" data-max-rows="1" data-size="xlarge" data-show-faces="false" data-auto-logout-link="false"> Connect with Facebook </div>
								<br>
								<br>
								<!-- In the callback, you would hide the gSignInWrapper element on a
								  successful sign in 
								  <div id="gSignInWrapper">
									<div id="customBtn" class="customGPlusSignIn">
									  <span class="icon"></span>
									  <span class="buttonText">Sign In with Google</span>
									</div>
								  </div>							
								<br>
								
								<a href="#contact" class="myButton1" style="color:black">Sign up with Email</a>
								 
							</div>
						
						<footer>
							<a href="#one" class="button style2 down">More</a>
						</footer>
					</div>
				</section> -->
				
				<!-- Banner -->		
				<section id="banner">
				
				<!--
					".inner" is set up as an inline-block so it automatically expands
					in both directions to fit whatever's inside it. This means it won't
					automatically wrap lines, so be sure to use line breaks where
					appropriate (<br />).
				-->
				<div class="inner">
					
					<header>
						<h2>This is Node</h2>
					</header>
					<div id= "intro_statement">
						<p>A brand new app designed to connect you to events and people around you.<br />
						View events happening around you, follow event feeds, connect with friends, groups and submit live feeds. <br/> </p>
					</div>
					<footer>
						<ul class="buttons vertical">
							<li><a href="#one" class="button fit scrolly">Tell Me More</a></li>
						</ul>
					</footer>
				
				</div>
				
				</section>
				
				
			
			<!-- One -->
				<section id="one" class="main style2 right dark fullscreen">
					<div class="content box style2">
						<header>
							<h2>The Purpose<br />
							</h2>
						</header>
						<p> Project Node brings the latest advances in open world maps and digital technology at your fingertips.
							With the touch of a button get real time updates delivered through our interactive map about events, social gathering
							and news updates occurring around you!</p>
					</div>
					<a href="#two" class="button style2 down anchored">Next</a>
				</section>
			
			<!-- Two -->
				<section id="two" class="main style2 left dark fullscreen">
					<div class="content box style2">
						<header>
							<h2>Getting Started</h2>
						</header>
						<p> Real time updates of local events, interactive media map, social engagement networks and event planning. Anything is possible with Node
						Click the video below for a demo</p>
					</div>
					<a href="#work" class="button style2 down anchored">Next</a>
				</section>
				
			<!-- Work -->
				<section id="work" class="main style3 primary">
					<div class="content container">
						<header>
							<h2>Mobile</h2>
							<p>Launching a brand new mobile app soon. Check for updates for the iPhone and Android Devices! </p>
						</header>
						
						<!--
							 Lightbox Gallery
							 
							 Powered by poptrox. Full docs here: https://github.com/n33/jquery.poptrox
						-->
							<div class="mobile">
								<div class="container small gallery">
									<div class="row flush images">
										<div class="6u"><a href="images/fulls/01.jpg" class="image full l"><img src="images/thumbs/01.jpg" title="The Anonymous Red" alt="" /></a></div>
										<div class="6u"><a href="images/fulls/02.jpg" class="image full r"><img src="images/thumbs/02.jpg" title="Airchitecture II" alt="" /></a></div>
									</div>
									
								</div>
							</div>

					</div>
				</section>
				
			<!-- Contact -->
				<section id="contact" class="main style3 secondary">
					<div class="content container">

						<header>
							<h2>Sign Up, its free!</h2>
						</header>
						
						<div class="box container small" id = "inner">
							<div id="error">
							</div>
							<br>
							<div class="fb-login-button" onlogin="fbLogin()" data-scope="public_profile,email,user_friends,user_location,user_birthday,user_events" data-max-rows="1" data-size="xlarge" data-show-faces="false" data-auto-logout-link="false"> Connect with Facebook </div>
							<br>
							<br>
							<div id="gSignInWrapper">
								<div id="customBtn" class="customGPlusSignIn">
								  <span class="icon"></span>
								  <span class="buttonText">Connect with Google</span>
								</div>
							</div>							
							<br>
							
							<hr>
							<br>
							<div  id = "register_inner" >
								
								<h1>Sign up with your Email</h1>
								
								<form class="form" id="register_form" method="post">
									<div  >
										<input type="text" onkeyup="checkFormValue( this)" id="username" name="username" placeholder="Your Username" />
									</div>
									
									<div >
										<input type="password" onkeyup="checkFormValue( this)" id="password" name="password" placeholder="Password" />
									</div>
									
									<div >
										<input type="text" id="age" onkeyup="checkFormValue( this)" name="Age" size="5" placeholder="Your Age (Must be over 13)" />
									</div>
									
									<div >
										 <select name="Sex" id="sex" onkeyup="checkFormValue( this)" >
											<option value = "0"> Sex </option>
											<option value = "1"> Male </option>
											<option value = "2"> Female </option>
											<option value = "3"> Other </option>
										</select>
									</div>
									
									<div >
										<input type="text" onkeyup="checkFormValue( this)" id="email" name="email" placeholder="Email" />
									</div>					
																
									<input type="button" value="Join" onclick="registerUser('register_form')" />
									
								</form>
								
							</div>
						
						

						</div>
					</div>
				</section>
		</div>
			<!-- Footer -->
			<footer id="footer">
			
				<!--
				     Social Icons
				     
				     Use anything from here: http://fortawesome.github.io/Font-Awesome/cheatsheet/)
				-->
					<ul class="actions">
						<li><a href="#" class="fa solo fa-twitter"><span>Twitter</span></a></li>
						<li><a href="#" class="fa solo fa-facebook"><span>Facebook</span></a></li>
						<li><a href="#" class="fa solo fa-google-plus"><span>Google+</span></a></li>
						<li><a href="#" class="fa solo fa-dribbble"><span>Dribbble</span></a></li>
						<li><a href="#" class="fa solo fa-pinterest"><span>Pinterest</span></a></li>
						<li><a href="#" class="fa solo fa-instagram"><span>Instagram</span></a></li>
					</ul>

				<!-- Menu -->
					<ul class="menu">
						<li>&copy; ProjectNode. All rights reserved.</li>
						<li>Design: <a href="http://html5up.net/">HTML5 UP</a></li>
					</ul>
			
			</footer>
		
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			 <div class="modal-header">
				<h4 class="modal-title">Log In/Sign Up <h4>
			  </div>
			  <div class="modal-body"id = "ModalBod">
					<div id = "login_error"> </div>
 
					<form id="login_form" method="post">
						<div >
							<input type="text"  onkeyup="checkFormValue( this)"  name="user" id="user" placeholder="Your Username" />
						</div>
						
						<div >
							<input type="password"  onkeyup="checkFormValue( this)" name="pass" id="pass" placeholder="Password" />
						</div>
						<a href="#contact"> <span style="color: #700000;font-weight:300"> Help! Can't access my account </span></a><br>
						<input type="button" class="myButton1" value="Sign In" onclick="loginUser('login_form')">
					</form>
					<!-- In the callback, you would hide the gSignInWrapper element on a successful sign in -->
						<br>
						<div class="fb-login-button" onlogin="fbLogin()" data-scope="public_profile,email,user_friends,user_location,user_birthday,user_events" data-max-rows="1" data-size="xlarge" data-show-faces="false" data-auto-logout-link="false"> Connect with Facebook </div>
						<br>
						<br>
						<div id="gSignInWrapper">
							<div id="customBtn2" class="customGPlusSignIn">
							  <span class="icon"></span>
							  <span class="buttonText">Sign In with Google</span>
							</div>
						</div>							
						<br>

			  </div>
			   <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div> 
			</div>
		  </div>
		</div>
