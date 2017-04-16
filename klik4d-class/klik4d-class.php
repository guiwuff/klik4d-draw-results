<?php
/**
*   To develop and test klik4d classes and methods
*   Standalone class ver 1.0
*   <gui.wuff@gmail.com> 16/04/2017
*   This is released standalone class
**/

class Klik4d {
	
    private $url; // url of togel site
	private $ua; // user agent for curl    
    private $fetchResult = array();
    private $success = true;
    private $xpathquery; // xpathquery
    private $drawResult = array(); // draw result in array
    private $drawJson; // encode drawResult into json
    private $jsonFile; // .json filename

    function __construct() {
        // Class construct
        $this->url = 'http://www.klik4d.com/login.aspx';
		$this->ua = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36';
        $this->jsonFile = 'klik4d-draw.json';
        $this->fetch_data();
        $this->xpathquery = '//table[@id="tblResult"]/tr';
        $result = $this->fetchResult;
        // if success fetching data
        if ( $this->success == true ) {
            $this->parse_data(); // parse data
        } else {
            // exit
            die ('Fetching data Error : '. $result['error']['msg'] );
        }
        // if success parsing data
        if ( $this->success == true ) {
            $this->data_json(); // save data to json
        } else {
            // exit
            die ('Parsing data Error : Array has no element' );
        }

    }
	
    public function get_result() {
		// Method to get draw result from jsonfile
        $file = $this->jsonFile;
        $result = json_decode(file_get_contents($file), true);
		return $result;
	}

    /**
    *   Private method to fetch data using curl
    *   Validate $this->success
    *   Update $this->fetchResult array
    *   @return nothing
    **/

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
        
        $this->fetchResult = $data;
        return;
    }

    /**
    *   Private method to parse html data using xpath
    *   Validate $this->success if array has element
    *   Update $this->drawResult array
    *   @return nothing
    **/
    private function parse_data() {
        // private method to parse data using DOMxpath
        $xpathquery = $this->xpathquery; // get xpath from construct
        $html = $this->fetchResult['html'];
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);
        $tableRows = $xpath->query($xpathquery);
        $tableData = array();
        foreach ($tableRows as $node) {
            $rowData = array();
            $i=0;
            foreach ($xpath->query('td', $node) as $cell) {
                $rowcleaned = str_replace("\xc2\xa0","", $cell->textContent);
                if ( $i == 0 ) :
                    $rowData["pool"] = $rowcleaned;
                elseif( $i == 1) :
                    $timestring = substr($rowcleaned, 0, -6);
                    $timestring = DateTime::createFromFormat('d/M/Y', $timestring); 
                    $unixtime = $this->convert_time($timestring->format('d F Y'));
                    $rowData["time"] = $unixtime;
                elseif( $i == 2 ) :
                    $rowData["result"] = $rowcleaned;
                endif;
                $i++;
            }
            $tableData[] = $rowData;
        }
        // success if $tableData has element
        if ( count($tableData > 0) ) {
            $this->drawResult = $tableData; // update placeholder    
        } else {
            $this->success = false;
        }

        return;
    }
    /**
    *   Private method to convert string into unix timestamp
    *   $timestring is required as argument
    *   @return $unixtime
    **/
    private function convert_time($timestring) {
        $unixtime = strtotime($timestring);
        // echo $timestring ." = ". $unixtime."<br>";
        return $unixtime;
    }
    /**
    *   Private method to save array into a json file
    *   Validate $this->success if json file has contents and the time signature is correct
    *   Update $this->drawJson in json formatted
    *   @return nothing
    **/

    private function data_json() {
        $updatedtime = strtotime("Now");
        $file = $this->jsonFile;
        $result = $this->drawResult;
        $stored = array(
            "lastUpdated" => $updatedtime,
            "resultsArray" => $result
        );
        $jsonres = json_encode($stored);
        // update drawJson 
        $this->drawJson = $jsonres;
        // save to .json file
        file_put_contents($file,$jsonres);
        return;
    }

}
?>