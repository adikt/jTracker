<?php
require_once('lib/connections/db.php');
include('lib/functions/functions.php');
$sitesettings = getSiteSettings();
$site_url = $sitesettings[0]['site_url'];
	
//For registration

	// we check if everything is filled in and perform checks

	if(!$_POST['username'])
	{
		die(msg(0,"<p>Please enter a username.</p>"));
	}
	
	if(strlen($_POST['username'])<3 || strlen($_POST['username'])>15)
	{
		die(msg(0,"<p>Username must be between 3 and 15 characters.</p>"));
	}

	elseif(uniqueUser($_POST['username']))
	{
		die(msg(0,"Username already taken."));
	}


	elseif(!$_POST['password'])
	{
		die(msg(0,"<p>Please enter a password.</p>"));
	}
	
	elseif(strlen($_POST['password'])<5)
	{
		die(msg(0,"<p>Usernames must be atleast 5 characters.</p>"));
	}

	elseif(!$_POST['email'])
	{
		die(msg(0,"<p>Please enter an email address.</p>"));
	}
	
	/*elseif(validateEmail($_POST['email']))
	{
		die(msg(0,"<p>Invalid email address.</p>"));
	}*/

	elseif(uniqueEmail($_POST['email']))
	{
		die(msg(0,"<p>Email taken. Please select another email address.</p>"));
	}

	else
		{
			$res = addUser($_POST['username'],$_POST['password'],$_POST['email'],$site_url);
				if ($res == 1){
					die(msg(0,"Failed to send activation email. Please contact the site admin."));
				}
				if ($res == 2){
					die(msg(0,"There was an error registering your details. Please contact the site admin."));
				}
				if ($res == 99){
					die(msg(1,"<p>Registration successful! <a href='login.php'>Click here</a> to login.</p>"));
				}
		}

	function msg($status,$txt)
	{
		return '{"status":'.$status.',"txt":"'.$txt.'"}';
	}

?>
