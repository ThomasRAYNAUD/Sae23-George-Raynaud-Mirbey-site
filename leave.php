<?php
session_start();
//cette page permet de se désinscire d'un covoiturage
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

//On récupère l'id de l'utilisateur actif
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

//On va récupérer les 5 élements envoyés par la page précédente
//Soit l'id du conducteur et l'id des 4 personnes qui participent
//On va regarder pour chaque variable si cet ID est égal à l'id de l'utilisateur actif
//Si oui on remplace cette valeur par un 0
$var=$_GET["ID"];
if ($id==$var){
    $var="0";
}

$p1=$_GET["P1"];
if ($id==$p1){
    $p1="0";
}

$p2=$_GET["P2"];
if ($id==$p2){
    $p2="0";
  }

$p3=$_GET["P3"];
if ($id==$p3){
    $p3="0";
}

$p4=$_GET["P4"];
$p4=substr($p4,0,-1);
echo $p4;
if ($id==$p4){
    $p4="0";
    echo "True";
}

$sql = "UPDATE movement SET IDTeam1 = $p1,IDTeam2 = $p2,IDTeam3 = $p3,IDTeam4 = $p4 WHERE IDmov=\"$var\";";

$verif = mysqli_query($conn, "SELECT * FROM movement WHERE IDMov= " . $var. ";");
if(mysqli_num_rows($verif)) {
  echo("Deleting data for $var ... <br>");
  if (mysqli_query($conn, $sql)) {
    echo "Entry deleted successfully in movement with values $var";
    $redirect_page = 'show2.php';
    header('Location:'  .$redirect_page);
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}


?>
