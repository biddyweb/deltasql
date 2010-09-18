<html>
<head>
<title>deltasql - Frequently Asked Questions (FAQ)</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("utils/utils.inc.php");
include("utils/constants.inc.php");

?>
<br>
<a href="index.php">Back to Main Menu</a>
<br>
<h2>Frequently Asked Questions (FAQ)</h2>

<h3>General questions</h3>
<ul>
<li><a href="#about">What is deltasql for?</a></li>
<li><a href="#who">Who is behind deltasql?</a></li>
<li><a href="#production">Is deltasql used in productive environments?</a></li>
<li><a href="#license">Under which license is deltasql released?</a></li>
<li><a href="#contribute">How can I contribute?</a></li>
<li><a href="#install">Is it difficult to install?</a></li>
<li><a href="#quick">Is there a Quick Guide?</a></li>
</ul>

<h3>Usage questions</h3>
<ul>
<li><a href="#modules">Why are there projects and modules?</a></li>
<li><a href="#table">Where is the script that I need to launch in my database, so that deltasql can work?</a></li>
<li><a href="#query">Which is the query I need to launch in my database to retrieve the current schema version?</a></li>
<li><a href="#syncscript">How can I create a synchronization script for my database?</a></li>
<li><a href="#client">What is the purpose of the client?</a></li>
<li><a href="#devprod">What is the difference between a production and a development schema?</a></li>
<li><a href="#branch">How can I create a branch?</a></li>
<li><a href="#duplicatebranch">Is it possible to create a branch of a branch?</a></li>
<li><a href="#downgrade">Is it possible to downgrade a database schema to a previous schema?</a></li>
<li><a href="#upgrade">I saw on the webpage that there is a new deltasql version, how do I upgrade?</a></li>
<li><a href="#scripttitle">All scripts are titled "db update". Where can I change this default?</a></li>
<li><a href="#colors">What do the colored rows mean in the 'List scripts' view and on the Google Gadget?</a></li>
<li><a href="#phonehome">What is the phone home functionality of deltasql?</a></li>
<li><a href="#question">I have another question, where to submit it?</a></li>
</ul>


<h2>General questions</h2>

<h3><a name="about"></a>What is deltasql for?</h3>
<p>
deltasql is a tool which is suitable for the "Agile Development" model, where developers often change the data model on the fly.
 deltasql allows to propagate the data model changes to all team members, so that anyone in the development team has a consistent
  database schema that matches the current source code. When the software reaches a stable milestone, deltasql supports the branching
   of the development db schema to a production schema. deltasql is also able to transform a development schema into a production schema 
   and viceversa.
</p>
<p>deltasql is Open Source and licensed under the General Public License, so there aren't any fees or charge for using it.</p>

<h3><a name="who"></a>Who is behind deltasql?</h3>

<p>We are mainly developers in Switzerland, but there are also contributors in India and other countries. We share the passion for Open Source
 and hope Deltasql can spare some time to people who have to manage several database schemas at a time in the same way it helped us. 
 </p>
 <p>
 We hope deltasql can help you in managing your
  database schemas, so that for example you have more time to drink coffee, to think over interesting problems or to go out in the evening :-) ... instead of debugging
   mismatchings between your data model and the source code you deployed to an important customer with more than 400 users at 10 o'clock in the evening!</p>

<h3><a name="production"></a>Is deltasql used in productive environments?</h3>

<p>Yes, it is used in companies in Switzerland and India. In some environments it manages more than 2000 scripts, 10 projects, 12 developers and 15 branches. From Google it
 can be seen that deltasql is popular in Brazil and Japan as well.
</p>
   

<h3><a name="license"></a>Under which license is deltasql released?</h3>
<p>Deltasql is released under the <a href="docs/GPL_license.txt">GNU General Public License</a> meaning that you can use this software
 free of charge in your commercial or Open Source software. However, if you significantly modify deltasql, you must report the changes back
 to the Open source community. 
</p> 

<h3><a name="contribute"></a>How can I contribute?</h3>
<p>
deltasql has a project page on <a href="http://sourceforge.net/projects/deltasql">sourceforge</a>. Feel free to check out the code and experiment with it,
 or to submit bug and feature requests. Any contributions (also from newbies) is welcome :-) Open Source is the best way to learn the
  fascinating world of Computer Science!
</p>


<h3><a name="install"></a>Is deltasql difficult to install?</h3>
<p>
deltasql is based on the LAMP stack (Linux, Apache, mySQL, PHP). It has the same difficulty as to setup a discussion forum on a webpage.
 deltasql has an automatic install page, though it can be installed step-by-step. Everything should be explained in 
 the <a href="manual.php#install-server">manual</a>.
</p>

