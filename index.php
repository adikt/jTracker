<?PHP
include 'variables.php';
require_once('lib/connections/db.php');
include('lib/functions/functions.php');

checkLogin('2');

$getuser = getUserRecords($_SESSION['user_id']);
$intUserID = $getuser[0]['id'];
?>
<?php
	include 'monnix_db.php';
	$strAction = "";
	$locationTable = "<table class='contentTable' border='0' cellpadding='2' cellspacing='2' width='100%'><tr class='tableHeader'><td>Country</td><td>Area</td><td></td></tr>";
	$growthTable = "<table class='contentTable' border='0' cellpadding='2' cellspacing='2' width='100%'><tr class='tableHeader'><td>Growth Area</td><td>Notes</td><td></td></tr>";
	
	function isResearch($inComp, $inID)	{
		$j=0;
		$query2 = "SELECT COUNT(Research.index) as researchCount FROM Research WHERE Research.company=$inComp AND Research.user=$inID;";
        $result2 = mysql_query($query2) or die('Error, query failed' . mysql_error());
        $row2 = mysql_fetch_array($result2);
		if ($row2['researchCount']>0)	{
			echo "<a class='ajax' href='research.php?ja=$inComp' title='Research'><img src='images/research.png' height='20px' width='20px' border='0'></a>";
			$j=1;
		}
		return $j;
	}
	
	function isResume($inCompany, $inID)	{
		$j=0;
		$query2 = "SELECT COUNT(event_log.index) as someCount FROM event_log WHERE event_log.company='$inCompany' AND event_log.user=$inID AND event_log.action='1';";
        $result2 = mysql_query($query2) or die('Error, query failed' . mysql_error());
        $row2 = mysql_fetch_array($result2);
		if ($row2['someCount']>0)	{
			echo "<a class='ajax' href='contacts.php?ja=$inCompany' title='Resume Sent'><img src='".$mURL."images/resume.png' height='20px' width='20px' alt='Resume Submitted'></a>";
			$j=1;
		}
		return $j;
	}
	
	function isInterview($inCompany, $inID)	{
		$j=0;
		$query2 = "SELECT COUNT(event_log.index) as someCount FROM event_log WHERE event_log.company='$inCompany' AND event_log.user='$inID' AND event_log.action='2';";
        $result2 = mysql_query($query2) or die('Error, query failed' . mysql_error());
        $row2 = mysql_fetch_array($result2);
		if ($row2['someCount']>0)	{
			echo "<a class='ajax' href='contacts.php?ja=$inCompany' title='Interview Conducted'><img src='".$mURL."images/interview.png' height='20px' width='20px' alt='Interview Conducted'></a>";
			$j=1;
		}
		return $j;
	}
	
	function isThankYou($inCompany, $inID)	{
		$j=0;
		$query2 = "SELECT COUNT(event_log.index) as someCount FROM event_log WHERE event_log.company='$inCompany' AND event_log.user='$inID' AND event_log.action='3';";
        $result2 = mysql_query($query2) or die('Error, query failed' . mysql_error());
        $row2 = mysql_fetch_array($result2);
		if ($row2['someCount']>0)	{
			echo "<a class='ajax' href='contacts.php?ja=$inCompany' title='Thank You Sent'><img src='".$mURL."images/thanks.png' height='20px' width='20px' alt='Thank You Sent'></a>";
			$j=1;
		}
		return $j;
	}
	
	function isFollowUp($inCompany, $inID)	{
		$j=0;
		$query2 = "SELECT COUNT(event_log.index) as someCount FROM event_log WHERE event_log.company='$inCompany' AND event_log.user='$inID' AND event_log.action='4';";
        $result2 = mysql_query($query2) or die('Error, query failed' . mysql_error());
        $row2 = mysql_fetch_array($result2);
		if ($row2['someCount']>0)	{
			echo "<a class='ajax' href='contacts.php?ja=$inCompany' title='Followed Up'><img src='".$mURL."images/followup.png' height='20px' width='20px' alt='Followed Up'></a>";
			$j=1;
		}
		return $j;
	}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style>

#firstRun {
	border-radius: 10px;
	border: 3px solid black;
	margin-left:auto;
	margin-right:auto;
	padding:3px 3px 3px 3px;
	background-color:#9DD5F8;
	font-size:14px;
}

#locTools {
	border-radius: 10px;
	border: 3px solid black;
	background-color:#C4D6EC;
}
#growthTools {
	border-radius: 10px;
	border: 3px solid black;
	background-color:#C4D6EC;
}


