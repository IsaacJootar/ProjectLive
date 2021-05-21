<?php
// UserClass-handles the the addition of new users//

require_once('database.php');

class userManager extends databaseObject  {
	
	public static $table_name="pl_users"; // table object//
	 //get this guys from the database fields//
	public static $db_fields = array('user_name', 'password', 'first_name', 'last_name', 'gender', 'phone', 'country', 'state');
	public $first_name;
	public $last_name;
	public $user_name;
	public $password;
	public $phone;
	public $gender;
	public $state;
	public $country;

	public function full_name() {
    	if(isset($this->first_name) && isset($this->last_name)) {
      	return $this->first_name . " " . $this->last_name;
    	} else {
      	return "";
    	}
  	}

	
}

?>