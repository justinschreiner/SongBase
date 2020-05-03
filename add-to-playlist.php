<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
$pid = $_POST['check_list'];
$sid = $_POST['sid'];
$mysqli = new mysqli("mysql.eecs.ku.edu", "jschreiner", "pass123", "jschreiner");
if ($mysqli->connect_errno) {
  printf("Connection to database failed %s\n", $mysqli->connect_error);
  exit();
}
if (!empty($pid)) {
  foreach ($pid as $selected) {
    $query = "INSERT INTO ISIN (s_id, p_id) VALUES ('$sid', $selected)";
    echo $query . "<br>";
    $mysqli->query($query);
  }
  header('Refresh: 0; songs.php');
}
