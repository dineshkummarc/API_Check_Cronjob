<?php 
	function get_token_input(){
		$myFile = "token.txt";
		$fh = fopen($myFile, 'r');
		if(filesize($myFile) > 0){	
			$myFileContents = fread($fh, filesize($myFile));
			return $myFileContents;
		}else{
			echo "";
		}
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


?>