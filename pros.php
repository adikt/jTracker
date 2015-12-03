<?PHP
require_once('lib/connections/db.php');
include('lib/functions/functions.php');

checkLogin('2');

$getuser = getUserRecords($_SESSION['user_id']);
$intUserID=$getuser[0]['id'];
?>
<?php
	include 'variables.php';
	include 'monnix_db.php';
	
	function fillResearchList($inResearch, $inSel, $inUser)	{
		echo "<select name='rsrcImport'>";
		echo "<option value ='null'> - </option>";
		$query2 = "SELECT Research.index, Research.phrase FROM Research WHERE Research.company='$inResearch' AND Research.user=$inUser;";
		$result2 = mysql_query($query2) or die('Error, query failed' . mysql_error());
		while($row2 = mysql_fetch_array($result2))
		{
			if ($row2['index']==$inSel){$isSelect="SELECTED";}else{$isSelect="";}
			echo "<option value ='" . $row2['index'] . "' " . $isSelect . ">" . $row2['phrase'] . "</option>";
		}
		echo "</select>";
	}
?>
<?php
	$actID="";
	$vis1="none";
	$vis2="block";
	if(strlen(trim($_GET['act']))>0)	{
		$actID=$_GET['act'];
		$vis1="block";
		$vis2="none";
	}
?>
<html>
<head>
<style>
#addnewpro {
border-radius: 10px;
background-color: white;
border: 3px solid black;
margin-left:auto;
margin-right:auto;
background-color:#DAE5E4;
 width:400px;
}
.protentTable {
border-collapse: collapse;
border-spacing: 0;
text-align: left;
}

</style>
<link rel="stylesheet" href="css/companies.css" />
<link rel="stylesheet" href="jquery/jquery-ui.css">
<script src="jquery/jquery.js"></script>
<script src="jquery/jquery-ui.js"></script>

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
			var answer = confirm("Delete this company Pro?")
			if (answer){
				document.forms[fName].elements["profIndex"].value = Ind;
				document.forms[fName].elements["act"].value = "del_"+inDept;
				document.forms[fName].submit();
			}
		}
		
		function editForm(fName, Ind, fAct, In1, inNotes)
		{
			document.forms[fName].elements["profIndex"].value = Ind;
			document.forms[fName].elements["act"].value = fAct;
			document.forms[fName].elements["input"].value = In1;
						
			if(inNotes!="")
			{
				document.forms[fName].elements["notes"].value = inNotes;
			}
			
			document.forms[fName].elements["btnAct"].value = "Update";
			toggle('contentdv'); 
			toggle('addnewpro'); 
			toggle('linkage');
		}
		
		function clearForm(fName, inIndex)
		{
			document.forms[fName].elements["input"].value = "";
			document.forms[fName].elements["notes"].value = "";
			document.forms[fName].elements["profIndex"].value = inIndex;
			document.forms[fName].elements["act"].value = "add_pros";
			document.forms[fName].elements["btnAct"].value = "Add";
		}
		
</script>

</head>
<body>
<h3 style="margin:5px 5px 5px 5px " align="center">
Company Pros Manager
</h3>

<div id="linkage" style="display:<?php echo $vis2; ?>; width:120px; margin-left:auto; margin-right:auto;" align="center">
   <a href="#" onClick="clearForm('pro_data', <?php echo $_GET['ja']; ?>); toggle('contentdv'); toggle('addnewpro'); toggle('linkage');"><div align="center" class="toolButton"><strong>Add New Pro</strong></div></a><BR>
</div>

<div id="addnewpro" style="display:<?php echo $vis1; ?>;" align="center">
	<div>
	<form method="post" action="dbhandle.php" id="pro_data">
    <h3>Add/Edit Company Pros</h3>
    <table style="text-align: left;" border="0" cellpadding="2" cellspacing="2">
    <tbody>
    	<tr>
            <td>Import Research:</td>
            <td><?php fillResearchList($_GET['ja'], '', $intUserID); ?></td>
        </tr>
        <tr>
            <td align="center" colspan="2"><B>OR:</td>
        </tr>
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
        <td align="center"><input value="Add" type="submit" name="btnAct"> <input value="Close" type="button" name="btnClose" onClick="toggle('contentdv'); toggle('addnewpro'); toggle('linkage');"></td>
        </tr>
    </tbody>
    </table>
    </form>
    </div>
</div>


<div id='contentdv' style="display:<?php echo $vis2; ?>;" align="center">
    <table style="text-align: left;" border="0" cellpadding="2" cellspacing="2" width="600" align="center" class="contentTable">
    <tbody>
        <tr class="tableHeader">
            <td align="left"><strong>Title</strong></td>
            <td align="center"><strong>Notes</strong></td>
            <td></td>
        </tr>
<?php
	$query = "SELECT * FROM Pros WHERE Pros.company='".$_GET['ja']."' AND Pros.user='".$intUserID."';";
	$result = mysql_query($query) or die('Error, query failed' . mysql_error());
	while($row = mysql_fetch_array($result))
	{
		echo "<tr class='tableRow'>";
		echo "<td align='left'>".$row['title']."</td>";
		echo "<td>".$row['notes']."</td>";
		echo "<td align='right'><img src='".$mURL."images/edit1.png' height='20px' width='20px' style='cursor:pointer;' alt='Edit' onClick=\"editForm('pro_data', '".$row['index']."', 'edt_pros', '". $row['title'] ."', '". $row['notes'] ."');\">";
		echo "<img src='".$mURL."images/delete.png' height='20px' width='20px' style='cursor:pointer;' alt='Delete' onClick=\"delForm('".$row['index']."', 'pro_data', 'pros')\">";
		echo "</td></tr>";
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