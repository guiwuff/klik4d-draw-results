<?php

class Klik4d_Draw {
	
	private $drawResult = array(); // array for the result
	private $url; // url of togel site
	private $ua; // user agent for curl
	
	function __construct() {
		// Class construct
		$this->url = 'http://www.klik4d.com/login.aspx';
		$this->ua = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36';
	}
	
	public function get_result() {
		// Method to get draw result from object
		$result = $this->$drawResult;
		return $result;
	}

	public function update_data() {
		/**
		/ Scrape to the site, parse and save to json file
		/ Use curl to fetch html data and save to var html
		/ Use Domxpath to parse and stores draw results into arrays
		/ Stores the arrays into json files
		**/
		$url = $this->url;
		$ua = $this->ua;
		// Options for curl set in array
		$options = array(
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_URL => $url,
						CURLOPT_USERAGENT => $ua,
						CURLOPT_AUTOREFERER    => true,
						CURLOPT_VERBOSE        => 1
						);
		
		$ch = curl_init(); // curl init
		curl_setopt_array($ch, $options);
		
		$content = curl_exec($ch); 
	    $err     = curl_errno($ch); 
	    $errmsg  = curl_error($ch) ; 
	    $header  = curl_getinfo($ch); 
	    
	    curl_close($ch);  // clode
		

				
	}	
}
?>