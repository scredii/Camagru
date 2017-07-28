<title>Camagru</title>
<div class="nav_bar">
    <!--<div class="create_account">
		<a id="create_account" href="subscribe.php">Créer mon compte</a>
	</div>-->
	<a class="tit" href="index.php"><img class="cama" src="pictures/site/transparent_text_effect1.png" alt="camagru_logo"></a><br/><br/>
	<ul id="menu-demo2">
	<li><a href="#"><div class='welcome'><img width="30px"id="logo_head" src="pictures/site/business-person-silhouette-wearing-tie.png" />
	<?php
	session_start();
		if ($_SESSION['auth']['login'] != "")
		{
			echo "Bienvenue ".$_SESSION['auth']['login']." !</div>";
		?>
		</a>
			<ul>
				<li><a href="logout.php">Déconnexion</a></li>
				<li><a href="webcam.php">Montages</a></li>
				<li><a href="galery.php">Galerie</a></li>
			</ul></ul>
		<?php
		}
		else
		{
			?>
</a>
		<ul>
			<li><a href="subscribe.php">Subscribe</a></li>
			<li><a href="index.php">Se connecter</a></li>
			<li><a href="galery.php">Galerie</a></li>
		</ul></ul>
		<?php
		}
		?>
<!--</a>
		<ul>
			<li><a href="logout.php">Déconnexion</a></li>
			<li><a href="webcam.php">Photos</a></li>
			<li><a href="galery.php">Galerie</a></li>
		</ul></ul>-->
</div>