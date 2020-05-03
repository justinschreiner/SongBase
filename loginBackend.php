<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$mysqli = new mysqli("mysql.eecs.ku.edu", "jschreiner", "pass123", "jschreiner");
if ($mysqli->connect_errno) {
  printf("Connection to database failed %s\n", $mysqli->connect_error);
  exit();
}
if (empty($username) || empty($password)) {

  echo "Fields cannot be empty\n";
  header('Refresh: .5; login.html');
} else if (!empty($username) && !empty($password)) {
  $checkUser = "SELECT username
                      FROM USERS
                      WHERE USERS.username = '" . $username . "'";
  $userResult = $mysqli->query($checkUser);
  $row = $userResult->fetch_assoc();
  if ($row['username'] == $username) {
    $checkPass = "SELECT password, u_id
                          FROM USERS
                          WHERE USERS.username = '" . $username . "'";
    $passResult = $mysqli->query($checkPass);
    $checkPassRow = $passResult->fetch_assoc();
    if (password_verify($password, $checkPassRow['password'])) {
      echo "Successfully logged in";
      $_SESSION['username'] = $username;
      $_SESSION['uid'] = $checkPassRow['u_id'];
      echo $_SESSION['username'];
      header('Refresh: 0; home.php');
    } else {
      echo "Login failed\n";
      header('Refresh: .5; login.html');
    }
  } else {
    echo "user does not exist\n";
    header('Refresh: .5; login.html');
  }
}
