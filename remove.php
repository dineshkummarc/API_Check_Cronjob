<?php
	// function remove_token_file(){
	// 	$myFile = "/home/hvn0220437/supercleaner.info/public_html/token.txt";
	// 	$fh = fopen($myFile, 'w+') or die("Can't open file.");
	// 	$token = "";
	// 	fwrite($fh, $token);
	// 	fclose($fh);
	// }

	function remove_output_file(){
		$myFile = "/home/hvn0220437/supercleaner.info/public_html/output.txt";
		$fh = fopen($myFile, 'w+') or die("Can't open file.");
		$token = "";
		fwrite($fh, $token);
		fclose($fh);
	}

	remove_output_file();
	header("Location: /checkapi.php?action=success");
?>