<h3><a name="quick"></a>Is there a Quick Guide?</h3>
<p>
Yes, there is one in the <a href="manual.php#quickguide">manual</a>.
</p>

<h2>Usage questions</h2>

<h3><a name="modules"></a>Why are there projects and modules?</h3>
<p>
There are both project and modules, and a project contains from one to several modules. Big projects might be splitted in several subprojects, and each subproject (=module) has some particular
 additional functionality that needs to be managed separately. Or in other configurations, companies like to define a module for the utilities common
  to all development done by the company (e.g. tables like TBUSER belong to this module), one module representing the main software itself, and one module
   represented by the customizations on the software done for one particular customer. 
</p>
<p>   
   Adding and removing modules to a project is also done in the
    <a href="list_projects.php">List Projects</a> page.	
</p>
<p>A dedicated section of the manual explains how to setup <a href="manual.php#projectsandmodules">your modules and projects</a>.</p>

<h3><a name="table"></a>Where is the script that I need to launch in my database schema, so that deltasql can work?</h3>
<p>
You can find the script in the <a href="list_projects.php">List Projects</a> page of deltasql, if for the corresponding project you click on the
 <b>Table</b> link. After that you need to choose your database type, and if your database schema will follow HEAD or stay one of the available
  branches. 
</p>
<p>
  deltasql will then generate for you a) the table TBSYNCHRONIZE, b) the first row of this table and c) an additional stored procedure
   to protect your schema from wrong scripts (c is only for some database types).
</p>

<h3><a name="query"></a>Which is the query I need to launch  in my database to retrieve the current schema version?</h3>
<p>
The query is:
</p>
<pre>
select * from TBSYNCHRONIZE where versionnr = (select max(versionnr) from TBSYNCHRONIZE);
</pre>
<p> The most important column is <tt>versionnr</tt> that contains the last version of the executed script.
The interesting columns are <tt>projectname</tt> with the project name and 
<tt>branchname</tt> that contains either <b>HEAD</b> for a development schema, or another name for a production schema.
</p>

<h3><a name="syncscript"></a>How can I create a synchronization script for my database?</h3>
<p>
Initially, you prepare your database schema <a href="#table">with some synchronization tables and data</a>.
</p>
<p>
Each time you want to synchronize, you need to launch first a script which retrieves <a href="#query">the current version of the database schema</a>.
 With this information, you can visit the <a href="dbsync.php">synchronization form of deltasql</a>, fill the form with data retrieved from the query,
  hit the form button and enjoy the SQL synchronization script deltasql will generate for you.
<p>
<p>The generated synchronization script will update your database schema with the scripts the developers submitted and it will also increase the
 current version of the database schema</p>.
<p>Deltasql is even a bit more sophisticated, for example a stored procedure at the beginning of the synchronization step verifies that the script
 is executed on the correct schema. Deltasql can handle database branches, it can transform a developer database into a production database and viceversa.</p>
  

<h3><a name="client"></a>What is the purpose of the client?</h3>
<p>
The purpose of the client is to speed up the upgrade of a database schema. The client normally implements two steps:
 1) the lookup of the current version in a given database schema and 2) issuing the request to deltasql for generating the
  upgrade script. The third step of executing the script in the database schema is left to the user.
</p>
<p>
In the manual, you can find instructions <a href="manual.php#install-clients">how to install</a> the available clients.
 Also there, you find <a href="manual.php#write-client">information</a> on how to write your own client. If you wrote one
  and would like to share it, contact please the <a href="mailto:gpu-world@lists.sourceforge.net">mailing list</a>. Thanks!
</p>

<h3><a name="devprod"></a>What is the difference between a production and a development schema?</h3>
<p>
A development database schema is normally used by developers and contains the latest available scripts. Each day, the developer
 updates it with few scripts. In deltasql, a development database is said to follow HEAD.
</p>
<p> 
 A production database schema on the contrary is deployed to a customer. Updates to this database are less frequent but more bulky, normally done when
 new releases of the software are scheduled. In deltasql, a production database is said to follow a branch.
</p>

<p>When you run the query that retrieves <a href="#query">the current version of the database schema</a>, check the value in the column
 branchname. If it contains HEAD, you know it has to be a development schema. If it contains something else than HEAD, you know it is a production schema.
The value in branchname is the branch the production schema will follow when further synchronization scripts are executed on it.</p>

<h3><a name="branch"></a>How can I create a branch?</h3>
<p>
Branches are defined at the project level. Therefore you should select the row in <a href="list_projects.php">List Projects</a> and click on the
 <b>Branch</b> link. You then give a name and a description to the branch. The description is just a mnemonic to remember in which circumstances
  you created the branch. 