</style>
<link rel="stylesheet" href="jquery/jquery-ui.css">
<link rel="stylesheet" href="colorbox.css" />
<link rel="stylesheet" href="css/companies.css" />
<script src="jquery/jquery.js"></script>
<script src="jquery/jquery-ui.js"></script>
<script src="java/jsCompanies.js"></script>
<script src="java/jquery.colorbox.js"></script>
<script language="javascript">
function toggle(id) {
	var state = document.getElementById(id).style.display;
		if (state == 'block') {
			document.getElementById(id).style.display = 'none';
		} else {
			document.getElementById(id).style.display = 'block';
		}
	}
</script>

<title>Job Search Tracker</title>

</head>
<body>
<table style="text-align: left;" border="0" cellpadding="2" cellspacing="2" width="100%">
    <tbody>
        <tr>
        <td align="left"><span style="font-size:larger; font-weight:bolder">Job Search Tracker</span></td>
        <td align="right" width="240px">
			<div align="center" style="border:medium #000000; border-radius:5px; background-color:#B0D5C9; padding:3px 3px 3px 3px;"><a href="index.php">Home</a> | 
			<? if ($getuser[0]['username']<>'guest') { ?>
			<a href="edit_profile.php">Profile</a> | 
			<? }?>
			<a href="help/help2.jpg" target="_blank">Help</a> | <a href="log_off.php?action=logoff">Log Off</a></div>
		</td>
        </tr>
    </tbody>
</table>
<HR>
<div align="center" style="margin-left:auto; margin-right:auto">
<table width="60%" border="0">
  <tr>
    <td width="33%"><a href='#Locations' class="inline">
    	<div align='center' class="toolButton"><strong>Location Manager</strong></div></a>
    </td>
    <td width="33%"><a href='#GrowthA' class="inline">
    	<div align='center' class="toolButton"><strong>Growth Area Manager</strong></div></a>
    </td>
    <td width="33%"><a href='#compData' class='inline'>
    	<div class="toolButton" align="center">
    		<strong>Add New Company!</strong>
        </div></a>
    </td>
  </tr>
</table>


</div>
<div align="center">
<?
	echo $strAction;
?>
</div>

<BR>

<div style='display:none'>
<div id="printPage" align="center">
	<div>
	<form method="post" action="print.php" id="print_page" target="_blank">
    <h3>Select Data and Companies to Print</h3>(Hold Ctrl to multi-select)
    <table style="text-align: left;" border="0" cellpadding="2" cellspacing="2">
    <tbody>
        <tr>
            <td>Companies:</td>
            <td>
            	<select name="compsel[]" multiple="multiple">
            <?php
				
				$query = "SELECT profiles.index, profiles.name FROM profiles WHERE profiles.user='$intUserID';";
                $result2 = mysql_query($query) or die('Error, query failed' . mysql_error());
				while($row = mysql_fetch_array($result2))
				{
					echo "<option value='".$row['index']."'>".$row['name']."</option>";
				}			
			?>
            </select>
			</td>
        </tr>
        <tr>
            <td>Data:</td>
            <td><select name="datasel[]" multiple="multiple">
                <option value="prfl">Profile</option>
                <option value="rsrc">Research</option>
                <option value="cnts">Contacts</option>
				</select>
           </td>
        </tr>
        <tr>
        <td><input name="act" value="printpage" type="hidden">
        </td>
        <td align="center"><input value="Print" type="submit" name="btnAct" onClick="$.colorbox.close();"> <input value="Done" type="button" name="btnClose" onClick="$.colorbox.close();"></td>
        </tr>
    </tbody>
    </table>
    </form>
    </div>
</div>

<div id="locData" align="center">
	<div>
	<form method="post" action="dbhandle.php" id="location_data">
    <h3>Add/Edit Location</h3>
    <table style="text-align: left;" border="0" cellpadding="2" cellspacing="2">
    <tbody>
        <tr>
            <td>Country:</td>
            <td><input name="input" type="text"></td>
        </tr>
        <tr>
            <td>Region:</td>
            <td><input name="notes" type="text"></td>
        </tr>
        <tr>
        <td><input name="act" value="add_loct" type="hidden"><input name="profIndex" value="" type="hidden">
        </td>
        <td align="center"><input value="Add" type="submit" name="btnAct"> <input value="Done" type="button" name="btnClose" onClick="$.colorbox.close();"></td>
        </tr>
    </tbody>
    </table>
    </form>
    </div>
</div>

