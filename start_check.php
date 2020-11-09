<?php
	
	//Set state = 1 file
	function set_state_start(){
		$myFile = "state.txt";
		$fh = fopen($myFile, 'w+') or die("Cannot open file");
		$myFileContents = 1;
		fwrite($fh, $myFileContents);
		fclose($fh);
		$myFile2 = "output.txt";
		$fh2 = fopen($myFile2, 'a') or die("Cannot append file");
		$annouce = "Bắt đầu chạy!"."<br>";
		fwrite($fh2, $annouce);
		fclose($fh2);
	}

	//Write input file
	function write_token_file($token){
		$myFile = "token.txt";
		$fh = fopen($myFile, 'w+') or die("Cannot write token file");
		fwrite($fh, $token);
		fclose($fh);
	}

	//Erase min max file first
	function reset_number_file(){
		$myFile = "number.txt";
		$fh = fopen($myFile, 'w+') or die("Cannot write number file");
		$new = "";
		fwrite($fh, $new);
		fclose($fh);
	}

	//Write min max file
	function write_number_file($number){
		$myFile = "number.txt";
		$fh = fopen($myFile, 'a') or die("Cannot write number file");
		fwrite($fh, $number);
		fclose($fh);
	}

	//Write to output file
	function write_output_file($result = array()){
		$myFile= "output.txt";
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
		reset_number_file();
		$min = $_POST['min_input'];
		$max = $_POST['max_input'];
		$token_input = $_POST['token_input'];
		write_number_file($min);
		$delimeter = "+";
		write_number_file($delimeter);
		write_number_file($max);
		write_token_file($token_input);
		header("Location: checkapi.php?action=success");
	}else{
		echo "<p style='color:red'>ERROR 404. Cannot find the page!</p>";
	}


?>