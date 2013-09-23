<?php session_start(); ?>
<html>
<head>
<title>deltasql - Synchronization Table</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<link rel="shortcut icon" href="pictures/favicon.ico" />
</head>
<?php
 include("utils/constants.inc.php");
 include("conf/config.inc.php");
 include("utils/copypaste.inc.php");
 include("head.inc.php");
 
 if (!isset($default_copypaste)) $default_copypaste=1;
 printCopyPasteJS($default_copypaste);
 
 echo "<body>";
 echo "<style type=\"text/css\">";
 include ("deltasql.css");
 echo "</style>";

 $projectid=$_POST['frmprojectid'];
 if ($projectid=="") die("<b><font color='red'>Please select a project!</font></b>");
 
 $frmdbtype = $_POST['frmdbtype'];
 $frmsourcebranch = $_POST['frmsourcebranch'];
 mysql_connect($dbserver, $username, $password);
 @mysql_select_db($database) or die("Unable to select database");
 $query="SELECT name FROM tbproject where id=$projectid";
 $result=mysql_query($query);
 $projectname=mysql_result($result,0,"name");
 mysql_close();

 if ($frmsourcebranch=="") $frmsourcebranch="HEAD";
 echo "<h2>Synchronization Table</h2>";
 echo "<p><i>Script to be created in the <b>$frmdbtype</b> database schema for the project <b>$projectname</b></i></p>";
 printCopyPasteLink("Copy to clipboard", 0, $default_copypaste);
?>
<hr>
<pre>
<?php
$intro="";
if (($frmdbtype=="$db_other") ||  ($frmdbtype=="$db_sybase")) {
  $intro = "-- you might need to adapt the following script to your database type\n" .
           "-- the table TBSYNCHRONIZE is mandatory. the stored procedure DELTASQL_VERIFY_SCHEMA is optional.\n\n";
  echo $intro;
}
if (($frmdbtype=="$db_oracle") || ($frmdbtype=="$db_other") || ($frmdbtype=="$db_sybase"))
$script = "
-- DROP TABLE TBSYNCHRONIZE;
CREATE TABLE TBSYNCHRONIZE
(
  PROJECTNAME                 VARCHAR2(64)              NOT NULL,
  UPDATE_DT                   DATE    DEFAULT SYSDATE   NOT NULL,
  UPDATE_USER                 VARCHAR2(64)              NULL,
  UPDATE_TYPE                 VARCHAR2(32)              NULL,
  VERSIONNR                   INTEGER                   NOT NULL,
  BRANCHNAME                  VARCHAR2(128)             NULL,
  TAGNAME                     VARCHAR2(128)             NULL,
  UPDATE_FROMVERSION          INTEGER                   NULL,
  UPDATE_FROMSOURCE           VARCHAR2(128)             NULL,
  DBTYPE                      VARCHAR2(32)              NULL,
  CONSTRAINT   UN_VERSIONNR   UNIQUE (VERSIONNR)
);

-- this stored procedure verifies that scripts are executed in the correct schema
CREATE OR REPLACE PROCEDURE DELTASQL_VERIFY_SCHEMA (versionExt INTEGER, branchnameExt VARCHAR2,projectnameExt VARCHAR2)
AS
 versionV INTEGER;
 branchnameV  VARCHAR2(128); 
 projectnameV  VARCHAR2(64); 
BEGIN
 SELECT versionnr INTO versionV FROM tbsynchronize WHERE versionnr = (SELECT max(versionnr) FROM tbsynchronize);
 SELECT branchname INTO branchnameV FROM tbsynchronize WHERE versionnr = (SELECT max(versionnr) FROM tbsynchronize);
 SELECT projectname INTO projectnameV FROM tbsynchronize WHERE versionnr = (SELECT max(versionnr) FROM tbsynchronize);
 IF (branchnameV <> branchnameExt) OR (versionV <> versionExt) OR (projectnameV <> projectnameExt) then
    raise_application_error(-20001, 'This script is for another schema or it was already executed!!!');
 end IF;
END;
/

"; else
if ($frmdbtype=="$db_mysql")
$script = "
CREATE TABLE `tbsynchronize` (
`projectname` VARCHAR( 64 ) NOT NULL ,
`update_dt` DATE NULL ,
`update_user` VARCHAR( 64 ) NULL ,
`update_type` VARCHAR( 32 ) NULL ,
`versionnr` INT NOT NULL,
`branchname` VARCHAR( 128 ) NULL ,
`tagname` VARCHAR( 128 ) NULL ,
`update_fromversion` INT NULL,
`update_fromsource` VARCHAR( 128 ) NULL,
`dbtype` VARCHAR( 32 ) NULL ,
UNIQUE KEY `versionnr` (`versionnr`)
) ENGINE = MYISAM ;

