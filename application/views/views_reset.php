<?php include('header.php'); ?>
	

	
	
	
	<script>
	window.onload = function(){
		startPage();
	};
	
	function startPage(){
		document.getElementById("input").onsubmit = function(){
		
		var check = document.getElementById("choice").value == "blank";
		
			if(check){
				alert('Please select the username you want to reset');
				return false;
			}else{
				return confirm("Are you sure you want to reset the User's Password?");
			}
			

			


		}
	}
	
	</script>

	
	<div class="container">
		<?php include('buttons.php'); ?>
		<div class="boxcontainer">
		<h2>Reset Password</h2>
		<?php
			error_reporting(0);
			$query = $this->db->query("SELECT * FROM users ORDER BY username;");
			
			
			echo "<form id=\"input\" method = \"post\" action =\"reset_password\">";
			echo "<table class=\"resetpassword\">";
			
		
				echo "<tr>";
				echo "<td>";
					echo "<select name=\"who\" id=\"choice\">";
					echo "<option value=\"blank\"></option>";
					foreach($query->result() as $row){
						if($row->username == "admin"){
					
						}else{
							echo "<option value= $row->username> $row->username </option>";
						}
					}
				echo "</td>";
				echo "<td>";
				echo "<input type = \"submit\" value =\"Reset Password\" name = \"login\">";
				echo "</td>";
				echo "</tr>";
			
			
			echo "</table>";
			echo "</form>";
			
		?>
		</div>
		
		
		

		


	</div>