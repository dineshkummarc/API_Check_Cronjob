<?php
	//Check if token exists or not, if not write to input file
	function check_token_input_file($token_array = array()){
		$myFile = "token.txt";
		$fh = fopen($myFile, 'r');
		$myFileContents = fread($fh, filesize($myFile));
		fclose($fh);
		echo $myFileContents;
	}

	function write_output_file($result = array()){
		$myFile = "output.txt";
		$fh = fopen($myFile, 'a') or die("Can't open file.");		
		$time = date('H:i:s');
		if($result['message_id'] != ""){
			$newOutput = "[ ".$time." ]"." Success!The message id is:".$result['message_id']."<br>";
		}else{
			$newOutput = "[ ".$time." ]"." API fail!"."<br>";
		}
		fwrite($fh, $newOutput);
		fclose($fh);
	}

	//Check if token is working or not
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
		
	//Main function
	if(isset($_POST['submit'])){
		$min = $_POST['min_input'];
		$max = $_POST['max_input'];
		$token_input = $_POST['token_input'];
		$token_array = preg_split("/\\r\\n|\\r|\\n/", $token_input);
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
		header("Location: /xampp/PHP0919E/API%20check%20web/checkapi.php?action=success");
	}else{
		echo "<p style='color:red'>ERROR 404. Cannot find the page!</p>";
	}


?>