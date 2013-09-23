<html>
<head>
<title>deltasql - Frequently Asked Questions (FAQ)</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<link rel="shortcut icon" href="pictures/favicon.ico" />
</head>
<body>
<?php
include("head.inc.php");
include("utils/utils.inc.php");
include("utils/constants.inc.php");
?>
<h2>Frequently Asked Questions (FAQ)</h2>

<h3>General questions</h3>
<ul>
<li><a href="#about">What is deltasql for?</a></li>
<li><a href="#logo">What does the deltasql logo mean?</a></li>
<li><a href="#cool">Why is deltasql so different from other synchronization tools?</a></li>
<li><a href="#production">Is deltasql used in productive environments?</a></li>
<li><a href="#install">Is it difficult to install?</a></li>
<li><a href="#license">Under which license is deltasql released?</a></li>
<li><a href="#milestones">What where the achieved milestones so far?</a></li>
<li><a href="#stable">Which are the most stable versions of deltasql?</a></li>
<li><a href="#quick">Is there a Quick Guide?</a></li>
<li><a href="#test">Where can I try out and experiment with deltasql?</a></li>
<li><a href="#download">Where can I download deltasql?</a></li>
<li><a href="#patch">How can I install a patch for deltasql?</a></li>
<li><a href="#upgrade">There is a new deltasql version, how do I upgrade?</a></li>
<li><a href="#who">Who is behind deltasql?</a></li>
<li><a href="#support">How can I get technical support for deltasql?</a></li>
<li><a href="#contribute">How can I contribute?</a></li>
<li><a href="#checkout">How can I checkout deltasql from the git repository?</a></li>
</ul>

<h3>Questions about synchronization</h3>
<ul>
<li><a href="#algo">How does the synchronization algorithm work?</a></li>
<li><a href="#modules">Why are there projects and modules?</a></li>
<li><a href="#table">Where is the script that I need to launch in my database, so that deltasql can work?</a></li>
<li><a href="#query">Which is the query I need to launch in my database to retrieve the current schema version?</a></li>
<li><a href="#syncscript">How can I create a synchronization script for my database?</a></li>
<li><a href="#client">What is the purpose of the client?</a></li>
<li><a href="#devprod">What is the difference between a production and a development schema?</a></li>
<li><a href="#branch">How can I create a branch and make production schemas?</a></li>
<li><a href="#proddev">How can I transform a production schema back into a development schema?</a></li>
<li><a href="#branchofbranch">Is it possible to create a branch of a branch?</a></li>
<li><a href="#tag">Is it possible to tag a particular release?</a></li>
<li><a href="#downgrade">Is it possible to downgrade a database schema to a previous schema?</a></li>
<li><a href="#verification">What does the "verification step" do?</a></li>
<li><a href="#continouus">Is it possible to perform continouus database integration?</a></li>
<li><a href="#export">In which formats can the synchronization script be exported?</a></li>
</ul>

<h3>Other questions</h3>
<ul>
<li><a href="#undefinedindex">Undefined index or Strict Standards errors everywhere right after installing deltasql server</a></li>
<li><a href="#scripttitle">All scripts are titled "db update". Where can I change this default?</a></li>
<li><a href="#colors">What do the colored rows mean in the 'List scripts' view?</a></li>
<li><a href="#lost">I lost the admin password, what can I do to restore access to deltasql?</a></li>
<li><a href="#slow">deltasql server has more than 2000 scripts and starts to get slow. How can I increase its performance?</a></li>
<li><a href="#email">How can I configure email notification for new scripts?</a></li>
<li><a href="#copypaste">The Copy and Paste functionality does not work in my browser or SQL client!</a></li>
<li><a href="#internet">Is it recommended to run deltasql outside the company's intranet?</a></li>
<li><a href="#question">I have another question, where to submit it?</a></li>
</ul>


<h2>General questions</h2>

<h3><a name="about"></a>What is deltasql for?</h3>
<p>
deltasql is a tool which is suitable for the "Agile Development" model, where developers frequently change the data model.
 deltasql allows to propagate the data model changes to all team members, so that anyone in the development team has a consistent
  database schema that matches the current source code. When the software reaches a stable milestone, deltasql supports the branching
   of the development db schema to a production schema. deltasql is also able to transform a development schema into a production schema 
   and viceversa.
</p>
<p>We hope deltasql can help you in managing your
  database schemas, so that for example you have more time to drink coffee, to think over interesting problems or to go out in the evening :-) ... instead of debugging
   mismatchings between your data model and the source code you deployed to an important customer until late in the night!</p>
</p>

<p>deltasql is Open Source and licensed under the General Public License, so there aren't any fees or charge for using it.</p>