<div id="compData" class="" align="center">
	<div>
    	<h3>Add/Edit Company</h3>
        <form method="post" action="dbhandle.php" enctype="multipart/form-data" id="comp_name">
        <table style="text-align: left;" border="0" cellpadding="2" cellspacing="2">
        <tbody>
            <tr>
                <td>Company:</td>
                <td><input name="input" type="text" size="40"></td>
                <td rowspan="3">
        
                </td>
            </tr>
            <tr >
                <td colspan='2'>
                    <label for="compGrow">Growth Area:</label>
                    <select name="compGrow">
                    <option value ='0'>-</option>
                <?
                    $query = "SELECT Growth.index, Growth.area, Growth.notes FROM Growth WHERE Growth.user=$intUserID;";
                    $result = mysql_query($query) or die('Error, query failed' . mysql_error());
                    while($row = mysql_fetch_array($result))
                    {
                        echo "<option value ='" . $row['index'] . "'>" . $row['area'] . "</option>";
						$query = "SELECT COUNT(profiles.index) as pCount FROM profiles WHERE profiles.user='$intUserID' AND profiles.compGrowth='" . $row['index'] . "';";
                    $result2 = mysql_query($query) or die('Error, query failed' . mysql_error());
					$row2 = mysql_fetch_array($result2);
						$isLocked=1;
						if ($row2['pCount']==0)	{
							$isLocked=0;
						}
						$growthTable=$growthTable . "<tr class='tableRow'><td>" . $row['area'] . "</td><td>" . $row['notes'] . "</td><td><a class='inline' href='#growData' onClick=\"editForm('growth_data', 'edt_grow', '".$row['area']."', '".$row['notes']."', 'growData', '".$row['index']."')\"><img src='".$mURL."images/edit1.png' height='20px' width='20px' style='cursor:pointer;' alt='Delete'></a><img src='".$mURL."images/delete.png' height='20px' width='20px' style='cursor:pointer;' alt='Delete' onClick=\"delForm('growth_data', 'grow', '".$row['index']."', 3, " . $isLocked . ")\"></td></tr>";
                    }
                    $growthTable=$growthTable . "</table>";
                ?>
                    </select><BR>
                    <label for="compLoc">Location:</label>
                    <select name="compLoc">
                    <option value ='0'>-</option>
                <?
                    $query = "SELECT Locations.index, Locations.country, Locations.area FROM Locations WHERE Locations.user='$intUserID';";
                    $result = mysql_query($query) or die('Error, query failed' . mysql_error());
                    while($row = mysql_fetch_array($result))
                    {
                        echo "<option value ='" . $row['index'] . "'>" . $row['country'] . " - " . $row['area'] . "</option>";
						
						$query = "SELECT COUNT(profiles.index) as pCount FROM profiles WHERE profiles.user='$intUserID' AND profiles.compLocation='" . $row['index'] . "';";
                    $result2 = mysql_query($query) or die('Error, query failed' . mysql_error());
					$row2 = mysql_fetch_array($result2);
						$isLocked=1;
						if ($row2['pCount']==0)	{
							$isLocked=0;
						}
						
						
						$locationTable=$locationTable . "<tr class='tableRow'><td>" . $row['country'] . "</td><td>" . $row['area'] . "</td><td><a class='inline' href='#locData' onClick=\"editForm('location_data', 'edt_loct', '".$row['country']."', '".$row['area']."', 'locData', '".$row['index']."')\"><img src='".$mURL."images/edit1.png' height='20px' width='20px' style='cursor:pointer;' alt='Delete'></a><img src='".$mURL."images/delete.png' height='20px' width='20px' style='cursor:pointer;' alt='Delete' onClick=\"delForm('location_data', 'loct', '".$row['index']."', 2, " . $isLocked . ");\"></td></tr>";
                    }
					$locationTable=$locationTable . "</table>";
                ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right">Notes</td>
                <td><textarea cols="30" rows="5" name="notes"></textarea></td>
            </tr>
            <tr>
                <td><input name="act" value="add_comp" type="hidden"><input name="profIndex" value="" type="hidden"></td>
                <td align="center"><input value="Add" type="submit" name="btnAct"> <input value="Done" type="button" name="btnClose" onClick="$.colorbox.close();"></td>
            </tr>
        </tbody>
        </table>
        </form>
    </div>
</div>

