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
/*
foreach($array as $key => $value){
    echo "<br></br>";
    echo $key,$value;
}*/

 if (isset($_SESSION['User'])) {
   echo "<br></br>";
   $sql2 = 'SELECT ID FROM security WHERE Login="'.$_SESSION['User'].'";';
   echo 'You are : ' . $_SESSION['User'];
   echo ". So you have additional rights, you can view all carpools and delete them.";
   echo "<br></br>";
 }else {
   echo "<br></br>";
   echo "You are not logged in";
   $redirect_page = 'connexion2.php';
   header('Location:'  .$redirect_page);
 }
//$id=1;
//echo "ID Admin".$id;
 if($id==1){
echo "<table class='tableau'>";
   $sql = "SELECT * FROM movement;";
   $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      echo "<tr class='ligne'><th class='ligneT'>Travel Type</th><th class='ligneT'>Participation</th><th class='ligneT'>City of Departure</th><th class='ligneT'>City of Arrival</th><th class='ligneT'>Hour of Departure</th><th class='ligneT'>Person1</th><th class='ligneT'>Person2</th><th class='ligneT'>Person3</th><th class='ligneT'>Person4</th><th class='ligneT'>Delete</th></tr>";

       while($row = $result->fetch_assoc()) {

         echo "<tr class='ligne'><td class='case'>".$row['MovementType']."</td><td class='case'>".$row['Participation']."</td><td class='case'>".$row['CityBeg']."</td><td class='case'>".$row['CityEnd']."</td><td class='case'>".$row['BegHour']."</td><td class='case'>".$array[$row['IDTeam1']]."</td><td class='case'>".$array[$row['IDTeam2']]."</td><td class='case'>".$array[$row['IDTeam3']]."</td><td class='case'>".$array[$row['IDTeam4']]."</td>";
           if ($id==1){
             echo "<td class='case'>";
             echo "<form action=\"http://localhost/delete_english.php/?ID=".$row["IDMov"]."\" method=\"post\">
        <input type=\"submit\" name=\"login\" value=\"X\" />
       </form></td></tr>";
           }
       }

echo "</table>";
}
}else{
   $redirect_page = 'show2_english.php';
   header('Location:'  .$redirect_page);
 }
  ?>
