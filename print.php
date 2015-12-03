<!doctype html>
<?PHP
require_once('lib/connections/db.php');
include('lib/functions/functions.php');

checkLogin('2');

$getuser = getUserRecords($_SESSION['user_id']);
$intUserID=$getuser[0]['id'];

include 'variables.php';
include 'monnix_db.php';

//$encrypted_txt = encrypt_decrypt('encrypt', $plain_txt);
//echo "Encrypted Text = $encrypted_txt\n";

//$compIDs = encrypt_decrypt('decrypt', $_GET['its']);
$compIDs=$_POST['compsel'];

?>

<html>
<head>
<style>
#contentdv {
	border-radius: 5px;
	background-color: white;
	border: 2px solid black;
	font-size:12px;
}
.profileTable {
	background-color: white;
	font-size:12px;
	border-collapse: collapse;
	border-spacing: 0;
}
.tableHeader	{
	border-bottom: 2px solid black;
	font-weight:bold;
	font-size:14px;
}
.tableRow {
	border-bottom: 2px solid black;
}
</style>
<meta charset="utf-8">
<title>Job Search Tracker Print Page</title>
</head>

<body>
<?
	$dataSels=$_POST['datasel'];
	$prfl=0;
	$rsrc=0;
	$cnts=0;
	if (in_array('prfl', $dataSels)){$prfl=1;}
	if (in_array('rsrc', $dataSels)){$rsrc=1;}
	if (in_array('cnts', $dataSels)){$cnts=1;}
?>

<table align='left' width='700'><tr><td>
<?php
	$runTimes=0;
	//$json = json_decode($compIDs, true);
	foreach ($compIDs as $compID)
	{
		$query = "SELECT profiles.name, profiles.notes AS pNotes, Locations.area AS lArea, Locations.country, Growth.area as gArea, Growth.notes as gNotes FROM profiles LEFT JOIN Locations ON Locations.index=profiles.compLocation LEFT JOIN Growth ON Growth.index=profiles.compGrowth WHERE profiles.index='".$compID."' AND profiles.user='$intUserID';";
		$result = mysql_query($query) or die('<b>Error, query failed:</b> <BR>' . mysql_error());
		$row = mysql_fetch_array($result);
		if ($runTimes>0){echo "<BR><HR>";}
		echo "<h3 style='margin:5px 5px 5px 5px;' align='center'>".$row['name']."</h3>";
		
		
		if($prfl==1){
?>
    <table width="80%" border="0" align="center" class="profileTable">
      <tr>
        <td><b>Growth Area:</b> <? echo $row['gArea'] ?><BR><? echo $row['gNotes'] ?> </td>
        <td><b>Location:</b> <? echo $row['lArea'].",".$row['country'] ?></td>
      </tr>
      <tr>
        <td colspan="2"><b>Notes:</b> <? echo $row['pNotes'] ?></td>
      </tr>
    </table>
<?
		}
//START Contacts PRINT***************************************************
if($cnts==1)
{
	$query = "SELECT COUNT(Contacts.index) AS cCount FROM Contacts WHERE Contacts.company='".$compID."' AND Contacts.user=$intUserID;";
	$result3 = mysql_query($query) or die('Error, query failed' . mysql_error());
	$row3 = mysql_fetch_array($result3);
	if($row3['cCount']>0)
	{
	echo "<h4 style='margin:5px 5px 5px 5px;' align='center'>".$row['name']." Contacts</h3>";
	
?>	
	<div id='contentdv' style="display:block;" align="left">
    <table style="text-align: left;" cellpadding="2" cellspacing="2" width="100%" align="center">
    <tbody>
        <tr class='tableHeader'>
        	<td align="left">Name</td>
            <td align="left" width="120px">Role</td>
            <td align="left" width="150px">Phone #</td>
            <td align="left">E-Mail</td>
        </tr>
<?php
	$query2 = "SELECT Contacts.name AS cName, Contacts.phone, Contacts.email, cp_roles.name as cRole, Contacts.notes FROM Contacts LEFT JOIN cp_roles ON cp_roles.index=Contacts.role WHERE Contacts.company='".$compID."' AND Contacts.user=$intUserID;";
	$result2 = mysql_query($query2) or die('Error, query failed' . mysql_error());
	while($row2 = mysql_fetch_array($result2))
	{
		echo "<tr>";
		echo "<td><u>".$row2['cName']."</u></td>";
		echo "<td>".$row2['cRole']."</td>";
		echo "<td>".$row2['phone']."</td>";
		echo "<td>".$row2['email']."</td>";
		echo "</tr><tr colspan='4' class='tableRow'><td><strong>Notes:</strong> ".$row2['notes']."</td></tr>";
	}

?>
</tbody>
</table>
</div>
<?
	}
}
//START RESEARCH PRINT***************************************************
if($rsrc==1)
{		
	$query = "SELECT COUNT(Research.index) AS rCount FROM Research WHERE Research.company='".$compID."' AND Research.user=$intUserID;";
	$result3 = mysql_query($query) or die('Error, query failed' . mysql_error());
	$row3 = mysql_fetch_array($result3);
	if($row3['rCount']>0)
	{
		echo "<h4 style='margin:5px 5px 5px 5px;' align='center'>".$row['name']." Research</h3>";
?>

<div id='contentdv' style="display:block;" align="left">
	
    <table style="text-align: left;" border="0" cellpadding="2" cellspacing="2" width="100%" align="center">
    <tbody>
        <tr class='tableHeader'>
        	<td align="left">Keyphrase</td>
            <td align="left">Description</td>
        </tr>
<?php
	$query2 = "SELECT * FROM Research WHERE Research.company='".$compID."' AND Research.user=$intUserID;";
	$result2 = mysql_query($query2) or die('Error, query failed' . mysql_error());
	while($row2 = mysql_fetch_array($result2))
	{
		echo "<tr class='tableRow'>";
		echo "<td>".$row2['phrase']."</td>";
		echo "<td>".$row2['notes']."</td></tr>";
	}

?>
</tbody>
</table>
</div>
<?php
	}
	else	{
?>
This company has no reasearch yet.
<BR>
</td></tr>
<?php
	}
	}//END RESEARCH PRINT
	$runTimes++;
} 
?>
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