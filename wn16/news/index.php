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

$config->titleTag = smartTitle(); #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php
$config->metaDescription = smartTitle() . ' - ' . $config->metaDescription; 

# SQL statement 
$sql = "select * from Category as c
inner join Subcategory as s on c.CategoryID = s.CategoryID";

//END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to header_inc.php
?>
<h3 align="center">News Feeds</h3>

<?php
#IDB::conn() creates a shareable database connection via a singleton class
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

$categories = [];

if(mysqli_num_rows($result) > 0)
{#there are records - present data
	while($row = mysqli_fetch_assoc($result))
	{# pull data from associative array 
       
        if(!in_array($row['CategoryTitle'], $categories)){
           array_push($categories,$row['CategoryTitle']);
           echo '<p>';
	       echo '<b>' . $row['CategoryTitle'] . '</b><br />';
           echo 'Description: <b>' . $row['CategoryDescription'] . '</b><br />';    
       }
        
       echo '<a href="read_feed.php?id=' . $row['SubcategoryID'] . '">' . $row['SubcategoryTitle'] . '</a><br />';
       echo 'Description: ' . $row['SubcategoryDescription'] . '<br />';

       
      
	   echo '</p>';
	}
}else{#no records
	echo '<div align="center">Sorry, there are no news feeds that match that category</div>';
}


get_footer(); #defaults to footer_inc.php
?>
