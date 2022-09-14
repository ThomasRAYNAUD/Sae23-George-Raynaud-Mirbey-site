<?php
$servername = "localhost";//on créé la connexion avec la base de données
$username = "zgeorge";
$password = 'ZA12*$za';
$dbname = "zgeorge_03";
$conn = mysqli_connect($servername, $username, $password, $dbname); //on ouvre la connexion
$filename = "add.json"; //on désigne le fichier json qu'on utilise
$data = file_get_contents($filename); //permet de décrypter le fichier json dans une variable
$array=json_decode($data,true); //utilise data pour le convertire en varibale php

//initialisation des varibles utilisées plus tard pour les requêtes
$informationskey="";
$informations="";
$data = "";
$datakey = "";
$vehicule = "";
$vehiculekey = "";
$deplacement = "";
$deplacementkey = "";
$groupeiut = "";
$groupeiutkey = "";
$information2="";
$groupeRT="";
$registration="";
$n=0; //numéro de l'utilisateur voulu, on utilise strval, ligne 28 car on le veut en caractère pas en entier

foreach ($array as $keyStart => $valueStart) { //tous les foreach utilisés permettent de rentrer dans le tableau et associer une clé à sa valeur ou tableau à nouveau
  if ($keyStart==strval($n)) { //si on est bien dans un utilisateur dans le json (0,1...)
    foreach ($valueStart as $key => $value) {
          foreach ($value as $keyI => $valueI) {//on rentre dans le tableau et on obtient les informations, data ...
            if($keyI=='Informations'){//si la clé trouvé c'est information alors on fait le traitement
              foreach ($valueI as $keyA => $valueA) {//on va voir ce qu'il y a dans information
                  if($keyA!='Adresses'){//si tout sauf adresse
                    $informations .= "'$valueA'" . " , ";//on met à la suite de la varible la valeur trouvé
                    $informationskey .= $keyA." , ";//pareil mais avec la clé de cette valeur
                    $information2.=$keyA."="."'$valueA'"." AND "; //dans la varible, on ajoute à la suite l'association clé et valeur pour la requête sql utilisé pour select
                  } else  { //dans l'autre cas ou la clé est "Adresses"
                    foreach ($valueA as $keyO => $valueO) { //on a un sous tableau dans ce cas
                      $informations .= "'$valueO'" . " , ";//on refait le même traitement que ligne 34-35
                      $informationskey .= $keyO." , ";
                    }
                  }
              }
            } else if ($keyI=='Data') {//dans le cas ou la clé est data
              foreach ($valueI as $keyC => $valueC) {//on rentre dans data et met les variables à la suite comme pour les clés
                  $data .= "'$valueC'" . " , ";
                  $datakey .= $keyC." , ";
              }
            } else if ($keyI=='Vehicule') {//dans le cas ou la clé est vehicule
              foreach ($valueI as $keyD => $valueD) {//même traitement que ligne45
                if ($keyD=='Registration') {//dans le cas ou la clé est registration utile comme c'est une clé, pour faire les liens
                  $vehicule .= "'$valueD'" . " , ";
                  $vehiculekey .= $keyD." , ";
                  $registration=$valueD;
                } else {
                  $vehicule .= "'$valueD'" . " , ";
                  $vehiculekey .= $keyD." , ";
                }
              }
            } else if ($keyI=='Deplacement'){//dans le cas ou la clé est deplacement
              foreach ($valueI as $keyE => $valueE) {//même traitement que ligne 45
                  $deplacement .= "'$valueE'" . " , ";
                  $deplacementkey .= $keyE." , ";

              }
            }else if ($keyI=='GroupeIUT'){//dans le cas ou la clé est groupIUT (on préfère ajouter les groupes manuellement mais on peut aussi passer par le json)
              foreach($valueI as $keyH => $valueH){//même traitement que ligne 45
                if ($keyH!='EDT') {//si on est pas dans EDT le traitement est simple
                    $groupeiut .= "'$valueH'" . " , ";
                    $groupeiutkey .= $keyH." , ";
                } else {//sinon, on a des tableaux dans tableau et encore dans tableau, il faut alors faire plusieurs foreach
                  foreach($valueH as $keyM => $valueM){
                    foreach ($valueM as $keyN => $valueN) {//même traitement que ligne 45
                        $groupeiut .= "'$valueN'" . " , ";
                        $groupeiutkey .= $keyN." , ";
                    }
                  }
                }
              }
            }
        }
    }
  }
  $n++;//incrémentation de la variable si plusieurs utilisateurs pour passer au suivant à la fin de la boucle


  //on fait les requêtes
  $informations = substr($informations,0,-2);//on enleve les 2 derniers caractères (la virgule et l'espace)
  $informationskey = substr($informationskey,0,-2);//pareil
  $sql1= "INSERT INTO Student ($informationskey) VALUES ($informations)";//requete SQL pour entrer dans la table Student
  //echo "<br>" . "<br>".$sql1;
  if (mysqli_multi_query($conn, $sql1)) {//on fait la requete et selon le résultat on dit que c'est bon ou sinon message d'erreur
    echo "New records created successfully";
  } else {
    echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
  }
 


  $vehicule = substr($vehicule,0,-2);
  $vehiculekey = substr($vehiculekey,0,-2);
  $information2 = substr($information2,0,-4);//on enlève les 4 derniers caractères car AND et espace
  $sql2bis="(SELECT ID FROM Student WHERE $information2)";//requete SELECT pour récupérer la clé ID selon le bon véhicule
  $result2 = $conn->query($sql2bis);
  if ($result2->num_rows > 0) {//on récupère l'ID voulu
    while($row = mysqli_fetch_assoc($result2)){
        $id=$row['ID'];
    }
  }



  $sql3= "INSERT INTO Vehicle ($vehiculekey,ID) VALUES ($vehicule, '$id')";//requete sql classique en mettant le bon ID (la clé)
  if (mysqli_multi_query($conn, $sql3)) {
    echo "New records created successfully";
  } else {
    echo "Error: " . $sql3 . "<br>" . mysqli_error($conn);
  }

  

  $deplacement = substr($deplacement,0,-2);
  $deplacementkey = substr($deplacementkey,0,-2);
  //echo "<br>" . $deplacement;
  //echo "<br>" . $deplacementkey;
  $sql4= "INSERT INTO Movement ($deplacementkey, Registration) VALUES ($deplacement,'$registration')";//requete classique avec la bonne plaque d'immatriculation récupéré dans une variable spécifique ligne 54
  //echo "<br>" ."<br>".$sql4;
  if (mysqli_multi_query($conn, $sql4)) {
    echo "New records created successfully";
  } else {
    echo "Error: " . $sql4 . "<br>" . mysqli_error($conn);
  }

  

  $data = substr($data,0,-2);
  $datakey = substr($datakey,0,-2);
  $sql2= "INSERT INTO Security ($datakey, ID) VALUES ($data, '$id')";//requete classique avec le bon id récupéré précédement pour être en coohérence avec les clés
  if (mysqli_multi_query($conn, $sql2)) {
    echo "New records created successfully";
  } else {
    echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
  }

  
//si on veut ajouter les groupes avec le json, il faut décommenter cette requête
  /*$groupeiut = substr($groupeiut,0,-2);
  $groupeiutkey = substr($groupeiutkey,0,-2);
  //echo "<br>" . $groupeiut;
  //echo "<br>" . $groupeiutkey;
  $sql5= "INSERT INTO GroupIUT ($groupeiutkey) VALUES ($groupeiut)";
  //echo "<br>" ."<br>".$sql5."<br><br>";
  if (mysqli_multi_query($conn, $sql5)) {
    echo "New records created successfully";
  } else {
    echo "Error: " . $sql5 . "<br>" . mysqli_error($conn);
  }*/

  
//on remet à 0 les variables pour passer à un autre utilisateur, 0->1 car on a déja fait les requêtes
  $informationskey="";
  $informations="";
  $data = "";
  $datakey = "";
  $vehicule = "";
  $vehiculekey = "";
  $deplacement = "";
  $deplacementkey = "";
  $groupeiut = "";
  $groupeiutkey = "";
  $information2="";
  $groupeRT="";
  $registration="";
}
mysqli_close($conn);//on ferme la connexion avec la base de données
?>