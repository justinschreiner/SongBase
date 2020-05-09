<!-- 
Adds new user to MySQL USERS table
-->

<?php
// Initialize MySQL connection
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
  if ($testResult->num_rows > 0) { // Check if username already exists
    echo "Username already taken, please choose another.";
    header('Refresh: 1.5; create.html');
  } else if ($password == $verifyPass && !empty($username) && !empty($password)) { // Add user to USERS table
    $password = password_hash($password, PASSWORD_DEFAULT);
    $insertQuery = "INSERT INTO USERS(username,password) VALUES ('$username', '$password')";

    if ($mysqli->query($insertQuery) == TRUE) { // Log user in and store their username as a session variable
      $_SESSION['username'] = $username;
      header('Refresh: 0; home.php');
    }
  }
} else { // Executes if one or more of the input fields is left empty
  echo "Do not leave any fields empty, please try again.";
  header('Refresh: 1.5; create.html');
}
