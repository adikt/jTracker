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
<link rel="stylesheet" href="jquery/jquery-ui.css">
<script src="jquery/jquery.js"></script>
<script src="jquery/jquery-ui.js"></script>

<script src="java/jquery.colorbox.js"></script>
<script language="javascript">
	function editForm(fName, fAct, inInput, inNotes, divID, Ind)
	{
		document.forms[fName].elements["profIndex"].value = Ind;
		document.forms[fName].elements["act"].value = fAct;
		document.forms[fName].elements["input"].value = inInput;
		if(inNotes!="")
		{
			document.forms[fName].notes.value = inNotes;

		}
		document.forms[fName].elements["btnAct"].value = "Update";
		overlay(divID);
	}
	
	function addForm(fName, fAct, divID)
	{
		document.forms[fName].elements["act"].value = fAct;
		document.forms[fName].elements["profIndex"].value = "";
		document.forms[fName].elements["input"].value = "";
		document.forms[fName].elements["btnAct"].value = "Add";
		var el = document.getElementById("notes");
		if (el != null)
		{
			document.getElementById("notes").value = "";
		}
		overlay(divID);
	}
	
	function delForm(fName, fAct, Ind, delType, isLocked)
	{
		if (isLocked)	{
			alert("Cannot delete a property in use!");
		}
		else	{
			if (delType==1)	{
				var qText = "Delete Company? This will erase ALL Research, Events, Contacts, Pros and Cons associate with this Company!!";
			}
			if (delType==2)	{
				var qText = "Delete this Location?";
			}
			if (delType==3)	{
				var qText = "Delete this Growth Area?";
			}
			var answer = confirm(qText)
			if (answer){
				document.forms[fName].elements["profIndex"].value = Ind;
				document.forms[fName].elements["act"].value = "del_"+fAct;
				document.forms[fName].submit();
			}
		}
	}
	
	function overlay(divID) {
		var el = document.getElementById(divID);
		el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
	}
	
	$(document).ready(
		function(){
			$(".ajax").colorbox({iframe:true, innerWidth:650, innerHeight:450}
		);
	});
	
	$(function() {
		$( "button" )
		.button()
		.click(function( event ) {
		event.preventDefault();
	});
	});
</script>
<link rel="stylesheet" href="colorbox.css" />
<style>
body {
     font: 62.5% "Trebuchet MS", sans-serif;
	 margin: 15px;
	 
}
.fakewindowcontain .ui-widget-overlay {
		position: absolute;
	}
	select {
		width: 200px;
	}
.overlay {
     visibility: hidden;
     position: absolute;
     left: 0px;
     top: 0px;
     width:100%;
     height:100%;
     text-align:center;
     z-index: 1000;
	 background-image:url(images/transpBlue50.png);
}

.overlay div {
     width:350px;
     margin: 100px auto;
     background-color: #fff;
     border:1px solid #000;
     padding:15px;
     text-align:center;
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
#firstRun {
border-radius: 10px;
background-color: white;
border: 3px solid black;
margin-left:auto;
margin-right:auto;
padding:3px 3px 3px 3px;
background-color:#9DD5F8;
}
#contentdv {
	border-radius: 10px;
	background-color: white;
	border: 3px solid black;
	background-color:#DAE5E4;
}
#locTools {
	border-radius: 10px;
	background-color: white;
	border: 3px solid black;
	background-color:#C4D6EC;
}
#growthTools {
	border-radius: 10px;
	background-color: white;
	border: 3px solid black;
	background-color:#C4D6EC;
}
.contentTable {
border-collapse: collapse;
border-spacing: 0;
text-align: left;
}
.tableHeader	{
	border-bottom: 2px solid black;
	font-size:medium;
	font-weight:bold;
}

.tableRow {
border-bottom: 1px solid black;
}

.contentTable tr:last-child td {
border-bottom: 0px solid black;
}
</style>

<title>Job Search Tracker</title>

</head>
<body>
<table style="text-align: left;" border="0" cellpadding="2" cellspacing="2" width="100%">
    <tbody>
        <tr>
        <td align="left"><span style="font-size:larger; font-weight:bolder">Job Search Tracker</span></td>
        <td align="right" width="240px">
			<div align="center" style="border:medium #000000; border-radius:5px; background-color:#B0D5C9; padding:3px 3px 3px 3px;"><a href="index.php">Home</a> | <a href="edit_profile.php">Profile</a> | <a href="help1.jpg" target="_blank">Help</a> | <a href="log_off.php?action=logoff">Log Off</a></div>
		</td>
        </tr>
    </tbody>
</table>
<div align="center">
<?
	echo $strAction;
