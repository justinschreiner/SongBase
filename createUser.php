<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
$username = $_POST['username'];
$password = $_POST['password1'];
$verifyPass = $_POST['password2'];
$mysqli = new mysqli("mysql.eecs.ku.edu", "jschreiner", "pass123", "jschreiner");
if ($mysqli->connect_errno) {
  printf("Connection to database failed %s\n", $mysqli->connect_error);
  exit();
}
if (!empty($username) && !empty($password)) {
  $testQuery = "SELECT username
                  FROM USERS
                  WHERE USERS.username = '" . $username . "'";
  $testResult = $mysqli->query($testQuery);
  if ($testResult->num_rows > 0) {
    echo $_POST['username'];
    echo $_POST['password'];
    //    header('Refresh: .1; create.html');
  } else if ($password == $verifyPass && !empty($username) && !empty($password)) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $insertQuery = "INSERT INTO USERS(username,password) VALUES ('$username', '$password')";

    if ($mysqli->query($insertQuery) == TRUE) {
      $_SESSION['username'] = $username;
      $uid = "SELECT u_id FROM USERS WHERE USERS.username = '". $username ."'";
      $uid = $mysqli->query($uid);
      $row = $uid->fetch_assoc();
      $_SESSION['uid'] = $row['u_id'];
      header('Refresh: 0; home.php');
    }
  }
} else {
  echo $_POST['username'];
  echo $_POST['password1'];
  echo $_POST['password2'];
  header('Refresh: 0; create.html');
  //  echo '<script>emptyField()</script>'

}



?>
