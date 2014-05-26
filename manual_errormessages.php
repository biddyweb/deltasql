<?php session_start(); ?>
<html>
<head>
<title>Manual - deltasql Error Messages</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<link rel="shortcut icon" href="pictures/favicon.ico" />
</head>
<body>
<?php
include("head.inc.php");
include("utils/constants.inc.php");
echo "<h2>deltasql Error Messages for $deltasql_version</h2>";
?>

<li><a name="1"></a><i>1</i>: <b>The project name was not found (PROJECTNAME)</b></li>
<p>
The project name used in the URL is not valid, it was specified as PROJECTNAME in the parameter <tt>project=</tt>. Instead, it has to be an identifier as specified under
 <a href="list_projects.php">List Projects</a> in the column <tt>name</tt>.
This error can be issued only by deltasql clients, but not by using the synchronization <a href="dbsync.php">form</a>.
</p>

<li><a name="2"></a><i>2</i>: <b>The source branch was not found (BRANCHNAME)</b></li>
<p>
The source branch name used in the URL is not valid, it was specified as BRANCHNAME in the parameter <tt>frombranch=</tt>. Instead, it has to be an identifier as specified under
 <a href="list_branches.php">List Branches</a> in the column <tt>name</tt>.
This error can be issued only by deltasql clients, but not by using the synchronization <a href="dbsync.php">form</a>.
</p>

<li><a name="3"></a><i>3</i>: <b>The target branch was not found (BRANCHNAME)</b></li>
<p>
The target branch name used in the URL is not valid, it was specified as BRANCHNAME in the parameter <tt>tobranch=</tt>. Instead, it has to be an identifier as specified under
 <a href="list_branches.php">List Branches</a> in the column <tt>name</tt>.
This error can be issued only by deltasql clients, but not by using the synchronization <a href="dbsync.php">form</a>.
</p>

<li><a name="5"></a><i>5</i>: <b>The source branch BRANCHNAME does not belong to the project PROJECTNAME</b></li>
<p>
The source BRANCHNAME as specified in the parameter <tt>frombranch=</tt> does not belong to the project specified in the parameter <tt>project=</tt>. Check the dependency
 <a href="list_branches.php">here</a> by using the columns <tt>name</tt> and <tt>project</tt>.
This error can be issued only by deltasql clients, but not by using the synchronization <a href="dbsync.php">form</a>.
</p>

<li><a name="6"></a><i>6</i>: <b>The target branch BRANCHNAME does not belong to the project PROJECTNAME</b></li>
<p>
The target BRANCHNAME as specified in the parameter <tt>frombranch=</tt> does not belong to the project specified in the parameter <tt>project=</tt>. Check the dependency
 <a href="list_branches.php">here</a> by using the columns <tt>name</tt> and <tt>project</tt>.
This error can be issued only by deltasql clients, but not by using the synchronization <a href="dbsync.php">form</a>.
</p>


<li><a name="8"></a><i>8</i>: <b>-- no scripts to be executed (from BRANCH1 [VERSION1] to BRANCH2 [VERSION2])</b></li>
<p>
This is not really an error. Deltasql found that there were no scripts needed to be executed. This message is just an SQL comment to inform that nothing needs to be done.
</p>

<li><a name="9"></a><i>9</i>: <b>Not possible to compute a dbsync update if version number is missing.</b></li>
<p>
Deltasql server does not know the current version number. You probably forgot to specify it in the synchronization <a href="dbsync.php">form</a> or the deltasql client
 did not specify the <tt>version=</tt> parameter.
</p>

<li><a name="10"></a><i>10</i>: <b>Not possible to compute a dbsync update if project name is missing.</b></li>
<p>
Deltasql server does not know the project name. You probably forgot to specify it in the synchronization <a href="dbsync.php">form</a> or the deltasql client
 did not specify the <tt>project=</tt> parameter.
</p>

<li><a name="11"></a><i>11</i>: <b>Project does not contain any modules. Please add at least one module to the project!</b></li>
<p>
For the project you selected, no modules are defined. Please define first a module in <a href="create_module.php">Create module</a> page.
 Add at list one script to this module in the <a href="submit_script.php">Submit script</a> page. 
Then add the newly defined module in <a href="list_projects.php">List Projects</a> page in this way: in the row where this project is listed choose the <b>Add Module</b> button.
Only when you accomplished all these steps you can start synchronizing on this project.
</p>

<li><a name="12"></a><i>12</i>: <b>Version number has to be greater equal zero.</b></li>
<p>
The version number has to be greater equal zero. Negative values are not a valid. Alphanumeric values are not valid as well.
</p>


<li><a name="13"></a><i>13</i>: <b>There is no path between target branch and source branch, please check them.</b></li>
<p>
Deltasql starts from the target branch (the leaf of the tree) and goes back recursively until it hits the source branch. If deltasql
 is not able to find the source branch, it means there is an error in your synchronization request as the two branches are not related to each other.
  Please check your source and target branch before executing the synchronization step.
</p>  
<p>
Additionally, deltasql can only upgrade database schemas, but is not able to go back to previous states to the schema, due to the incremental, not reversible nature of the SQL scripts.
This error could also mean that you mistyped the version number in the synchronization <a href="dbsync.php">form</a>, or that you chose a target branch which was done
 before the current one. 
</p>

<li><a name="15"></a><i>15</i>: <b>The given version number is lower than when the branch was created.</b></li>
<p>
There has to be a mistake in the version number you retrieved from the database schema as it is lower than when the branch was created. Or did you by chance specify the wrong source branch?
</p>

<li><a name="16"></a><i>16</i>: <b>Version number not allowed if synchronizing from a tag</b></li>
<p>
You are not allowed to specify the version number in the synchronization form, as you are synchronizing from a tag. In fact, 
the tag implicitly sets a version number from where to start the synchronization... simply leave the version number blank in 
the synchronization form and try again :-)
</p>

<li><a name="17"></a><i>17</i>: <b>The tag [TAGNAME] does not belong to the project!</b></li>
<p>
The source or target tag you specified does not belong to the project you would like to synchronize. Please check it!
</p>

<li><a name="18"></a><i>18</i>: <b>Database type not specified!</b></li>
<p>
The database type for this project is not specified. Please go to <a href="list_projects.php">List Projects</a>, edit the project and choose a database type.
</p>

<?php include("bottom.inc.php"); ?>
</body>
</html>