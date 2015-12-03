<?PHP
require_once('../lib/connections/db.php');
include('../lib/functions/functions.php');

checkLogin('2');

$getuser = getUserRecords($_SESSION['user_id']);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$getuser[0]['username'];?>'s Home Page.</title>
</head>

<body>
	<div align="right"><a href="index.php">Home</a> | <? if (!empty($getuser[0]['thumb_path'])){echo "<a href='manage_photo.php'>Manage My Photo</a> | ";} else {echo "<a href='upload_photo.php'>Upload Photo</a> | ";} ?><a href="change_pass.php">change password</a> | <a href="edit_profile.php">Edit Profile</a> | <a href="log_off.php?action=logoff">sign out</a></div></td>
	<p>Welcome <?php if(empty($getuser[0]['first_name']) || empty($getuser[0]['last_name'])){echo $getuser[0]['username'];} else {echo $getuser[0]['first_name']." ".$getuser[0]['last_name'];} ?></p>
	<? displayUserImg($getuser[0]['id']); ?>
</body>
</html>