<div id="proData" class="overlay">
	<div>
	<form method="post" action="dbhandle.php" id="pro_data">
    <h3>Add/Edit Company Pros</h3>
    <table style="text-align: left;" border="0" cellpadding="2" cellspacing="2">
    <tbody>
        <tr>
            <td>Title:</td>
            <td><input name="input" type="text"></td>
        </tr>
        <tr>
            <td>Notes:</td>
            <td><textarea cols="30" rows="5" name="notes" id="notes"></textarea></td>
        </tr>
        <tr>
        <td><input name="act" value="add_pros" type="hidden"><input name="profIndex" value="" type="hidden">
        </td>
        <td align="center"><input value="Add" type="submit" name="btnAct"> <input value="Done" type="button" name="btnClose" onClick="$.colorbox.close();"></td>
        </tr>
    </tbody>
    </table>
    </form>
    </div>
</div>

</div>





<div id='contentdv' align="center">
	<table width="100%" border="0" class="contentTable" >
  <tr  class='tableHeader' cellspacing="5px">
    <td align='center' width="40px">Rank</td>
    <td align='left'>Company</td>
    <td align='left'>Location
    </td>
    <td align='left'>
    	<b>Growth Area</b>
    </td>
    <td align="center">
    	<b>Pros</b>
    </td>
    <td align="center">
    	<b>Cons</b>
    </td>
    <td align="center" width="105px">
    	<b>Completed</b>
    </td>
    <td align="center" width="120px">
    	<b>Next Step</b>
    </td>
    <td align="center">
    	<b>Progress</b>
    </td>
    <td align="right" style="padding-left:5px;"></td>
  </tr>
<?
	$ran=0;
	$query = "SELECT (SELECT COUNT(Pros.index) FROM Pros WHERE Pros.company=profiles.index and Pros.user=$intUserID) AS proCount, (SELECT COUNT(Cons.index) FROM Cons WHERE Cons.company=profiles.index and Cons.user=$intUserID) AS conCount, profiles.name, profiles.index AS cIndex, profiles.notes AS pNotes, Locations.area AS lArea, Locations.Index as lIndex, Locations.country, Growth.area as gArea, Growth.index AS gIndex, Growth.notes AS gNotes FROM profiles LEFT JOIN Locations ON Locations.index=profiles.compLocation LEFT JOIN Growth ON Growth.index=profiles.compGrowth WHERE profiles.user=$intUserID ORDER BY proCount-conCount DESC;";
    $result = mysql_query($query) or die('Error, query failed' . mysql_error());
    while($row = mysql_fetch_array($result))
	{
		$ran++;
		$i=0;
		$k=0;
		$l=0;
		$strClass="";
		$query = "SELECT COUNT(event_log.index) as intFeedback FROM event_log WHERE event_log.action=5 AND event_log.company='" . $row['cIndex'] . "' AND event_log.user=$intUserID;";
    	$fresult = mysql_query($query) or die('Error, query failed' . mysql_error());
		$frow = mysql_fetch_array($fresult);
		if($frow['intFeedback']>0) {
			$strClass="done";
		}
		
		echo "<tr class='tableRow".$strClass."'>";
    	echo "<td align='center'>".$ran."</td><td><strong><a class='ajax' href='contacts.php?ja=".$row['cIndex']."' title='Contacts'>".$row['name'] ."</A></strong></td>";
    	echo "<td>" . $row['lArea'] . ", " . $row['country'] . "</td>";
    	echo "<td>" . $row['gArea'] . "</td>";
		echo "<td align='center'><strong><A href='pros.php?ja=" . $row['cIndex'] . "' class='ajax' title='Company Pros'>" . $row['proCount'] . "</a></strong></td>";
		echo "<td align='center'><strong><A href='cons.php?ja=" . $row['cIndex'] . "' class='ajax' title='Company Cons'>" . $row['conCount'] . "</a></strong></td>";
		
		echo "<td>";
		$i=isResearch($row['cIndex'],$intUserID);
		$k=isResume($row['cIndex'],$intUserID);
		$l=isInterview($row['cIndex'],$intUserID);
		$m=isThankYou($row['cIndex'],$intUserID);
		$n=isFollowUp($row['cIndex'],$intUserID);
		echo "</td><td align='center'>";
		if ($i==0)	{
			echo "<a class='ajax' href='research.php?act=new&ja=" . $row['cIndex'] . "' title='Research'><div align='center' class='toolButton'>Add Research</div></a>";	
		}
		if ($i==1 and $k==0)	{
			echo "<a class='ajax' href='contacts.php?ja=" . $row['cIndex'] . "&nt=1' title='Contact Event'><div align='center' class='toolButton'>Submit Resume</div></a>";	
		}
		if ($i==1 and $k==1 and $l==0)	{
			echo "<a class='ajax' href='contacts.php?ja=" . $row['cIndex'] . "&nt=2' title='Contact Event'><div align='center' class='toolButton'>Add Interview</div></a>";	
		}
		if ($i==1 and $k==1 and $l==1 and $m==0)	{
			echo "<a class='ajax' href='contacts.php?ja=" . $row['cIndex'] . "&nt=3' title='Contact Event'><div align='center' class='toolButton'>Send Thanks</div></a>";	
		}
		if ($i==1 and $k==1 and $l==1 and $m==1 and $n==0)	{
			echo "<a class='ajax' href='contacts.php?ja=" . $row['cIndex'] . "&nt=4' title='Contact Event'><div align='center' class='toolButton'>Follow Up</div></a>";	
		}
		if ($i==1 and $k==1 and $l==1 and $m==1 and $n==1)	{
			echo "<B>Completed!!!</B>";	
		}
		echo "</td><td width='150px' height='25px'>";
		$perc=(($i+$k+$l+$m+$n)/5)*100;
		echo "<script>$(function(){\$('#progressbar" . $ran . "').progressbar({value:" . $perc . "});});</script><div id='progressbar" . $ran . "' style='height:25px:'></div></td>";
		echo "<td style='padding-left:5px; padding-right:7px;' align='right'><a class='inline' href='#compData'><img src='".$mURL."images/edit1.png' height='20px' width='20px' style='cursor:pointer;' onClick=\"editForm('comp_name','edt_comp', '".$row['name']."','".$row['pNotes']."', 'compData', '" . $row['cIndex'] . "');\"></a>";
		echo " <img src='".$mURL."images/delete.png' height='20px' width='20px' style='cursor:pointer;' onClick=\"delForm('comp_name','comp', '" . $row['cIndex'] . "', 1, 0);\">";
		echo "<a class='inline' href='#printPage' onclick=\"printForm('".$row['cIndex']."');\"><img src='".$mURL."images/printer.png' height='20px' width='20px'></a></td>";
		
		echo "</tr>";
	}
