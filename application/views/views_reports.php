<?php include('header.php'); ?>
	<body>
		  <div class="container">
		  <?php include('buttons.php'); ?>
		  <div class="boxcontainer">
				    <h2>Reports</h2>
<?php
	error_reporting(0);
	$query = $this->db->query("SELECT * FROM users ORDER BY username;");
	

	// This part would be use to generate reports for specific dates

	echo form_open('');
	echo "<table class=\"view_reports\">";
		echo "<tr>";
			echo "<td><label>From:</label></td>";
			echo "<td><input type = \"text\" name = \"from\"  id =\"datepicker1\"   /></td>";
			echo "<td>";
			echo form_error("set_day1");
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td><label>To:</label></td>";
			echo "<td><input type = \"text\" name = \"to\" id =\"datepicker2\"   /></td>";
			echo "<td>";
			echo form_error("set_day2");
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td><label>For:</label></td>";
			echo "<td colspan=\"2\">";
			echo "<select name=\"who\">";
				echo "<option value=\"all\">All</option>";
				foreach($query->result() as $row){
					if($row->username == "admin"){
					
					}else{
						echo "<option value= $row->username> $row->username </option>";
					}
				}
			echo "</select>";
			echo "</td>";

		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan=\"3\">";
				echo "<input class=\"submit\" type = \"submit\"  name= \"generate\" class = \"loginBut2_small\" >";
			echo "</td>";
		echo "</tr>";
		

	
	echo "</table>";
		  ?>
				    
		  </div>
	
	<?php
	echo form_close();



	if (isset($_POST['generate'])){
		// after pressing the submit button then data will be generated on the lower portion of the screen
		


		
		
		// next would be to do a range query using the data found from the database
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$who = $this->input->post('who');
		
		
		
		echo "<table class=\"dtr\">";
				    echo "<tr><th>Name</th> <th>Date</th> <th>Time-in</th> <th>Lunch-out</th> <th>Lunch-in</th> <th>Time-out</th></tr>";
		
		if($who == "all"){
		
		}else{
			$query1 = $this->db->query("SELECT * FROM $who where date between '$from' and '$to' ORDER by date;");
			foreach($query1->result() as $row1){
			echo "<tr>";
		                echo "<td>";
				    echo $who;
				echo "</td>";
				echo "<td>";
					echo $row1->date;
				echo "</td>";
			
				echo "<td>";
					echo $row1->clock_in;
				echo "</td>";
			
				echo "<td>";
					echo $row1->lunch_out;
				echo "</td>";
					
				echo "<td>";
					echo $row1->lunch_in;
				echo "</td>";
				
				echo "<td>";
					echo $row1->clock_out;
				echo "</td>";
			echo "</tr>";
			}
		}
		
		
		  echo "<button class=\"export_btn\">Export</button>";
		echo "</table>";
		
		

	}




?>
		  
</div>
<script>
		  $(document).ready(function() {
			$("#datepicker1,#datepicker2 ").datepicker({
				changeYear: true,
				changeMonth: true,
				dateFormat: 'yy-mm-d' 				
			})

	});
	
	
</script>