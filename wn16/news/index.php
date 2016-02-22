<?php
/**
 * index.php a list page of news feeds
 *
 *
 * @package nmCommon
 * @author Mitchell Thompson <thomitchell@gmail.com>
 * @version 1 2016/02/19
 * @link 
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see config_inc.php  
 * @see header_inc.php
 * @see footer_inc.php 
 * @todo none
 */

require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
require '../inc_0700/credentials_inc.php'; #provides db credentials

$config->titleTag = smartTitle(); #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php
$config->metaDescription = smartTitle() . ' - ' . $config->metaDescription; 

# SQL statement 
$sql = "select * from Category";

//END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to header_inc.php
?>
<h3 align="center">News Feeds</h3>

<!--
<p>
    <h3>News Category 1</h3>
    <b>News Category 1 description</b>
    <ul>
        <li><a href="#">News Sub-Category 1</a></li>
        <li><a href="#">News Sub-Category 2</a></li>
        <li><a href="#">News Sub-Category 3</a></li>
    </ul>
</p>
<p>
    <h3>News Category 2</h3>
    <b>News Category 2 description</b>
    <ul>
        <li><a href="#">News Sub-Category 4</a></li>
        <li><a href="#">News Sub-Category 5</a></li>
        <li><a href="#">News Sub-Category 6</a></li>
    </ul>
</p>
<p>
    <h3>News Category 3</h3>
    <b>News Category 3 description</b>
    <ul>
        <li><a href="#">News Sub-Category 7</a></li>
        <li><a href="#">News Sub-Category 8</a></li>
        <li><a href="#">News Sub-Category 9</a></li>
    </ul>
</p>
-->


<?php
#IDB::conn() creates a shareable database connection via a singleton class
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));


if(mysqli_num_rows($result) > 0)
{#there are records - present data
	while($row = mysqli_fetch_assoc($result))
	{# pull data from associative array
	   echo '<p>';
	   echo '<a href="read_feed.php?id=' . $row['CategoryID'] . '">' . $row['Category'] . '</a><br />';
	   echo 'Description: <b>' . $row['Description'] . '</b><br />';   
	   echo '</p>';
	}
}else{#no records
	echo '<div align="center">Sorry, there are no news feeds that match that category</div>';
}
@mysqli_free_result($result);

get_footer(); #defaults to footer_inc.php
?>
