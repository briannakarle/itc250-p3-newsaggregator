<?php
/**
 * news_list1.php a list page of news feeds
 *
 * based on demo_shared.php
 *
 * demo_idb.php is both a test page for your IDB shared mysqli connection, and a starting point for 
 * building DB applications using IDB connections
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
# '../' works for a sub-folder.  use './' for the root
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials

$config->titleTag = smartTitle(); #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php
$config->metaDescription = smartTitle() . ' - ' . $config->metaDescription; 
/*
$config->metaDescription = 'Web Database ITC281 class website.'; #Fills <meta> tags.
$config->metaKeywords = 'SCCC,Seattle Central,ITC281,database,mysql,php';
$config->metaRobots = 'no index, no follow';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/

# SQL statement - PREFIX is optional way to distinguish your app
$sql = "select * from wn16_news_categories";

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
//echo '<div align="center"><h4>SQL STATEMENT: <font color="red">' . $sql . '</font></h4></div>';
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
