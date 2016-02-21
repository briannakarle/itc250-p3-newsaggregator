<?php
/**
 * news_view1.php a view page to show a single news feed
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

get_footer(); #defaults to footer_inc.php


class Feed
{
    public $CategoryID = 0;
    public $Category = '';
    public $Description = '';
    
    public function __construct($id)
    {
        $this->CategoryID = (int)$id;
        
        #SQL statement - PREFIX is optional way to distinguish your app
        $sql = "select * from wn16_news_categories where CategoryID=$this->CategoryID";
        

        #IDB::conn() creates a shareable database connection via a singleton class
        $result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

    
        if(mysqli_num_rows($result) > 0)
        {#there are records - present data
            while($row = mysqli_fetch_assoc($result))
            {# pull data from associative array
                
                $querySplit = explode(" ", $row['Category']);
                $query = implode("+", $querySplit);
                $this->Category = $query;
                
                
                  $request = 'https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=' . $this->Category . '&output=rss';
                  $response = file_get_contents($request);
                  $xml = simplexml_load_string($response);
                  print '<h1>' . $xml->channel->title . '</h1>';
                  foreach($xml->channel->item as $story)
                  {
                    echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
                    echo '<p>' . $story->description . '</p><br /><br />';
                  }
            }
        }
        echo '<p><a href="index.php">BACK</a></p>';
        // todo: update Back Link to index.php
        //echo '<p><a href="index.php">BACK</a></p>';
        @mysqli_free_result($result);
    
    
    }#end news constructor



}
