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
      <video id="video"></video>
      <button id="startbutton">Prendre une photo</button>
      <canvas id="canvas"></canvas>
      <img src="http://placekitten.com/g/320/261" id="photo" alt="photo">
      <script type="text/javascript" src="cam.js"></script>
      <form action="image.php" name="uploadphoto" method="post" style="display:inline-table;" enctype="multipart/form-data">
      <input name="image" id="toto" hidden/>
      <input type="submit" value="OK" hidden/>
  </form>
</body>
</html>
