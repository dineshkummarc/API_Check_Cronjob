<?php
	//Get the output
	function get_output_file(){
		$myFile = "output.txt";
		$fh = fopen($myFile, 'r');
		if(filesize($myFile) > 0){
			$myFileContents = fread($fh, filesize($myFile));
			echo $myFileContents;
		}
		fclose($fh);
	}

	//Get the min number
	function get_min_number_file(){
		$myFile = "number.txt";
		$fh = fopen($myFile, 'r');
		$myFileContents = fread($fh, filesize($myFile));
		//print_r($myFileContents);
		$myFile_array = explode("+",$myFileContents);
		fclose($fh);
		echo $myFileContents[0];
	}

	//Get the max number
	function get_max_number_file(){
		$myFile = "number.txt";
		$fh = fopen($myFile, 'r');
		$myFileContents = fread($fh, filesize($myFile));
		$myFile_array = explode("+",$myFileContents);
		fclose($fh);
		echo $myFileContents[2];
	}

	//Check if there is tokens input yet or not
	function token_input_valid(){
		$myFile = "token.txt";
		$fh = fopen($myFile, 'r');
		if (filesize($myFile) == 0 && !isset($_GET['action'])) {
			return 0;
		}else{
			header("Location: /xampp/PHP0919E/API%20check%20web/checkapi.php?action=success");
		}
		fclose($fh);
	}

	//Get the token that have been input
	function get_token_input(){
		$myFile = "token.txt";
		$fh = fopen($myFile, 'r');
		if(filesize($myFile) > 0){	
			$myFileContents = fread($fh, filesize($myFile));
			echo $myFileContents;
		}else{
			echo "";
		}
		fclose($fh);
	}

	if (!isset($_GET['action'])) {
			token_input_valid();
	}	

?>


<!DOCTYPE html>
<html>
<head>
	<title>Check API Website</title>
	<link rel="stylesheet" type="text/css" href="checkapi.css">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<script type="text/javascript">
	$(document).ready(function(){
		<?php if(isset($_GET['action'])){ ?>
			$("#start-button").attr("disabled","");
		<?php } ?>

		$("#start-button").click(function(){
			var x = $("#min_input").val();
			var y = $("#max_input").val();
			if(x == ""){
				alert("Không được để trống!");
				$("#min_input").focus();
				return false;
			}else if(y == ""){
				alert("Không được để trống!");
				$("#max_input").focus();
				return false;
			}else if(x > y || x == y){
				alert("Max must be larger than min!");
				return false;
			}else{
				return true;
			}
		});

		$("#stop-button").click(function(){
			return confirm("Bạn có muốn dừng lại?");
		});
	});
</script>
<body>
	<div id="left_column" class="column">
		<form action="start_check.php" method="POST">
			<div id="top_left_column">
				<label>MIN</label>
				<input type="number" name="min_input" id="min_input" class="number-input" min="0" max="60" required value="<?php if(isset($_GET['action'])){ get_min_number_file();	} ?>">

				<label>MAX</label>
				<input type="number" name="max_input" id="max_input" class="number-input" min="0" max="60" required value="<?php if(isset($_GET['action'])){ get_max_number_file();	} ?>">

				<button type="submit" id="start-button" name="submit" class="submit-button">START</button>

				<a href="/xampp/PHP0919E/API%20check%20web/remove.php"><button type="button" id="stop-button" class="submit-button">STOP</button></a>
			</div>

			<div id="bottom_left_column">
				<br>
				<label>Mỗi token cách nhau 1 dòng:</label><br>
				<textarea cols="90" rows="40" id="token_input" name="token_input"><?php 
					get_token_input(); ?></textarea>
			</div>
		</form>
	</div>

	<div id="right_column" class="column">
		<?php 
		if(isset($_GET['action'])){
			echo "Bắt đầu check API...<br>";
			get_output_file();	
		} ?>
	</div>

</body>
</html>