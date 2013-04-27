<html>
<head>
<title>deltasql - A software to synchronize Database Schemas</title>
<?php include("meta.inc.php"); ?>
</head>
<body>
<?php include("top.inc.php"); ?>
<?php include("menu.inc.php"); ?>
<center>
<i>"Wonderful job, thank you for writing", Jayson Otis in March 2012 via sourceforge</i>
</center>
<br>
<center>
<img src="docs/devel-no-deltasql.jpg" border="0"><br>
<p><i>Without deltasql:</i> A developer has to send his/her scripts to everyone, 
the exact database state is known only to the database owner.</p><br>
</center>

<h3>Features</h3>
<ul>
<li><img src="deltasql/icons/show.png"> Deltasql server manages SQL scripts which alter database structure 
and contents. 
It  
organizes scripts in modules, which can be grouped in projects. It 
allows to search among them.</li>
<li><img src="deltasql/icons/show2.png"> Database synchronization by adding special synchronization 
table to each schema. Synchronization script generated by deltasql 
server. Handling of branches of branches and tags supported.</li>
<li>Verification step inside synchronization script to ensure 
script is executed on correct schema (available for Oracle and 
PostgreSQL).</li>
<li><img src="deltasql/icons/rights.png"> Several teams of developers can manage several projects and several 
databases.</li>
<li><img src="deltasql/icons/tree.png"> Ability to manage development schemas and production schemas by 
creating branches, branches of branches and tags.</li>
<li>Syncronization scripts can be generated for Oracle, 
postgreSQL, mySQL and 
sqlite. On user request, any SQL-like database can be supported.</li>
<li>Synchronization script can be exported in several formats, including
 pretty printed HTML, text and XML or even a zipped package with each 
script stored in a file.</li>
<li>Free to use, Open Source tool licensed under GPL.</li>
<li>Integration on several platform (Windows XP, Windows 7, Linux) with multipurpose 
deltaclient tool.</li>
<li>Integration in Eclipse IDE with ant client or dbredactor 
client.</li>
<li>Bash client can perform <a 
href="deltasql/faq.php#continouus">continouus database 
integration</a> on Linux.</li>
<li>RSS feed shows latest submitted scripts.</li>
<li>Easy to install, like a webforum, as deltasql server runs on 
Apache/PHP backed by a mySQL database.</li>
<li><img src="deltasql/icons/help.png">There is a <a href="deltasql/manual.php">manual</a>,  a <a 
href="deltasql/faq.php">list of frequently asked questions</a> and a set 
of tutorial movies explaining how it works.</li>
<li>It is used productively by companies in USA, China, Italy, 
Switzerland and India 
and is popular in Japan and South Korea. In some companies it manages 
more than 
2000 scripts and more than 10 projects.</li>
<li>Typically used for large J2EE/Oracle or J2EE/mySQL software architectures which are partially customized to the customer's wishes.</li>
<li>Ability to send email notifications to users who would like to work without deltasql.</li>
<li><a href="deltasql/server_stats.php">Charting</a> features to monitor how deltasql improves over time.</li>
<li>Ability to diff scripts if they were subsequently updated, ability to plot the tree of tags and branches and more...</li>
<li>In short, deltasql is lightweight but powerful, fast and reliable :-)</li>
</ul>

<br>

<center>
<img src="docs/devel-with-deltasql.jpg" border="0"><br>
<p><i>With deltasql:</i> A developer sends the script to the deltasql server only, 
the exact database state is always known and can be synchronized to any state.</p><br>
</center>

<?php include("bottom.inc.php"); ?>
</body>
</html>
