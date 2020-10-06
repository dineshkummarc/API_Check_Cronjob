<?php
	function send_notification($to = '',$data = array()){

		$apiKey = 'AAAA2OmKkg8:APA91bHdDFPpRvofgfUVKHVzN5M7pA7sr4FVpr_qFavg4BIZoR3SSWAuky_ykN5VXcQbNGFY10betbl1n7khxZU_ZeEaz1nY44RNFQy1rI065VF0ELT8rgCSIAX3KtCkjRK0Kf6JBy7j';
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
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result,true);
	}

		$to = "/topics/all";
		$data = array(
			'body' => 'New message'
		);
		print_r(send_notification($to,$data));
	
 ?>