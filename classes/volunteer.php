<?php
// Class-handles the the addition of new volunteers//

//require_once('database.php');

class volunteerManager extends databaseObject  {
	
	public static $table_name="pl_volunteers"; // table object//
	 //get this guys from the database fields//
	public static $db_fields = array('id', 'name', 'gender', 'password', 'phone', 'email', 'state', 'message', 'date');
	
	public $id;
	public $name;
	public $phone;
	public $gender;
	public $password;
	public $state;
	public $email;
	public $message;
	public $date;
	
	
	/*
	public function full_name() {
    	if(isset($this->first_name) && isset($this->last_name)) {
      	return $this->first_name . " " . $this->last_name;
    	} else {
      	return "";
    	}
  	}

*/	
} // database object//

?>