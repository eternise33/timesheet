<?php include('header.php'); ?>
	<?php error_reporting(0); ?>
	<body style="background-color: #fff;">
	<!-- 
		Main Admin Page. I will be showing daily log in reports upon login and will create a button for adding users :-)		
	-->
	
	<div class = "container">
		<?php include('buttons.php'); ?>
		<?php 
			error_reporting(0);
			$datenow = date("F d, Y");
			$todays_date = date('Y-m-d') ;
			
			echo "<p><b> $datenow </b></p>";
			
			// first would be to query the users table which list everyones usernames. I have used the usernames to generate there tables
			$query = $this->db->query("SELECT * FROM users ORDER BY username;");
		?>
		<table class="dtr">
			<tr>
				<th>Name</th> <th>Time-in</th> <th>Lunch-out</th> <th>Lunch-in</th> <th>Time-out</th>
			</tr>
		<?php
			foreach ($query->result() as $row){
				// next would be to use a loop to check all the tables on this particular date :-)
				$tablename = $row->username;
				if($tablename == "admin"){
					
				}else{
					$this->db->where('date', $todays_date);
					$result1 = $this->db->get($tablename);
					
					
					echo "<tr>";
					echo "<td>";
						echo $row->username;
					echo "</td>";
					
					foreach($result1->result() as $row1){
					
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

			
			}

			

		?>
		</table>
		
		<button class="export_btn">Export</button>
		
		
		
		
		
		
		
		
		

	</div>

</body>
</html>