<html>
<head>
<title>deltasql - Synchronization Table</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
 echo "<style type=\"text/css\">";
 include ("deltasql.css");
 echo "</style>";

 include("utils/constants.inc.php");
 $frmdbtype = $_POST['frmdbtype'];
 $frmsourcebranch = $_POST['frmsourcebranch'];
 $projectid=$_POST['frmprojectid'];
 $projectname=$_POST['frmprojectname'];
 $frmschemaname = $_POST['frmschemaname'];

 if ($frmsourcebranch=="") $frmsourcebranch="HEAD";
 echo "<h3>Script to be created in the <b>$frmdbtype</b> database schema for the project <b>$projectname</b></h3>";
?>
<a href="list_projects.php">Back to List Projects</a>
<hr>
<pre>
<?php
if (($frmdbtype=="$db_other") ||  ($frmdbtype=="$db_sybase")) {
  echo "-- you might need to adapt the following script to your database type\n";
  echo "-- the table TBSYNCHRONIZE is mandatory. the stored procedure DELTASQL_VERIFY_SCHEMA is optional.\n\n";
}
if (($frmdbtype=="$db_oracle") || ($frmdbtype=="$db_other") || ($frmdbtype=="$db_sybase"))
echo "
-- DROP TABLE TBSYNCHRONIZE;
CREATE TABLE TBSYNCHRONIZE
(
  PROJECTNAME                 VARCHAR2(64)              NOT NULL,
  UPDATE_DT                   DATE    DEFAULT SYSDATE   NOT NULL,
  UPDATE_USER                 VARCHAR2(64)              NULL,
  UPDATE_TYPE                 VARCHAR2(32)              NULL,
  VERSIONNR                   INTEGER                   NOT NULL,
  BRANCHNAME                  VARCHAR2(128)             NULL,
  DESCRIPTION                 VARCHAR2(128)             NULL,
  UPDATE_FROMVERSION          INTEGER                   NULL,
  UPDATE_FROMSOURCE           VARCHAR2(128)             NULL,
  SCHEMANAME                  VARCHAR2(32)              NULL,
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
echo "
CREATE TABLE `tbsynchronize` (
`projectname` VARCHAR( 64 ) NOT NULL ,
`update_dt` DATE NULL ,
`update_user` VARCHAR( 64 ) NULL ,
`update_type` VARCHAR( 32 ) NULL ,
`versionnr` INT NOT NULL,
`branchname` VARCHAR( 128 ) NULL ,
`description` VARCHAR( 128 ) NULL,
`update_fromversion` INT NULL,
`update_fromsource` VARCHAR( 128 ) NULL,
`schemaname`  VARCHAR( 32 ) NULL ,
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
echo "
-- DROP TABLE tbsynchronize;
CREATE TABLE tbsynchronize
(
  projectname                 varchar(64)                    not null,
  update_dt                   datetime     default getdate()   not null,
  update_user                 varchar(64)              null,
  update_type                 varchar(32)              null,
  versionnr                   integer                  not null,
  branchname                  varchar(128)             null,
  description                 varchar(128)             null,
  update_fromversion          integer                  null,
  update_fromsource           varchar(128)             null,
  schemaname                  varchar(32)              null,
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
echo "
-- DROP TABLE tbsynchronize;
CREATE TABLE tbsynchronize
(
  projectname character varying(64),
  update_dt date,
  update_user character varying(64),
  update_type character varying(32),
  versionnr integer UNIQUE,
  branchname character varying(128),
  description character varying(128),
  update_fromversion integer,
  update_fromsource character varying(128),
  schemaname character varying(32),
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
echo "
CREATE TABLE tbsynchronize
(
  projectname text,
  update_dt text,
  update_user text,
  update_type text,
  versionnr int primary key,
  branchname text,
  description text,
  update_fromversion int,
  update_fromsource text,
  schemaname text,
  dbtype text
);


";



  include("conf/config.inc.php");
  include("utils/utils.inc.php");
  mysql_connect($dbserver, $username, $password);
  @mysql_select_db($database) or die("Unable to select database");
  $versionnr=get_global_version();
  mysql_close();
  echo "INSERT INTO tbsynchronize (PROJECTNAME, VERSIONNR, BRANCHNAME, UPDATE_USER, UPDATE_TYPE, SCHEMANAME, DBTYPE)\n";
  echo "VALUES ('$projectname', $versionnr, '$frmsourcebranch', 'INTERNAL', 'deltasql-server', '$frmschemaname', '$frmdbtype');\n";
  
  if ($frmdbtype=="$db_oracle")
       echo "COMMIT;\n";

?>
</pre>
</body>
</html>
