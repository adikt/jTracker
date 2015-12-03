<?PHP
require_once('lib/connections/db.php');
include('lib/functions/functions.php');

checkLogin('2');

$getuser = getUserRecords($_SESSION['user_id']);

	function contact_company($inCont)	{
		$query1 = "SELECT Contacts.company FROM Contacts WHERE Contacts.index=$inCont;";
		$result1 = mysql_query($query1) or die('Error, query failed' . mysql_error());
		$row1 = mysql_fetch_array($result1);
		return $row1['company'];
	}
?>
<?php
	include 'variables.php';
	include 'monnix_db.php';
	$strAction = "";
	$intUserID = $getuser[0]['id'];
	
	if(strlen($_POST['act'])>0)	{
		$strFunc1 = "";
		$strTable = "";
		
		$strDepartment = "";
		$frmFunc = substr($_POST['act'], 0, 3);
		switch($frmFunc):
		case 'add':
			$strFunc1 = "INSERT INTO ";
			$strAction = "Added new";
		break;
		case 'del':
			$strFunc1 = "DELETE FROM ";
			$strAction = "Removed ";
			$inIndex = trim($_POST['profIndex']);
		break;
		case 'edt':
			$strFunc1 = "UPDATE ";
			$strAction = "Updated ";
			$inIndex = trim($_POST['profIndex']);
		break;
		endswitch;
		
		$strInput = trim($_POST['input']);
		$strRedirect = "";
		
		switch(substr($_POST['act'], strlen($_POST['act'])-4)):
		case 'pros':
			$strNotes = trim($_POST['notes']);
			$inIndex = trim($_POST['profIndex']);
			$query = "SELECT Pros.company FROM Pros WHERE Pros.index='$inIndex' AND Pros.user=$intUserID;";
			if($frmFunc=="edt")
			{
				$result = mysql_query($query) or die('Error, query failed' . mysql_error());
				$row = mysql_fetch_array($result);
					
				$strTable = "Pros SET Pros.title='$strInput', Pros.notes='$strNotes' WHERE Pros.index='$inIndex' AND Pros.user='$intUserID';";
				$inIndex=$row['company'];
			}
			else if($frmFunc=="del")	{
				$result = mysql_query($query) or die('Error, query failed' . mysql_error());
				$row = mysql_fetch_array($result);
				$strTable = "Pros WHERE Pros.index='$inIndex' AND Pros.user='$intUserID';";
				$inIndex=$row['company'];
			}
			else if($frmFunc=="add")	{
				$isImport = trim($_POST['rsrcImport']);
				if ($isImport!='null')	{
					$query = "SELECT Research.phrase, Research.notes FROM Research WHERE Research.index='".$_POST['rsrcImport']."' AND Research.user=$intUserID;";
					$result = mysql_query($query) or die('Error, query failed' . mysql_error());
					$row = mysql_fetch_array($result);
					$strInput=$row['phrase'];
					$strNotes=$row['notes'];
				}
				$strTable = "Pros (Pros.title, Pros.notes, Pros.user, Pros.company) VALUES ('$strInput', '$strNotes', '$intUserID', '$inIndex');";
			}
			
			$strRedirect = "pros.php?ja=".$inIndex;
			$strDepartment = "Company Pros";
		break;
		case 'cons':
			$strNotes = trim($_POST['notes']);
			$inIndex = trim($_POST['profIndex']);
			$query = "SELECT Cons.company FROM Cons WHERE Cons.index='$inIndex' AND Cons.user=$intUserID;";
			if($frmFunc=="edt") {
				$result = mysql_query($query) or die('Error, query failed' . mysql_error());
				$row = mysql_fetch_array($result);
					
				$strTable = "Cons SET Cons.title='$strInput', Cons.notes='$strNotes' WHERE Cons.index='$inIndex' AND Cons.user='$intUserID';";
				$inIndex=$row['company'];
			}
			else if($frmFunc=="del")	{
				$result = mysql_query($query) or die('Error, query failed' . mysql_error());
				$row = mysql_fetch_array($result);
				$strTable = "Cons WHERE Cons.index='$inIndex' AND Cons.user='$intUserID';";
				$inIndex=$row['company'];
			}
			else if($frmFunc=="add")	{
				$isImport = trim($_POST['rsrcImport']);
				if ($isImport!='null')	{
					$query = "SELECT Research.phrase, Research.notes FROM Research WHERE Research.index='".$_POST['rsrcImport']."' AND Research.user=$intUserID;";
					$result = mysql_query($query) or die('Error, query failed' . mysql_error());
					$row = mysql_fetch_array($result);
					$strInput=$row['phrase'];
					$strNotes=$row['notes'];
				}
				$strTable = "Cons (Cons.title, Cons.notes, Cons.user, Cons.company) VALUES ('$strInput', '$strNotes', '$intUserID', '$inIndex');";
			}
			
			$strRedirect = "cons.php?ja=".$inIndex;
			$strDepartment = "Company Cons";
		break;
		case 'evnt':
			$strNotes = trim($_POST['notes']);
			$evCont = trim($_POST['contIndex']);
			$strRedirect = "log.php?ja=".$evCont;
			$intCompany=contact_company($evCont);
			$inAction = trim($_POST['actions']);
			if($frmFunc=="edt")
			{
				$strTable = "event_log SET event_log.edate='$strInput', event_log.notes='$strNotes', event_log.action='$inAction' WHERE event_log.index=$inIndex AND event_log.user='$intUserID';";
			}
			else if($frmFunc=="del")	{
				$strTable = "event_log WHERE event_log.index='$inIndex' AND event_log.user='$intUserID';";
			}
			else if($frmFunc=="add")	{
				$strTable = "event_log (event_log.edate, event_log.notes, event_log.user, event_log.company, event_log.contact, event_log.action) VALUES ('$strInput', '$strNotes', '$intUserID', '$intCompany', '$evCont', '$inAction');";
			}
			$strDepartment = "Research";
		break;
		case 'rsrc':
			$strNotes = trim($_POST['notes']);
			$rsComp = trim($_POST['compIndex']);
			$strRedirect = "research.php?ja=".$rsComp;
			if($frmFunc=="edt")
			{
				$strTable = "Research SET Research.phrase='$strInput', Research.notes='$strNotes' WHERE Research.index=$inIndex AND Research.user='$intUserID';";
			}
			else if($frmFunc=="del")	{
				$strTable = "Research WHERE Research.index='$inIndex' AND Research.user='$intUserID';";
			}
			else if($frmFunc=="add")	{
				$strTable = "Research (Research.phrase, Research.notes, Research.user, Research.company) VALUES ('$strInput', '$strNotes', '$intUserID', $rsComp);";
			}
			$strDepartment = "Research";
		break;
		case 'cont':
			$contRole = trim($_POST['role']);
			$contPhone = trim($_POST['phone']);
			$contEmail = trim($_POST['email']);
			$contComp = trim($_POST['compIndex']);
			$strNotes = trim($_POST['notes']);
			$strRedirect = "contacts.php?ja=".$contComp;
			if($frmFunc=="edt")
			{
				$strTable = "Contacts SET name='$strInput', notes='$strNotes', role=$contRole, email='$contEmail', phone='$contPhone', company='$contComp' WHERE Contacts.index=$inIndex AND Contacts.user='$intUserID';";
			}
			else if($frmFunc=="add")	{
				$strTable = "Contacts (Contacts.name, Contacts.role, Contacts.phone, Contacts.email, Contacts.company, Contacts.notes, Contacts.user) VALUES ('$strInput', '$contRole', '$contPhone', '$contEmail', '$contComp', '$strNotes', '$intUserID');";
			}
			else if($frmFunc=="del")	{
				$query = "DELETE FROM event_log WHERE event_log.contact='$inIndex' AND event_log.user='$intUserID';";
				mysql_query($query) or die('Error, query failed. ' . mysql_error());
				$strTable = "Contacts WHERE Contacts.index='$inIndex' AND Contacts.user='$intUserID';";
			}
			$strDepartment = "Contact";
		break;
		case 'comp':
			$compLoc = trim($_POST['compLoc']);
			$compGrow = trim($_POST['compGrow']);
			$compMat = trim($_POST['compMat']);
			$strNotes = trim($_POST['notes']);
			if($frmFunc=="edt")
			{
				$strTable = "profiles SET profiles.name='$strInput', profiles.notes='$strNotes', profiles.compLocation='$compLoc', profiles.compGrowth='$compGrow' WHERE profiles.index='$inIndex' and profiles.user='$intUserID';";
			}
			else if($frmFunc=="del")	{
				$query = "DELETE FROM event_log WHERE event_log.company='$inIndex' AND event_log.user='$intUserID';";
				mysql_query($query) or die('Error, query failed. ' . mysql_error());
				$query = "DELETE FROM Contacts WHERE Contacts.company='$inIndex' AND Contacts.user='$intUserID';";
				mysql_query($query) or die('Error, query failed. ' . mysql_error());
				$query = "DELETE FROM Research WHERE Research.company='$inIndex' AND Research.user='$intUserID';";
				mysql_query($query) or die('Error, query failed. ' . mysql_error());
				$query = "DELETE FROM Cons WHERE Cons.company='$inIndex' AND Cons.user='$intUserID';";
				mysql_query($query) or die('Error, query failed. ' . mysql_error());
				$query = "DELETE FROM Pros WHERE Pros.company='$inIndex' AND Pros.user='$intUserID';";
				mysql_query($query) or die('Error, query failed. ' . mysql_error());
				$strTable = "profiles WHERE profiles.index='$inIndex' AND profiles.user='$intUserID';";
			}
			else if($frmFunc=="add")	{
				$strTable = "profiles (name, notes, compLocation, compGrowth, profiles.user) VALUES ('$strInput', '$strNotes', '$compLoc', '$compGrow', '$intUserID');";
			}
			$strDepartment = "Company";
		break;
		case 'matr':
			if($frmFunc=="edt")
			{
				$strTable = "Materials SET material='$strInput' WHERE Materials.index='$inIndex' AND Materials.user='$intUserID;";
			}
			else if($frmFunc=="del")	{
				$strTable = "Materials WHERE Materials.index='$inIndex' AND Materials.user='$intUserID';";
			}
			else if($frmFunc=="add")	{
				$strTable = "Materials (material, Materials.user) VALUES ('$strInput', '$intUserID');";
			}
			$strDepartment = "Material";
		break;
		case 'grow':
			$strNotes = trim($_POST['notes']);
			if($frmFunc=="edt")
			{
				$strTable = "Growth SET Growth.area='$strInput', Growth.notes='$strNotes' WHERE Growth.index='$inIndex' AND Growth.user='$intUserID';";
			}
			else if($frmFunc=="del")	{
				$strTable = "Growth WHERE Growth.index='$inIndex' AND Growth.user='$intUserID';";
			}
			else if($frmFunc=="add")	{
				$strTable = "Growth (Growth.area, Growth.notes, Growth.user) VALUES ('$strInput', '$strNotes', '$intUserID');";
			}
			$strDepartment = "Growth Area";
		break;
		case 'loct':
			$strNotes = trim($_POST['notes']);
			if($frmFunc=="edt")
			{
				$strTable = "Locations SET country='$strInput', area='$strNotes' WHERE Locations.index='$inIndex' AND Locations.user='$intUserID';";
			}
			else if($frmFunc=="del")	{
				$strTable = "Locations WHERE Locations.index='$inIndex' AND Locations.user='$intUserID';";
			}
			else if($frmFunc=="add")	{
				$strTable = "Locations (Locations.country, Locations.area, Locations.user) VALUES ('$strInput', '$strNotes', $intUserID);";
			}
			$strDepartment = "Location";
		break;

		endswitch;
        $query = $strFunc1 . $strTable;

		$strAction = $strAction." <strong>".$strDepartment."</strong> '".$strInput."'.";
		mysql_query($query) or die('Error, query failed. ' . mysql_error());
		$streRedirect = 'Location: '.$mURL.$strRedirect;
		header( $streRedirect );
	}
	
?>