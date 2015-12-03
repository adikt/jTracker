<?PHP
require_once('lib/connections/db.php');
include('lib/functions/functions.php');

checkLogin('2');

$getuser = getUserRecords($_SESSION['user_id']);
$intUserID=$getuser[0]['id'];

include 'variables.php';
include 'monnix_db.php';

$hide1="block";
$hide2="none";
$hide3="block";

if ($_GET['act']=="new"){
	$hide1="none";
	$hide2="block";
	$hide3="none";
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script src="jquery/jquery.js"></script>
<script src="jquery/jquery-ui.js"></script>
<script src="java/jtruncate.js"></script>
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
			var answer = confirm("Delete Research Item?")
			if (answer){
				document.forms[fName].elements["profIndex"].value = Ind;
				document.forms[fName].elements["act"].value = "del_"+inDept;
				document.forms[fName].submit();
			}
		}
		
		function editForm(fName, Ind, fTitle, In1, inNotes)
		{
			document.forms[fName].elements["profIndex"].value = Ind;
			document.forms[fName].elements["act"].value = fTitle;
			document.forms[fName].elements["input"].value = In1;
			if(inNotes!="")
			{
				document.forms[fName].elements["notes"].value = inNotes;
			}
			
			document.forms[fName].elements["btnAct"].value = "Update";
			toggle('contentdv'); 
			toggle('addnewresearch'); 
			toggle('linkage');
		}
		
		function clearForm(fName)
		{
			document.forms[fName].elements["input"].value = "";
			document.forms[fName].elements["notes"].value = "";
			document.forms[fName].elements["profIndex"].value = "";
			document.forms[fName].elements["act"].value = "add_rsrc";
			document.forms[fName].elements["btnAct"].value = "Add";
		}
		
		
</script>
<style>
#addnewresearch {
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

<h3 style="margin:5px 5px 5px 5px " align="center">Research:</h3>

<div id="linkage" style="display:<? echo $hide1; ?>; width:150px; margin-left:auto; margin-right:auto;" align="center">
   <a href="#" onClick="clearForm('research_data'); toggle('contentdv'); toggle('addnewresearch'); toggle('linkage');"><div align="center" class="toolButton"><strong>Add New Research</strong></div></a><BR>
</div>

<div id="addnewresearch" style=" display:<? echo $hide2; ?>;" align="center">
	<form method="post" action="dbhandle.php" id="research_data">
    <h4 style="margin:5px 5px 5px 5px;">Add/Edit Research</h4>
    <table style="text-align: left;" border="0" cellpadding="2" cellspacing="2">
    <tbody>
        <tr>
            <td>Keyphrase:</td>
            <td><input name="input" type="text"></td>
        </tr>
        <tr>
            <td >Description:</td>
            <td ><textarea cols="30" rows="5" name="notes" id="notes"></textarea></td>
        </tr>
        <tr>
        <td>
        <input name='act' value='add_rsrc' type='hidden'>
<?php
        echo "<input name='compIndex' value='".$_GET['ja']."' type='hidden'>";
?>		<input name="profIndex" value="" type="hidden">
        </td>
        <td align="center"><input value="Add" type="submit" name="btnAct"> <input value="Close" type="button" name="btnClose" onClick="toggle('contentdv'); toggle('addnewresearch'); toggle('linkage');"></td>
        </tr>
    </tbody>
    </table>
    </form>
</div>


<div id='contentdv' style="display:<? echo $hide3; ?>;" align="center">
    <table style="text-align: left;" border="0" cellpadding="2" cellspacing="2" width="600" align="center">
    <tbody>
        <tr>
        	<td align="left" width="25%"><strong>Keyphrase</strong></td>
            <td align="left"><strong>Description</strong></td>
            <td></td>
        </tr>
<?php
	$query = "SELECT * FROM Research WHERE Research.company='".$_GET['ja']."' AND Research.user=$intUserID;";
	$result = mysql_query($query) or die('Error, query failed' . mysql_error());
	while($row = mysql_fetch_array($result))
	{
		echo "<tr>";
		echo "<td>".$row['phrase']."</td>";
		echo "<td><div class='txtDescription'>".$row['notes']."</div></td>";
		echo "<td><img src='".$mURL."images/edit1.png' height='20px' width='20px' style='cursor:pointer;' onClick=\"editForm('research_data', '".$row['index']."', 'edt_rsrc', '". $row['phrase'] ."', '". $row['notes'] ."');\">";
		echo "<img src='".$mURL."images/delete.png' height='20px' width='20px' style='cursor:pointer;' onClick=\"delForm('".$row['index']."', 'research_data', 'rsrc')\"></td></tr>";
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
<script language="javascript">
	$().ready(function() {  
		  $('.txtDescription').jTruncate({  
			  length: 46,  
			  moreText: "[More]",  
			  lessText: "[Less]",  
		  });  
		}); 
</script>

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