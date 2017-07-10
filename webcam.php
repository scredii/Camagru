<?php
session_start();
require("auth.php");
if (auth::isLogged() == FALSE)
{
  header('Location: index.php');
  exit();
}
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
	<meta charset="UTF-8">
  <!--<a class="power" href="http://localhost:8888/camagru/logout.php"><img class="power" src="pictures/site/power_logo.png" alt="logout"></a><br/><br/>-->
  <style type="text/css">@import url("style.css");</style>
</head>
<header>
    <?php
    include('header2.php');
    ?>
    </header>
  <body>
      <div class="menu1">
        <div class="menu2">
                <a style=" border-right : 1px solid grey;" href="/My_account.php" class="header-nav-link">Mon compte</a>
                <a href="galery.php" style=" border-right : 1px solid grey;" class="header-nav-link1">Galerie</a>
                <a href="logout.php" style=" border-right : 1px solid grey;" class="header-nav-link2">Deconnexion</a>                
        </div>
      </div>
      <div class="grandform1">
        <div class="all_form">
                      <div class="account-form1">
                          <div class="conteneur">
        <h2>Utilise ta webcam...  Ou upload ta photo !</h2>
        <!--</div>-->
                          <!--<div class="conteneur1">-->
        
        <!--<h2>Ou upload ta photo !</h2>-->
        </div>
      <video id="video"></video>
      <!--<div class="shot">-->
      <button  id="startbutton">Prendre une photo</button>
      <!--</div>-->
      <canvas id="canvas"></canvas>
      <img src="http://placekitten.com/g/320/261" id="photo" alt="photo" hidden/>
      <script type="text/javascript" src="cam.js"></script>
      <form action="image.php" name="uploadphoto" method="post"  enctype="multipart/form-data">
        <input name="image" id="toto" hidden/>
		<input type="hidden" name="MAX_FILE_SIZE" value="524288" />
        <div class="upload_photo">
		<input type="file" name="upload_photo" id="upload_photo" value="upload_photo"/>
		<label for="upload_photo">only .PNG (Max size 0.5Mo)</label>
        </div>
        <div class="filter">
		<label for="filter2">  Choisis un filtre: </label><br><br>
            <input type="radio" name="filter" value="snap" checked> Snapchat <br>
  			<input type="radio" name="filter" value="beer"> Beer <br>
  			<input type="radio" name="filter" value="spliff"> Spliff <br><br>
              <label for="filter2">  (optionnel) effet: </label><br><br>
            <input type="radio" name="filter2" value="1" > black & white <br>
        </div>
        <input type="submit" value="OK" hidden/>
      </form>
      </div>
      </div>
  <!--<div class="gallery">-->
<?php
try
{
	$db = new PDO('mysql:host=localhost;dbname=cama_base','root','root');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) 
{
    echo 'Connection failed: ' . $e->getMessage();
}
$username = $_SESSION['auth']['login']; 
$picture = $db->query('SELECT * FROM picture WHERE username = "' . $username . '" ');
while (($test = $picture->fetch()))
{
            $titi[] = $test;
}
if ($titi)
{
$i = 0;

echo 	'<div class="pupload">';
?>
<h2> Apercu</h2>
<?php
$test = fopen("pictures/users/".$titi[$i]['picture'], "r");
while($titi[$i] && $i < 4)
{
	$tof = file_get_contents("pictures/users/".$titi[$i]['picture']);
	?>
	<img width="150px" id="pupload" src="<?php echo  $tof; ?>" />
	<?php
$i++;
}
?>
			<p>
            <a  id="lost_account" href="galery.php">Voir toute la galerie</a>
			</p>	
<?php
	echo "</div>";
}


?>   
</div>
      </div>

</body>
<?php include("footer.html");
?>
</html>
