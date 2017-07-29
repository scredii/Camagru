<?php
session_start();
require("auth.php");
include('config/database.php')
?>
<!DOCTYPE html>
<html>
	<head>
			<meta charset="utf-8"/>
            <style type="text/css">@import url("./style.css");</style>
            <script type="text/javascript" src="alert.js"></script>
	</head>
    <header>
	<?php
		 include('header2.php');
	?>
    </header>
	<body>
<?php
$db = auth::connect_sql();
$PicturePerPage = 4;
$nbrPicture_total = $db->query('SELECT COUNT(*) FROM picture');
while (($test = $nbrPicture_total->fetch()))
{
            $retour_total = $test;
}
$picture = $db->query('SELECT * FROM picture');
while (($test = $picture->fetch()))
{
            $donnees_total[] = $test;
}
$nombreDePages = ceil($retour_total[0]/$PicturePerPage);
if (isset($_GET['page']))
{
     $pageActuelle = intval($_GET['page']);
     if ($pageActuelle > $nombreDePages)
          $pageActuelle = $nombreDePages;
}
else
	$pageActuelle = 1;
$premiereEntree = ($pageActuelle - 1) * $PicturePerPage;
$retour_messages = $db->query('SELECT * FROM picture ORDER BY id DESC LIMIT '.$premiereEntree.', '. $PicturePerPage .'');
echo 	'<div class="title_gal3" ><center><h2>La Galerie</h2></center></div>
		<div class="pupload1" align="center">';
echo "<div class='testdiv'>";
while ($donnees_messages = $retour_messages->fetch())
{
	$ret = $donnees_messages["id"];
	$retour_comm = $db->query('SELECT comments, id_picture, username, date_comm FROM comments  WHERE  id_picture = "' . $ret . '" ORDER BY date_comm DESC');
	while ($tqi = $retour_comm->fetch())
		$commentqi[] = $tqi;
	$tof = file_get_contents("pictures/users/".$donnees_messages['picture']);
	echo '<center><div id="scroll-content" class="grandform2">
			<div align="center" class="all_form2">
			<div align="center" class="account-form2">
			<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">';
	$i = 0;
?>
		<div class="les_comm" style="clear:both;">
<?php
	if ($commentqi)
	{
		while ($commentqi[$i])
		{	
?>
			<div class="author" style="clear:both;">
			<?php 
				echo "<strong>".$commentqi[$i]['username']." </strong>";
				?>
				<div class="msg"> 
					<?php
						echo htmlspecialchars($commentqi[$i]['comments']); 
?>
					<div class="date_comm" style="clear:both;">
					<?php 
					$date = date_create($commentqi[$i]['date_comm']);
					echo date_format($date, 'd F, H:i'); ?>
				</div>
			</div>
		</div>
<?php
			$i++;
		}
	}
	else
		echo "<div class='author'>Pas encore de commentaire</div>";
?>
</div>
<?php
$url = $_SERVER['REQUEST_URI'];
?>
	<td><div class="ret_pic"><img width="320px" height="240px" id="pupload1" src="<?php echo  $tof ?>" />

	<div class="welcome"> Posté par: <?php echo nl2br(stripslashes($donnees_messages['username'])) ?></div>
	<div class="likes">
		<?php
			$id_pic = $donnees_messages['id'];
			if (auth::is_like($donnees_messages) == FALSE)
			{
				$nbr_like = auth::count_like($donnees_messages);
				?>
				<div class="count_like"><?php echo "(".$nbr_like.")" ?> </div>			
				<form id="monForm2" method="POST" action="like.php">
					<input type="hidden" value="<?php echo $id_pic ?>" name="id_pic"/>
					<input type="hidden" value="<?php echo $url ?>" name="url_actual"/>
					<button type="submit" name="submit" Value="OK"/></button>
				</form></div>
					<?php
			}
			else
			{
				$nbr_like = auth::count_like($donnees_messages);
				?>
				<div class="count_like"><?php echo "(".$nbr_like.")" ?> </div>
				<form id="monForm3" method="POST" action="unlike.php">
					<input type="hidden" value="<?php echo $id_pic ?>" name="id_pic"/>
					<input type="hidden" value="<?php echo $url ?>" name="url_actual"/>
					<button type="submit" name="submit" Value="OK"/></button>
				</form></div>
				<?php
			}
	if ($donnees_messages['username'] == $_SESSION['auth']['login'])
	{
		?>
		<form id="monForm" method="POST" action="del.php">
			<input type="hidden" value="<?php echo $url ?>" name="url_actual"/>
			<input type="hidden" value="<?php echo $donnees_messages[0] ?>" name="id_photo"/>
			<button type="submit" name="submit" Value="OK"/></button>
		</form>
		<?php
	}
	?>
	</td>
	</form>

	</tr>

	</table>
			<div class="form_com">
                <form method="POST" action="comments.php">
				<input type="hidden" value="<?php echo $donnees_messages[0] ?>" name="id_photo"/>
				<input type="hidden" value="<?php echo $donnees_messages['username'] ?>" name="user_photo"/>												
				<input type="hidden" value="<?php echo $url ?>" name="url_actual"/>
				<input type="hidden" value="<?php echo  $_SESSION['auth']['login'] ?>" name="username"/>
						<textarea name="comments" id="comments"  rows="2" cols="200" style="width:500px;" placeholder="Votre commentaire..."></textarea>
                        <br/>
                        <br/>
                            <input type="submit" id="submit"  name="submit" value="OK">
                </form>
				</div>
            </div>
	<br/><br/>
		</center>
		<?php
$commentqi = array();
}
echo "</div>";
echo '<p align="center">Page : ';
$i = 1;
while ($i <= $nombreDePages)
{
	if ($i == $pageActuelle)
	{
		echo ' [ '.$i.' ] '; 
	}
	else
	{
		echo ' <a href="galery.php?page='.$i.'">'.$i.'</a> ';
	}
	$i++;
}
echo "</div>";
echo '</p>';
?>
</body>
<footer>
<?php
	include("footer.html");
?>
</footer>
</html>