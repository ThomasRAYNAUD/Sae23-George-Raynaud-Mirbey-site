<?php
session_start();
$servername = "localhost";//on créé la connexion avec la base de données
$username = "zgeorge";
$password = 'ZA12*$za';
$dbname = "zgeorge_03";
    //créé la connexion
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    //on regarde si les valeurs du mot de passe et de l'identifiant ont été
    //entrées par l'utilisateur
    if (!empty($_POST['MDP']) and !empty($_POST['Nom'])){
    $myObj = new stdClass();
    $myObj->username = $_POST["Nom"];
    $myObj->password = $_POST["MDP"];
    $myJSON = json_encode($myObj);
    $decoded=json_decode($myJSON);
  }
    //On créé une variable qui passera à 1 si on trouve l'utilisateur précédent
    //Dans la base de données
    $found=0;
    $sql = "SELECT * FROM security";
    $result = $conn->query($sql);
    echo "<table>";
    //Si on trouve le nom d'utilisateur, on enregistre son mot de passe dans une variable
    //Cette variable va permettre de comparé si le mot de passe entré est juste ou non
    if ($result->num_rows > 0 and !empty($_POST['Nom']) and !empty($_POST['MDP'])) {
        while($row = $result->fetch_assoc()) {
            if($row["Login"]==$decoded->{"username"}){
              $found+=1;
              $motdepasse=$row["Password"];
            }
        }
        echo "</table>";
    }
   //Dans cette partie, on va regarder si le mot de passe de l'utilisateur est correct
   //et si l'utilisateur entré existe bien
   //Si le mot de passe et l'identifiant sont justes, alors on redirige sur la page principale
   //du site, sinon on affiche une erreur en fonction des résultats des tests
    if($found>0 and !empty($_POST['Nom'] and !empty($_POST['MDP']))){
      $Name=$decoded->{"username"};
      $MDP=$decoded->{"password"};
      if($MDP==$motdepasse){
        echo "Hello "."$Name";
        //On va regarder quelle langue l'utilisateur souhaite utiliser, et en
        //fonction on le redirige, si aucune langue n'est choisie on utilise le
        //francais par defaut
        echo $_POST["language"];
        if(!empty($_POST["language"])){
          if($_POST["language"]=="French"){
            $_SESSION['User'] = "$Name";
            $redirect_page = 'index.php';
            header('Location:' . $redirect_page);
            die();
          }else{
            $_SESSION['User'] = "$Name";
            $redirect_page = 'index_english.php';
            header('Location:' . $redirect_page);
            die();
          }
        }else{
          $_SESSION['User'] = "$Name";
          $redirect_page = 'index.php';
          header('Location:' . $redirect_page);
          die();
        }
  }else{
    echo "<p class=\"error\" >* Mot de passe ou nom d'utilisateur incorrect</p>";
  }
    }else if (!empty($_POST['Nom'])){
      $Name=$_POST['Nom'];
      echo "<p class=\"error\" >* Utilisateur ".$Name." introuvable, essayez de vous inscrire</p>"; //la class ne fonctionne pas encore
  }
 ?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style.css">
  <title>Carnel</title>
<link rel="icon" href="carnellogo.png">
</head>
<body>
  <script>
    //Ce script permet d'afficher le mot de passe de l'utilisateur
    var txt=document.getElementById('MDP');

    // On ajoute un evenement qui s'executera quand on cliquera
    // sur le bouton et qui executera la fonction updateBtn
    btn.addEventListener('click', updateBtn);

    // Fonction qui d'afficher le mot de passe
    function Afficher() {
      //On récupère le champ dans lequel on tape le mot de passe
      var input = document.getElementById("MDP");
      //Si le mot de passe n'est pas affiché, on change la valeur password
      //En text pour pouvoir le voir
      if (input.type === "password")
      {
        input.type = "text";
      }else{
        //Sinon on passe la valeur en password pour ne plus l'afficher
        input.type = "password";
      }
    }
  </script>
  <div class="container">
    <div class="logo">
      <img class='img' src="carnellogo.png" alt="logo de carnel">
    </div>
    <div class="carre">
      <div class="footer">
        <p class="tab-link active">Login</p>
      </div>
      <form action="connexion2.php" method="post">
        <div class="row">
          <input type="text" class="input" id="Nom" name="Nom" placeholder="Username" required>
        </div>
        <div class="row">
          <input placeholder="Password" name="MDP" ID="MDP" type="password" class="input" required>
          <br>
          <input type="checkbox" onclick="Afficher()">
        </div>
        <p>Please choose a language</p>
        <div>
          <input type="radio" id="Lang1"
           name="language" value="French">
          <label for="Lang1">French</label>

          <input type="radio" id="Lang2"
           name="language" value="English">
          <label for="Lang2">English</label>

        </div>
        <div>

        <button class="btn" type="submit">Login</button>
      </form>
    </div>
  </div>
</body>
 </html>
