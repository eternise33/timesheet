	window.onload = function(){
		startPage();
	}; 
	
	function startPage(){
		document.getElementById("submit").onsubmit = function(){
			var username = document.getElementById("username").value;
			username = username.trim;
			var password = document.getElementById("password").value;
			password = password.trim;
			var username_count = document.getElementById("username").value.length;
			var password_count = document.getElementById("password").value.length;
			
			
			if(username == "" && password == ""){
				alert("Please enter your Username and Password");
				return false
			}else if(username == ""){
				alert("Please enter your Username");
				return false;
			}else if (password == ""){
				alert("Please enter your Password");
				return false
			}else{
				if(username_count < 5 || username_count > 10){
					alert("Username should be at least 5 to 10 Characters Long");
					return false;
				}else if(password_count < 6){
					alert("Invalid Password. Minimum of 6 characters");
				}else{
					return true
				}


			}

		}
	}