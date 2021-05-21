<?php
//campaignGoalManager handles the the addition of campaign goal amount//

require_once('database.php');

class campaignReviewManager extends databaseObject  {
	
	public static $table_name="pl_campaign_review"; // table object//
	 //get this guys from the database fields//
	public static $db_fields = array('id', 'campaign_id', 'date');
	public $id;
	public $campaign_id;
	public $date;



}

?>