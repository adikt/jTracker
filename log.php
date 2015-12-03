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
	
	function convert_event($inEvent)	{
		$query1 = "SELECT event FROM events WHERE events.index=$inEvent;";
		$result1 = mysql_query($query1) or die('Error, query failed' . mysql_error());
		$row1 = mysql_fetch_array($result1);
		return $row1['event'];
	}
	
	function write_events($inSel)	{
		echo "<select name='actions'>";
		$query = "SELECT * FROM events;";
		$result = mysql_query($query) or die('Error, query failed' . mysql_error());
		while($row = mysql_fetch_array($result))
		{
			if ($row['index']==$inSel){$isSelect="SELECTED";}else{$isSelect="";}
			echo "<option value ='" . $row['index'] . "' " . $isSelect . ">" . $row['event'] . "</option>";
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
#addnewevent {
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
			var answer = confirm("Delete Contact Event?")
			if (answer){
				document.forms[fName].elements["profIndex"].value = Ind;
				document.forms[fName].elements["act"].value = "del_"+inDept;
				document.forms[fName].submit();
			}
		}
		
		function editForm(fName, Ind, fTitle, In1, inNotes, inRole)
		{
			document.forms[fName].elements["profIndex"].value = Ind;
			document.forms[fName].elements["act"].value = fTitle;
			document.forms[fName].elements["input"].value = In1;
			var val = inRole;
			var sel = document.forms[fName].elements["actions"];
			var opts = sel.options;
			for(var opt, j = 0; opt = opts[j]; j++) {
				if(opt.value == val) {
					sel.selectedIndex = j;
					break;
				}
			}
			
			if(inNotes!="")
			{
				document.forms[fName].elements["notes"].value = inNotes;
			}
			
			document.forms[fName].elements["btnAct"].value = "Update";
			toggle('contentdv'); 
			toggle('addnewevent'); 
			toggle('linkage');
		}
		
		function clearForm(fName)
		{
			document.forms[fName].elements["input"].value = "";
			document.forms[fName].elements["notes"].value = "";
			document.forms[fName].elements["profIndex"].value = "";
			document.forms[fName].elements["act"].value = "add_evnt";
			document.forms[fName].elements["btnAct"].value = "Add";
		}
		
		$(function() {
			$( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
		});
</script>

</head>

<body>

<h3 style="margin:5px 5px 5px 5px " align="center">
<?php
	$query = "SELECT Contacts.name, Contacts.company FROM Contacts WHERE Contacts.index='".$_GET['ja']."' AND Contacts.user=".$intUserID.";";
	$result = mysql_query($query) or die('Error, query failed' . mysql_error());
	$row = mysql_fetch_array($result);
	echo "<a href='contacts.php?ja=".$row['company']."'>Contacts</a>/". $row['name'] ." - Event Log:";
?>
</h3>

<div id="linkage" style="display:<?php echo $vis2; ?>; width:150px; margin-left:auto; margin-right:auto;" align="center">
   <a href="#" onClick="clearForm('event_data'); toggle('contentdv'); toggle('addnewevent'); toggle('linkage');"><div align="center" class="toolButton"><strong>Add New Event</strong></div></a><BR>
</div>

<div id="addnewevent" style="display:<?php echo $vis1; ?>;" align="center">
	<form method="post" action="dbhandle.php" id="event_data">
    <h4 style="margin:5px 5px 5px 5px;">Add/Edit Contact Event</h4>
    <table style="text-align: left;" border="0" cellpadding="2" cellspacing="2">
    <tbody>
        <tr>
            <td>Date:</td>
            <td><input name="input" id="datepicker" type="text"></td>
        </tr>
        <tr>
            <td>Action:</td>
            <td><?php  write_events($actID);?></td>
        </tr>
        <tr>
            <td>Notes:</td>
            <td><textarea cols="30" rows="5" name="notes" id="notes"></textarea></td>
        </tr>
        <tr>
            <td>
                <input name='act' value='add_evnt' type='hidden'>
        <?php
                echo "<input name='contIndex' value='".$_GET['ja']."' type='hidden'>";
        ?>		<input name="profIndex" value="" type="hidden">
            </td>
        <td align="center"><input value="Add" type="submit" name="btnAct"> <input value="Close" type="button" name="btnClose" onClick="toggle('contentdv'); toggle('addnewevent'); toggle('linkage');"></td>
        </tr>
    </tbody>
    </table>
    </form>
</div>


<div id='contentdv' style="display:<?php echo $vis2; ?>;" align="center">
    <table style="text-align: left;" border="0" cellpadding="2" cellspacing="2" width="600" align="center" class="contentTable">
    <tbody>
        <tr class="tableHeader">
            <td align="left"><strong>Date</strong></td>
            <td align="center"><strong>Action</strong></td>
            <td align="center"><strong>Notes</strong></td>
            <td></td>
        </tr>
<?php
	$query = "SELECT * FROM event_log WHERE event_log.contact='".$_GET['ja']."' AND event_log.user=".$intUserID.";";
	$result = mysql_query($query) or die('Error, query failed' . mysql_error());
	while($row = mysql_fetch_array($result))
	{
		echo "<tr class='tableRow'>";
		echo "<td align='left'>".$row['edate']."</td>";
		echo "<td align='center'>".convert_event($row['action'])."</td>";
		echo "<td>".$row['notes']."</td>";
		echo "<td align='right'><img src='".$mURL."images/edit1.png' height='20px' width='20px' style='cursor:pointer;' alt='Edit' onClick=\"editForm('event_data', '".$row['index']."', 'edt_evnt', '". $row['edate'] ."', '". $row['notes'] ."', '". $row['action'] ."')\">";
		echo "<img src='".$mURL."images/delete.png' height='20px' width='20px' style='cursor:pointer;' alt='Delete' onClick=\"delForm('".$row['index']."', 'event_data', 'evnt')\">";
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
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://monnixsys.com/analytics/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 3]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
    g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="http://monnixsys.com/analytics/piwik.php?idsite=3" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->

</body>
</html>