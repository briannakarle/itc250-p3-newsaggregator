<?php

//Feed.php to be used to store session data for read_feed.php

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
?>