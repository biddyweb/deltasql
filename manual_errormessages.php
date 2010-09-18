<html>
<head>
<title>Manual - deltasql Error Messages</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("utils/constants.inc.php");
echo "<h1>deltasql Error Messages for $deltasql_version</h1>";
?>
<a href="manual.php">Back to manual</a><br><br>


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

<li><a name="4"></a><i>4</i>: <b>There has to be a mistake in TBSYNCHRONIZE as the last version is lower than the source branch (VTABLE smaller than VBRANCH)</b></li>
<p>
The version retrieved in the table TBSYNCHRONIZE is lower than the version when the source branch was created. The source branch is also specified in TBSYNCHRONIZE in the column
 BRANCHNAME. You should compare the version number in TBSYNCHRONIZE with the version number specified for the source branch <a href="list_branches.php">here</a>
 in the column <tt>version number when branch is done</tt>.
This error generally means that you mistyped the version number in the synchronization <a href="dbsync.php">form</a>, or that the URL for the deltasql server specified in your
 client is wrong, or that an entry in TBSYNCHRONIZE was modified by hand in a wrong manner.
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

<li><a name="7"></a><i>7</i>: <b>Cannot downgrade a project! (from BRANCH1 [VERSION1] to BRANCH2 [VERSION2])</b></li>
<p>
deltasql can only upgrade database schemas, but is not able to go back to previous states to the schema, due to the incremental, not reversible nature of the SQL scripts.
This error generally means that you mistyped the version number in the synchronization <a href="dbsync.php">form</a>, or that you chose a target branch which was done
 before the current one.
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



</body>
</html>