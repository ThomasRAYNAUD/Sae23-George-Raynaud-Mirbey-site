<?php
session_start();
 ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Carnel</title>
    <link rel="icon" href="carnellogo.png">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>

    <?php
    if (isset($_SESSION['User'])) {

}
else {
    echo "Je ne te connais pas...";
    $redirect_page = 'connexion.php';
    header('Location:'  .$redirect_page);
}

     ?>

     <table class="tableau">
    <tr>
        <td>
            <ul class="test">
              <li><a href="index.php">Menu</a></li>
              <li><a href="redirect.php">Voir mes trajets</a></li>
              <li><a class="active" href="covoiturage_modif.php">Chercher un trajet</a></li>
              <li><a href="deconnexion.php">Se deconnecter</a></li>
            </ul>
        </td>
    </tr>
    </table>

<br>
<div class="box2">
     <form class="test" action="covoiturage_modif.php" method="post">

       <div class="row">
       <label for="Ville1">Ville de départ</label>
       <input type="text" class="input" name="Ville1" id="Ville1">
       </div>

       <br>

       <div class="row">
       <label for="Ville2">Ville d'arrivée</label>
       <input type="text" class="input" name="Ville2" id="Ville2">
       </div>

       <br>

       <div class="row">
       <label for="Etape">Etape</label>
       <input type="text" class="input" name="Etape" id="Etape">
       </div>

       <br>

       <div class="row">
       <label for="Etape1">Etape</label>
       <input type="text" name="Etape1" id="Etape1" class="input">
       </div>
       <br>
       <div class="row">
       <label for="Etape2">Etape</label>
       <input type="text" name="Etape2" id="Etape2" class="input">
      </div>
       <br>
       <div class="row2">
       <label for="debh">Heure de départ</label>
       <input type="number" name="debh" id="debm" min=0 max=23 placeholder="H." >
       <label for="debm">h</label>
       <input type="number" name="debm" id="debm" min=0 max=59  placeholder="min.">
       </div>
       <br>
       <input type="submit" name="Chercher" value="Chercher">
     </form>
</div>
<br>
     <?php
     $servername = "localhost";//on créé la connexion avec la base de données
     $username = "zgeorge";
     $password = 'ZA12*$za';
     $dbname = "zgeorge_03";

     // Create connection

     $conn = mysqli_connect($servername, $username, $password, $dbname);
     if (!$conn) {
       die("Connection failed: " . mysqli_connect_error());
     }

     $sql = "SELECT * FROM movement";

     if (!empty($_POST['Ville1'])){
       if($sql!="SELECT * FROM movement"){
          $sql=$sql.' AND CityBeg="'.$_POST['Ville1'].'"';

        }else{
          $sql=$sql.'  WHERE CityBeg="'.$_POST['Ville1'].'"';
        }
     }

     if (!empty($_POST['Ville2'])){
       if($sql!="SELECT * FROM movement"){
          $sql=$sql.' AND CityEnd="'.$_POST['Ville2'].'"';

        }else{
          $sql=$sql.'  WHERE CityEnd="'.$_POST['Ville2'].'"';
        }
     }

     if (!empty($_POST['Etape'])){
       if($sql!="SELECT * FROM movement"){
          $sql=$sql." AND Step1=".$_POST['Etape'];

        }else{
          $sql=$sql."  WHERE Step1=".$_POST['Etape'];
        }
     }
     if (!empty($_POST['Etape2'])){
       if($sql!="SELECT * FROM movement"){
          $sql=$sql." AND Step2=".$_POST['Etape2'];

        }else{
          $sql=$sql."  WHERE Step2=".$_POST['Etape2'];
        }
     }
     if (!empty($_POST['Etape3'])){
       if($sql!="SELECT * FROM movement"){
          $sql=$sql." AND Step3=".$_POST['Etape3'];

        }else{
          $sql=$sql."  WHERE Step3=".$_POST['Etape3'];
        }
     }

     if (!empty($_POST['debh']) and !empty($_POST['debm'])){
       if($sql!="SELECT * FROM movement"){
         if($_POST['debh']<10){
           $sql=$sql." AND BegHour=0".$_POST['debh'];
         }else{
           $sql=$sql." AND BegHour=".$_POST['debh'];
         }

         if($_POST['debm']<10){
           $sql=$sql."h0  ".$_POST['debm'];
         }else{
           $sql=$sql."h".$_POST['debm'];
         }

        }else{
          if($_POST['debh']<10){
            $sql=$sql."WHERE BegHour=0".$_POST['debh'];
          }else{
            $sql=$sql."WHERE BegHour=".$_POST['debh'];
          }

          if($_POST['debm']<10){
            $sql=$sql."h0".$_POST['debm'];
          }else{
            $sql=$sql."h".$_POST['debm'];
          }
        }
     }

     $sql=$sql.";";

     //echo $sql;
$n=1;
echo "<br>";
     $result = $conn->query($sql);
     if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
             echo "<div class='result'> <h3>Trajet numéro $n</h3><i class='fa-solid fa-arrow-right'></i>";
             echo"    Ville de départ : ".$row["CityBeg"]."<br>";
             echo "<i class='fa-solid fa-arrow-right'></i>    Destination : ".$row["CityEnd"]."<br>";
             echo "<i class='fa-solid fa-arrow-right'></i>    Participation : ".$row["Participation"]."<br>";
             echo "<i class='fa-solid fa-arrow-right'></i>    Moyen de transport : ".$row["MovePurpose"];
             echo "</div>";
             $n++;
         }
     } else {
         echo "Aucun trajet";
     }


     mysqli_close($conn);
     ?>
  </body>
</html>
