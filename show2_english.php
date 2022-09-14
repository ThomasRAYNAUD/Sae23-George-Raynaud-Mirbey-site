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
              <li><a href="index_english.php">Menu</a></li>
              <li><a class="active" href="redirect_english.php">See my Journeys</a></li>
              <li><a href="covoiturage_modif_english.php">Search a Journey</a></li>
              <li><a href="deconnexion.php">Sign Out</a></li>
            </ul>
        </td>
    </tr>
    </table>
</body>
</html>
<?php
if (isset($_SESSION['User'])) {
  echo "<br>"."<h3>Here are the carpools to which you are registered :</h3>";
  $sql2 = 'SELECT ID FROM security WHERE Login="'.$_SESSION['User'].'";';
}
else {
  echo "You are not logged in.";
  $redirect_page = 'connexion2.php';
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

//$sql2 = "SELECT ID FROM Security WHERE Login=$_SESSION['User']";
$sql2 ='SELECT ID FROM security WHERE Login="'.$_SESSION["User"].'";';

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
$array["0"]="X";
/////////////

if (isset($_SESSION['User'])) {
  echo "<br></br>";
  $sql2 = 'SELECT ID FROM security WHERE Login="'.$_SESSION['User'].'";';
  //echo 'Vous êtes : ' . $_SESSION['User'];
  //echo "<br></br>";
}else{
  //echo "<br></br>";
  echo "Vous êtes déconnecté";
  $redirect_page = 'connexion2.php';
  header('Location:'  .$redirect_page);
}

$sql = "SELECT * FROM movement WHERE IDTeam1='$id' OR IDTeam2='$id' OR IDTeam3='$id' OR IDTeam4='$id';";
$nbrPersonne=0;
$nbr=4;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  echo "<table class='tableau'><tr class='ligne'><th class='ligneT'>Travel Mode</th><th class='ligneT'>Travel Goal</th><th class='ligneT'>Number of Participant(s)</th><th class='ligneT'>Participation</th><th class='ligneT'>Person1</th><th class='ligneT'>Person2</th><th class='ligneT'>Person3</th><th class='ligneT'>Person4</th><th class='ligneT'>Unsubscribe</th></tr>";

    while($row = $result->fetch_assoc()) {
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
      $pers=strval($nbr-$nbrPersonne)-1;
      echo "<tr class='ligne'><td class='case'>".$row['MovementType']."</td><td class='case'>".$row['MovementType']."</td><td class='case'>".$row['MovePurpose']."</td><td class='case'>".$nbrPersonne."</td><td class='case'>".$row['Participation']."</td><td class='case'>".$array[$row['IDTeam1']]."</td><td class='case'>".$array[$row['IDTeam2']]."</td><td class='case'>".$array[$row['IDTeam3']]."</td><td class='case'>".$array[$row['IDTeam4']]."</td>";
echo "<td class='case'>"."<form action=leave_english.php/?ID=".$row['IDMov']."&P1=".$row['IDTeam1']."&P2=".$row['IDTeam2']."&P3=".$row['IDTeam3']."&P4=".$row['IDTeam4']."\" method=\"post\">
<input type=\"submit\" name=\"login\" value=\"X\" />
</form>"."</td></tr>";
    }
} else {
  echo "<tr><td>";
  echo "You are not enrolled in any carpool";
  echo "</tr></td>";
}
echo "<table>";
mysqli_close($conn);
?>
