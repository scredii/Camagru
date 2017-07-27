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
<style type="text/css">@import url("style.css");</style>
</head>
<header>
    <?php
    include('header2.php');
    ?>
    </header>
  <body>
      <div class="title_gal3" >
        <center>
            <h2>Prendre des photos</h2>
        </center>
     </div>
    <div class="grandform1">
        <div class="all_form_4">
                      <div class="account-form1">
                          <div class="conteneur">
        <h2>Utilise ta webcam...  Ou upload ta photo !</h2>
        </div>
      <video id="video"></video>
      <button  id="startbutton" disabled="disabled">Prendre une photo</button>
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
            <input type="radio" name="filter" value="snap" onclick="document.getElementById('startbutton').disabled=false"> Snapchat <br>
  			<input type="radio" name="filter" value="beer" onclick="document.getElementById('startbutton').disabled=false"> Beer <br>
  			<input type="radio" name="filter" value="spliff" onclick="document.getElementById('startbutton').disabled=false"> Spliff <br><br>
            <label for="filter2">  (optionnel) effet: </label><br><br>
            <input type="radio" name="filter2" value="1" > black & white <br>
        </div>
        <input type="submit" value="OK" hidden/>
      </form>
      </div>
      </div>
<?php
$db = auth::connect_sql();
$username = $_SESSION['auth']['login']; 
$picture = $db->query('SELECT * FROM picture WHERE username = "' . $username . '"ORDER BY id DESC');
while (($test = $picture->fetch()))
{
    $titi[] = $test;
}
if ($titi)
{
    $i = 0;

    echo 	'<div class="pupload">';
    ?>
    <h2>Apercu de la galerie</h2>
    <?php
    $test = fopen("pictures/users/".$titi[$i]['picture'], "r");
    while($titi[$i] && $i < 4)
    {
        $tof = file_get_contents("pictures/users/".$titi[$i]['picture']);
        ?>
        <img width="150px" height="113px" id="pupload" src="<?php echo  $tof; ?>" />
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
