<?php
	include 'variables.php';
	include 'monnix_db.php';
	    print_r ($_POST);
	print_r ($_POST['act']."<BR>");
	if(strlen($_POST['act'])>0)	{
		$strFunc1 = "";
		$strTable = "";
		$strAction = "";
		$strDepartment = "";
		switch(substr($_POST['act'], 0, 3)):
		case 'add':
			$strFunc1 = "INSERT INTO ";
			$strAction = "Added new";
		break;
		case 'del':
			$strFunc1 = "DELETE FROM ";
			$strAction = "Removed ";
		break;
		endswitch;
		switch(substr($_POST['act'], strlen($_POST['act'])-4)):
		case 'comp':
			$strInput = trim($_POST['input']);
			$strNotes = trim($_POST['notes']);
			$strTable = "companies (name, notes) VALUES ('$strInput', '$strNotes');";
			$strDepartment = "Company";
		break;
		case 'matr':
			$strInput = trim($_POST['input']);
			$strTable = "Materials (material) VALUES ('$strInput');";
			$strDepartment = "Material";
		break;
		case 'grow':
			$strInput = trim($_POST['input']);
			$strNotes = trim($_POST['notes']);
			$strTable = "Growth (area, notes) VALUES ('$strInput', '$strNotes');";
			$strDepartment = "Growth Area";
		break;
		case 'loct':
			$strInput = trim($_POST['input1']);
			$strNotes = trim($_POST['notes']);
			$strTable = "companies (country, area) VALUES ('$strInput', '$strNotes');";
			$strDepartment = "Location";
		break;
		endswitch;
        $query = $strFunc1 . $strTable;
		echo $query;
		$strAction = $strAction." <strong>".$strDepartment."</strong> '".$strInput."'.";
		mysql_query($query) or die('Error, query failed. ' . mysql_error());
		
	}
	
?>