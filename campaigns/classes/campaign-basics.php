<?php
//campaignBasicManager handles the the addition of new campaign basica//

require_once('database.php');

class campaignBasicsManager extends databaseObject   {
	
	public static $table_name="pl_campaign_basics"; // table object//
	 //get this guys from the database fields//
	public static $db_fields = array('id','campaign_id', 'campaign_category',
	 'campaign_tittle', 'campaign_beneficiary', 'beneficiary_type', 'campaign_video_link', 'campaign_tagline', 'campaign_state','campaign_location', 'campaign_duration', 'campaign_due_date', 'campaign_creation_date');
	
	public $id;
	public $campaign_id;
	public $campaign_category;
	public $campaign_tittle;
	public $campaign_tagline;
	public $campaign_video_link;
    public $campaign_state;
	public $campaign_location;
	public $campaign_duration;
	public $campaign_due_date;
	public $campaign_creation_date;
	public $campaign_beneficiary;
	public $beneficiary_type;



}

?>