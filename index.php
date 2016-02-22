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

$config->titleTag = "News"
$config->banner = "Environmental News"; 

# SQL statement
$sql = "SELECT * FROM ";

get_header(); #defaults to theme header or header_inc.php

?>
<div class="wrapper">
	<h1><?=$config->banner;?></h1>


</div>
<p </p>
<?php
# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

if(mysqli_num_rows($result) > 0)
{#records exist - process

	while($row = mysqli_fetch_assoc($result))
	{# process each row
         echo '<div align="center">
                  <a href="' . VIRTUAL_PATH . 'p3/news_view.php?id=' . (int)$row['CategoryID'] . '">' . dbOut($row['Title']) . '</a>';
         
         echo '</div>';
	}
	
}else{#no records
    echo "<div align=center>There are no matching records.</div>";	
}

@mysqli_free_result($result);



//dumpDie($config);
get_footer(); #defaults to theme header or footer_inc.php
?>
