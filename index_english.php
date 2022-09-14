<?php
session_start();
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Carnel</title>
  <link rel="icon" href="carnellogo.png">
  <link rel="stylesheet" href="style2.css">
</head>
<body>

<table class="tableau">
    <tr>
        <th>
                <?php
                //Si une session est active, on affiche un message de bienvenue
                //Sinon on renvoie l'utilisateur sur la page de connexion
                if (isset($_SESSION['User'])) {
                  echo "<br>"."Welcome on ";
                  echo "<p class='title'>Carnel</p>" . $_SESSION['User']." !";

                }
                else {
                  echo "Vous êtes déconnecté.";
                  $redirect_page = 'connexion.php';
                  header('Location:'  .$redirect_page);
                }
                ?>
        </th>
    </tr>
    <tr>
        <td>
            <ul class="test">
              <li><a class="active" href="index_english.php">Menu</a></li>
              <li><a href="redirect_english.php">See my Journeys</a></li>
              <li><a href="covoiturage_modif_english.php">Search a Journey</a></li>
              <li><a href="deconnexion_english.php">Sign Out</a></li>
            </ul>
        </td>
    </tr>
    <tr>
        <td>
            <div class="texte">
                <h2>Carnel</h2>
                <h3>History :</h3>
                <p>Carnel is a web application intended for internal use by students of the Networks and Telecommunications department of the IUT de Montbéliard. It was developed as part of Learning and Assessment Situation 23 by first-year students (Thomas MIRBEY, Thomas RAYNAUD and Zacharie GEORGE). </p>
                <h3>Role and usefulness :</h3>
                <p>This app allows you to organise the networking of students who are studying in the same city, who live in the same city and who travel to the same places for study, leisure or shopping. This app is not only intended for carpooling, but you can also provide information on other ways of getting around, such as bicycle or train ... </p>
                <h3>How do I get your account?</h3>
                <p>To obtain your account, you must contact an administrator at: administration@carnel.com </p>
                <p>They can add you to the list of attendees with the password you want. You will need to fill in various pieces of information that you can pass on to us.</p>
            </div>
        </td>
    </tr>
</table>
<img class="IUT" src="IUT.png" alt="">
</body>
</html>
