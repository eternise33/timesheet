<?php include('header.php'); ?>	
	<?php 
		error_reporting(0);
		// ill be using query to check if a current login for today has already been registered
		$todays_date = date('Y-m-d') ;
		
		$username = $this->session->userdata('username');
		$this->db->where('date', $todays_date);
		$query1 = $this->db->get($username);
		foreach($query1->result() as $row1){}
		
		$time_in = $row1->clock_in;
		$lunch_out = $row1->lunch_out;
		$lunch_in =  $row1->lunch_in;
		$time_out = $row1->clock_out;
		
	?>
	
	
	

	

	
	<body>
		
		
		<div class = "container">
			<h1 class="logo"></h1>
			<div class="time_n_date">
				<div id="clockDisplay" class="clockStyle"></div>
				<hr/>
				<p><?php echo date("F d, Y"); ?></p>
			</div>
			<!-- I have used relationship between the pattern of clock_in, lunch_out, lunch_in and finally clock_out to determine wether a button should be usable--> 
		
			<!-- This is to determine if  the clock_in button should be enabled or not  -->

			<h1 class="username">Welcome <?php echo $username ?> !</h1>
			
			
			<table>
				<tr>
					<td>
					<?php 
				if($query1 ->num_rows() == 1){
					echo "<input class=\"btn_notact\" type = \"button\" disabled name = \"clock_in\" value = \"Clock In\" >";
			
				}else{
			?>
					<input class="btn_active" type = "button" name = "lunch_in" value = "Clock In" onClick="location.href='<?php echo base_url()."main/clock_in"?>'">
			<?php
				}
			?>
					</td>
					<td>
			<!-- This is to determine if  the lunch_out button should be enabled or not  -->
			
			<?php 
				if($lunch_out != NULL || $time_in == NULL){
					echo "<input class=\"btn_notact\" type = \"button\" disabled name = \"lunch_out\" value = \"Lunch Out\" >";
			
				}else{
			?>
					<input class="btn_active" type = "button" name = "lunch_out" value = "Lunch Out" onClick="location.href='<?php echo base_url()."main/lunch_out"?>'">
			<?php
				}
			?>
					</td>
					<td>
			<!-- This is to determine if  the lunch_in button should be enabled or not  -->
		
			<?php 
				if($lunch_out == NULL || $lunch_in != NULL){
					echo "<input class=\"btn_notact\" type = \"button\" disabled name = \"lunch_in\" value = \"Lunch In\" >";
			
				}else{
			?>
					<input class="btn_active" type = "button" name = "lunch_in" value = "Lunch In" onClick="location.href='<?php echo base_url()."main/lunch_in"?>'">
			<?php
				}
			?>
					</td>
					<td>
			<!-- This is to determine if  the clock_out button should be enabled or not  -->
		
			<?php 
				if($lunch_in == NULL || $time_out != NULL){
					echo "<input class=\"btn_notact\" type = \"button\" disabled name = \"clock_out\" value = \"Clock Out\" >";
			
				}else{
			?>
					<input class="btn_active" type = "button" name = "clock_out" value = "Clock Out" onClick="location.href='<?php echo base_url()."main/clock_out"?>'">
			<?php
				}
			?>
					</td>
			
			<!-- Done with the basic button functions next would be to show the data to the user-->
					
				</tr>
				<tr>
					<td><?php echo $time_in?></td>
					<td><?php echo $lunch_out?></td>
					<td><?php echo $lunch_in?></td>
					<td><?php echo $time_out?></td>
				</tr>
			</table>
			
			
			<input class="logout_btn" type = "button" name = "log_out" value = "Log Out" onClick="location.href='<?php echo base_url()."main/logout"?>'">

			

		</div>
		</div>
	</body>

</html>