<h3><a name="logo"></a>What does the deltasql logo mean?</h3>

<p>
The triangle represents the greek letter delta, which also means difference in mathematics. The cylinder is a symbol often used in IT charts to represent a database. 
The two symbols together identify a system which is able to handle differences on a database with mathematical precision.
The logo was created in 2007 by <a href="patrizia.php">Patrizia</a>.
</p>

<h3><a name="cool"></a>Why is deltasql so different from other synchronization tools?</h3>

<p>
Unlike commercial tools that compare a source and target database schema and then automatically create a SQL script with the differences, deltasql assumes
 that you are very knowledgeable about SQL and that you are able to script single changes in SQL. For example, if your source code makes a new reference to
  a new column in a particular table, it assumes that you know about the command <tt>alter table x add column y</tt>. If you should not have this ability, 
  then you probably can get most of it if you invest an afternoon of study on a good SQL tutorial.
</p>
<p>
A part of this initial difficulty, deltasql is easy to learn and has plenty to offer. As you will see, you can set it up in minutes on your laptop. You can start it as your
little pet project well hidden on your machine and extend it so far, until it gets a powerful monster installed on the central server of your company,
 with as many tentacles as existing databases. 
</p>
<p>
Dropping a <a href="get_synchronization_table.php">special table</a> on your database schema is enough to put it under version control. If you forget a schema
 for some time because you are doing something else, you will exactly know how many scripts you miss to get it to the latest version. Or if you
  dump the schema and copy it somewhere else, you still keep it under version control, because the synchronization table is copied along with the dump.
When you generate a synchronization script with deltasql for a particular schema, the last statement of the sync script will always be an INSERT statement in the special table, to update the  
 current version number of the schema. So simple.
</p>
<p> 
In the beginning, you will use only one module and one project. But later on, especially if you have a base product which has different customization layers
 for each customer, you will appreciate a setup with <a href="#modules">several modules for one project</a>.
</p>
<p>
If you develop alone, you will maybe create a module disjoint from projects <a href="manual.php#maintenance">to store your collection of scripts</a> which is kind of your spell collection as DBA wizard. 
With the practical diff feature embedded in deltasql, you will see how your scripts change and improve over time. 
</p>
<p>If you have plenty of schemas to manage and fear to execute the synchronization script in the wrong schema, a <a href="#verification">verification</a> stored procedure on top of 
 the script will protect you from any wrongdoing.
<p>
If you develop in team, you will get your development schema synchronized with source code <a href="http://deltasql.sourceforge.net/deltasql/dbsync.php">with four clicks of the mouse</a>.
 If you are even lazier, you will use <a href="http://deltasql.sourceforge.net/deltasql/clients.php">a deltasql client</a> to synchronize your schema with the other developers. 
 If you are old style and do not trust this crazy system, you still will <a href="faq.php#email">receive an email</a> when someone inserts a new script into deltasql server.
</p>
<p>
Your team will be motivated on one side by a <a href="http://deltasql.sourceforge.net/deltasql/server_stats.php">collective statistics</a> where the overall contribution is
 summarized, showing how the server grows in complexity over time. On the other side, competitiveness among developers will spark looking at whom will enter the 
 <a href="http://deltasql.sourceforge.net/deltasql/topten.php">top ten</a>.
</p>
<p>If you like how source code develops and you think at it as a fluid or as a tree which grows with plenty of branches and fruits, you can study the
 <a href="manual.php#insights">synchronization algorithm embedded in deltasql</a>. When you branch in source code, you can also branch on deltasql.
  You can identify the gems on your tree by tagging important product releases. With some manual intervention you can transform a development schema into a production schema or the other way around. 
 Or you can even try to develop <a href="manual.php#write-client">your own client for deltasql server</a> tailored to your needs.</p>

<p>If you are a Linux crack, you can go on implementing <a href="faq.php#continouus">continouus integration for databases</a> with the bash client provided. The entire source
 code is provided, so you can modify the system's behaviour at wish. Overnight, the source code will be checked out and rebuilt; 
 the bash deltasql client will update the reference database schema. Shortly after, the whole battery of unit tests will be launched against the connected database. 
 The entire work will be performed automatically while you are sleeping. 
 In the morning, before the tedious bootstrapping of your local application server, you will know in advance if the latest source code on HEAD expects a missing column in the database :-)</p> 
 
<p>On the other side, deltasql is unfinished and has many gray areas which need improvement and maintenace. Did you find a way to get the verification script working on
 your preferred database type? Did you extend the poor server's side API without breaking backward compatibility? Did you upgrade a client to get it working
  with newer libraries? We would be glad to <a href="http://deltasql.sourceforge.net/develop.php">hear about it</a>. Not only we will publish your work and
   credit you properly, you will also spend less time integrating your features each time you upgrade to a new deltasql release. The whole community will benefit.
    If you contribute, your colleague leaving top down on the other side of the world will contribute as well. Even if deltasql will miss its mission, we will
 have learnt completely new ways to do amazing things :-)