</p>
<p>  
  From now on, you can use the <a href="dbsync.php">Synchronization Form</a> to transform your current HEAD schema into the branch
   schema (also called the production schema). Remember to choose in the Synchronization Form for the field <i>From:</i> the value HEAD, 
and for the field <i>Update To:</i> the new branch you created in deltasql. 
</p>
<p>
After launching the script generated by the Synchronization Form, the database scripts will be only
    the ones explicitely marked also for the branch.
</p>

<h3><a name="duplicatebranch"></a>Is it possible to create a branch of a branch?</h3>
<p>
Yes, it is possible to do this by duplicating a branch. In the page <a href="list_branches.php">List Branches</a> you can click
on the <b>Duplicate</b> button (if you have rights as a Project Manager or as an Administrator). The duplication
  process will create a new branch that starts at the same point as the old branch. All scripts that are tagged
   with the old branch will be tagged also with the new branch. From now on, when submitting a new script, it is possible
    to decide if it belongs to the old, to the new or to both branches.
 </p>
<p>
To upgrade a production schema from the old branch to the new branch, you should run this query in the schema:
</p>
<pre>
/* substitute NEW_BRANCH with the new branch name */
UPDATE TBSYNCHRONIZE SET BRANCHNAME='NEW_BRANCH' WHERE versionnr= (select max(versionnr) from TBSYNCHRONIZE);
</pre> 
<p>After launching this update to the table TBSYNCHRONIZE the schema will follow the new branch and everything will work as expected.</p>


<h3><a name="downgrade"></a>Is it possible to downgrade a database schema to a previous schema?</h3>
<p>
No, unfortunately not, as developers submit scripts like "ALTER TABLE ADD" or "INSERT INTO TB..." and they do not provide an SQL script that
 reverts the change. deltasql has not sufficient artificial intelligence to generate scripts that revert the database to the previous state. If reversal is necessary, 
 developers need to provide the reverting scripts by adding them to deltasql.
</p>

<h3><a name="upgrade"></a>I saw on the webpage that there is a new deltasql version, how do I upgrade?</h3>
<p>
First, read through the <a href="http://www.gpu-grid.net/deltasql/docs/ChangeLog.txt">Changelog</a> to see if there is something interesting, or if some
 bug is fixed.  Then, simply download from the <a href="https://sourceforge.net/project/showfiles.php?group_id=212117&package_id=255379">webpage</a> the latest
  deltasql package and unzip (or untar) it at the same place where you installed it. In the ChangeLog, you will also see if it is necessary to upgrade
   the deltasql schema (it will contain the ALTER TABLE commands you will execute on the deltasql schema). The published package will not overwrite
   your <tt>conf/config.inc.php</tt> file, and everything should still work as expected.
</p>
<p>   If not, please contact the <a href="mailto:gpu-world@lists.sourceforge.net">mailing
    list</a> for further support.
</p>

<h3><a name="scripttitle"></a>All scripts are titled "db update". Where can I change this default?</h3>
<p>
You can change the variable <tt>$default_script_title</tt> in the file <tt>config.inc.php</tt> in the directory <tt>conf</tt>.
</p>


<h3><a name="colors"></a>What do the colored rows mean in the 'List scripts' view and on the Google Gadget?</h3>
<p>
The colored rows just show how old the first submission of a script was. The row is green if the script
 was submitted in the last 20 minutes, yellow if it is less than 5 hours old and blue if it is less than one day old.
</p>

<h3><a name="phonehome"></a>What is the phone home functionality of deltasql?</h3>
<p>
Deltasql collects usage statistics and sends it to the deltasql.org homepage. When you install Deltasql, you are asked
 if you want Deltasql to submit usage statistics: each 100 scripts submitted to the homepage,
 deltasql server contacts deltasql.org and sends row counts of important tables in deltasql. The current deltasql version is
 also sent over the wire. 
</p>
<p>Why is deltasql.org collecting this data? We just would like to get an idea of how many scripts deltasql is managing overall.
 We would like to publish this information on the homepage for advertisment purposes, in the hope that the user basis increases.
 Additionally, some row counts tell us if our users are using advanced functionality like branches or complex project-modules
  structures. The frequency of upgrades to deltasql server can be revealed as well.
</p>
<p>
deltasql.org will not use the collected data to mail advertisement or to harm any deltasql user.
</p>
<p>
 If you still want to disable this functionality, add or modify the row <tt>submit_usage_stats=false;</tt>
 in <tt>conf/config.inc.php</tt>. 
</p>

<h3><a name="question"></a>I have another question, where to submit it?</h3>
<p>
You can submit your question to the <a href="mailto:gpu-world@lists.sourceforge.net">GPU mailing list</a>.
</p>




<a href="index.php">Back to Main Menu</a>

</body>
