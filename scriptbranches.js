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


    function getBranchesCheckListForSubmit(moduleid)
	{
		if (moduleid != "")
		{
			url = "ajax/get_branches_with_module.php?moduleid="+moduleid;
			http.open("GET", url, true);
			http.onreadystatechange = getBranchesResponseCheckList; 
			http.send(null);
        }
	}
    
    function getBranchesCheckListForEdit(moduleid)
	{
		if (moduleid != "")
		{
            scriptid = document.scriptform.scriptid.value;
			url = "ajax/get_branches_with_module_and_script.php?moduleid="+moduleid+'&scriptid='+scriptid;
            //alert(url);
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
            //alert(result);
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
                    var checked = result_arr[1];
					var name = result_arr[2];
                    
                    var checkbox = document.createElement('input');
                    checkbox.type = "checkbox";
                    checkbox.name =  "BRANCH_"+code;
                    checkbox.checked = (checked == 1);
                   
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
	
	function getBranches2ndList(projectid)
	{
		var obj = document.syncform;
		if (projectid != "")
		{
			url = "ajax/get_branches_with_project.php?projectid="+projectid;
			http.open("GET", url, true);
			http.onreadystatechange = getBranchesResponse2ndList; 
			http.send(null);
			
		}
	}
	
	function getBranchesResponse2ndList()
	{
		var obj = document.syncform;
		if (http.readyState == 4)
		{
			var result = trimString(http.responseText);
			if (result != '' && result != 'undefined')
			{
				clearBox(obj.frombranchid);
                clearBox(obj.tobranchid);
				var result_line_arr = result.split("###");
				for (i=0;i<result_line_arr.length;i++)
				{
					var result_arr = result_line_arr[i].split(":");
					var code = result_arr[0];
					var name = result_arr[1];
					obj.frombranchid.options[i] = new Option(name, code);
                    obj.tobranchid.options[i] = new Option(name, code);
				}
			}		
		}
	}
    
    function getBranches3rdList(frombranchid)
	{
        var obj = document.syncform;
		if (frombranchid != "")
		{
            projectid=obj.frmprojectid.value;
            if (projectid!="") {
        	   url = "ajax/get_branches_with_project_and_branch.php?projectid="+projectid+"&frombranchid="+frombranchid;
			   http.open("GET", url, true);
			   http.onreadystatechange = getBranchesResponse3rdList; 
			   http.send(null);
            }
        }
	}
    
    function getBranchesResponse3rdList()
	{
        var obj = document.syncform;
		if (http.readyState == 4)
		{
			var result = trimString(http.responseText);
			if (result != '' && result != 'undefined')
			{
                clearBox(obj.tobranchid);
				var result_line_arr = result.split("###");
				for (i=0;i<result_line_arr.length;i++)
				{
					var result_arr = result_line_arr[i].split(":");
					var code = result_arr[0];
					var name = result_arr[1];
                    obj.tobranchid.options[i] = new Option(name, code);
				}
			}		
		}
	}
	
	function getBranchesForProject(projectid)
	{
		if (projectid != "")
		{
			url = "ajax/get_branches_with_project_notag.php?projectid="+projectid;
			http.open("GET", url, true);
			http.onreadystatechange = getBranchesResponseForProject; 
			http.send(null);
			
		}
	}
	
	function getBranchesResponseForProject()
	{
		var obj = document.gettable;
		if (http.readyState == 4)
		{
			var result = trimString(http.responseText);
			if (result != '' && result != 'undefined')
			{
				clearBox(obj.frmsourcebranch);
                var result_line_arr = result.split("###");
				for (i=0;i<result_line_arr.length;i++)
				{
					var result_arr = result_line_arr[i].split(":");
					var code = result_arr[0];
					var name = result_arr[1];
					obj.frmsourcebranch.options[i] = new Option(name, code);
               	}
			}		
		}
	}
    