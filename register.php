<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-GB">
<head>
	<title>Member Registration</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="robots" content="index, follow" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
	
	<script type="text/javascript" src="js/jquery-1.6.2.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function(){
	
			$('#regForm').submit(function(e) {
				register();
				e.preventDefault();	
			});	
		});
	</script>

    <style>
body {
     font: 62.5% "Trebuchet MS", sans-serif;
	 font-size:14px;
	 margin: 15px;
	 
}
.fakewindowcontain .ui-widget-overlay {
		position: absolute;
	}
select {
	width: 200px;
}

A:link {
	text-decoration: none;
	color:#BC0003;
}
A:visited {
	text-decoration: none;
	color:#BC0003;
}
A:active {
	text-decoration: none;
}
A:hover {
	text-decoration: none; 
	color:#09927E;
}

#contentdv {
	border-radius: 10px;
	background-color: white;
	border: 3px solid black;
	background-color:#DAE5E4;
	font-size:12px;
	width:300px; 
	margin-left:auto; 
	margin-right:auto;
}
#profileTools{
	border:medium #000000; 
	border-radius:5px; 
	background-color:#B0D5C9; 
	padding:3px 3px 3px 3px;
}
</style>
</head>
<body>
<table style="text-align: left;" border="0" cellpadding="2" cellspacing="2" width="100%">
    <tbody>
        <tr>
        <td align="left"><span style="font-size:larger; font-weight:bolder">Job Search Tracker</span></td>
        <td align="right" width="100px">
			<div align="center" id="profileTools"><a href="index.php">Home</a></div>
		</td>
        </tr>
    </tbody>
</table>
 <HR><BR>  
<div align="center">
	<p><b>Register</b><BR />
	<p>Use the form below to register.</p>
</div>
	<div class="done"><p>Registration successful! <a href="login.php">Click here</a> to login.</p></div><!--close done-->
	<div class="form" id='contentdv'>
	<form id="regForm" action="reg_submit.php" method="post">
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
			<td>
				<label for="email">Email:</label>
			</td>
			<td>
			<input onclick="this.value='';" name="email" type="text" size="25" maxlength="50" value="<?php if(isset($_POST['email'])){echo $_POST['email'];}?>"/>
			</td>
		  </tr>
		   <tr>
			<td>&nbsp;</td>
			<td>
				<input type="submit" name="register" value="Register" /><img id="loading" src="images/loading.gif" alt="working.." />
			</td>
		  </tr>
		  <tr>
			<td colspan="2"><div id="error">&nbsp;</div></td>
		  </tr>
		</table>
	</form>
	</div><!--close form-->
	
	<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//monnixsys.com/analysis/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 1]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//monnixsys.com/analysis/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->

</body>
</html>