</p>

<p>No matter if you are a busy DBA, a developer with no private life, a stressed manager or a bored open source developer. No matter if you are a beginner or an experienced professional,
deltasql will help you and will overhaul the way your organization thinks about databases!</p>
 
<h3><a name="production"></a>Is deltasql used in productive environments?</h3>

<p>Yes, it is used in companies in Switzerland, India, USA, Italy, and Spain. 
In some environments it manages more than 2000 scripts, 10 projects, 12 developers and 15 branches. From Google it
 can be seen that deltasql is popular in Brazil, Japan and South Korea as well. There are even pages in arabic language about deltasql!
</p>

<h3><a name="install"></a>Is deltasql difficult to install?</h3>
<p>
deltasql is based on the LAMP stack (Linux, Apache, mySQL, PHP). It has the same difficulty as to setup a discussion forum on a webpage.
 deltasql has an automatic install page, though it can be installed step-by-step. Everything should be explained in 
 the <a href="manual.php#install-server">manual</a>.
</p>
<p>As you can see from this movie, <a href="http://sourceforge.net/projects/deltasql/files/tutorials%20%28movies%29/000_deltasql_how_to_install_server_11min.avi/download"><img src="pictures/movie.jpg" border="0"></a> 
you can get deltasql server installed on your own Windows computer or on a Windows server in about 10 minutes and with a low level of difficulty. If you have care
 to use a Linux distribution with the LAMP stack installed and running, the install process is straightforward on Linux, too.</p>

<p>Also productive environments can run with deltasql server on Windows, although for best performance Linux is recommended.
</p>


<h3><a name="license"></a>Under which license is deltasql released?</h3>
<p>Deltasql is released under the <a href="docs/GPL_license.txt">GNU General Public License</a> meaning that you can use this software
 free of charge in your commercial or Open Source software. However, if you significantly modify deltasql, you must report the changes back
 to the Open source community. 
</p> 

<h3><a name="milestones"></a>What where the achieved milestones so far?</h3>

<p>This is a list of achieved milestones:</p>
<ul>
<li>In December 2007, 0.800 is released on sourceforge after six months of saltuary development. It is in beta stage and contains many ideas which will be later developed.</li>
<li>0.850 is the first release effectively used in production. It controlled about 7 schemas of 2 customers with 3 branches each.</li>
<li>In 2008, the 1.0.x series introduces the idea of deltasql clients. It is actively used in production by several users.</li>
<li>In September 2010, the 1.2.x series introduces <a href="#continouus">continouus database integration</a>.</li>
<li>The 1.3.x series developed through 2011 redesigns the synchronization algorithm to support branches of branches and tags. Features and security are enhanced. Several companies use deltasql in their daily business.</li>
<li>In 1.4.x a client targeted at the Windows platform (XP, 7) is delivered and the email notification feature is added. Parameters customize deltasql behaviour depending on user preferences.</li>
<li>The 1.5.x series in 2012 adds charting features to monitor the deltasql server and a handy copy/paste functionality.</li>
<li>The 1.6.x series in 2013 ships with a deltaclient compiled for the linux platform and adds navigation with frames. 1.6.2 ships with dynamic listboxes for the synchronization form and script management. 1.6.3 introduces the toolbox, a collection of tools which assist in SQL script creation.</li>
</ul>

<h3><a name="stable"></a>Which are the most stable versions of deltasql?</h3>

<p>
Stability is also a matter of personal judgment. However, due to the deltasql release process, stable versions are generally the ones with the highest minor number. 
This is because when a new feature is introduced, the major number is increased. Over time the feature gets stabilized in successive releases.
As an example, for the 1.5 line, the stablest version is probably 1.5.5, as no additional release 1.5.6 was published.
Stable releases so far where: 1.6.4, 1.5.5 <a href="faq.php#patch">with patch 4 applied</a>, 1.3.7 (only PHP4 supported) and 1.0.9 (now obsolete).
</p>

<h3><a name="quick"></a>Is there a Quick Guide?</h3>
<p>
Yes, there is one in the <a href="manual.php#quickguide">manual</a>.
</p>

<h3><a name="test"></a>Where can I try out and experiment with deltasql?</h3>
<p>
Deltasql can be tested on <a href="http://deltasql.sourceforge.net/deltasql/">this page</a>. On the login page
 the password for the administrator is provided. Feel free to experiment with this instance of deltasql. From time
  to time, the database is restored to an initial status, so that you can not break anything.
</p>

