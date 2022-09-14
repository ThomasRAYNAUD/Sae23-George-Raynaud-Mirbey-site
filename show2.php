<?php
session_start();
?>
<!DOCTYPE html>
<html>
<title>Carnel</title>
<link rel="icon" href="carnellogo.png">
<link rel="stylesheet" href="style2.css">
<head>
</head>
<body>
  <table class="tableau">
    <tr>
        <td>
            <ul class="test">
              <li><a href="index.php">Menu</a></li>
              <li><a class="active" href="redirect.php">Voir mes trajets</a></li>
              <li><a href="covoiturage_modif.php">Chercher un trajet</a></li>
              <li><a href="deconnexion.php">Se deconnecter</a></li>
            </ul>
        </td>
    </tr>
    </table>
</body>
</html>
<?php
//On va récupérer l'ID de la session active
if (isset($_SESSION['User'])) {
  echo "<br>"."<h3>Voici les covoiturages auquels vous êtes inscrits :</h3>";
  $sql2 = 'SELECT ID FROM security WHERE Login="'.$_SESSION['User'].'";';

}
else {
  echo "Vous êtes déconnecté.";
  $redirect_page = 'connexion.php';
  header('Location:'  .$redirect_page);
}


$servername = "localhost";
$username = "toto";
$password = 'toto';
$dbname = "soutenance";
$array=array();

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

//$sql2 ='SELECT ID FROM security WHERE Login="'.$_SESSION["User"].'";';
//On exécute la requête SQL ci dessus, qui a été définie plus tot dans le code
$result2 = $conn->query($sql2);
if ($result2->num_rows > 0) {
  while($row = mysqli_fetch_assoc($result2)){
      $id=$row['ID'];
      //echo "Mon ID est ".$id;
    }
} else {
    echo "Empty Data";
}
/////////////
//On récupère l'ID, le Nom et le Prénom de tous les utilisateurs dans un array
$sql3 ='SELECT ID,Name,FirstName FROM student;';

$result3 = $conn->query($sql3);
if ($result3->num_rows > 0) {
  while($row = mysqli_fetch_assoc($result3)){
        $var=$row['ID'];
        //echo $var;
        $text=$row['FirstName']." ".$row['Name'];
        $array[$var]=$text;
    }
}
//Dans la table, 0 est utilisé pour une case vide qui ne contient pas
//de numéro d'utilisateur, on va afficher une croix à la place d'un 0
$array["0"]="X";
/////////////

if (isset($_SESSION['User'])) {
  echo "<br></br>";
  $sql2 = 'SELECT ID FROM security WHERE Login="'.$_SESSION['User'].'";';

}else{

  echo "Vous êtes déconnecté";
  $redirect_page = 'connexion.php';
  header('Location:'  .$redirect_page);
}
//on créé une requête qui va chercher toutes les lignes où l'id de l'utilisateur apparait
$sql = "SELECT * FROM movement WHERE IDTeam1=$id OR IDTeam2=$id OR IDTeam3=$id OR IDTeam4=$id;";

//Ces variables servent pour calculer le nombre de places restantes pour un covoiturage
$nbrPersonne=0;
$nbr=4;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  //Si on a un résultat on affiche un tableau
  echo "<table class='tableau'><tr class='ligne'><th class='ligneT'>Mode de déplacement</th><th class='ligneT'>But du déplacement</th><th class='ligneT'>Nombre de personne(s)</th><th class='ligneT'>Participation</th><th class='ligneT'>Personne 1</th><th class='ligneT'>Personne 2</th><th class='ligneT'>Personne 3</th><th class='ligneT'>Personne 4</th><th class='ligneT'>Se désinscrire</th></tr>";

    while($row = $result->fetch_assoc()) {
      //On calcule le nombre de places occupées
      if($row['IDTeam1']==0){
        $nbrPersonne++;
      }
      if($row['IDTeam2']==0){
        $nbrPersonne++;
      }
      if($row['IDTeam3']==0){
        $nbrPersonne++;
      }
      if($row['IDTeam4']==0){
        $nbrPersonne++;
      }
      //On obtient le nombre de personnes qui participent
      $pers=strval($nbr-$nbrPersonne)-1;
      //On affiche toutes les informations utiles et un bouton pour se désincrire d'un covoiturage
      echo "<tr class='ligne'><td class='case'>".$row['MovementType']."</td><td class='case'>".$row['MovementType']."</td><td class='case'>".$row['MovePurpose']."</td><td class='case'>".$nbrPersonne."</td><td class='case'>".$row['Participation']."</td><td class='case'>".$array[$row['IDTeam1']]."</td><td class='case'>".$array[$row['IDTeam2']]."</td><td class='case'>".$array[$row['IDTeam3']]."</td><td class='case'>".$array[$row['IDTeam4']]."</td>";
echo "<td class='case'>"."<form action=leave.php/?ID=".$row['IDMov']."&P1=".$row['IDTeam1']."&P2=".$row['IDTeam2']."&P3=".$row['IDTeam3']."&P4=".$row['IDTeam4']."\" method=\"post\">
<input type=\"submit\" name=\"login\" value=\"X\" />
</form>"."</td></tr>";
    }
} else {
  //Si il n'y a pas de résultats avec l'id de l'utilisateur
  echo "<tr><td>";
  echo "Vous n'êtes inscrit à aucun covoiturage";
  echo "</tr></td>";
}
echo "<table>";
mysqli_close($conn);
?>
