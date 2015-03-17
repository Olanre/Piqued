<?php 
/*****************
 This file is used to create the custom
 email we send out to clients
  
	@author: Campaign Monitor
	@modified by: Olanre Okunlola
	@date: 2014-07-06
*/


function generateEmail( $sSalt, $type){
$html_email = "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<!-- If you delete this meta tag, Half Life 3 will never be released. -->
<meta name='viewport' content='width=device-width' />

<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<title>Node Confirmation Email</title>
	
 <link rel='stylesheet' type='text/css' href='../css/email.css' />

</head>
 
<body bgcolor='#FFFFFF'>

<!-- HEADER -->
<table class='head-wrap' bgcolor='#4682B4'>
	<tr>
		<td></td>
		<td class='header container' >
						<h6 class='collapse'>Confirmation Email</h6>
				
		</td>
		<td></td>
	</tr>
</table><!-- /HEADER -->


<!-- BODY -->
<table class='body-wrap'>
	<tr>
		<td></td>
		<td class='container' bgcolor='#FFFFFF'>

			<div class='content'>
			<table>
				<tr>
					<td>";
					
					if($type == 1){
							$html_email .= "
						<h3>You're all set!</h3>
						<p class='lead'>Thank you for choosing to participate in the next level of real time social media.
							Node connects you to the world around you in unique way! </p>
						<p> Node is committed to protecting your privacy. We will never send you emails or newletters apart from this one unless you subscribe to the feed </p>
						<p class='callout'>
							Please click on the URL to confirm your registration and start the experience!<br>
							If clicking does not work please copy and paste the URL below in your browser search bar<br><br>
							
							&nbsp;&nbsp;&nbsp;   http://127.0.0.1/Node/confirm.php?ua={$sSalt} &raquo;
						</p><!-- /Callout Panel -->					
												
						<!-- social & contact -->
						<table class='social' width='100%'>
							<tr>
								<td>
									
									<!-- column 1 -->
									<table align='left' class='column'>
										<tr>
											<td>				
												
												<h5 class=''>Connect with Us:</h5>
												<p class=''><a href='#' class='soc-btn fb'>Facebook</a> <a href='#' class='soc-btn tw'>Twitter</a> <a href='#' class='soc-btn gp'>Google+</a></p>
						
												
											</td>
										</tr>
									</table><!-- /column 1 -->	
									
									<!-- column 2 -->
									<table align='left' class='column'>
										<tr>
											<td>				
																			
												<h5 class=''>Contact Info:</h5>												
												<p>Phone: <strong>7093512041</strong><br/>
													Email: <strong><a href='emailto:okunlola.olanre@gmail.com'>okunlola.olanre@gmail.com</a></strong></p>
                
											</td>
										</tr>
									</table><!-- /column 2 -->
									
									<span class='clear'></span>	
									
								</td>
							</tr>
						</table><!-- /social & contact -->
					";
					}else{
					
					
					}
					$html_email .= "	
					</td>
				</tr>
			</table>
			</div><!-- /content -->
									
		</td>
		<td></td>
	</tr>
</table><!-- /BODY -->

<!-- FOOTER -->
<table class='footer-wrap'>
	<tr>
		<td></td>
		<td class='container'>
			
				<!-- content -->
				<div class='content'>
				<table>
				<tr>
					<td align='center'>
						<p>
							<a href='#'>Terms</a> |
							<a href='#'>Privacy</a> |
							<a href='#'><unsubscribe>Unsubscribe</unsubscribe></a>
						</p>
					</td>
				</tr>
			</table>
				</div><!-- /content -->
				
		</td>
		<td></td>
	</tr>
</table><!-- /FOOTER -->

</body>
</html>
";
return $html_email;
}
?>