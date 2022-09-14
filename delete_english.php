<?php
session_start();
//cette page sert à supprimer une ligne de la table movement
$servername = "localhost";//on créé la connexion avec la base de données
$username = "zgeorge";
$password = 'ZA12*$za';
$dbname = "zgeorge_03";

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
      echo "ID trouvé";
    }
} else {
    echo "Empty Data";
}


if (!empty($_GET["ID"])){
  $var=$_GET["ID"];
  //On vérifie si l'utilisateur est bien administrateur avant d'exécuter la commande
  //De suppression
  if($id==1){
    echo $var;
    //Avant de supprimer les données, on va vérifier si elles existent Bien
    //Sinon on ne fait pas la requête de suppression. Une fois la suppression
    //effectué on redirige vers la page de visualisation
    $sql = "DELETE FROM movement WHERE IDMov=\"$var\";";
    $verif = mysqli_query($conn, "SELECT * FROM Movement WHERE IDMov= " . $var. ";");
    if(mysqli_num_rows($verif)) {
      echo("Deleting data for $var ... <br>");
      if (mysqli_query($conn, $sql)) {
        echo "New record deleted successfully in Movement with values $var";
        $redirect_page = 'show_admin_english.php';
        header('Location:'  .$redirect_page);
        //Dans les autres cas on redirige sur la page admninistrateur
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
    }
  }else{
    $redirect_page = 'show_admin_english.php';
    header('Location:'  .$redirect_page);
  }

}else{
  $redirect_page = 'show_admin_english.php';
  header('Location:'  .$redirect_page);
}

?>
