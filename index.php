<!DOCTYPE html>
<html>
	<head>
			<meta charset="utf-8"/>
			<style type="text/css">@import url("./style.css");</style>
			<script type="text/javascript" src="alert.js"></script>
	</head>
	<header>
	<?php
		 include('header1.php');
	?>
	</header>
	<body>
		<div class="grandform">
			<div align="center" class="all_form">
				<div class="account-form">
					<h2>Se connecter</h2>
				<form method="POST" action="camagru.php">
						<input type="text" id="username" name="login" placeholder="Login"/>
						<br>
						<br/>
						<input type="password" id="password" name="passwd" placeholder="Password"/>
						<br>
						<br/>
						<br>
						<br/>
							<input type="submit" id="submit"  name="submit" value="OK">
				</form>
			</div>
			<div class"extraform">
			<p>
			<a id="lost_account" href="lost.php">Mot de passe oublié ?</a>
			</p>				
			</div>
			</div>
            <br>
    </body>
    <footer>
    <div class="forty">
<img class="logofor" src="pictures/site/42_logo.png" alt="42_logo" align="bottom">
</div>
</footer>
</html>