<h3><a name="download"></a>Where can I download deltasql?</h3>
<p>
Deltasql can be downloaded at sourceforge.net <a href="http://sourceforge.net/projects/deltasql/files/">on this page</a>. Deltasql is available as .zip
 and as .tar.gz package. To unpack the tar package, execute <tt>gunzip deltasql-x.y.z.tar.gz</tt> first, then
  issue <tt>tar -xf deltasql-x.y.z.tar</tt> on your preferred Bash shell.
</p>

<h3><a name="patch"></a>How can I install a patch for deltasql?</h3>
<p>
Along with releases, we publish patches on user request, or as backport from features of the development branch. 
You can recognize if there is a patch for a given release, if there is a zip file named <tt>patch_[patchnumber]_[short patch description].zip</tt> on the deltasql project page where you downloaded a release. Installation is simple: unzip the package and drop the files in the deltasql server 
 folder. You will recognize, that the patch is installed on the main page: the release number receives a dash and the patch number. E.g. a patched deltasql 1.5.5 with patch one will become 1.5.5-1. Patches are incremental: if you install patch seven for a particular release,
  you will automatically install patches from one through six.
</p>

<h3><a name="upgrade"></a>There is a new deltasql version, how do I upgrade?</h3>
<p>
First, read through the <a href="http://deltasql.sourceforge.net/deltasql/docs/ChangeLog.txt">Changelog</a> to see if there is something interesting, or if some
 bug is fixed.  Then, simply download from the <a href="http://sourceforge.net/projects/deltasql/files">webpage</a> the latest
  deltasql package and unzip (or untar) it at the same place where you installed it. The published package will not overwrite
   your <tt>conf/config.inc.php</tt> file, and everything should still work as expected.
</p>
<p>
Occasionally, the schema of deltasql itself changes: to retrieve the script to be applied to the deltasql database schema you can visit this 
<a href="http://deltasql.sourceforge.net/deltasql/dbsync.php">synchronization form</a> and select as project <tt>deltasql-Server</tt>. Select the From: and To: fields as well. As an example, if you upgrade
 from 1.3.0 to 1.3.3, set in From: <tt>TAG_deltasql_1.3.0</tt> and in To: <tt>TAG_deltasql_1.3.3</tt>. Then click on the <b>Generate Script</b> button.
  Now, you'll need to apply the generated script into your deltasql server instance.
</p>
<p>If the synchronization form shouldn't be available (or if you upgrade from a version prior to 1.3.0), you need to read in ChangeLog if it is necessary to upgrade
   the deltasql schema (it will contain the ALTER TABLE commands you will execute on the deltasql schema at each release note).
<p>If run in trouble, please contact the <a href="mailto:gpu-world@lists.sourceforge.net">mailing
    list</a> for further support.
</p>
<p>
If you are upgrading a production instance, take a backup copy and work on the backup, until you are sure everything works as expected!
 Anyway, if you are using deltasql, you should know the business ;-)!
</p>
</p>
<p>
Another way to keep updated with the development is to checkout the git repository of Deltasql and to issue
 from time to time <tt>git pull</tt> to update the repository as described in <a href="faq.php#checkout">this FAQ</a>.
</p>


<h3><a name="who"></a>Who is behind deltasql?</h3>

<p>We are mainly developers in Switzerland, but there are also contributors in India and other countries. We share the passion for Open Source
 and hope Deltasql can spare some time to people who have to manage several database schemas at a time in the same way it helped us. Deltasql should become
  the ultimate database versioning tool by hackers for hackers!
 </p>

<h3><a name="support"></a>How can I get technical support for deltasql?</h3>
<p>
We provide technical support for following activities:
<ul>
<li>Migrate your deltasql server to the latest version (e.g. a migration from versions lower than 1.3 can not be automated)</li>
<li>Develop particular clients and new server functionality</li>
<li>Configure deltasql server for email notification</li>
<li>Consulting services</li>
<li>Training</li>
</ul>
</p>
<p>
Please <a href="mailto:tiziano.mengotti AT gmail.com">send an email</a> to ask for technical support.
</p>



<h3><a name="contribute"></a>How can I contribute?</h3>
<p>
deltasql has a project page on <a href="http://sourceforge.net/projects/deltasql">sourceforge</a>. Feel free to check out the code and experiment with it,
 or to submit bug and feature requests. However, please be aware that the source code as it is now was quickly developed to get something working and needs a careful rewrite in some professional framework. If you extended deltasql 
 in some new way, you are welcome to share your source code with the deltasql community :-)
 </p>


