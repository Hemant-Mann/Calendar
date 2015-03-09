<?php

class User extends DatabaseObject {
	
	protected static $table_name = "users";
	protected static $db_fields = ['id',  'name', 'email', 'username', 'password'];
	public $id;
	public $name;
	public $email;
	public $username;
	public $password;

	private $required_fields = ['name', 'email', 'username', 'password'];
	public $errors = [];

	public static function authenticate($username="", $password="") {
	    global $database;
	    if($result_set = self::find_by_field("username",$username)) {
			$user = array_shift($result_set);
		} else {
			$user = false;
		}
	    $password = $database->escape_value($password);

		if($user) {
		  if(password_check($password, $user->password)) {
		  	return $user;
		  } else {   
		  	return false; 	
		  }
		} else {
		  	return false;
		 }
	}

	public function password_encrypt($password) {
		$hash_format = "$2y$10$";  //tells PHP to use Blowfish with a "cost" of 10
		$salt_length = 22; //Blowfish salts should be 22-characters or more
		$salt = $this->generate_salt($salt_length);
		$format_and_salt = $hash_format. $salt;	
		$hash = crypt($password, $format_and_salt);
		return $hash;
	}

	public function generate_salt($length) {
		//Not 100% unique, not 100% random, but good enought for a salt
		//MD5 returns 32 characters
		$unique_random_string = md5(uniqid(mt_rand(), true));
		
		//valid characters for a salt are [a-z A-Z 0-9 ./]
		$base64_string = base64_encode($unique_random_string);
		
		//but not '+' which is in base64 encoding
		$modified_base64_string = str_replace('+', '.', $base64_string);
		
		//Truncate string to the correct length
		$salt = substr($modified_base64_string, 0, $length);
		
		return $salt;
	}

	public function save() {
		// Check if any required field is empty
		foreach($this->required_fields as $field) {
			if(empty($this->{$field})) {
				$this->errors[] = "Please fill the required fields";
				return false;
			} else {
				// Nothing is empty so check the lengths
				if($field == 'name') {
					if(strlen($this->{$field}) > 80) {
						$this->errors[] = "Length of name can be 80 characters only";
					}
				} elseif($field == 'email') {
					if(strlen($this->{$field}) > 200) {
						$this->errors[] = "Email can only be 200 characters long";
					}
				} else {
					if(strlen($this->{$field}) > 60) {
						$this->errors[] = "Max length of the {$field} is 60 characters";
					}
				}
			}
		}
		// A new record won't have an id yet
		if(isset($this->id)) {
			// To update the description or price
			return $this->update();
		} else {
			//Can't save if there are pre-existing errors
			if(!empty($this->errors)) { return false; } 

			global $database;

			// Check if the email already exists in the database;
			if($result_set = self::find_by_field("email", $this->email)) {
				$user = array_shift($result_set);
				if($user->email === $this->email) {
					$this->errors[] = "Please try with a different email id";
				}
			}

			// Check if the username already exists in the database;
			if($result_set = self::find_by_field("username", $this->username)) {
				$user = array_shift($result_set);
				if($user->username === $this->username) {
					$this->errors[] = "Please try with a different username";
				}
			}

			if(empty($this->errors)) {
				// No errors create a user
				return $this->create();
			} else {
				return false;
			}

		}
	}  

}
	
?>