?>
</div>
<br>
<div align="center">
<button onClick="overlay('compData');">Add New Company!</button>
</div>
<BR>
<div id="matData" class="overlay">
	<div>
	<form method="post" action="dbhandle.php" id="material_data">
    <h3>Add/Edit Material</h3>
    <table style="text-align: left;" border="0" cellpadding="2" cellspacing="2">
    <tbody>
        <tr>
            <td>Material Name:</td>
            <td><input name="input" type="text"></td>
        </tr>
        <tr>
        <td><input name="act" value="add_matr" type="hidden"><input name="profIndex" value="" type="hidden">
        </td>
        <td align="center"><input value="Add" type="submit" name="btnAct"> <input value="Close" type="button" name="btnClose" onClick="addForm('material_data', 'add_matr', 'matData');"></td>
        </tr>
    </tbody>
    </table>
    </form>
    </div>
</div>

<div id="growData" class="overlay">
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
                <td align="center"><input value="Add" type="submit" name="btnAct"> <input value="Close" type="button" name="btnClose" onClick="addForm('growth_data', 'add_grow', 'growData');"></td>
            </tr>
        </tbody>
        </table>
        </form>
    </div>
</div>

<div id="compData" class="overlay">
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
						$growthTable=$growthTable . "<tr class='tableRow'><td>" . $row['area'] . "</td><td>" . $row['notes'] . "</td><td><img src='".$mURL."images/edit1.png' height='20px' width='20px' style='cursor:pointer;' alt='Delete' onClick=\"editForm('growth_data', 'edt_grow', '".$row['area']."', '".$row['notes']."', 'growData', '".$row['index']."')\"><img src='".$mURL."images/delete.png' height='20px' width='20px' style='cursor:pointer;' alt='Delete' onClick=\"delForm('growth_data', 'grow', '".$row['index']."', 3, " . $isLocked . ")\"></td></tr>";
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
						
						
						$locationTable=$locationTable . "<tr class='tableRow'><td>" . $row['country'] . "</td><td>" . $row['area'] . "</td><td><img src='".$mURL."images/edit1.png' height='20px' width='20px' style='cursor:pointer;' alt='Delete' onClick=\"editForm('location_data', 'edt_loct', '".$row['country']."', '".$row['area']."', 'locData', '".$row['index']."')\"><img src='".$mURL."images/delete.png' height='20px' width='20px' style='cursor:pointer;' alt='Delete' onClick=\"delForm('location_data', 'loct', '".$row['index']."', 2, " . $isLocked . ");\"></td></tr>";
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
                <td align="center"><input value="Add" type="submit" name="btnAct"> <input value="Close" type="button" name="btnClose" onClick="addForm('comp_name', 'add_comp', 'compData');"></td>
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
        <td align="center"><input value="Add" type="submit" name="btnAct"> <input value="Close" type="button" name="btnClose" onClick="addForm('pro_data', 'add_pros', 'proData');"></td>
        </tr>
    </tbody>
    </table>
    </form>
    </div>
</div>

<div id="conData" class="overlay">
	<div>
	<form method="post" action="dbhandle.php" id="con_data">
    <h3>Add/Edit Company Cons</h3>
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
        <td><input name="act" value="add_cons" type="hidden"><input name="profIndex" value="" type="hidden">
        </td>
        <td align="center"><input value="Add" type="submit" name="btnAct"> <input value="Close" type="button" name="btnClose" onClick="addForm('con_data', 'add_cons', 'conData');"></td>
        </tr>
    </tbody>
    </table>
    </form>
    </div>
</div>

<div id='contentdv' align="center">
	<table width="100%" border="0" class="contentTable">
  <tr  class='tableHeader'>
    <td align='left'>Rank</td>
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
    <td align="left">
    	<b>Completed</b>
    </td>
    <td align="left">
    	<b>Next Step</b>
    </td>
    <td align="center">
    	<b>Progress</b>
    </td>
    <td align="right" style="padding-left:5px;"></td>
  </tr>