?>
</table>
</div>
<?php
	if ($ran==0)	{
?>
	<BR><BR>
	<div align="center" style="width:600px;" id="firstRun">
	<p align='center'><strong>Getting Started</strong></p>
    <p align="left">
    Step 1) <a class="inline" href="#locData">Add a Location</a> you want to work (these will show up when adding a company)<BR>
    Step 2) <a class="inline" href="#growData">Add a Growth Area</a> you are exploring (these will show up when adding a company)<BR> 
    Step 3) <a class="inline" href="#compData">Add a Company</a><BR>
    Step 4) Add a Contact by clicking on the company name<BR>
    Step 5) Follow the 'Next Step' suggestions to getting a job!<BR>
    </p>
    </div>
<?php
	}
?>
<div style='display:none'>
<div id="Locations" align="center">
<div>
	<strong>Locations Manager</strong><BR>
    <BR>
    <a class="inline" href="#locData" onClick="addForm('location_data', 'loct');">Add Location</a>
	<div style="width:350px;" id="locTools" align="center">
    	<?php echo $locationTable; ?>
    </div>
</div>
</div></div>

<div style='display:none'>
<div id="GrowthA" align="center">
<div>
	<div id="growthLink" style="display:block;">
        <strong>Growth Area Manager</strong><BR>
        <BR>
        <a href="#" onClick="addForm('growth_data', 'grow'); toggle('growthTools'); toggle('growthLink'); toggle('growData');">Add Growth Area</a>
    </div>
	<div style="width:350px; display:block;" id="growthTools" align="center">
    	<?php echo $growthTable; ?>
    </div>
    <div id="growData" align="center" style="display:none;">
        <div>
            <form method="post" action="dbhandle.php" id="growth_data">
            <h3>Add/Edit Growth Area</h3>
            <table style="text-align: left;" border="0" cellpadding="2" cellspacing="2">
            <tbody>
                <tr>
                    <td>Growth Area</td>
                    <td><input name="input" type="text"></td>
                </tr>
                <tr>
                    <td align="right">Notes</td>
                    <td><textarea cols="30" rows="5" name="notes"></textarea></td>
                </tr>
                <tr>
                    <td><input name="act" value="add_grow" type="hidden"><input name="profIndex" value="" type="hidden">
                    </td>
                    <td align="center"><input value="Add" type="submit" name="btnAct"> <input value="Done" type="button" name="btnClose" onClick="toggle('growthTools'); toggle('growthLink'); toggle('growData');"></td>
                </tr>
            </tbody>
            </table>
            </form>
        </div>
	</div>
</div>
</div></div>    	


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


</body></html>