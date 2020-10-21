<?php
	//Get the output
	function get_output_file(){
		$myFile = "/home/hvn0220437/supercleaner.info/public_html/output.txt";
		$fh = fopen($myFile, 'r') or die("Cannot open file");
		if(filesize($myFile) > 0){
			$myFileContents = fread($fh, filesize($myFile));
			echo $myFileContents;
		}
		fclose($fh);
	}

	//Get the min number
	function get_min_number_file(){
		$myFile = "/home/hvn0220437/supercleaner.info/public_html/number.txt";
		$fh = fopen($myFile, 'r') or die("Cannot open file");
		$myFileContents = fread($fh, filesize($myFile));
		//print_r($myFileContents);
		$myFile_array = explode("+",$myFileContents);
		fclose($fh);
		echo $myFile_array[0];
	}

	//Get the max number
	function get_max_number_file(){
		$myFile = "/home/hvn0220437/supercleaner.info/public_html/number.txt";
		$fh = fopen($myFile, 'r') or die("Cannot open file");
		$myFileContents = fread($fh, filesize($myFile));
		$myFile_array = explode("+",$myFileContents);
		fclose($fh);
		echo $myFile_array[1];
	}

	//Check if there is tokens input yet or not
	function token_input_valid(){
		$myFile = "/home/hvn0220437/supercleaner.info/public_html/token.txt";
		$fh = fopen($myFile, 'r') or die("Cannot open file");
		if (filesize($myFile) == 0 && !isset($_GET['action'])) {
			return 0;
		}else{
			header("Location: /checkapi.php?action=success");
		}
		fclose($fh);
	}

	//Get the token that have been input
	function get_token_input(){
		$myFile = "/home/hvn0220437/supercleaner.info/public_html/token.txt";
		$fh = fopen($myFile, 'r') or die("Cannot open file");
		if(filesize($myFile) > 0){	
			$myFileContents = fread($fh, filesize($myFile));
			echo $myFileContents;
		}else{
			echo "";
		}
		fclose($fh);
	}

	//Check state file
	function check_state_file(){
		$myFile = "/home/hvn0220437/supercleaner.info/public_html/state.txt";
		$fh = fopen($myFile, 'r') or die("Cannot open file");
		$myFileContents = fread($fh, filesize($myFile));
		fclose($fh);
		return $myFileContents;
	}

	if (!isset($_GET['action'])) {
			token_input_valid();
	}	

?>


<!DOCTYPE html>
<html>
<head>
	<title>Check API Website</title>
	<style type="text/css">
		*{
	margin: 0px;
	padding: 0px;
}

.column{
	width: 43% !important;
	padding: 20px;
	height: 570px;
}


#left_column{
	float: left;
}

#top_left_column{
	width: 80%;
}

#bottom_left_column{
	width: 80%;
}
#right_column{
	margin-top: 85px !important;
	margin: 20px;
	float: right;
	overflow-x: hidden;
	overflow-y: auto;
	background: black;
	color: white;
	min-height: 570px !important;
}
#token_input{
	width: 130%;
}

.submit-button{
	margin-right: 5px;
	padding: 5px;
}


.number-input{
	padding: 5px;
}

@media(max-width: 1092px){
	.submit-button{
		margin-right: 2px;
		padding: 3px;
	}

	.number-input{
	padding: 3px;
	}
}

	</style>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<script type="text/javascript">
	$(document).ready(function(){
		<?php if(check_state_file() == 1){ ?>
			$("#start-button").css("display", "none");
			$("#stop-button").css("display", "inline");
		<?php }else{ ?>
			$("#start-button").css("display", "inline");
			$("#stop-button").css("display", "none");
		<?php } ?>

		function scrollToBottom (id) {
   			var div = document.getElementById(id);
   			div.scrollTop = div.scrollHeight - div.clientHeight;
		}

		scrollToBottom("right_column");

        //$("#right_column").scrollTop($("#right_column").height());

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

		$("#clear-button").click(function(){
			return confirm("Bạn có muốn xóa log?");
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
				<input type="number" name="min_input" id="min_input" class="number-input" min="0" max="60" required value="<?php  get_min_number_file(); ?>">

				<label>MAX</label>
				<input type="number" name="max_input" id="max_input" class="number-input" min="0" max="60" required value="<?php  get_max_number_file();?>">

				<a href="/continue-check.php" id="start-button"><button type="button" class="submit-button">START</button></a>

				<a href="/stop-check.php" id="stop-button"><button type="button" class="submit-button">STOP</button></a>

				<button type="submit" id="save-button" name="submit" class="submit-button">SAVE</button>

				<a href="/remove.php" id="clear-button"><button type="button" class="submit-button">CLEAR</button></a>
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
		<?php get_output_file(); ?>
	</div>

</body>
</html>