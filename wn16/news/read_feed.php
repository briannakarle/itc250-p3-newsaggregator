<?php
/**
 * read_feed.php a view page to show a single news feed
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
require_once '../inc_0700/credentials_inc.php'; #provides db credentials

$config->titleTag = smartTitle(); #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php
$config->metaDescription = smartTitle() . ' - ' . $config->metaDescription; 


if((isset($_GET['id'])) && (int)$_GET['id'] > 0){//good data, process
    $id = (int)$_GET['id'];
}else{//bad data, don't process
    //this is redirection in PHP:
    header('Location:index.php');
}

//END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to header_inc.php

#SQL statement
$sql = 'select * from Category as c inner join Subcategory as s on c.CategoryID = s.CategoryID where s.SubcategoryID=' . $id;


#IDB::conn() creates a shareable database connection via a singleton class
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));



    
if(mysqli_num_rows($result) > 0)
{#there are records - present data
            
    while($row = mysqli_fetch_assoc($result))
    {# pull data from associative array
                
        $querySplit = explode(" ", $row['CategoryTitle'] . ' ' . $row['SubcategoryTitle']);
        $query = implode("+", $querySplit);
        
        $subCatDescp = $row['SubcategoryDescription'];
            
    }
    
@mysqli_free_result($result);
}


$request = 'https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=' . $query . '&output=rss';    
$data = file_get_contents($request);
       

$today = date("Y-m-d H:i:s");    
$myFeed = new Feed($id,$today,$data);
//dumpDie($myFeed);

$xml = simplexml_load_string($myFeed->Data);
echo '<h1>' . $xml->channel->title . '</h1>';
echo '<p>' . $subCatDescp . '</p><br />';    
foreach($xml->channel->item as $story)   
{
    echo '<div class="article">';
    echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
    echo '<p>' . $story->description . '</p><br /><br />';
    echo '</div><!-- end class article -->';
}


echo '<p><a href="index.php">BACK</a></p>';
get_footer(); #defaults to footer_inc.php
    
    
class Feed 
{
    public $ID = 0;
    public $DateTime = '';
    public $Data = '';
    
    
    
    public function __construct($id, $Datetime, $Data)
    {
        $this->ID = $id;
        $this->DateTime = $Datetime;
        $this->Data = $Data;
    
    }


}
