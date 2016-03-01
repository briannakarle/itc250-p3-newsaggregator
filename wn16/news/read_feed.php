
<?php
/**
 * read_feed.php a view page to show a single news feed
 *
 * This page uses the Feed class to gather articles from google and display on the page
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
//Feed.php to be used to store session data
include 'Feed.php';

$config->titleTag = smartTitle(); #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php
$config->metaDescription = smartTitle() . ' - ' . $config->metaDescription; 


if((isset($_GET['id'])) && (int)$_GET['id'] > 0){//good data, process
    $id = (int)$_GET['id'];
}else{//bad data, don't process
    //this is redirection in PHP:
    header('Location:index.php');
}

//clean out session if older than 10 minutes
session_clean(600);

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
         
        //take category and subcategory then turn into string with "+" between each word for google news query
        $querySplit = explode(" ", $row['CategoryTitle'] . ' ' . $row['SubcategoryTitle']);
        $query = implode("+", $querySplit);
        
        $subCatDescp = $row['SubcategoryDescription'];
            
    }    
@mysqli_free_result($result);
}

$data = '';
if(empty($_SESSION)){//if there isn't a session, start one
    startSession();
    
    //get feed data
    $request = 'https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=' . $query . '&output=rss';  
    $data = file_get_contents($request);
    
    //create Feed object 
    $today = date("Y-m-d H:i:s");  
    $myFeed = new Feed($id,$today,$data);
    $xml = simplexml_load_string($myFeed->Data);
    
    //create session with Feed data
    session_write($myFeed->ID, $myFeed->Data);  
    
}else{//if session already set
    //get session data and load it it $xml variable
    $data = session_read($id);
    $xml = simplexml_load_string($data);
}

//output feed data
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

//close session
session_close();
get_footer(); #defaults to footer_inc.php