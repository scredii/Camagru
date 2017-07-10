<?php
session_start();
require("auth.php");

function create_page($count)
{
    if (fopen("/galery.php/".$count."", "w") == FALSE)
        echo "Probleme lors de la creation de la page";
}

if (auth::isLogged() == FALSE)
{
  header('Location: index.php');
  exit();
}
?>
<!DOCTYPE html>
<html>
	<head>
            <style type="text/css">@import url("./style.css");</style>
            <script type="text/javascript" src="alert.js"></script>
	</head>
    <header>
	<?php
		 include('header2.php');
	?>
    </header>
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
$max = $db->query('SELECT * FROM picture');
$picture = $db->query('SELECT * FROM picture LIMIT 10 OFFSET 0');
while (($test = $picture->fetch()))
{
            $titi[] = $test;
}
while (($limit = $max->fetch()))
{
            $toto[] = $limit;
}
if ($titi)
{
$i = 0;
$count = 1;
echo '<div class="pupload_gal">';
?>
<h2>La galerie</h2>
<?php
$test = fopen("pictures/users/".$titi[$i]['picture'], "r");
while($titi[$i])
{
	$tof = file_get_contents("pictures/users/".$titi[$i]['picture']);
	?>
	<img width="150px" id="pupload_gal" src="<?php echo  $tof; ?>" />
<?php
$i++;
}
	echo "</div>";
    if (sizeof($titi) < sizeof($toto))
    {
        echo "HERE";
        $count++;
        create_page($count);
        echo "<a href='galery.php/'".$count."'";
    }
}
else
    echo "La galerie est vide pour le moment !";
?>   
</div>
      </div>

</body>
<?php 
include("footer.html");
?>
</html>
