function toggle(id) {
        var state = document.getElementById(id).style.display;
            if (state == 'block') {
                document.getElementById(id).style.display = 'none';
            } else {
                document.getElementById(id).style.display = 'block';
            }
        }

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
}

function printForm(cID)
{
	fName="print_page";
	Value=cID;
	eval("SelectObject = document.forms['" + fName + "'].elements['compsel[]']" + ";");
	for(index = 0; index < SelectObject.length; index++) 
	{
		if(SelectObject[index].value == Value)
		SelectObject.selectedIndex = index;
	}	

}
function addForm(fName, fAct)
{
	document.forms[fName].elements["act"].value = "add_"+fAct;
	document.forms[fName].elements["profIndex"].value = "";
	document.forms[fName].elements["input"].value = "";
	document.forms[fName].elements["btnAct"].value = "Add";
	var el = document.forms[fName].notes;
	if (el != null)
	{
		document.forms[fName].notes.value = "";
	}
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

$(document).ready(
	function(){
		$(".ajax").colorbox({iframe:true, innerWidth:650, innerHeight:450, onClosed:function(){ window.location.reload(); }});
		$(".inline").colorbox({inline:true, innerWidth:400, innerHeight:300});
	}
);

$(function() {
	$( "button" )
	.button()
	.click(function( event ) {
	event.preventDefault();
});
});
