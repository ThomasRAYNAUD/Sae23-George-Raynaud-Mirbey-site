<?php
session_start();

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

if (isset($_SESSION['User'])) {
  echo "<br></br>";
  $sql2 = 'SELECT ID FROM security WHERE Login="'.$_SESSION['User'].'";';
  echo 'Welcome ' . $_SESSION['User'];
  echo "<br></br>";
}else {
  echo "<br></br>";
  echo "You are not logged in";
  $redirect_page = 'connexion.php';
  header('Location:'  .$redirect_page);
}

//$id=1;
if($id==1){
  echo "1";
  $redirect_page = 'show_admin_english.php';
  header('Location:'  .$redirect_page);
}else{
  //echo"!1";
  $redirect_page = 'show2_english.php';
  header('Location:'  .$redirect_page);
}

 ?>
