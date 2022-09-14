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
                  echo "<br>"."Bienvenue sur";
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
              <li><a class="active" href="index.php">Menu</a></li>
              <li><a href="redirect.php">Voir mes trajets</a></li>
              <li><a href="covoiturage_modif.php">Chercher un trajet</a></li>
              <li><a href="deconnexion.php">Se deconnecter</a></li>
            </ul>
        </td>
    </tr>
    <tr>
        <td>
            <div class="texte">
                <h2>Carnel</h2>
                <h3>Histoire :</h3>
                <p>Carnel est une application web destinée à un usage interne par les étudiants du département Réseaux et Télécommunications de l'IUT de Montbéliard. Elle a été développée dans le cadre de la Situation d'Apprentissage et d'Evaluation 23 par des étudiants en première année (Thomas MIRBEY, Thomas RAYNAUD et Zacharie GEORGE). </p>
                <h3>Rôle et utilité :</h3>
                <p>Cette application permet d'organiser la mise en contact d'étudiants qui étudient dans la même ville, qui habitent dans la même ville et qui se rendent aux mêmes endroits pour leurs études, leurs loisirs ou pour leurs courses. Cette application n'est pas seulement destinée au covoiturage, mais vous pouvez aussi y renseigner d'autres moyens de se déplacer comme par exemple le vélo ou le train ... </p>
                <h3>Comment obtenir votre compte ?</h3>
                <p>Pour obtenir votre compte, il faut contacter un administrateur à l'adresse : administration@carnel.com </p>
                <p>Ces derniers peuvent vous inscrire sur la liste des participants avec le mot de passe que vous souhaitez. Vous devrez renseigner différentes informations que vous pouvez nous transmettre.</p>
            </div>
        </td>
    </tr>
</table>
<img class="IUT" src="IUT.png" alt="">
</body>
</html>
