<?php

## Defin base url of site
define('BASE_URL', 'http://localhost/risiko/');

## define assets path like css/js and images
define('CSS_PATH', BASE_URL .'css/');
define('JS_PATH', BASE_URL .'js/');

//class database
class Database {
	
	
	var $config = array(
			'host' 		=> 'localhost',
			'db'		=> 'risiko',
			'login'		=> 'root',
			'password'	=> '',
			'port'		=> 3306
		);
	//construct connect to db
	function __construct() {
	
		$con = mysql_connect($this->config['host'], $this->config['login'],$this->config['password']);
		
		if (!$con) {
			die('Could not connect: ' . mysql_error());
		} 
		
		$cons = mysql_select_db($this->config['db']);
	}

	/*
	 * function insert to db
	 * @params data of array
	 * @return status
	 */
	
	function add($data) {
		
		if(!empty($data)) {
			$QRY = "INSERT INTO messages(name,email,message,created) VALUES('{$data['name']}', '{$data['email']}', '{$data['message']}', '". date('Y-m-d H:i:s') ."')";
			
			$result = mysql_query($QRY);
			
			if($result)
				return mysql_insert_id();
			else
				return FALSE;
		} else
			return FALSE;
		
	}
	
	/*
	 * function get One data
	 * @params id
	 * @return array of data
	 */
	function getOne($id) {
	
		if(empty($id))
			return FALSE;
			
		//get by id
		$QRY = "SELECT * FROM messages WHERE id={$id}";
		
		$result = mysql_query($QRY);
		$data = mysql_fetch_array($result, MYSQL_ASSOC);
		
		if(!empty($data)) {
			return $data;
		} else
			return FALSE;
	
	}
	
	/*
	 * function get data
	 * @params array of parameter
	 * @return array of data
	 */
	 
	function getData($p=array()) {
		$limit = isset($p['limit']) ? $p['limit'] : 10;
		$offset = isset($p['offset']) ? $p['offset'] : 0;
		
		
		$QRY = "SELECT * FROM messages";
		$QRY .= ' ORDER BY created desc';
		if(!empty($limit)) {
			$QRY .= ' limit '. $offset .','.$limit;
		}
		
	
		$result = mysql_query($QRY);
		$i=0;
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$data[$i] = $row;
			$i++;
		}
		
		return $data;
	}
	
	/*
	 * function set time like x minutes ago
	 * @params unixtime
	 * @return string of time like x hours ago
	 */
	
	function human_time($time)
	{
	   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	   $lengths = array("60","60","24","7","4.35","12","10");

	   $now = time();

		   $difference     = $now - $time;
		   $tense         = "ago";

	   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
		   $difference /= $lengths[$j];
	   }

	   $difference = round($difference);

	   if($difference != 1) {
		   $periods[$j].= "s";
	   }

	   return "{$difference} {$periods[$j]} ago ";
	}

}
?>