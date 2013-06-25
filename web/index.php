<html>
<head>
<title>deltasql - A software to synchronize Database Schemas</title>
<?php include("meta.inc.php"); ?>
</head>
<body>
<?php include("top.inc.php"); ?>
<?php include("menu.inc.php"); ?>

<p>deltasql is an Open Source tool to keep track of your database 
schemas. It supports several developers working on the same schema.</p>
</p>

<center>
<p>
<i>
"Deltasql is a wonderful software application that fitted the requirement for achieving better database script management in my company. 
It has made life easier for us ever since. It is primarily because of this software that I was able to achieve the task of automating a whole 
lot of processes in my company.", Harikrishnan Nair, Amrita Technologies, via Linkedin in April 2013</i>
</p>
</center>

<center>
<a href="http://sourceforge.net/projects/deltasql/"><img 
src="deltasql/pictures/server-statistics.png" border="0"></a>
<br><i>Picture: deltasql server showing general statistics.</i>
</center>

<h3>How deltasql works</h3>
<p>
A strong version control system for databases saves time to developers, who would like to keep their schema updated while developing with minimal effort. 
With a version control for databases, the number of mistakes dued to different schemas or missing scripts is considerably reduced. Critical errors in production due to schema
 inconsistencies disappear, too.
</p>
<p>
deltasql is an Open Source tool to synchronize databases with source code.
While developing middle size or big applications, developers undertake changes to the data model which go along with changes to the source code. From time
  to time, branches of source code are done to stabilize the code which will go to production. A sort of data model branch is also needed.
</p>
<p>  
deltasql provides a simple set of php scripts to be executed on an apache server backed by a mySQL database to collect all scripts which change the data model, and means to handle 
data model branches. The trick is to number the sql scripts and to create on each database instance a table which keeps the number of the latest executed script 
(the table deltasql uses is named TBSYNCHRONIZE). 
</p>
<p> 
 A <a href="deltasql/dbsync.php">form</a> allows the user to enter data 
from the 
synchronization table and thereafter the needed chain of datamodel updates is computed and shown to the user. The user
 has to manually execute all scripts. It is possible to update development schemas (the HEADs) and production schemas (the branches), to transform a production schema into a development schema and
 vice versa. Also in case of a schema dumped and imported into another database, it is still upgradeable as the synchronization table
 is contained into the copyed schema. However, it is not possible to downgrade a schema back to a previous version. 
</p>
<p> 
 There are <a href="deltasql/index.php">deltasql clients</a>, which automatically collect synchronization data from a given database schema.
 Though deltasql works best with Oracle, PostgreSQL and mySQL schemas, any other database type can use most of deltasql functionality.
</p>


<center>
<p>
<i>
"The open source solution I’ve looked at closely is deltasql. This employs a custom server for mapping changes which runs on Apache, making it cross platform compatible with Windows or Linux. It uses a similar commit and update strategy but pulling the individual scripts from it’s central server instead of SVN. This solution also allows for more databases to be catalogued, including mySQL and postgreSQL and Oracle. Lit integrates into the Eclipse IDE via asset of open source windows so is totally free to use.",  From the article <a href="http://creative-jar.com/insights/labs/programming/database-source-control-map-those-changes/" target="blank_">Database Source Control: Map Those Changes</a> by Tim Hustler</i>
</p>
</center>

<?php include("bottom.inc.php"); ?>
</body>
</html>
