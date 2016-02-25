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
?>
<h3 align="center">News Feed View</h3>

<?php

$myFeed = new Feed($id);
//dumpDie($myFeed);

echo '<p><a href="index.php">BACK</a></p>';
get_footer(); #defaults to footer_inc.php


class Feed
{
    public $CategoryID = 0;
    public $CategoryTitle = '';
    public $CategoryDescription = '';
    
    public function __construct($id)
    {
        $this->CategoryID = (int)$id;
        
        #SQL statement
        //$sql = "select * from Subcategory where SubcategoryID=$this->CategoryID";
        $sql = "select * from Category as c inner join Subcategory as s on c.CategoryID = s.CategoryID where s.SubcategoryID=$this->CategoryID";

        #IDB::conn() creates a shareable database connection via a singleton class
        $result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

    
        if(mysqli_num_rows($result) > 0)
        {#there are records - present data
            while($row = mysqli_fetch_assoc($result))
            {# pull data from associative array
                
              $catPlusSubCat = $row['CategoryTitle'] . ' ' . $row['SubcategoryTitle']; 
              $querySplit = explode(" ", $catPlusSubCat);
              $query = implode("+", $querySplit);
              $this->CategoryTitle = $query;
             
                
              $request = 'https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=' . $this->CategoryTitle . '&output=rss';    
              $response = file_get_contents($request);
              $xml = simplexml_load_string($response);
              echo '<h1>' . $xml->channel->title . '</h1>';
              foreach($xml->channel->item as $story)
                 {
                    echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
                    echo '<p>' . $story->description . '</p><br /><br />';
                  }
            }
        }
    
    
    
        
        @mysqli_free_result($result);
    
    
    }#end news constructor



}
