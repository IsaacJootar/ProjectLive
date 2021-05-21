<?php
//campaignPhotoManager handles the the addition of new campaign buidup photos//

require_once('database.php');

class campaignPhotoManager extends databaseObject   {
	
	public static $table_name="pl_campaign_photos"; // table object//
	 //get this guys from the database fields//
	public static $db_fields = array('id', 'campaign_id', 'user_id', 'photo_name', 
		'photo_ext', 'photo_size');
	
	public $id;
	public $category_id;
	public $campaign_id;
	public $user_id;
	public $photo_name;
	public $photo_ext;
	public $photo_size;
	
	
	
	 public static function find_campaign_photo_name_by_campaign_id($campaign_id){ 
		global $database;         
		$query=$database->query("SELECT `photo_name` FROM ".SELF::$table_name." WHERE `campaign_id`=$campaign_id");
		$file_name=$database->fetch_array(($query));
		$file_name=$file_name['photo_name'];
  		if(empty($file_name)){
			return '';
		}

		if(!empty($file_name)){ 
			 return $file_name;
		}

	}
	
	
	
	
	

	 public static function find_campaign_photo_by_user_id($campaign_id, $user_id){ 
		global $database;         
		$query=$database->query("SELECT `photo_name` FROM ".SELF::$table_name." WHERE `campaign_id`=$campaign_id AND `user_id`= $user_id");
			
		$file_name=$database->fetch_array(($query));
		$file_name=$file_name['photo_name'];
  		if(empty($file_name)){
			return 'no campaigns are created yet';
		}

		if(!empty($file_name)){
			return "<img src='classes/campaign-photos/resized_$file_name'  alt='Campaign photo'>"; 
		}

	}


 public static function find_featured_campaign_photo_by_campaign_id($campaign_id){ 
		global $database;         
		$query=$database->query("SELECT `photo_name` FROM ".SELF::$table_name." WHERE `campaign_id`=$campaign_id");
		$file_name=$database->fetch_array(($query));
		$file_name=$file_name['photo_name'];
  		if(empty($file_name)){
			return '';
		}

		if(!empty($file_name)){ 
			 return "<img src='campaigns/campaign-photos/$file_name' width='200' height='195'  alt=' campaign featured'/>";
		}

	}
	 public static function find_thumb_campaign_photo_by_user_id($campaign_id, $user_id){ 
		global $database;         
		$query=$database->query("SELECT `photo_name` FROM ".SELF::$table_name." WHERE `campaign_id`=$campaign_id AND `user_id`= $user_id");
		$file_name=$database->fetch_array(($query));
		$file_name=$file_name['photo_name'];
  		if(empty($file_name)){
			return '';
		}
		if(!empty($file_name)){
			return "<img src='campaign-photos/$file_name' width='265' height='195'  alt='Campaign photo'>"; 
		}

	}

	 public static function find_campaign_photo_by_campaign_id($campaign_id){ 
		global $database;         
		$query=$database->query("SELECT `photo_name` FROM ".SELF::$table_name." WHERE `campaign_id`=$campaign_id");
		$file_name=$database->fetch_array(($query));
		$file_name=$file_name['photo_name'];
  		if(empty($file_name)){
			return '';
		}

		if(!empty($file_name)){ 
			 return "<img src='campaign-photos/$file_name' alt='ProjectLive Africa campaign photo'/>";
		}

	}
	
	 public static function find_campaign_photo_by_campaign_id_for_admin($campaign_id){ 
		global $database;         
		$query=$database->query("SELECT `photo_name` FROM ".SELF::$table_name." WHERE `campaign_id`=$campaign_id");
		$file_name=$database->fetch_array(($query));
		$file_name=$file_name['photo_name'];
  		if(empty($file_name)){
			return '';
		}

		if(!empty($file_name)){ 
			 return "<img src='../campaigns/campaign-photos/$file_name' alt='ProjectLive Africa campaign photo'/>";
		}

	}
	 public static function find_thumb_campaign_photo_by_campaign_id($campaign_id){ 
		global $database;         
		$query=$database->query("SELECT `photo_name` FROM ".SELF::$table_name." WHERE `campaign_id`=$campaign_id");
		$file_name=$database->fetch_array(($query));
		$file_name=$file_name['photo_name'];
  		if(empty($file_name)){
			return '';
		}

		if(!empty($file_name)){ 
			 return "<img src='campaigns/campaign-photos/$file_name' width='560' height='195'  alt=' Campaign Image '/>";
		}

	}


	
}

?>
