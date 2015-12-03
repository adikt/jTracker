<?PHP
require_once('lib/connections/db.php');
include('lib/functions/functions.php');

checkLogin('2');

$getuser = getUserRecords($_SESSION['user_id']);
?>
<?php
	include 'variables.php';
	include 'monnix_db.php';
	
	function write_roles()	{
		echo "<select name='role'>";
		$query = "SELECT * FROM cp_roles;";
		$result = mysql_query($query) or die('Error, query failed' . mysql_error());
		while($row = mysql_fetch_array($result))
		{
			echo "<option value ='" . $row['index'] . "'>" . $row['name'] . "</option>";
		}
		echo "</select>";
	}
	
	function convert_role($inRole)	{
		$query1 = "SELECT name FROM cp_roles WHERE cp_roles.index=$inRole;";
		$result1 = mysql_query($query1) or die('Error, query failed' . mysql_error());
		$row1 = mysql_fetch_array($result1);
		return $row1['name'];
	}
?>

<html>
<head>

<script language="JavaScript">
    function toggle(id) {
        var state = document.getElementById(id).style.display;
            if (state == 'block') {
                document.getElementById(id).style.display = 'none';
            } else {
                document.getElementById(id).style.display = 'block';
            }
        }
		
		function delForm(Ind, fName, inDept)
		{
			var answer = confirm("Delete Contact?")
			if (answer){
				document.forms[fName].elements["profIndex"].value = Ind;
				document.forms[fName].elements["act"].value = "del_"+inDept;
				document.forms[fName].submit();
			}
		}
		
		function editForm(fName, Ind, fTitle, In1, InNotes, inPhone, inEmail, inRole)
		{
			
			document.forms[fName].elements["profIndex"].value = Ind;
			document.forms[fName].elements["act"].value = fTitle;
			document.forms[fName].elements["input"].value = In1;
			var val = inRole;
			var sel = document.forms[fName].elements["role"];
			var opts = sel.options;
			for(var opt, j = 0; opt = opts[j]; j++) {
				if(opt.value == val) {
					sel.selectedIndex = j;
					break;
				}
			}
			if(InNotes!="")
			{
				document.forms[fName].elements["notes"].value = InNotes;
			}
			if(inPhone!="")
			{
				document.forms[fName].elements["phone"].value = inPhone;
			}
			if(inEmail!="")
			{
				document.forms[fName].elements["email"].value = inEmail;
			}
			document.forms[fName].elements["btnAct"].value = "Update";
			toggle('contentdv'); 
			toggle('addnewcontact'); 
			toggle('linkage');
		}
		
		function clearForm(fName)
		{
			document.forms[fName].elements["input"].value = "";
			document.forms[fName].elements["phone"].value = "";
			document.forms[fName].elements["email"].value = "";
			document.forms[fName].elements["notes"].value = "";
			document.forms[fName].elements["profIndex"].value = "";
			document.forms[fName].elements["act"].value = "add_cont";
			document.forms[fName].elements["btnAct"].value = "Add";
		}
</script>
<style>
#addnewcontact {
border-radius: 10px;
background-color: white;
border: 3px solid black;
margin-left:auto;
margin-right:auto;
background-color:#DAE5E4;
 width:360px;
}
</style>
<link rel="stylesheet" href="css/companies.css" />
</head>
<body>

<h3 style="margin:5px 5px 5px 5px " align="center">Company Contacts:</h3>
<?php
	$actText="View";
	$actNum="";
	if(strlen($_GET['nt'])>0)	{
		$noteID=$_GET['nt'];
		if ($noteID==1)	{
			$actNum="1";
			$strMessage="Select 'Add' to add <b>Resume Submission</b> event to a contact.<BR>If you used a website, add the website as a contact.";	
		}
		else {
			if ($noteID==2)	{$strDept='Interview';$actNum="2";}
			if ($noteID==3)	{$strDept='Thank You Card';$actNum="3";}
			if ($noteID==4)	{$strDept='Follow-Up';$actNum="4";}
			$strMessage="Select 'Add' to add <b>" . $strDept . "</b> to a contact.";	
		}
		$actText="Add";
		
		echo "<div id='message' align='center' class='message'>";
		echo $strMessage;
		echo "</div><BR>";
	}
