<?php include('header.php'); ?>


	<div class="container">
		<?php include('buttons.php'); ?>
		<!-- add user to the website/first form on the website-->
		<div class="boxcontainer">
		<h2 align = "center">Add Users</h2>
		<form method = "post" action ="validate_add_user">
			<table class="adduser">
			<tr ><td><label>Username:</label></td> <td><input type ="text" name ="add_username" ><?php echo form_error("add_username"); ?></td></tr>
			<tr ><td><label>First Name:</label></td> <td><input type ="text" name ="fname" ><?php echo form_error("fname"); ?></td></tr>
			<tr ><td><label>Last Name:</label></td> <td><input type ="text" name ="lname" ><?php echo form_error("lname"); ?></td></tr>
			<tr><td colspan="2"><input class="submit" type = "submit" value ="Add User" name = "login"></td></tr>
			</table>
		</form>
		</div>
		
		

		
		
		

		


	</div>


