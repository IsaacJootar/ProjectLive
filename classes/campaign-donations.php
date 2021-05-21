<?php
//campaignBasicManager handles the the addition of new campaign basica//

class campaignDonationManager extends databaseObject   {
	
	public static $table_name="pl_campaign_donations"; // table object//
	 //get this guys from the database fields//
	public static $db_fields = array('id', 'campaign_id', 'user_id', 'campaign_category',
	 'identity_of_donor', 'donation_amount', 'donation_date', 'name_of_donor', 'phone_of_donor', 'email_of_donor', 'comment_of_donor',  'payment_id', 'payment_status', 'reference_code', 'payment_channel');
	
	public $id;
	public $campaign_id;
	public $user_id;
	public $identity_of_donor;
	public $donation_amount;
	public $donation_date;
	public $name_of_donor;
	public $phone_of_donor;
	public $email_of_donor;
	public $comment_of_donor;
	public $campaign_category;
	public $payment_id;
	public $payment_status;
	public $reference_code;
	public $payment_channel;

// Whats now the need of putting these methods here. move them into the inherited class and return the results as objects//
	public static function find_all_campaign_donations_by_campaign_id($campaign_id=0){ 
		global $database;         
		$query=$database->query("SELECT SUM(donation_amount) AS `donation_amount` FROM ".SELF::$table_name." WHERE `campaign_id`='{$campaign_id}' AND `payment_status`=1 AND `reference_code` !='' AND `payment_id` !=''");
		$donations=$database->fetch_array(($query));
		$donations=$donations['donation_amount'];
  		if(empty($donations)){
			return 0;
		}

		if(!empty($donations)){
			return $donations; 
		}
	}

	public static function find_percentage_on_donations_by_campaign_id($campaign_id){ 
		global $database;         
		// get the campaign goal to calculate percentage of donations//
		$goal_query=$database->query("SELECT `amount` FROM  `pl_campaign_goal` WHERE `campaign_id`='{$campaign_id}' ");
		$campaign_goal=$database->fetch_array(($goal_query));
		$campaign_goal=$campaign_goal['amount'];
		// calculate percentage//
		 $percent=self::find_all_campaign_donations_by_campaign_id($campaign_id)/ $campaign_goal * 100;// donations from the returned result in the donation method above,  divided by target campaign goal,  multiplid by 100//
		 if($percent < 1) {
		 	return 0;
		 }else{
		 return round($percent);
		}
	


	}

// count number of donations//

public static function find_numbers_of_donations_by_campaign_id($campaign_id){ 
		global $database;         
		$count_donations=$database->query("SELECT `id` FROM  `pl_campaign_donations` WHERE `campaign_id`='{$campaign_id}' AND `payment_status`=1 AND `reference_code` !='' AND `payment_id` !=''");
		return $count_donations=$database->num_rows(($count_donations));
	
	


	}


}

?>