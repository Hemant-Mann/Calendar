<?php

class Event extends DatabaseObject {
	protected static $table_name = "events";
	protected static $db_fields = ['event_id',  'user_id', 'event_title', 'event_desc', 'event_start', 'event_end'];
	
	public $user_id;
	/*
	* The event ID
	*
	* @var int
	*/
	public $event_id;
	/**
	* The event title
	*
	* @var string
	*/
	public $event_title;
	/**
	* The event description
	*
	* @var string
	*/
	public $event_desc;
	/**
	* The event start time
	*
	* @var string
	*/
	public $event_start;
	/**
	* The event end time
	*
	* @var string
	*/
	public $event_end;

	private $required_fields = ['event_title', 'event_start', 'event_end'];
	public $errors = [];	
	/**
	* Accepts an array of event data and stores it
	*
	* @param array $event Associative array of event data
	* @return void
	*/
	public function __construct($event=[])	{
		if (!empty($event))	{
			$this->event_id = $event->event_id;
			$this->user_id = $event->user_id;
			$this->event_title = $event->event_title;
			$this->event_desc = $event->event_desc;
			$this->event_start = $event->event_start;
			$this->event_end = $event->event_end;
		} else {
			return false;
		}
	}

	/**
	 * Accepts an array of event span
	 * @param array $range Associative array of start_date and end_date
	 * @return void/event object
	*/
	public static function month_events($range = []) {
		if(empty($range)) {
			return false;
		}
		global $database;
		$start_date = $database->escape_value($range['start_date']);
		$end_date = $database->escape_value($range['end_date']);
		$user_id = $range['user_id'];
		if(empty($start_date) && empty($end_date)) { return false; }
		
		$sql = "SELECT * FROM ". self::$table_name. " WHERE event_start BETWEEN '{$start_date}' AND '{$end_date}' AND user_id = '{$user_id}' ORDER BY event_start";
		return self::find_by_sql($sql);
	}

	public function save() {
		foreach($this->required_fields as $field) {
			if (empty($this->{$field})) {
				$this->errors[] = "Please fill in the required fields";
				return false;
			}
		}

		if(isset($this->event_id)) {
			return $this->update();
		} else {
			if(empty($this->errors)) {
				return $this->create();
			} else {
				return false;
			}
		}
	}

	public function update() {
		global $database;
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach ($attributes as $key => $value) {
			$attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql  = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE event_id=". $database->escape_value($this->event_id);
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}

	public function create() {
		global $database;
		// Don't forget your SQL syntax 
		$attributes = $this->sanitized_attributes();
		$sql  = "INSERT into ".self::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
		$sql .= ") VALUES ('";	
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		if($database->query($sql)) {
			$this->event_id = $database->insert_id();
			return true;
		} else {
			return false;
		}
	}

	public function delete() {
		global $database;
		$sql = "DELETE from ".self::$table_name;
		$sql .= " WHERE event_id =". $database->escape_value($this->event_id);
		$sql .= " LIMIT 1";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false; 

	}
}

?>