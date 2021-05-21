<?php
//campaignBasicManager handles the the addition of new campaign basica//

require_once('database.php');
class campaignStoryManager extends databaseObject   {
	
	public static $table_name="pl_campaign_stories"; // table object//
	 //get this guys from the database fields//
	public static $db_fields = array('id', 'campaign_id', 'story');
	
	public $id;
	public $campaign_id;
	public $story;
	


}

?>