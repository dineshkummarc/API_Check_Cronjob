<?php

	//Set state = 0 file
	function set_state_stop(){
		$myFile = "state.txt";
		$fh = fopen($myFile, 'w+') or die("Cannot open file");
		$myFileContents = 0;
		fwrite($fh, $myFileContents);
		fclose($fh);
		$myFile2 = "output.txt";
		$fh2 = fopen($myFile2, 'a') or die("Cannot append file");
		$annouce = "Đã dừng chạy!"."<br>";
		fwrite($fh2, $annouce);
		fclose($fh2);
	}

	set_state_stop();
	header("Location: checkapi.php?action=success");
?>