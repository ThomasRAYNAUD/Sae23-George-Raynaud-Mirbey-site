<?php
session_start();
?>

<!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <title>Carnel</title>
      <link rel="icon" href="carnellogo.png">
      <link rel="stylesheet" href="style2.css">
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
$servername = "localhost";
$username = "toto";
$password = 'toto';
$dbname = "soutenance";
//On créé un array qui va contenir l'id et le nom + le prenom de l'utilisateur
//Que l'on utilisera pour l'affichage
 $array=array();

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
     }
 } else {
     echo "Empty Data";
 }
/////////////

//On récupère l'ID, le nom et le prenom de tous les utilisateurs
 $sql3 ='SELECT ID,Name,FirstName FROM student;';

 $result3 = $conn->query($sql3);
 if ($result3->num_rows > 0) {
   while($row = mysqli_fetch_assoc($result3)){
         $var=$row['ID'];
         //echo $var;
         //On créé un texte qui va etre du type Prenom Nom
         $text=$row['FirstName']." ".$row['Name'];
         //On associe la clé ID au texte
         $array[$var]=$text;
     }
 }
 //Dans la table, 0 est utilisé pour une case vide qui ne contient pas
 //de numéro d'utilisateur, on va afficher une croix à la place d'un 0
$array["0"]="X";
/////////////
//On vérifie si une session est active
 if (isset($_SESSION['User'])) {
   echo "<br></br>";
   $sql2 = 'SELECT ID FROM security WHERE Login="'.$_SESSION['User'].'";';
   echo 'Vous êtes : ' . $_SESSION['User'];
   echo ". Vous avez donc des droits supplémentaires, vous pouvez visionner tous les covoiturages et les supprimer.";
   echo "<br></br>";
 }else {
   echo "<br></br>";
   echo "Vous êtes déconnecté";
   $redirect_page = 'connexion.php';
   header('Location:'  .$redirect_page);
 }
//$id=1;
//echo "ID Admin".$id;
//Si l'utilisateur est bien administrateur, on va afficher un tableau de tous les covoiturages
//Existants avec la possibilité de supprimer une ligne en cliquant sur un bouton
 if($id==1){
echo "<table class='tableau'>";
   $sql = "SELECT * FROM movement;";
   $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      echo "<tr class='ligne'><th class='ligneT'>Type de transport</th><th class='ligneT'>Type de participation</th><th class='ligneT'>Ville de départ</th><th class='ligneT'>Ville d'arrivé</th><th class='ligneT'>Heure de départ</th><th class='ligneT'>Partipant1</th><th class='ligneT'>Participant2</th><th class='ligneT'>Participant3</th><th class='ligneT'>Participant4</th><th class='ligneT'>Supprimer</th></tr>";

       while($row = $result->fetch_assoc()) {

         echo "<tr class='ligne'><td class='case'>".$row['MovementType']."</td><td class='case'>".$row['Participation']."</td><td class='case'>".$row['CityBeg']."</td><td class='case'>".$row['CityEnd']."</td><td class='case'>".$row['BegHour']."</td><td class='case'>".$array[$row['IDTeam1']]."</td><td class='case'>".$array[$row['IDTeam2']]."</td><td class='case'>".$array[$row['IDTeam3']]."</td><td class='case'>".$array[$row['IDTeam4']]."</td>";
         //le bouton de suppression se trouve en dessous
         echo "<td class='case'>";
         echo "<form action=\"delete.php/?ID=".$row["IDMov"]."\" method=\"post\">
        <input type=\"submit\" name=\"login\" value=\"X\" />
       </form></td></tr>";

       }

echo "</table>";
}
//si l'utilisateur n'est pas administrateur,on le redirige sur
// la page de visualisation utilisateur
}else{
   $redirect_page = 'show2.php';
   header('Location:'  .$redirect_page);
 }
  ?>
