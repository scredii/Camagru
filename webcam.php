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
	<title>Camagru</title>
  <a class="tit" href="http://localhost:8888/camagru/index.php"><img class="cama" src="pictures/site/cama_log.png" alt="camagru_logo"></a><br/><br/>
  <a class="power" href="http://localhost:8888/camagru/logout.php"><img class="power" src="pictures/site/power_logo.png" alt="logout"></a><br/><br/>
  <style type="text/css">@import url("style.css");</style>
  <div class="hello"> <?php echo "hello ". $_SESSION['auth']['login'] . " !"; ?>  </div>
</head>
  <body>
	  <center>
      <video id="video"></video>
      <button id="startbutton">Prendre une photo</button>
      <canvas id="canvas"></canvas>
	  </center>
      <img src="http://placekitten.com/g/320/261" id="photo" alt="photo" hidden/>
      <script type="text/javascript" src="cam.js"></script>
      <form action="image.php" name="uploadphoto" method="post" style="display:inline-table;" enctype="multipart/form-data">
        <input name="image" id="toto" hidden/>
		<input type="hidden" name="MAX_FILE_SIZE" value="524288" />
		<label for="upload_photo">only .PNG (Max size 0.5Mo)</label>
		<input type="file" name="upload_photo" id="upload_photo" value="upload_photo"/>
        <div class="filter">
		<label for="filter">Choissisez un filtre</label>
            <input type="radio" name="filter" value="snap" checked> Snapchat<br>
  			<input type="radio" name="filter" value="beer"> Beer<br>
  			<input type="radio" name="filter" value="spliff"> Spliff <br>
            <input type="radio" name="filter2" value="1" > black & white <br>
        </div>
        <input type="submit" value="OK" hidden/>
      </form>
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
$picture = $db->query('SELECT * FROM picture');
while (($test = $picture->fetch()))
{
            $titi[] = $test;
}
$i = 1;
echo 	'<div class="pupload">';
$test = fopen("pictures/users/".$titi[$i]['picture']);
echo $test;
while($titi[$i])
{
	$tof = file_get_contents("pictures/users/".$titi[$i]['picture']);
	?>
	<img width="150px" id="pupload" src="<?php echo  $tof; ?>" />
	<?php
$i++;
}
	echo "</div>";

?>   
</div>
</body>
<?php include("footer.html");
?>
</html>
    <!--<span>'.$data['prix'].' </span><br>-->
