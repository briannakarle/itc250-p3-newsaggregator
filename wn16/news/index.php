<?php
/**
 * index.php a list page of news feeds
 *
 *
 * @package nmCommon
 * @author Mitchell Thompson <thomitchell@gmail.com>
 * @author Brianna Karle <briannarkarle@gmail.com>
 * @author Jennifer Lockett <lockettjk@gmail.com>
 * @version 1 2016/02/19
 * @link App: http://mitchlthompson.com/wn16/news/ 
 * @link Staging Area: https://docs.google.com/document/d/1kCmCA3P_8FDUPRyJX2MMBUW4UrF6DUzHxBNXaU35V8Y/edit?usp=sharing
 * @link Github repo: https://github.com/briannakarle/itc250-p3-newsaggregator
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see config_inc.php  
 * @see header_inc.php
 * @todo none
 */

require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
require_once '../inc_0700/credentials_inc.php'; #provides db credentials

$config->titleTag = smartTitle(); #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php
$config->metaDescription = smartTitle() . ' - ' . $config->metaDescription; 

# SQL statement 
$sql = "select * from Category as c
inner join Subcategory as s on c.CategoryID = s.CategoryID";

//END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to header_inc.php
?>
<h3>Environmental News</h3>

<?php
#IDB::conn() creates a shareable database connection via a singleton class
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

//create empty array to keep track of Categories
$categories = [];

if(mysqli_num_rows($result) > 0)
{#there are records - present data
    
	while($row = mysqli_fetch_assoc($result))
	{# pull data from associative array 
        if(!in_array($row['CategoryTitle'], $categories))
        {//if CategoryTitle not in array, add to array to not use again, then echo Title&Description
           array_push($categories,$row['CategoryTitle']);
           echo '<div class="panel panel-primary well col-md-12">';
           echo '<div class="panel-heading">';
           echo '<h3 class="panel-title">';
	       echo  $row['CategoryTitle'] . '</h3></div>';
           echo '<div class="panel-body">Description:' . $row['CategoryDescription'] . '</div></div>';    
       }
        //echo each subcategory under current category   
       echo '<div class="panel panel-default"><div class="panel-body text-center"><a href="read_feed.php?id=' . $row['SubcategoryID'] . '">' . $row['SubcategoryTitle'] . '</a></div></div>';
	}
}else{#no records
	echo '<div align="center">Sorry, there are no news feeds that match that category</div>';
}


get_footer(); #defaults to footer_inc.php
?>