<?php
//campaignGoalManager handles the the addition of campaign goal amount//

require_once('database.php');

class campaignGoalManager extends databaseObject  {
	
	public static $table_name="pl_campaign_goal"; // table object//
	 //get this guys from the database fields//
	public static $db_fields = array('id','campaign_id', 'amount');
	public $id;
	public $campaign_id;
	public $amount;





	 public static function find_all_campaign_goal_by_campaign_id($campaign_id){ 
		global $database;         
		$query=$database->query("SELECT `amount` FROM ".SELF::$table_name." WHERE `campaign_id`='{$campaign_id}'");
		$amount=$database->fetch_array(($query));
		$amount=$amount['amount'];
  		if(empty($amount)){
			return 0;
		}

		if(!empty($amount)){
			return $amount; 
		}
	}


}

?>