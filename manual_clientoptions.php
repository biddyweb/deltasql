<html>
<head>
<title>Manual - deltasql client options</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("utils/constants.inc.php");
echo "<h1>deltasql client options for version $deltasql_version</h1>";
?>
<a href="manual.php">Back to manual</a><br><br>

<h2>Client options</h2>

<li><tt>project=</tt> the Project name as retrieved from the colum PROJECTNAME in TBSYNCHRONIZE</li>
<li><tt>version=</tt> the version number as retrieved from the colum VERSIONNR in TBSYNCHRONIZE</li>
<li><tt>frombranch=</tt> the current branch as retrieved from the colum BRANCHNAME in TBSYNCHRONIZE</li>
<li><tt>tobranch=</tt> the target branch that will be reached after applying the synchronization script</li>
<li><tt>user=</tt> the user name that requested the synchronization script</li>
<li><tt>client=</tt> the name of the deltasql client that requests the synchronization script</li>
<li><tt>comment=</tt> an optional comment that will be shown at the top of the script</li>
<li><tt>htmlformatted=</tt> set to 1 to get a pretty printed HTML version of the synchronization script 
(usually it is a text file without any particular formatting)</li>
<li><tt>xmlformatted=</tt> set to 1 to get an XML version of the synchronization script, see below for the schema definition</li>
<li><tt>dbtype=</tt> the type of the database, it should be one of the constants defined in utils/constants.inc.php</li>
<li><tt>schemaname=</tt> an optional name for the current schema, as retrieved from the colum SCHEMANAME in TBSYNCHRONIZE</li>


<h2>XML examples</h2>

<p>deltasql Server answers with two XML types, either an Error message or a synchronization script, if the option <tt>xmlformatted=1</tt>
is set.</p>

<h3><a href="docs/xml-error-example.xml" target=_blank>Error Message</a></h3>

<h3><a href="docs/xml-synchro-example.xml" target=_blank>Synchronization Script</a></h3>
</body>
</html>