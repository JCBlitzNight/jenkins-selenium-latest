<?php 
	session_start();
	
	if(isset($_POST['submit']))
	{
		if((isset($_POST['password']) && $_POST['password'] !=''))
		{
			$password = trim($_POST['password']);

			// Validate password strength
			$uppercase = preg_match('@[A-Z]@', $password);
			$lowercase = preg_match('@[a-z]@', $password);
			$number    = preg_match('@[0-9]@', $password);
			$specialChars = preg_match('@[^\w]@', $password);

			if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
				$errorMsg = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
			}

			$lines= file("https://raw.githubusercontent.com/danielmiessler/SecLists/master/Passwords/Common-Credentials/10-million-password-list-top-1000.txt");
			foreach ($lines as $line) {
				if($password == $line){
					$errorMsg = 'Password found in password list';
				}
			}
			if(!isset($errorMsg)){
				header('location:dashboard.php');
			}
			exit;
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login Page | | ICT32303 Practical Test</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
	
	<div class="container">
		<h1>ICT32303 Practical Test</h1>
		<?php 
			if(isset($errorMsg))
			{
				echo "<div class='error-msg'>";
				echo $errorMsg;
				echo "</div>";
				unset($errorMsg);
			}
			
			if(isset($_GET['logout']))
			{
				echo "<div class='success-msg'>";
				echo "You have successfully logout";
				echo "</div>";
			}
		?>
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
			<div class="field-container">
				<label>Password</label>
				<input type="password" name="password" required placeholder="Enter Your Password">
			</div>
			<div class="field-container">
				<button type="submit" name="submit">Login</button>
			</div>
			
		</form>
	</div>
</body>
</html>