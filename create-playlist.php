<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
$uid = $_SESSION['uid'];
$pname = $_POST['createPlaylistName'];
$pdesc = $_POST['createPlaylistDescription'];
$mysqli = new mysqli("mysql.eecs.ku.edu", "jschreiner", "pass123", "jschreiner");
if($mysqli->connect_errno)
  {
    printf("Connection to database failed %s\n", $mysqli->connect_error);
    exit();
  }
if(!empty($pname))
  {
      $query = "INSERT INTO PLAYLISTS (u_id, name, description) VALUES ($uid, '$pname', '$pdesc')";
      echo $query;
      $mysqli->query($query);
      header('Refresh: .1; songs.php');
  }
 ?>