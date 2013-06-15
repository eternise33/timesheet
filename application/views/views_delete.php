<?php include('header.php'); ?>
	
	<?php
		if(isset($_POST['login'])){
			$select = $this->input->post('who');
	
		}
	?>
	
	
	
	<script>
	window.onload = function(){
		startPage();
	};
	
	function startPage(){
		document.getElementById("input").onsubmit = function(){
		
			var check = document.getElementById("choice").value == "blank";
			
			if(check){
				alert('Please select the username you want to delete');
				return false;
			}else{
				return confirm("Are you sure you want to delete User");
			}
			

			


		}
	}
	
	</script>

	
	<div class="container">
		<?php include('buttons.php'); ?>
		<div class="boxcontainer">
		<h2>Delete User</h2>
		<?php
			error_reporting(0);
			$query = $this->db->query("SELECT * FROM users ORDER BY username;");
			
			
			echo "<form id=\"input\" method = \"post\" action =\"delete_user\">";
			echo "<table class=\"deleteuser\">";
			
		
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
				echo "<input type = \"submit\" value =\"Delete User\" name = \"login\">";
				echo "</td>";
				echo "</tr>";
			
			
			echo "</table>";
			echo "</form>";
			
		?>
		</div>
		
		
		

		


	</div>