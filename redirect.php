<?php
session_start();
//Cette page a pour but de rediriger l'utilisateur vers une page de visualisation
//Des covoiturages, si il est administrateur, il sera redirigé sur une page
//Différente
$servername = "localhost";
$username = "toto";
$password = 'toto';
$dbname = "soutenance";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

//On récupère l'ID de l'utilisateur dans une variable
$sql2 ='SELECT ID FROM security WHERE Login="'.$_SESSION["User"].'";';

$result2 = $conn->query($sql2);
if ($result2->num_rows > 0) {
  while($row = mysqli_fetch_assoc($result2)){
      $id=$row['ID'];
      echo "Mon ID est ".$id;
    }
} else {
    echo "Empty Data";
}

//On regarde si une session est active ou non, si ce n'est pas le cas on
//Redirige sur la page de connexion
if (isset($_SESSION['User'])) {
  echo "<br></br>";

  echo 'Bonjour ' . $_SESSION['User'];
  echo "<br></br>";
}else {
  echo "<br></br>";
  echo "Vous êtes déconnecté";
  $redirect_page = 'connexion.php';
  header('Location:'  .$redirect_page);
}

//On regarde si l'id de l'utilisateur est celui de l'administrateur, on redirige
//Sur la page appropriée
if($id==1){
  echo "1";
  $redirect_page = 'show_admin.php';
  header('Location:'  .$redirect_page);
}else{
  //echo"!1";
  $redirect_page = 'show2.php';
  header('Location:'  .$redirect_page);
}

 ?>
