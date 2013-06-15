<?php include('header.php'); ?>
	
	<div class = "container">
		<div class="login_box">
			<h1 align = "center">Timesheet Login</h1>
			
			<?php
				echo form_open('main/validate_login');
			?>
			
				<table class="login" align="center">
					
				<tr><td>Username:</td><td><input type ="text" name ="username" id="username" autofocus>	
				<?php echo form_error("username"); ?></td></tr>
				
				<tr><td>Password:</td><td><input type ="password" name ="password" id="password">
				<?php echo form_error("password"); ?></td></tr>
				
				<tr><td colspan="2"><input class="submit" type = "submit" value ="Log In" name = "login"></td></tr>
				</table>
			</form>
		</div>	




		
		<div id = "error_message">
		
		</div>
	</div>


</html>