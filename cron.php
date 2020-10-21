<?php 
	//Check state file
	function check_state_file(){
		$myFile = "/home/hvn0220437/supercleaner.info/public_html/state.txt";
		$fh = fopen($myFile, 'r') or die("Cannot open file");
		$myFileContents = fread($fh, filesize($myFile));
		fclose($fh);
		return $myFileContents;
	}

	//Write to time file
	function write_time_file($wait){
		$myFile= "/home/hvn0220437/supercleaner.info/public_html/time.txt";
		$fh = fopen($myFile, 'w+') or die("Cannot write time file");		
		$doneTime = date('d')*24*60*60+date('H')*60*60 + date('i')*60 + date('s');
		$newOutput = $doneTime."+".$wait;
		fwrite($fh, $newOutput);
		fclose($fh);
	}

	function get_time_file(){
		$myFile = "/home/hvn0220437/supercleaner.info/public_html/time.txt";
		$fh = fopen($myFile, 'r') or die("Cannot open file");
		$myFileContents = fread($fh, filesize($myFile));
		//print_r($myFileContents);
		$myFile_array = explode("+",$myFileContents);
		fclose($fh);
		return $myFile_array[0];
	}

	function get_wait_time_file(){
		$myFile = "/home/hvn0220437/supercleaner.info/public_html/time.txt";
		$fh = fopen($myFile, 'r') or die("Cannot open file");
		$myFileContents = fread($fh, filesize($myFile));
		//print_r($myFileContents);
		$myFile_array = explode("+",$myFileContents);
		//print_r($myFile_array);
		fclose($fh);
		return $myFile_array[1];
	}

	function get_min_number_file(){
		$myFile = "/home/hvn0220437/supercleaner.info/public_html/number.txt";
		$fh = fopen($myFile, 'r') or die("Cannot open file");
		$myFileContents = fread($fh, filesize($myFile));
		//print_r($myFileContents);
		$myFile_array = explode("+",$myFileContents);
		fclose($fh);
		return $myFileContents[0];
	}

	//Get the max number
	function get_max_number_file(){
		$myFile = "/home/hvn0220437/supercleaner.info/public_html/number.txt";
		$fh = fopen($myFile, 'r') or die("Cannot open file");
		$myFileContents = fread($fh, filesize($myFile));
		$myFile_array = explode("+",$myFileContents);
		fclose($fh);
		return $myFileContents[2];
	}

	function get_token_input(){
		$myFile = "/home/hvn0220437/supercleaner.info/public_html/token.txt";
		$fh = fopen($myFile, 'r');
		if(filesize($myFile) > 0){	
			$myFileContents = fread($fh, filesize($myFile));
			return $myFileContents;
		}else{
			echo "";
		}
		fclose($fh);
	}

	//Write to output file
	function write_output_file($result = array()){
		$myFile= "/home/hvn0220437/supercleaner.info/public_html/output.txt";
		$fh = fopen($myFile, 'a') or die("Cannot append output file");		
		$time = date('H:i:s');
		if($result['message_id'] != ""){
			$newOutput = "[ ".$time." ]"." Success!The message id is:".$result['message_id']."<br>";
		}else{
			$newOutput = "[ ".$time." ]"." API fail!"."<br>";
		}
		fwrite($fh, $newOutput);
		fclose($fh);
	}

	//Write to output file
	function write_time_output_file($wait){
		$myFile= "/home/hvn0220437/supercleaner.info/public_html/output.txt";
		$fh = fopen($myFile, 'a') or die("Cannot append output file");		
		$time = date('H:i:s');
		$newOutput = "[ ".$time." ]"." Tạm dừng. Lần tiếp theo sau ".$wait." phút<br>";
		fwrite($fh, $newOutput);
		fclose($fh);
	}

	function send_notification($to = '',$data = array(),$apiKey = ''){

		$fields = array('to' => $to, 'notification' => $data);

		$headers = array('Authorization: Bearer '.$apiKey,'Content-Type: application/json');

		$url = 'https://fcm.googleapis.com/fcm/send';
		
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL,$url);
		curl_setopt( $ch,CURLOPT_POST,true);
		curl_setopt( $ch,CURLOPT_HTTPHEADER,$headers);
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER,true);

		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($fields));
		$resultAPI = curl_exec($ch);
		curl_close($ch);
		return json_decode($resultAPI,true);
	}

	$currentTime = date('d')*24*60*60+date('H')*60*60 + date('i')*60 + date('s');
	$previousTime = get_time_file();
	$previousWait = get_wait_time_file();
	if (check_state_file() == 1) {
		if(($currentTime - $previousTime) >= $previousWait*60){
			$token=get_token_input();
			$token_array = preg_split("/\\r\\n|\\r|\\n/", $token);
			$i = 0;
			for($i == 0; $i < count($token_array); $i++){
				if($token_array[$i] != ""){
					//echo $token_array[$i]."<br>";
					$to = "/topics/all";
					$data = array(
					'body' => 'New message'
					);
					$apiKey = $token_array[$i];
					$result = send_notification($to,$data,$apiKey);
					write_output_file($result);
				}	
			}
    		$min = get_min_number_file();
    		$max = get_max_number_file();
    		$wait = rand($min,$max);
    		write_time_output_file($wait);
    		write_time_file($wait);
    	
		}	
	}
	
?>