
UPDATE tbbranch SET versionnr=24 WHERE name='HEAD';
INSERT INTO tbbranch VALUES (2, 'BRANCH_1',1, '', 7, '2008-05-02', 0,'HEAD',0,1);
INSERT INTO tbbranch VALUES (3, 'BRANCH_2',1, '', 7, '2008-05-02', 0,'HEAD',0,1);
INSERT INTO tbbranch VALUES (4, 'DELTA_1',2, '', 13, '2008-05-21', 1,'HEAD',0,1);
INSERT INTO tbbranch VALUES (5, 'DELTA_2',2, 'second branch after script 6', 17, '2008-05-21', 1,'HEAD',0,1);

-- 
-- Dumping data for table 'tbmodule'
-- 

INSERT INTO tbmodule VALUES (1, 'mycompany-common', 'These are tables used in all projects of MyCompany. Typically tables like TBUSER, TBROLE, TBGROUPS are mantained in this module. This module belongs to the project MyProject.', '2008-04-07', 2, 0);
INSERT INTO tbmodule VALUES (2, 'myapplication', 'This is the application layer which contains all tables and packages which are customer independent. It is based on the mycompany-common layer.', '2008-05-02', 9, 0);
INSERT INTO tbmodule VALUES (3, 'mycustomer', 'These are the customized tables used only for the particular customer MyCustomer. They lay on top of the tables defined in mycompany-common and myapplication database modules', '2008-04-07', 4, 0);
INSERT INTO tbmodule VALUES (4, 'myapplication-maintenance', 'Here, a collection of scripts is maintaned, which is used for occasional database maintenance, but not for synchronizing the database schemas.', '2008-04-07', 6, 0);
INSERT INTO tbmodule VALUES (5, 'deltasql-test-module', '', '2008-05-21', 24, 0);

-- 
-- Dumping data for table 'tbmoduleproject'
-- 

INSERT INTO tbmoduleproject VALUES (1, 1, 1);
INSERT INTO tbmoduleproject VALUES (2, 2, 1);
INSERT INTO tbmoduleproject VALUES (3, 3, 1);
INSERT INTO tbmoduleproject VALUES (4, 5, 2);

-- 
-- Dumping data for table 'tbparameter'
-- 

UPDATE tbparameter SET paramvalue='24' WHERE paramname='VERSION' and paramtype='GLOBAL';

-- 
-- Dumping data for table 'tbproject'
-- 

INSERT INTO tbproject VALUES (1, 'myproject', 'This project is about delivering the application MyApplication to the customer MyCustomer. It contains three database modules: mycompany-common, myapplication and mycustomer. These are the modules on which the database schemas will be upgraded. The module myapplication-maintenance instead, contains only scripts which are used for occasional database maintenance.', '2008-04-07');
INSERT INTO tbproject VALUES (2, 'deltasql-test-project', '', '2008-05-21');

-- 
-- Dumping data for table 'tbscript'
-- 

