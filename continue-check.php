<?php

	//Set state = 1 file
	function set_state_start(){
		$myFile = "/home/hvn0220437/supercleaner.info/public_html/state.txt";
		$fh = fopen($myFile, 'w+') or die("Cannot open file");
		$myFileContents = 1;
		fwrite($fh, $myFileContents);
		fclose($fh);
		$myFile2 = "/home/hvn0220437/supercleaner.info/public_html/output.txt";
		$fh2 = fopen($myFile2, 'a') or die("Cannot append file");
		$annouce = "Bắt đầu chạy!"."<br>";
		fwrite($fh2, $annouce);
		fclose($fh2);
	}

	set_state_start();
	header("Location: /checkapi.php?action=success");
?>