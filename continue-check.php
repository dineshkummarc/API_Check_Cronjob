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

	set_state_start();
	header("Location: checkapi.php?action=success");
?>