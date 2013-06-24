function SetAllBranches(CheckValue)
{
	var objCheckBoxes = document.scriptform.branchset.elements;
	// set the check value for all check boxes
	for(var i = 0; i < objCheckBoxes.length; i++) {
		var obj = objCheckBoxes[i];
		if (obj.name.indexOf('BRANCH_') >= 0) {
			obj.checked = CheckValue;
		}
	}
}

function RemoveEmptyLines() {
  var text = document.forms['script'].elements['script'].value;
  text = text.replace(/\n\n/g, "\n");
  document.forms['script'].elements['script'].value = text;  
  alarm(text);
}


    function getBranchesCheckList(moduleid)
	{
        var obj = document.scriptform;
		if (moduleid != "")
		{
			url = "ajax/get_branches_with_module.php?moduleid="+moduleid;
			http.open("GET", url, true);
			http.onreadystatechange = getBranchesResponseCheckList; 
			http.send(null);
        }
	}
	
	function getBranchesResponseCheckList()
	{
		if (http.readyState == 4)
		{
			var result = trimString(http.responseText);
			if (result != '' && result != 'undefined')
			{
                var checkboxes = document.scriptform.branchset.getElementsByTagName('input');
                var labels     = document.scriptform.branchset.getElementsByTagName('label');
                
                // removing previous checkboxes
                // we start from the end!!
                length = checkboxes.length;
                while(length--) {
                    var remElm = checkboxes[length];   // element to be removed
                    document.scriptform.branchset.removeChild(remElm);
                    
                    var labElm = labels[length];
                    document.scriptform.branchset.removeChild(labElm);
                }
                
				var result_line_arr = result.split("###");
				for (i=0;i<result_line_arr.length;i++)
				{
					var result_arr = result_line_arr[i].split(":");
					var code = result_arr[0];
					var name = result_arr[1];
					
                    
                    var checkbox = document.createElement('input');
                    checkbox.type = "checkbox";
                    checkbox.name =  "BRANCH_"+code;
                    if (name!="HEAD") {
                        checkbox.checked=false;
                    } else {
                        checkbox.checked=true;
                    }
                    checkbox.id =  "BRANCH_"+code;
                    checkbox.value = 1;
                    
                    var newlabel = document.createElement("label");
                    newlabel.setAttribute("for",i);
                    newlabel.innerHTML = name;
                    
                    document.scriptform.branchset.appendChild(checkbox);
                    document.scriptform.branchset.appendChild(newlabel);
				}
                //alert('Over');    
			}	
                    
		}
	}