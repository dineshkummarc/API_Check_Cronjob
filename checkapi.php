<?php
	function get_output_file(){
		$myFile = "output.txt";
		$fh = fopen($myFile, 'r');
		$myFileContents = fread($fh, filesize($myFile));
		fclose($fh);
		echo $myFileContents;
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
		})
	});
</script>
<body>
	<div id="left_column" class="column">
		<form action="start_check.php" method="POST">
			<div id="top_left_column">
				<label>MIN</label>
				<input type="number" name="min_input" id="min_input" class="number-input" min="0" max="60" required>

				<label>MAX</label>
				<input type="number" name="max_input" id="max_input" class="number-input" min="0" max="60" required>

				<button type="submit" id="start-button" name="submit" class="submit-button">START</button>

				<button type="submit" id="stop-button" class="submit-button">STOP</button>
			</div>

			<div id="bottom_left_column">
				<br>
				<label>Mỗi token cách nhau 1 dòng:</label><br>
				<textarea cols="90" rows="40" id="token_input" name="token_input"></textarea>
			</div>
		</form>
	</div>

	<div id="right_column" class="column">
		<?php 
		if(isset($_GET['action'])){
			get_output_file();	
		} ?>
	</div>

</body>
</html>