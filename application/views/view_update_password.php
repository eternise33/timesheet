<?php include('header.php'); ?>
	
	<!-- This will be used to update password for the user--> 
	
	<div class = "container">
		<div class="boxcontainer">
		<h2 align = "center">Update Password</h2>
			<form method = "post" action ="validate_password">
			<table class="change_password">
			<tr ><td><label>New Password:</label></td><td><input type ="password" name ="new_password" ></td></tr>
			<tr ><td><label>Verify Password:</label></td><td><input type ="password" name ="ver_password" ></td></tr>
		

			<tr><td colspan="2"><input class="submit" type = "submit" value ="Log In" name = "login"></td></tr>
			</table>
			
			<?php echo validation_errors(); ?>
		</form>
		</div>

	</div>


</html>