"; 
/*
This mySQL code does not work
-- to execute in phpMyAdmin, define the delimiter in the SQL window as // in the editbox and remove the DELIMITER statements
DELIMITER //
DROP PROCEDURE IF EXISTS DELTASQL_VERIFY_SCHEMA //
CREATE PROCEDURE DELTASQL_VERIFY_SCHEMA(IN version INT, IN branchname CHAR(64), IN projectname CHAR(64))
up:BEGIN
DECLARE ver INT;
DECLARE bra CHAR(64);
DECLARE pro CHAR(64);

SET ver   =  (SELECT versionnr  FROM tbsynchronize WHERE versionnr = (SELECT max(versionnr) FROM tbsynchronize));
SET bra   =  (SELECT branchname FROM tbsynchronize WHERE versionnr = (SELECT max(versionnr) FROM tbsynchronize));
SET pro   =  (SELECT branchname FROM tbsynchronize WHERE versionnr = (SELECT max(versionnr) FROM tbsynchronize));

IF (ver <> version) or (bra<>branchname) or (pro <> projectname) THEN
    SELECT 'This script is for another schema!!!' AS `FALSE`;
    LEAVE up; 
END IF;
END;
//
DELIMITER ;
*/
else
if ($frmdbtype=="$db_sqlserver")
$script = "
-- DROP TABLE tbsynchronize;
CREATE TABLE tbsynchronize
(
  projectname                 varchar(64)                    not null,
  update_dt                   datetime     default getdate()   not null,
  update_user                 varchar(64)              null,
  update_type                 varchar(32)              null,
  versionnr                   integer                  not null,
  branchname                  varchar(128)             null,
  tagname                     varchar(128)             null,
  update_fromversion          integer                  null,
  update_fromsource           varchar(128)             null,
  dbtype                      varchar(32)              null,
  CONSTRAINT   un_versionnr   UNIQUE (versionnr)
);


-- this function verifies that scripts are executed in the correct schema
CREATE PROCEDURE deltasql_verify_schema
@versionExt int, 
@branchnameExt varchar,
@projectnameExt varchar
AS
DECLARE
 @versionV int,
 @branchnameV  varchar(128), 
 @projectnameV  varchar(64); 

 SELECT @versionV = versionnr FROM tbsynchronize WHERE versionnr = (SELECT max(versionnr) FROM tbsynchronize);
 SELECT @branchnameV = branchname FROM tbsynchronize WHERE versionnr = (SELECT max(versionnr) FROM tbsynchronize);
 SELECT @projectnameV = projectname FROM tbsynchronize WHERE versionnr = (SELECT max(versionnr) FROM tbsynchronize);
 
IF ((@branchnameV <> @branchnameExt) OR (@versionV <> @versionExt) OR (@projectnameV <> @projectnameExt))
begin
   RAISERROR('This script is for another schema or it was already executed!!!', 10, 1);
end

GO


";
else
if ($frmdbtype=="$db_pgsql")
$script = "
-- DROP TABLE tbsynchronize;
CREATE TABLE tbsynchronize
(
  projectname character varying(64),
  update_dt date,
  update_user character varying(64),
  update_type character varying(32),
  versionnr integer UNIQUE,
  branchname character varying(128),
  tagname character varying(128),
  update_fromversion integer,
  update_fromsource character varying(128),
  dbtype character varying(32)
);

-- this function verifies that scripts are executed in the correct schema
CREATE OR REPLACE FUNCTION DELTASQL_VERIFY_SCHEMA (versionExt INTEGER, branchnameExt character varying,projectnameExt character varying)
RETURNS void AS $$
DECLARE
 versionV INTEGER;
 branchnameV  character varying(128); 
 projectnameV  character varying(64); 
BEGIN
 SELECT versionnr INTO versionV FROM tbsynchronize WHERE versionnr = (SELECT max(versionnr) FROM tbsynchronize);
 SELECT branchname INTO branchnameV FROM tbsynchronize WHERE versionnr = (SELECT max(versionnr) FROM tbsynchronize);
 SELECT projectname INTO projectnameV FROM tbsynchronize WHERE versionnr = (SELECT max(versionnr) FROM tbsynchronize);
 IF (branchnameV <> branchnameExt) OR (versionV <> versionExt) OR (projectnameV <> projectnameExt) then
    raise exception 'This script is for another schema or it was already executed!!!';
 end IF;
END;
$$ LANGUAGE plpgsql;

";
else
if ($frmdbtype=="$db_sqlite")
$script = "
CREATE TABLE tbsynchronize
(
  projectname text,
  update_dt text,
  update_user text,
  update_type text,
  versionnr int primary key,
  branchname text,
  tagname text,
  update_fromversion int,
  update_fromsource text,
  dbtype text
);


";

echo $script;

  include("conf/config.inc.php");
  include("utils/utils.inc.php");
  mysql_connect($dbserver, $username, $password);
  @mysql_select_db($database) or die("Unable to select database");
  $versionnr=get_global_version();
  mysql_close();
  $insert = "INSERT INTO tbsynchronize (PROJECTNAME, VERSIONNR, BRANCHNAME, UPDATE_USER, UPDATE_TYPE, DBTYPE)\n" .
            "VALUES ('$projectname', $versionnr, '$frmsourcebranch', 'INTERNAL', 'deltasql-server', '$frmdbtype');\n";
  
  echo "$insert";
  $commit = "";
  if ($frmdbtype=="$db_oracle") {
       $commit = "COMMIT;\n";
	   echo $commit;
  }
?>
</pre>

<?php
include("bottom.inc.php");
// repeating the script for copy&paste purposes
printCopyPasteBlock("$intro\n$script\n$insert\n$commit", $default_copypaste);
?>
</body>
</html>
