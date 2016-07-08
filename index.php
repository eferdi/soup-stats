<?php
require_once("class/db_soupStats.class.php");
require_once("libs/raintpl/rain.tpl.class.php"); //include Rain TPL

raintpl::$tpl_dir = "template/minimal/"; // template directory
raintpl::$cache_dir = "tmp/"; // cache directory

$tpl = new raintpl(); //include Rain TPL
$tpl->draw( "home" ); // draw the template
?>