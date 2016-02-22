<?php
/**
 * index.php 
 *
 * @package nmCommon
 * @author Bill Newman <williamnewman@gmail.com>
 * @version 2.091 2011/06/17
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see config_inc.php 
 * @todo none
 */
 
require 'inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
$config->titleTag = THIS_PAGE; #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php  
$config->nav1 = array("aboutus.php"=>"About Us") + $config->nav1; 

get_header(); #defaults to theme header or header_inc.php
?>
<div class="wrapper" style="margin-top:.5em;">
	<h1><?=$config->banner;?></h1>


</div>
<p </p>
<?php


//dumpDie($config);
get_footer(); #defaults to theme header or footer_inc.php
?>