<?
	$ran=0;
	$query = "SELECT profiles.name, profiles.index as cIndex, profiles.notes AS pNotes, Locations.area AS lArea, Locations.Index as lIndex, Locations.country, Growth.area as gArea, Growth.index AS gIndex, Growth.notes AS gNotes FROM profiles LEFT JOIN Locations ON Locations.index=profiles.compLocation LEFT JOIN Growth ON Growth.index=profiles.compGrowth WHERE profiles.user=$intUserID;";
    $result = mysql_query($query) or die('Error, query failed' . mysql_error());
    while($row = mysql_fetch_array($result))
	{
		$ran++;
		$i=0;
		$k=0;
		$l=0;
		echo "<tr class='tableRow'>";
    	echo "<td></td><td>".$row['name'] ." (<a class='ajax' href='contacts.php?ja=".$row['cIndex']."' title='Contacts'>Contacts</A>)</td>";
    	echo "<td>" . $row['lArea'] . ", " . $row['country'] . "</td>";
    	echo "<td>" . $row['gArea'] . "</td>";
		$query2="SELECT COUNT(Cons.index) AS cCount, COUNT(Pros.index) AS pCount FROM Cons, Pros WHERE Cons.company=".$row['cIndex']." OR Pros.company=".$row['cIndex'].";";
		$result2 = mysql_query($query2) or die('Error, query failed' . mysql_error());
		$row2 = mysql_fetch_array($result2);
		echo "<td align='center'><A href='#' onClick=\"editForm('pro_data','edt_pros', '','', 'proData', '".$row['cIndex']."');\">" . $row2['pCount'] . "</a></td>";
		echo "<td align='center'><A href='#' onClick=\"editForm('con_data','edt_cons', '','', 'conData', '".$row['cIndex']."');\">" . $row2['cCount'] . "</a></td>";
		
		echo "<td>";
		$i=isResearch($row['cIndex'],$intUserID);
		$k=isResume($row['cIndex'],$intUserID);
		$l=isInterview($row['cIndex'],$intUserID);
		$m=isThankYou($row['cIndex'],$intUserID);
		$n=isFollowUp($row['cIndex'],$intUserID);
		echo "</td><td>";
		if ($i==0)	{
			echo "<a class='ajax' href='research.php?ja=" . $row['cIndex'] . "' title='Research'>Add Research</a>";	
		}
		if ($i==1 and $k==0)	{
			echo "<a class='ajax' href='contacts.php?ja=" . $row['cIndex'] . "&nt=1' title='Contact Event'>Submit Resume</a>";	
		}
		if ($i==1 and $k==1 and $l==0)	{
			echo "<a class='ajax' href='contacts.php?ja=" . $row['cIndex'] . "&nt=2' title='Contact Event'>Add Interview</a>";	
		}
		if ($i==1 and $k==1 and $l==1 and $m==0)	{
			echo "<a class='ajax' href='contacts.php?ja=" . $row['cIndex'] . "&nt=3' title='Contact Event'>Send Thanks</a>";	
		}
		if ($i==1 and $k==1 and $l==1 and $m==1 and $n==0)	{
			echo "<a class='ajax' href='contacts.php?ja=" . $row['cIndex'] . "&nt=4' title='Contact Event'>Follow Up</a>";	
		}
		echo "</td><td width='150px' height='25px'>";
		$perc=(($i+$k+$l+$m+$n)/5)*100;
		echo "<script>$(function(){\$('#progressbar" . $ran . "').progressbar({value:" . $perc . "});});</script><div id='progressbar" . $ran . "' style='height:25px:'></div></td>";
		echo "<td style='padding-left:5px;'><img src='".$mURL."images/edit1.png' height='20px' width='20px' style='cursor:pointer;' onClick=\"editForm('comp_name','edt_comp', '".$row['name']."','".$row['pNotes']."', 'compData', '" . $row['cIndex'] . "');\">";
		echo " <img src='".$mURL."images/delete.png' height='20px' width='20px' style='cursor:pointer;' onClick=\"delForm('comp_name','comp', '" . $row['cIndex'] . "', 1, 0);\"></td>";
		
		echo "</tr>";
	}
?>
</table>
</div>
<?php
	if ($ran==0)	{
?>
	<BR><BR>
	<div align="center" style="width:500px;" id="firstRun">
	<p align='center'><strong>Getting Started</strong></p>
    <p align="left">
    1) <a href="#" onClick="overlay('locData');">Add a Location</a> you want to work (these will show up when adding a company)<BR>
    2) <a href="#" onClick="overlay('growData');">Add a Growth Area</a> you are exploring (these will show up when adding a company)<BR> 
    3) <a href="#" onClick="overlay('compData');">Add a CompanyProfile</a><BR>
    4) Follow the 'Next Step' suggestions to getting a job!<BR>
<BR>
    Help is in the top right corner :)
    </p>
    </div>
<?php
	} else	{
?>
	<BR><BR>
    <table width="80%" style="margin-left:auto; margin-right:auto;" border="0">
	<tr valign="top"><td align="center" >
	<div style="width:300px;" id="locTools" align="center">
		<strong>Locations Manager</strong><BR><BR>
        <a href="#" onClick="overlay('locData');">Add Location</a>
        <HR>
    	<?php echo $locationTable; ?>
    </div>
    </td><td align="center">
	<div style="width:300px;" id="growthTools" align="center">
		<strong>Growth Area Manager</strong><BR><BR>
        <a href="#" onClick="overlay('growData');">Add Growth Area</a>
        <HR>
    	<?php echo $growthTable; ?>
    </div>
    </td></tr>
    </table>
<?php
	}
?>

<div id="locData" class="overlay">
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
            <td>Area:</td>
            <td><input name="notes" type="text"></td>
        </tr>
        <tr>
        <td><input name="act" value="add_loct" type="hidden"><input name="profIndex" value="" type="hidden">
        </td>
        <td align="center"><input value="Add" type="submit" name="btnAct"> <input value="Close" type="button" name="btnClose" onClick="addForm('location_data', 'add_loct', 'locData');"></td>
        </tr>
    </tbody>
    </table>
    </form>
    </div>
</div>
</body></html>