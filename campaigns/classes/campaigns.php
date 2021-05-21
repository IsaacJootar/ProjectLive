<?php
//campaignsManager handles the the addition of new campaign buidup photos//

require_once('database.php');

class campaignsManager extends databaseObject   {
	
	public static $table_name="pl_campaigns"; // table object//
	 //get this guys from the database fields//
	public static $db_fields = array('id','campaign_code', 'campaign_category', 'user_id');
	public $id;
	public $campaign_category;
	public $campaign_code;
	public $user_id;

}

?>