<h3><a name="checkout"></a>How can I checkout deltasql from the git repository?</h3>
<p>
First, you need to install a git client. On Windows, you can use <a href="http://sourceforge.net/projects/gitextensions/">git extensions</a>.
 On Gentoo, run <tt>emerge -av git</tt>. On Ubuntu, run <tt>sudo apt-get install git-core</tt>.
</p>
<p>
The command to checkout the deltasql repository is: <tt>git clone git://git.code.sourceforge.net/p/deltasql/code deltasql-code</tt>.
 To keep the repository updated, run from time to time <tt>git pull</tt> in the directory deltasql-code, which will be created by the checkout process issued by the previous command.
</p>


<h2>Questions about Synchronization</h2>

<h3><a name="algo"></a>How does the synchronization algorithm work?</h3>
<p>
In Deltasql (since version 1.3.0), it is possible to create multiple branches. Branches are made from the original line of development which is represented in Deltasql by
 the special branch named HEAD or can be made from other branches and from branches of branches, too. Each control version system has a particular way to name the original line of development: e.g. Subversion
  calls it 'trunk', git calls it 'master', but Deltasql calls it <b>HEAD</b> after the old but reliable Concurrent Version System (CVS).
</p>
<center>
<img src="pictures/timeline.png" border="0"><br>
<i>Picture: </i>Deltasql timeline with source and target
</center>
<p>Deltasql advances commit revision number (the <b>version number</b>) across all branches.
When creating a new branch, Deltasql remembers at which version number and from which source branch branching occurs. The development tree shown in the picture above
 is stored.</p>
<p>
When the user asks deltasql to generate a synchronization script for a particular database schema, the user provides the version number of the schema and its branch, and gives a target branch which should
 be achieved by the synchronization algorithm (the source circle in the picture). By providing the target branch, the user implicitly provides the target version number as the latest version number available in Deltasql at the moment (the target circle in the picture). 
</p>
<p>Alternatively, the user can provide a target tag, which contains target branch and target version number.</p>
<p>With this information, Deltasql first traverses back the tree of branches, from target (the leaf) to the source (the schema version number and its branch), recording the path in a particular
 table called TBSCRIPTGENERATION.</p>
<p>Deltasql then walks back along the path and for each segment of the tree, it generates a sequence of scripts which belong to that segment of the tree.</p>
<p>The synchronization script is then the collation of the sequences of scripts and follows the path from source to target.</p>
<p>There are <a href="manual.php#insights">more details</a> on the synchronization algorithm in the manual.</p>

<p>This movie <a href="http://sourceforge.net/projects/deltasql/files/tutorials%20%28movies%29/010_deltasql_how_synchronization_works_14min.avi/download"><img src="pictures/movie.jpg" border="0"></a> is an introduction tutorial on how synchronization works.</p>


<h3><a name="modules"></a>Why are there projects and modules?</h3>
<p>
There are both project and modules, and a project contains from one to several modules. Big projects might be splitted in several subprojects, and each subproject (=module) has some particular
 additional functionality that needs to be managed separately. Or in other configurations, companies like to define a module for the utilities common
  to all development done by the company (e.g. tables like TBUSER belong to this module), one module representing the main software itself, and one module
   represented by the customizations on the software done for one particular customer. 
</p>
<p>   
   Adding and removing modules to a project is also done in the
    <a href="http://deltasql.sourceforge.net/deltasql/list_projects.php">List Projects</a> page.	
</p>
<p>A dedicated section of the manual explains how to setup <a href="manual.php#projectsandmodules">your modules and projects</a>.</p>

<h3><a name="table"></a>Where is the script that I need to launch in my database schema, so that deltasql can work?</h3>
<p>
You can find the script in the <a href="http://deltasql.sourceforge.net/deltasql/list_projects.php">List Projects</a> page of deltasql, if for the corresponding project you click on the
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
select * from tbsynchronize where versionnr = (select max(versionnr) from tbsynchronize);
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
 With this information, you can visit the <a href="http://deltasql.sourceforge.net/deltasql/dbsync.php">synchronization form of deltasql</a>, fill the form with data retrieved from the query,
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


<h3><a name="branch"></a>How can I create a branch and make production schemas?</h3>
<p>
Branches are defined at the project level. Therefore you should select the row in <a href="http://deltasql.sourceforge.net/deltasql/list_projects.php">List Projects</a> and click on the
 <b>Branch</b> link. You then give a name and a description to the branch. The description is just a mnemonic to remember in which circumstances
  you created the branch. 
</p>
<p>  
  From now on, you can use the <a href="http://deltasql.sourceforge.net/deltasql/dbsync.php">Synchronization Form</a> to transform your current HEAD schema into the branch
   schema (also called the production schema). Remember to choose in the Synchronization Form for the field <i>From:</i> the value HEAD, 
