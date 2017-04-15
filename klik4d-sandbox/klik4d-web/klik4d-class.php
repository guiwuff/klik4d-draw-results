<?php
/**
*   To develop and test klik4d classes and methods
*
**/

class Klik4d {
	
    private $url; // url of togel site
	private $ua; // user agent for curl    
    private $drawResult = array();
    private $success = true;

    function __construct() {
        // Class construct
        $this->url = 'http://www2.klik4d.com/login.aspx';
		$this->ua = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36';
        $this->fetch_data();
        $result = $this->drawResult;
        // if success parse data
        if ( $this->success == true ) {

        } else {
            // exit
            die ('Fetching data Error : '. $result['error']['msg'] );
        }
    }
	
    public function get_result() {
		// Method to get draw result from object
		$result = $this->drawResult;
		return $result;
	}


    private function fetch_data() {
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
	    
	    curl_close($ch);  // close

        $data = array(
			'html' => $content,
			'header' => $header,
            'error' => array(
                'err' => $err,
                'msg' => $errmsg
            )
		);

        // if curl error from $data['error']['err'];
        if ( $data['error']['err'] != '0' ) {
            // change success to false
            $this->success = false;
        } 
        
        $this->drawResult = $data;
        return $data;
    }
}
?>