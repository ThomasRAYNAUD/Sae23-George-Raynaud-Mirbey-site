<?php
session_start();
function unlog(){
  session_destroy(); }
  unlog();
 ?>


<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Carnel</title>
    <link rel="icon" href="carnellogo.png">
    <img class='img' src="carnellogo.png" alt="logo de carnel">
  </head>
  <form class="test" action="deconnexion.php" method="post">
    <br>
    <input type="submit" name="Sign Out" value="Sign Out" onclick=unlog()>
  </form>
    <?php
    $redirect_page = 'connexion2.php';
    header('Location:'  .$redirect_page);
     ?>

  </body>
</html>