and for the field <i>Update To:</i> the new branch you created in deltasql. 
</p>
<p>
After launching the script generated by the Synchronization Form, the database scripts will be only
    the ones explicitely marked also for the branch.
</p>

<p>This movie <a href="http://sourceforge.net/projects/deltasql/files/tutorials%20%28movies%29/020_deltasql_branching_and_transforming_schema_to_production_10min.avi/download"><img src="pictures/movie.jpg" border="0"></a> shows how to turn a development schema into a production schema.</p>

<h3><a name="proddev"></a>How can I transform a production schema back into a development schema?</h3>
<p>
 It can be done in the the <a href="http://deltasql.sourceforge.net/deltasql/dbsync.php">Synchronization Form</a> as well. Choose in the Synchronization Form for the field <i>From:</i> the branch name and the version retrieved with 
 <a href="faq.php#query">this query</a>, 
and for the field <i>Update To:</i> simply choose HEAD. Deltasql will generate a synchronization script which will turn the production schema back into a development schema. 
</p>
<p>This is the most advanced feature currently implemented in deltasql. Therefore, it is recommended to review the script manually before executing it on the <i>copy</i> of the production schema.</p>

<p>This movie <a href="http://sourceforge.net/projects/deltasql/files/tutorials%20%28movies%29/030_deltasql_transforming_schema_from_production_back_to_development_8min.avi/download"><img src="pictures/movie.jpg" border="0"></a> shows how to turn a production schema back into a development schema.</p>

<h3><a name="branchofbranch"></a>Is it possible to create a branch of a branch?</h3>
<p>
Yes, it is possible. In the <a href="http://deltasql.sourceforge.net/deltasql/list_branches.php">List Branches</a> page you can click
on the <b>Branch</b> button (if you have rights as a Project Manager or as an Administrator). From now on, when submitting a new script, it is possible
    to decide if it belongs to the old, to the new or to both branches.
 </p>

<h3><a name="tag"></a>Is it possible to tag a particular release?</h3>
<p>
Yes, it is. In <a href="http://deltasql.sourceforge.net/deltasql/list_branches.php">List Branches</a>, there is a <b>Tag</b> action.
</p> 

<h3><a name="downgrade"></a>Is it possible to downgrade a database schema to a previous schema?</h3>
<p>
No, unfortunately not, as developers submit scripts like "ALTER TABLE ADD" or "INSERT INTO TB..." and they do not provide an SQL script that
 reverts the change. deltasql has not sufficient artificial intelligence to generate scripts that revert the database to the previous state. If reversal is necessary, 
 developers need to provide the reverting scripts by adding them to deltasql.
</p>

<h3><a name="verification"></a>What does the "verification step" do?</h3>
<p>
For some database types, deltasql gives the usual TBSYNCHRONIZE table and provides an additional stored procedure called DELTASQL_VERIFY_SCHEMA.
The stored procedure DELTASQL_VERIFY_SCHEMA is called on top of every synchronization script created by Deltasql server. Its purpose is to make sure
 that the synchronization script is executed on the correct schema. 
</p>
<p> 
To verify it, the stored procedure is called with the arguments which are found as last entries in TBSYNCHRONIZATION. 
Therefore the stored procedure verifies that the current schema belongs 
to the correct project, it is at the correct version number and is on 
the correct branch. If there is a mismatch, the stored procedure raises 
an exception which prevents the rest of the synchronization script to be 
executed. This feature therefore protects schemas from synchronization 
scripts which are not meant for them. Imagine to launch a sync script 
with more than 100 SQL statements on the wrong production schema! What a 
nightmare!
</p> 
<p>A call to DELTASQL_VERIFY_SCHEMA depends on the database type, and looks e.g. for Oracle in this way</p>
<pre>
-- this verifies that the present script is executed in the correct schema
CALL DELTASQL_VERIFY_SCHEMA(1, 'HEAD', 'deltasql-Server');
</pre>
<p>
If, for a particular database type, the development team was not able to define such a stored procedure, you will see this comment on top of the
 synchronization script:
</p>
<pre>
-- Please make sure this script is executed on the correct schema!!
</pre>

<p>This movie <a href="http://sourceforge.net/projects/deltasql/files/tutorials%20%28movies%29/070_deltasql_how_verification_step_works_5min.avi/download"><img src="pictures/movie.jpg" border="0"></a> explains how the verification step works.</p>


<h3><a name="continouus"></a>Is it possible to perform continouus database integration?</h3>
<p>
Under continouus integration, a developer normally understands the nightly checkout of the source code followed by
 a rebuild of the whole source code to verify if something is broken. Generally, it is possible to verify in the morning the status
  of the build in some logfiles or even on a website.
