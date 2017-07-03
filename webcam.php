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
      <img src="http://placekitten.com/g/320/261" id="photo" alt="photo" hidden/>
      <script type="text/javascript" src="cam.js"></script>
      <form action="image.php" name="uploadphoto" method="post" style="display:inline-table;" enctype="multipart/form-data">
        <input name="image" id="toto" hidden/>
        <div class="filter">
            <input type="radio" name="filter" value="snap" checked> Snapchat<br>
  			<input type="radio" name="filter" value="beer"> Beer<br>
  			<input type="radio" name="filter" value="spliff"> Spliff
        </div>
        <input type="submit" value="OK" hidden/>
      </form>
  <div class="gallery">
<?php
require("auth.php");
        echo '
    <div class="col33">
    <h1>'.$result['picture'].'</h1><br>
    <img src="./pictures/users/tde.png" /><br>
    <span>'.$data['prix'].' $</span><br>
    </div>
    ';
if (!$db = auth::connect_sql())
{
	echo "ERROR";
}
echo "HERE GEIEPFFKE";
$picture = $db->query('SELECT * FROM picture');
// if (($test = $picture->fetch()))
// {
//             $titi = $test;
// }
while ($result = $picture->fetch())
{
	echo $titi;
	echo $picture;
	print_r($result);
        echo '
    <div class="col33">
    <h1>'.$result['picture'].'</h1><br>
    <img src="./pictures/users/tde.png" /><br>
    <span>'.$data['prix'].' $</span><br>
    </div>
    ';
    $i++;
}
?>   
</div>
</body>
</html>
