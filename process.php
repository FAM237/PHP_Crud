<?php

session_start();

// $mysqli =  new mysqli( 'localhost', 'root','crud','')
//  or die (mysqli_error($mysqli)); 
$user = "root";
$mdp = "";
$bd = "php_crud";
$serveur = "localhost";

$link = mysqli_connect($serveur, $user, $mdp, $bd);

$id = 0;
$result = '';
$update = false;
$name = '';
$location = '';

if ($link) {
  //echo "connexion etablit";

} else {
  die(mysqli_connect_error());
}
//bout de code qui permet d'afficher le contenu de la Base de donne a l'ecran
if (isset($_POST['save'])) {
  $name = $_POST['name'];
  $location = $_POST['location'];
  $link->query("INSERT INTO data (name,location) VALUES ('$name','$location')") or
    die($link->error);
  $_SESSION['message'] = "record has been saved!";
  $_SESSION['msg_type'] = "success";

  header("location: index.php");
}

// bout de code qui permet de supprimer les lignes dans la base de donnee
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  // die($id);
  $link->query("DELETE FROM data WHERE id= $id") or die($link->error);
  $_SESSION['message'] = "record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location: index.php");
}

// bout de code qui permet de modifier le contenu dans la base de donnee
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $update = true;
  $result = $link->query("SELECT * FROM data WHERE id= $id") or die($link->error);
  // var_ dump($result->num_rows);
  if ($result->num_rows == 1) {
    $row = $result->fetch_array();
    $id = $row['id'];
    // $location = $row['location'];
    header('location: index.php?id='.$id.'&update=true');


  }
}

if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $location = $_POST['location'];

  $link->query("UPDATE data SET name='$name', location='$location' WHERE id= $id") or die($link->error);

  $_SESSION['message'] = "Record has been updated successfully!";
  $_SESSION['msg_type'] = "warning";

  header('location: index.php');

}
?>