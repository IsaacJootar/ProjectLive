<?php
// UserClass-handles the the addition of new users//

require_once('database.php');

class enquiry extends databaseObject  {
	
	public static $table_name="pl_enquiry"; // table object//
	 //get this guys from the database fields//
	public static $db_fields = array('id', 'enq_name', 'enq_phone', 'enq_message');
	
	public $id;
	public $enq_name;
	public $enq_phone;
	public $enq_message;

	
}

?>