<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-GB">
<head>
	<title>Log In</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="robots" content="index, follow" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
	
	<script type="text/javascript" src="js/jquery-1.6.2.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
		
	<script type="text/javascript">
		$(document).ready(function(){
	
			$('#loginForm').submit(function(e) {
				login();
				e.preventDefault();	
			});	
		});

	</script>
<link rel="stylesheet" href="css/companies.css" />
</head>
<body>
	<table align="center" width="100%" cellspacing="1" cellpadding="1" border="0">
	  <tr>
      	<td align="left"><span style="font-size:larger; font-weight:bolder">Job Search Tracker</span></td>
		<td align="right"><a href="admin/login.php">Admin Login</a></td>
	  </tr>
	</table>
    
	<? if(!empty($error)){echo "<div class='error'>".$error."</div>";}?>
	<hr/>
    <table width="80%" border="0" align="center" cellspacing="15px">
  <tr>
    <td width="50%">
    	<div id='betmsg' align="center" style="width:300px; border: 3px solid black; border-radius:10px; background-color:#A7D6EC; margin-left:auto; margin-right:auto; padding-left:5px; padding-right:5px;">
    <P style="color:#000000;; font-weight:bold" align="center">About jTracker</P>
    <p align="left">
    	jTracker (Job Search Tracker) is an application to help organize the application process events, contacts and companies during the job search process.
    </p>
    <p align="left"><b>Not Working:</b><BR />
	Some bugs here and there<br />
    Printing:<br />
	-Pros/Cons<BR />
    -Action Log
    </p>
</div>
    </td>
    <td style="50%">
    	<div align="center" id="contentdv" style="width:280px;">
        <B>LOGIN</B>
        <p align="center">Please log on to your account to proceed, or <BR /><a href="register.php"><strong>Register a new user.</strong></a> </p>
        <HR />
        <form id="loginForm" method="post" action="login_submit.php">
            <table align="center" width="50%" cellspacing="1" cellpadding="1" border="0">
              <tr>
                <td colspan="2" ></td>
              </tr>
              <tr>
                <td>
                    <label for="username">Username:</label>
                </td>
                <td>
                    <input onclick="this.value='';" name="username" type="text" size="25" maxlength="8" value="<?php if(isset($_POST['username'])){echo $_POST['username'];}?>"/>
                </td>
              </tr>
              <tr>
                <td>
                    <label for="password">Password:</label>
                </td>
                <td>
                    <input name="password" type="password" size="25" maxlength="15" />
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" name="submit" value="Login" /><img id="loading" src="images/loading.gif" alt="Logging in.." />
                </td>
              </tr>
              <tr>
                <td class="normalLinks" colspan="2">
                    <a href="pass_reset.php"><div align='center' class="toolButton" style="width:130px; margin-left:auto; margin-right:auto"><strong>Password recovery?</strong></div></a>
                </td>
                
              </tr>
              <tr>
                <td colspan="2"><div id="error">&nbsp;</div></td>
              </tr>
            </table>
        </form>
        </div>
    </td>
  </tr>
</table>

<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//monnixsys.com/analysis/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 2]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//monnixsys.com/analysis/piwik.php?idsite=2" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->

</body>
</html>