?>
<div id="linkage" style="display:block; width:140px; margin-left:auto; margin-right:auto;" align="center">
   <a href="#" onClick="clearForm('contact_data'); toggle('contentdv'); toggle('addnewcontact'); toggle('linkage');"><div align="center" class="toolButton"><strong>Add New Contact</strong></div></a>
</div>
<BR>

<div id="addnewcontact" style="display:none;" align="center">
	<form method="post" action="dbhandle.php" id="contact_data">
    <h4 style="margin:5px 5px 5px 5px;">Add/Edit Contact</h4>
    <table style="text-align: left;" border="0" cellpadding="2" cellspacing="2" class="contentTable">
    <tbody>
        <tr>
            <td>Name:</td>
            <td><input name="input" type="text"></td>
        </tr>
        <tr>
            <td>Role:</td>
            <td><?php  write_roles();?></td>
        </tr>
        <tr>
            <td>Phone:</td>
            <td><input name="phone" type="text"></td>
        </tr>
        <tr>
            <td>E-Mail:</td>
            <td><input name="email" type="text"></td>
        </tr>
        <tr>
            <td>Notes:</td>
            <td><textarea cols="30" rows="5" name="notes" id="notes"></textarea></td>
        </tr>
        <tr>
        <td>
        <input name='act' value='add_cont' type='hidden'>
<?php
        echo "<input name='compIndex' value='".$_GET['ja']."' type='hidden'>";
?>		<input name="profIndex" value="" type="hidden">
        </td>
        <td align="center"><input value="Add" type="submit" name="btnAct"> <input value="Close" type="button" name="btnClose" onClick="toggle('contentdv'); toggle('addnewcontact'); toggle('linkage');"></td>
        </tr>
    </tbody>
    </table>
    </form>
</div>


<div id='contentdv' style="display:block;" align="center">
    <table class="contentTable" border="0" cellpadding="2" cellspacing="2" width="600" align="center">
    <tbody>
        <tr class="tableHeader">
            <td align="left"><strong>Name</strong></td>
            <td align="center"><strong>Role</strong></td>
            <td align="center"><strong>Phone</strong></td>
            <td align="center"><strong>Email</strong></td>
            <td align="center"><strong>Log</strong></td>
            <td></td>
        </tr>
<?php
	$query = "SELECT * FROM Contacts WHERE Contacts.company=".$_GET['ja']." AND Contacts.user=".$getuser[0]['id'].";";
	$result = mysql_query($query) or die('Error, query failed' . mysql_error());
	while($row = mysql_fetch_array($result))
	{
		echo "<tr class='tableHighlight'>";
		echo "<td align='left'><strong>".$row['name']."</strong></td>";
		echo "<td align='center'>".convert_role($row['role'])."</td>";
		echo "<td align='center'>".$row['phone']."</td>";
		echo "<td align='center'>".$row['email']."</td>";
		echo "<td align='center'><a href='log.php?ja=".$row['index']."&act=". $actNum ."'><div align='center' class='toolButton'><strong>". $actText ."</strong></div></a></td>";
		echo "<td align='right'><img src='".$mURL."images/edit1.png' height='20px' width='20px' style='cursor:pointer;' alt='Edit' onClick=\"editForm('contact_data', '".$row['index']."', 'edt_cont', '". $row['name'] ."', '". $row['notes'] ."', '". $row['phone'] ."', '". $row['email'] ."', '". $row['role'] ."')\">";
		echo "<img src='".$mURL."images/delete.png' height='20px' width='20px' style='cursor:pointer;' alt='Delete' onClick=\"delForm('".$row['index']."', 'contact_data', 'cont')\">";
		echo "</td></tr><tr class='tableRow'>";
		echo "<td></td>";
		echo "<td colspan='4'>".$row['notes']."</td></tr>";
	}
?>
</tbody>
</table>
</div>
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