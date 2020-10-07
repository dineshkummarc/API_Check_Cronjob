<?php
	function remove_token_file(){
		$myFile = "token.txt";
		$fh = fopen($myFile, 'w') or die("Can't open file.");
		$token = "";
		fwrite($fh, $token);
		fclose($fh);
	}

	function remove_output_file(){
		$myFile = "output.txt";
		$fh = fopen($myFile, 'w') or die("Can't open file.");
		$token = "";
		fwrite($fh, $token);
		fclose($fh);
	}

	function remove_number_file(){
		$myFile = "number.txt";
		$fh = fopen($myFile, 'w') or die("Can't open file.");
		$token = "";
		fwrite($fh, $token);
		fclose($fh);
	}

	remove_token_file();
	remove_output_file();
	remove_number_file();
	header("Location: /xampp/PHP0919E/API%20check%20web/checkapi.php");
?>