<?php

class Calendar extends DatabaseObject {
	
	/**
	* The date from which the calendar should be built
	*
	* Stored in YYYY-MM-DD HH:MM:SS format
	*
	* @var string the date to use for the calendar
	*/
	private $useDate;
	/**
	* The month for which the calendar is being built
	*
	* @var int the month being used
	*/
	private $month;
	/**
	* The year from which the month's start day is selected
	*
	* @var int the year being used
	*/
	private $year;
	/**
	* The number of days in the month being used
	*
	* @var int the number of days in the month
	*/
	private $daysInMonth;
	/**
	* The index of the day of the week the month starts on (0-6)
	*
	* @var int the day of the week the month starts on
	*/
	private $startDay;

	private function find_user_id() {
		if(isset($_SESSION['user_id']))  {
			return $_SESSION['user_id'];
		} else {
			return false;
		}
	}

	public $userId;

	public function __construct($useDate=NULL){
		/*
		* Gather and store data relevant to the month
		*/
		if ( isset($useDate) )	{
			$this->useDate = $useDate;
		} else {
			$this->useDate = date('Y-m-d H:i:s');
		}
		$this->userId = $this->find_user_id();
		/*
		* Convert to a timestamp, then determine the month
		* and year to use when building the calendar
		*/
		$ts = strtotime($this->useDate);
		$this->month = date('m', $ts);
		$this->year = date('Y', $ts);

		/*
		* Determine how many days are in the month
		*/
		$this->daysInMonth = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
		
		/*
		* Determine what weekday the month starts on
		*/
		$ts = mktime(0, 0, 0, $this->month, 1, $this->year);
		$this->startDay = date('w', $ts);
	}

	/**
	* Loads event(s) info into an array
	*
	* @param int $id an optional event ID to filter results
	* @return array an array of events from the database
	*/
	private function loadEventData($id=NULL)	{
		if(!empty($id)) {
			return Event::find_by_field("event_id", $id, ["limit" => 1, "user_id" => $this->userId]);
		}
		/*
		* Otherwise, load all events for the month in use
		*/
		else {
			/*
			* Find the first and last days of the month
			*/
			$start_ts = mktime(0, 0, 0, $this->month, 1, $this->year);
			$end_ts = mktime(23, 59, 59, $this->month+1, 0, $this->year);
			$start_date = date('Y-m-d H:i:s', $start_ts);
			$end_date = date('Y-m-d H:i:s', $end_ts);
			
			$range = ["start_date" => $start_date, "end_date" => $end_date, "user_id" => $this->userId];
			return Event::month_events($range);
		}
	}

	/**
	* Loads all events for the month into an array
	*
	* @return array events info
	*/
	private function createEventObj() {
		/*
		* Load the events object array
		*/
		$arr = $this->loadEventData();
		/*
		* Create a new array, then organize the events
		* by the day of the month on which they occur
		*/
		$events = array();
		foreach ( $arr as $event )	{
			$day = date('j', strtotime($event->event_start));
			$hasEvent = new Event($event);	
			if($hasEvent) {
				$events[$day][] = $hasEvent;
			}
		}
		return $events;
	}
	/**
	 * Return HTML Markup for moving around the year
	 * With the help of links to go to next month or previous month
	 *
	 * @return string the Navigation links HTML markup
	*/
	/**
	 * Return the month and year of the current calendar
	*/
	public function getMonthYr() {
		$array = ["month" => $this->month, "year" => $this->year];
		return $array;
	}

