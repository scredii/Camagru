<?php
require("auth.php");
    //     echo '
    // <div class="col33">
    // <h1>'.$result['picture'].'</h1><br>
    // <img src="./pictures/users/tde.png" /><br>
    // <span>'.$data['prix'].' $</span><br>
    // </div>
    // ';
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
// $i = 0;
// while ($titi[$i] != NULL)
// {
//     print_r($titi[$i]['picture']);
//     $i++;
// }
// if ($result = $picture->fetch())
// {
	// echo $titi;
	// echo $picture;
	// print_r($result);
    print_r($titi);
    // echo $titi[0]['picture'];
    // $src = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $titi[0]['picture']));

    // echo'
    // <div class="col33">
    // <h1>'.$result['picture'].'</h1><br>
   echo '<img src="'.$titi[0]['picture'].'" /><br>';
    // <span>'.$data['prix'].' $</span><br>
    // </div>
    // ';
    // $i++;
// }
    header("Content-type: image/png");
    echo $src1;
?>   