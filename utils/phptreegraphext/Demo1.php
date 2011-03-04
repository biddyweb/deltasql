<?php

/**
 *	phpTreeGraph
 *	Linux filesystem hierarchy demo
  * 	@author Mathias Herrmann
**/

//include GD rendering class
require_once('./classes/GDRenderer.php');

//create new GD renderer, optinal parameters: LevelSeparation,  SiblingSeparation, SubtreeSeparation, defaultNodeWidth, defaultNodeHeight
$objTree = new GDRenderer(30, 10, 30, 50, 40);

//add nodes to the tree, parameters: id, parentid optional title, text, width, height, image(path)
$objTree->add(1,0,'/', '', 10, 20);
$objTree->add(2,1,'bin', 'nothing');
$objTree->add(3,1,'boot', 'nothing');
$objTree->add(4,1,'dev', 'nothing');
$objTree->add(5,1,'etc', '', 50, 20);
$objTree->add(6,1,'home', 'nothing');
$objTree->add(7,1,'lib', 'nothing');
$objTree->add(8,1,'lost+found', 'nothing', 100);
$objTree->add(9,1,'mnt', 'nothing');
$objTree->add(10,1,'proc', 'nothing');
$objTree->add(11,1,'root', 'nothing');
$objTree->add(12,1,'sbin', 'nothing');
$objTree->add(13,1,'tmp', 'nothing');
$objTree->add(14,1,'usr', '', 50, 20);
$objTree->add(15,1,'var', '', 50, 20);
$objTree->add(16,5,'rc.d', 'nothing');
$objTree->add(17,5,'skel', 'nothing');
$objTree->add(18,5,'X11', 'nothing');
$objTree->add(19,14,'bin', 'nothing');
$objTree->add(20,14,'local', 'nothing');
$objTree->add(21,14,'include', 'nothing');
$objTree->add(22,14,'lib', 'nothing');
$objTree->add(23,14,'man', 'nothing');
$objTree->add(24,14,'sbin', 'nothing');
$objTree->add(25,14,'src', 'nothing');
$objTree->add(26,14,'X11 R6', 'nothing');
$objTree->add(27,15,'tmp', 'nothing');
$objTree->add(28,15,'spool', '', 50, 20);
$objTree->add(29,20,'bin', 'nothing');
$objTree->add(30,20,'sbin', 'nothing');
$objTree->add(31,25,'linux', 'nothing');
$objTree->add(32,28,'lpd', 'nothing');
$objTree->add(33,28,'mail', 'nothing');
$objTree->add(34,28,'uucp', 'nothing');
$objTree->add(35,28,'cron', 'nothing');

//$objTree->setNodeLinks(GDRenderer::LINK_BEZIER);

$objTree->setBGColor(array(255, 255, 255));
$objTree->setNodeTitleColor(array(0, 128, 255));
$objTree->setNodeMessageColor(array(0, 192, 255));
$objTree->setLinkColor(array(0, 64, 128));
//$objTree->setNodeLinks(GDRenderer::LINK_BEZIER);
$objTree->setNodeBorder(array(0, 0, 0), 2);
$objTree->setFTFont('/usr/share/fonts/truetype/msttcorefonts/arial.ttf', 10, 0, GDRenderer::CENTER);

$objTree->stream();

?>