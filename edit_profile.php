<?PHP
require_once('lib/connections/db.php');
include('lib/functions/functions.php');

checkLogin('2');

$getuser = getUserRecords($_SESSION['user_id']);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Edit <?=$getuser[0]['username'];?>'s Profile.</title>
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
	
			$('#editprofileForm').submit(function(e) {
				editprofile();
				e.preventDefault();	
			});
			
			$('#updatepassForm').submit(function(e) {
				updatepass();
				e.preventDefault();	
			});	
		});

	</script>
    <script language="javascript">
	function toggle(id, status) {
		if (status == '0') {
			document.getElementById(id).style.display = 'none';
		} else {
			document.getElementById(id).style.display = 'block';
		}
	}
</script>
    <style>
.form {
	border-radius: 10px;
	background-color: white;
	border: 3px solid black;
	background-color:#DAE5E4;
	font-size:12px;
}
#profileTools{
	border:medium #000000; 
	border-radius:5px; 
	background-color:#B0D5C9; 
	padding:3px 3px 3px 3px;
}

</style>
<link rel="stylesheet" href="css/companies.css" />
</head>


<body>
<table style="text-align: left;" border="0" cellpadding="2" cellspacing="2" width="100%">
    <tbody>
        <tr>
        <td align="left"><span style="font-size:larger; font-weight:bolder">Job Search Tracker</span></td>
        <td align="right" width="240px">
			<div align="center" id="profileTools"><a href="index.php">Home</a> | <a href="edit_profile.php">Profile</a> | <a href="help/help2.jpg" target="_blank">Help</a> | <a href="log_off.php?action=logoff">Log Off</a></div>
		</td>
        </tr>
    </tbody>
</table>
 <HR><BR>   
	<p align="center"><?php echo $getuser[0]['username']; ?>, edit your profile.</p>
	<p align="center" class="done">Profile updated successfully.</p><!--close done-->
    <table border="0" style="height:230px; margin-left:auto; margin-right:auto;">
  <tr>
    <td width="160px">
    	<a href='#compData' class='inline' onClick="toggle('passForm','0'); toggle('profileForm','1');">
    	<div class="toolButton" align="center">
    		<strong>Edit Profile</strong>
        </div></a>
        
    </td>
    <td></td>
    <td width="160px">
    	<a href='#compData' class='inline' onClick="toggle('profileForm','0'); toggle('passForm','1'); ">
    	<div class="toolButton" align="center">
    		<strong>Change Password</strong>
        </div></a>
    </td>
    </tr>
    <tr>
    <td width="350px" colspan="3">
    	<div class="form" id='profileForm' style="width:350px; margin-left:auto; margin-right:auto; display:block;">
	  		<h3 align="center">Update Profile</h3>
      <form id="editprofileForm" action="edit_profile_submit.php" method="post">
	  <table border="0" cellpadding="0" cellspacing="0" style="padding-left:8px;" align="center">
		<tr>
			<td><label for="first_name">User Name:</label></td><td><input type="text" name="first_name" value="<? if(isset($getuser[0]['first_name'])){echo $getuser[0]['first_name'];}?>"/></td>
		</tr>
		<tr>
			<td valign="top">Current:</td><td valign="top"><?= $getuser[0]['username'];?></td>
		</tr>
		<tr>
			<td style="padding-top:8px;"><label for="email"><label>Email:</label></td><td style="padding-top:8px;"><input type="text" name="email" value="" /> <span class="label"> </span></td>
		</tr>
        <tr>
        	<td>Current:</td>
            <td><?= $getuser[0]['email'];?></td>
        </tr>
		<tr>
			<td colspan="2" style="padding-top:5px;" align="center"><input type="submit" name="editprofile" value="Update Profile" /><img id="loading" src="../images/loading.gif" alt="Updating.." /><BR></td>
		</tr>
		<tr>
			<td colspan="2"><div id="error">&nbsp;</div></td>
		</tr>
        <tr>
        	<td align="center" colspan="2">
        	<b></b>
            </td>
        </tr>
	  </table>
	  </form>
	</div>
    <!----- END PROFILE END ------>
    
    
    <div class="form" id="passForm" style="display:none; width:350px">
			<h3 align="center">Change Password</h3>
			<table class="searchForm" border="0" align="center">
                <form id="updatepassForm" action="change_pass_submit.php" method="post">
                <tr>
                    <td><label for="old password">Old Password:</label></td><td><input name="oldpassword" type="password"/></td>
                </tr>
                <tr>
                    <td><label for="new password">New Password:</label></td><td><input name="newpassword" type="password"/></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type="submit" name="submit" value="Change Password" /><img id="loading" src="../images/loading.gif" alt="Updating.." /></td>
                </tr>
                <tr>
                    <td colspan="2"><div id="error">&nbsp;</div></td>
                </tr>
                </form>
            </table>
        </div>
            <!--close form-->
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