</p>
<p>With the deltasql bash client (available at the <a href="http://deltasql.sourceforge.net/deltasql/index.php">main page</a> for download) it is possible
 to improve this process. The deltasql bash client can be configured to upgrade each night a predefined
  database schema, if <tt>continouusintegration.sh</tt> is scheduled as cron job with <tt>crontab -e</tt>.
</p>
<p>Assume you have a huge software application which runs on an application server, backed by a database server:</p>
<p>You could implement the following steps:</p>
<ul>
<li>1. Checkout sourcecode from repository, build the source code as in traditional continouus integration.</li>
<li>2. Launch deltasql bash client and let the database schema be upgraded to the latest version.</li>
<li>3. Launch the software on the application server and verify that the application server is correctly bound
 to the database schema.</li>
</ul> 
<p>By implementing the above steps you achieve complete continouus integration which includes the database schema
 as well. Improving continouus integration in this way allows to detect mismatches between source code and
  data model at an early stage.</p>
  
<p>If you are interested in this feature, you can read <a href="manual.php#install-bash">this entry in the manual</a> on how to install the bash client.</p>  
 
<h3><a name="export"></a>In which formats can the synchronization script be exported?</h3>

<p>
The format can be chosen at the bottom of the <a href="http://deltasql.sourceforge.net/deltasql/dbsync.php">synchronization form</a>. The most used is the <b>HTML</b> one
 which is pretty printed (SQL is highlighted with geshi library). This format is the preferred one to be copyed and pasted into the own database 
browser (like Toad, PL SQL Developer, Microsoft SQL Server Management Studio, etc). 
</p>
<p>
It is possible to create a text version of the synchronization script or
  an XML version for further processing. In this case, you need the View->Page Source functionality of your browser, to see the script in the
  original format.</p>
<p>  
  Additionally, it is possible to export the files as single scripts, so that they can be used
   in <a href="http://www.dbdeploy.com">dbdeploy</a>-like tools. When exporting scripts in this way, deltasql server will first generate the scripts
    into the <tt>output/scripts</tt> directory of the server, then zip it and finally serve the .zip for download.
   The idea of dbdeploy-like tools is to include the single scripts in a directory accessible by the setup executable. The setup executes then the single
   scripts when installing the application.
</p>

<h2>Other questions</h2>


<h3><a name="scripttitle"></a>All scripts are titled "db update". Where can I change this default?</h3>
<p>
You can change the variable <tt>$default_script_title</tt> in the file <tt>config.inc.php</tt> in the directory <tt>conf</tt>.
</p>


<h3><a name="colors"></a>What do the colored rows mean in the 'List scripts' view?</h3>
<p>
The colored rows just show how old the first submission of a script was. The row is green if the script
 was submitted in the last 20 minutes, yellow if it is less than 5 hours old and blue if it is less than one day old.
</p>


<h3><a name="lost"></a>I lost the admin password. What can I do to restore access to deltasql?</h3>
<p>
If you lost the admin password (or if you messed up with the hash salt in TBPARAMETER), you can execute the following
 script into the deltasql database schema:
</p>
<p>
<pre>
UPDATE tbuser SET password='log4admin',encrypted=0,passwhash='' where username='admin';
</pre>
</p>
<p>
You can then login in deltasql with username <b>admin</b> and password <b>log4admin</b>. After that, you should change the password again
 to something more secure.
</p>
<p>
In case you messed up with the salt in TBPARAMETER, you should reset all passwords for the other users as well. A password reset
 can be issued in the <a href="http://deltasql.sourceforge.net/deltasql/list_users.php">List Users</a> page.
</p>


<h3><a name="slow"></a>deltasql server has more than 2000 scripts and starts to get slow. How can I increase its performance?</h3>

<p>If deltasql is slow when inserting new scripts, make sure the feature of sending emails is disabled, by setting <tt>$emails_enable=false</tt> in
 <tt>conf/config.inc.php</tt>.   </p>
 
<p>On the contrary, if deltasql is slow when generating the synchronization script, try to set the variable <tt>$disable_sql_highlighting=true;</tt> in <tt>conf/config.inc.php</tt> so that the SQL highlighting step is skipped.</p>

<h3><a name="email"></a>How can I configure email notification for new scripts?</h3>
<p>
Email notification of new scripts is an important feature of deltasql, so that users can slowly migrate from a development model where they are informed by email,
 to the new deltasql model. It is enough to ask all users to submit new scripts via deltasql server. Users who would like to continue working by managing their database schemas manually,
  can keep checking their inbox for new scripts. More advanced users can start experimenting with the database synchronization feature of deltasql, and their inbox will be free from any SQL script.
</p>

<p>In the next paragraphs, we explain in detail how to prepare deltasql server, so that the email notification feature works.</p>