INSERT INTO tbscript (id, code, module_id, versionnr, user_id, update_dt, update_user, comments, title, isapackage, isaview) VALUES (3, 'test', 2, 9, 1, '2008-05-02', '', '', 'db update', 0, 1);
INSERT INTO tbscript (id, code, module_id, versionnr, user_id, update_dt, update_user, comments, title, isapackage, isaview) VALUES (4, '-- 1 script only for HEAD', 5, 12, 1, '2008-05-21', '', '', 'db update', 0, 0);
INSERT INTO tbscript (id, code, module_id, versionnr, user_id, update_dt, update_user, comments, title, isapackage, isaview) VALUES (5, '-- 2 script only for HEAD', 5, 13, 1, '2008-05-21', '', '', 'db update', 0, 0);
INSERT INTO tbscript (id, code, module_id, versionnr, user_id, update_dt, update_user, comments, title, isapackage, isaview) VALUES (6, '-- 3 script only for HEAD', 5, 14, 1, '2008-05-21', '', '', 'db update', 0, 0);
INSERT INTO tbscript (id, code, module_id, versionnr, user_id, update_dt, update_user, comments, title, isapackage, isaview) VALUES (7, '-- 4 script for both HEAD and DELTA_1', 5, 15, 1, '2008-05-21', '', '', 'db update', 0, 0);
INSERT INTO tbscript (id, code, module_id, versionnr, user_id, update_dt, update_user, comments, title, isapackage, isaview) VALUES (8, '-- 5 script only for DELTA_1', 5, 16, 1, '2008-05-21', '', '', 'db update', 0, 0);
INSERT INTO tbscript (id, code, module_id, versionnr, user_id, update_dt, update_user, comments, title, isapackage, isaview) VALUES (9, '-- 6 script only for HEAD before branch DELTA_2 comes', 5, 17, 1, '2008-05-21', '', '', 'db update', 0, 0);
INSERT INTO tbscript (id, code, module_id, versionnr, user_id, update_dt, update_user, comments, title, isapackage, isaview) VALUES (10, '-- 7 script only for HEAD', 5, 18, 1, '2008-05-21', '', '', 'db update', 0, 0);
INSERT INTO tbscript (id, code, module_id, versionnr, user_id, update_dt, update_user, comments, title, isapackage, isaview) VALUES (11, '-- 8 script for HEAD and DELTA_2', 5, 19, 1, '2008-05-21',  '', '', 'db update', 0, 0);
INSERT INTO tbscript (id, code, module_id, versionnr, user_id, update_dt, update_user, comments, title, isapackage, isaview) VALUES (12, '-- 9 script for DELTA_2 only', 5, 20, 1, '2008-05-21', '', '', 'db update', 0, 0);
INSERT INTO tbscript (id, code, module_id, versionnr, user_id, update_dt, update_user, comments, title, isapackage, isaview) VALUES (13, '-- 10 script for HEAD, DELTA_1 and DELTA_2', 5, 21, 1, '2008-05-21', '', '', 'db update', 0, 0);
INSERT INTO tbscript (id, code, module_id, versionnr, user_id, update_dt, update_user, comments, title, isapackage, isaview) VALUES (14, '-- 11 script for HEAD and DELTA_1', 5, 22, 1, '2008-05-21', '', '', 'db update', 0, 0);
INSERT INTO tbscript (id, code, module_id, versionnr, user_id, update_dt, update_user, comments, title, isapackage, isaview) VALUES (15, '-- 12 script for DELTA_1 only', 5, 23, 1, '2008-05-21', '', '', 'db update', 0, 0);
INSERT INTO tbscript (id, code, module_id, versionnr, user_id, update_dt, update_user, comments, title, isapackage, isaview) VALUES (16, '-- 13 again an only HEAD', 5, 24, 1, '2008-05-21', '', '', 'db update', 0, 0);

-- 
-- Dumping data for table 'tbscriptbranch'
-- 

INSERT INTO tbscriptbranch VALUES (19, 3, 2);
INSERT INTO tbscriptbranch VALUES (23, 6, 1);
INSERT INTO tbscriptbranch VALUES (22, 5, 1);
INSERT INTO tbscriptbranch VALUES (21, 4, 1);
INSERT INTO tbscriptbranch VALUES (20, 3, 3);
INSERT INTO tbscriptbranch VALUES (18, 3, 1);
INSERT INTO tbscriptbranch VALUES (24, 7, 1);
INSERT INTO tbscriptbranch VALUES (25, 7, 4);
INSERT INTO tbscriptbranch VALUES (26, 8, 4);
INSERT INTO tbscriptbranch VALUES (27, 9, 1);
INSERT INTO tbscriptbranch VALUES (28, 10, 1);
INSERT INTO tbscriptbranch VALUES (29, 11, 1);
INSERT INTO tbscriptbranch VALUES (30, 11, 5);
INSERT INTO tbscriptbranch VALUES (37, 14, 1);
INSERT INTO tbscriptbranch VALUES (36, 12, 5);
INSERT INTO tbscriptbranch VALUES (33, 13, 1);
INSERT INTO tbscriptbranch VALUES (34, 13, 4);
INSERT INTO tbscriptbranch VALUES (35, 13, 5);
INSERT INTO tbscriptbranch VALUES (38, 14, 4);
INSERT INTO tbscriptbranch VALUES (39, 15, 4);
INSERT INTO tbscriptbranch VALUES (40, 16, 1);


INSERT INTO tbuser VALUES (1, 'admin', 'testdbsync', 'Main', 'Administrator', 'admin@deltasql', 3);

