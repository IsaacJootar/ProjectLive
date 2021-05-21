<?php
//campaignBasicManager handles the the addition of new campaign basica//

require_once('database.php');

class campaignBankManager extends databaseObject   {
	
	public static $table_name="pl_campaign_bank_details"; // table object//
	 //get this guys from the database fields//
	public static $db_fields = array('id','campaign_id', 'bank_name', 'account_number');
	public $id;
	public $campaign_id;
	public $bank_name;
	public $account_number;
	


}

?>