<p>
First, you need to get sendmail up and running on your system. Linux users should refer to the documentation available on the Internet.
 XAMPP users can check the subfolder <tt>xampp/sendmail</tt> where a sendmail for Windows is available. 
 All users need an account on a SMTP server whose details need to be stored in a configuration file.</p>
 <p>
 Windows users need to edit <tt>sendmail.ini</tt>.
 Linux users need to edit a sendmail configuration file somewhere in the <tt>/etc/</tt> folder structure, after they installed sendmail on their box.
 </p>
 
 <p>
 You should test that sendmail is working as follows: create a text file with this structure first, and save it as <tt>test.txt</tt>:
 </p>
 <pre>
From: test@test.com
To: youremail@test.com
Subject: A test email from sendmail
This is the body
 </pre>
 
 <p>
 Then launch this command in a Linux shell or on the MS-DOS prompt: <tt>sendmail -t &#60; test.txt</tt> and check that you received an email in your inbox.
 </p>
 <p>If sendmail is working, you can proceed to configure the following variables in <tt>conf/config.inc.php</tt>:</p>
<pre>
$emails_enable=true;
$emails_sender="admin@deltasql.org";
$emails_subject_identifier="[deltasql]";
</pre>
 <p>
 The variable <tt>emails_enable</tt> simply tells if notification by email is enabled or not. <tt>emails_sender</tt> defines from whom the email is sent. In most cases you need here to configure
 an existing email address on the SMTP server. If you do not do it, the email might be rejected by the spam filter. The <tt>emails_subject_identifier</tt>
  is a string added in the email's subject to inform everyone that this email is automatically generated by deltasql.
 </p>
 
<p>Linux users need to define the path of sendmail and of deltasql as follows:</p>
<pre>
$sendmail_command="/usr/bin/sendmail -t <";
$deltasql_path="/var/www/deltasql/";
</pre>
<p>XAMPP users under Windows should define instead (double backward slashes are important and not a mistake!):</p>
<pre>
$sendmail_command="C:\\xampp\\sendmail\\sendmail.exe -t <";
$deltasql_path="C:\\xampp\\htdocs\\deltasql\\";
</pre>

<p>Once you defined the variables correctly, you can configure at least one user with a valid email address in the Preferences window. Finally, submit
 a new script to deltasql and check that the email is received correctly :-).</p>

<p>On the contrary, if you do not need this feature, you might want to disable it by setting  <tt>$emails_enable=false;</tt> in the configuration file <tt>conf/config.inc.php</tt>. Following this action, the field to set 
 an email address in the Preferences window will be hidden.</p>
 
<h3><a name="copypaste"></a>The Copy and Paste functionality does not work in my browser or SQL client!</h3>
<p>
Although the functionality is very practical, for some browser (e.g. Internet Explorer) or some text editor (e.g. notepad of Windows) there might be problems with the copy and paste functionality 
introduced with version 1.5.2.
</p>
<p>
If single users would like to disable it, they can disable it on their 'Preferences' page. To disable the functionality also when not logged in, you need to set the variable <tt>$default_copypaste</tt>
 in <tt>conf/config.inc.php</tt> to 0.
</p>
 

<h3><a name="undefinedindex"></a>Undefined index or Strict standard errors everywhere right after installing deltasql server</h3>

<p>
If you get errors similar to the following one right after installing deltasql server:
<br>
<b>
<tt>
Notice: Undefined index: rights in D:\xampplite\htdocs\deltasql\utils\utils.inc.php on line 185
</tt>
</b>
</p>
<p>
or
<br>
<b><tt>Strict Standards: Assigning the return value of new by reference is deprecated...</tt></b>
</p>
<p>
you should modify <tt>php.ini</tt> (in XAMPP for example it is located under C:\xampp\php) and change the variable error_reporting from
<tt>
E_ALL | E_STRICT
</tt>
to<br>
<tt><b>
error_reporting  =  E_ALL & ~E_NOTICE
</tt></b><br>

After that you need to restart the Apache webserver. This will solve the issue.
</p>

<h3><a name="internet"></a>Is it recommended to run deltasql outside the company's intranet?</h3>

<p>deltasql provides some simple mechanisms to authenticate users and store their passwords in a secure manner.
However, we still do not recommend running deltasql on the internet: deltasql is not routinely verified against sql injection attacks, nor provides authentication via https.</p>

<h3><a name="question"></a>I have another question, where to submit it?</h3>
<p>
Please <a href="http://sourceforge.net/projects/deltasql/">visit the forum</a> on the project homepage for bug reports, suggestions and inquiries. We appreciate your feedback! 
Have fun with deltasql :-)
</p>

<?php include("bottom-with-navbar.inc.php"); ?>
</body>
</html>