	public function buildNavigation() {
		$left = $this->month - 1; $right = $this->month + 1; $yr = $this->year;
		if($left == 0) { $left = 12; $yr--; } 
		$html = '<a href="'.HOME.'home?month='.$left.'&year='.$yr.'" data-month="'.$left.'" data-year="'.$yr.'" id="goLeft">&laquo;</a>';

		if($right > 12) { $right = 1; $yr = $yr + 1; } else { $yr = $this->year; }
		$html .= '<a href="'.HOME.'home?month='.$right.'&year='.$yr.'" data-month="'.$right.'" data-year="'.$yr.'" id="goRight" style="float: right;">&raquo;</a>';
		return $html;

	}
	/**
	* Returns HTML markup to display the calendar and events
	*
	* Using the information stored in class properties, the
	* events for the given month are loaded, the calendar is
	* generated, and the whole thing is returned as valid markup.
	*
	* @return string the calendar HTML markup
	*/
	public function buildCalendar()	{
		$event_info = "";
		/*
		* Determine the calendar month and create an array of
		* weekday abbreviations to label the calendar columns
		*/
		$cal_month = date('F Y', strtotime($this->useDate));
		$weekdays = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
	
		/*
		* Add a header to the calendar markup
		*/
		$html = "\n\t<h2>$cal_month</h2>";
		for ( $d=0, $labels=NULL; $d<7; ++$d ) {
			$labels .= "\n\t\t<li>" . $weekdays[$d] . "</li>";
		}
		$html .= "\n\t<ul class=\"weekdays\">". $labels . "\n\t</ul>";
		/*
		* Load events data
		*/
		$events = $this->createEventObj();

		/*
		* Create the calendar markup
		*/
		$html .= "\n\t<ul>"; // Start a new unordered list
		for ( $i=1, $c=1, $t=date('j'), $m=date('m'), $y=date('Y');	$c<=$this->daysInMonth; ++$i )	{
			/*
			* Apply a "fill" class to the boxes occurring before
			* the first of the month
			*/
			$class = $i<=$this->startDay ? "fill" : NULL;

			/*
			* Add a "today" class if the current date matches
			* the current date
			*/
			if ( $c==$t && $m==$this->month && $y==$this->year ) {
				$class = "today";
			}

			/*
			* Build the opening and closing list item tags
			*/
			$ls = sprintf("\n\t\t<li class=\"%s\">", $class);
			$le = "\n\t\t</li>";

			/*
			* Add the day of the month to identify the calendar box
			*/
			if ( $this->startDay<$i && $this->daysInMonth>=$c) {
				/*
				* Format events data
				*/
				$event_info = NULL; // clear the variable
				if(isset($events[$c])) {
					foreach ( $events[$c] as $event ) {
						$link = '<a href="'.HOME.'event?id=' .$event->event_id .'">' . $event->event_title. '</a>';
						$event_info .= "\n\t\t\t$link";
					}
				}
				$date = sprintf("\n\t\t\t<strong>%02d</strong>",$c++);
			} else { $date="&nbsp;"; }

			/*
			* If the current day is a Saturday, wrap to the next row
			*/
			$wrap = $i!=0 && $i%7==0 ? "\n\t</ul>\n\t<ul>" : NULL;

			/*
			* Assemble the pieces into a finished item
			*/
			$html .= $ls . $date. $event_info . $le . $wrap;
		}

		/*
		* Add filler to finish out the last week
		*/
		while ( $i%7!=1 ) {
			$html .= "\n\t\t<li class=\"fill\">&nbsp;</li>";
			++$i;
		}

		/*
		* Close the final unordered list
		*/
		$html .= "\n\t</ul>\n\n";

		/*
		* Return the markup for output
		*/
		return $html;
	}

	/**
	* Displays a given event's information
	*
	* @param int $id the event ID
	* @return string basic markup to display the event info
	*/
	public function displayEvent($id) {
		
		if(empty($id)) { return NULL; }
		$id = preg_replace('/[^0-9]/', '', $id);

		$event = $this->loadEventById($id);
		
		/*
		* Generate strings for the date, start, and end time
		*/
		if(!empty($event)) {
		$ts = strtotime($event->event_start);
		$date = date('F d, Y', $ts);
		$start = date('g:ia', $ts);
		$end = date('g:ia', strtotime($event->event_end));
		/*
		* Generate and return the markup
		*/
		return "<h2>$event->event_title</h2>"."\n\t<p class=\"dates\">$date, $start&mdash;$end</p>"
			. "\n\t<p>$event->event_desc</p>";
		} else {
			return false;
		}
	}

	/**
	* Returns a single event object
	*
	* @param int $id an event ID
	* @return object the event object
	*/
	private function loadEventById($id) {
	
		if(empty($id)) {
			return NULL;
		}

		$event = $this->loadEventData($id);
		if(isset($event[0])) {
			return new Event($event[0]);
		} else {
			return NULL;
		}
	}
}
	
?>
