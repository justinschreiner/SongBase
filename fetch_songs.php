<?php
$songname = $_POST['name'];
$mysqli = new mysqli("mysql.eecs.ku.edu", "jschreiner", "pass123", "jschreiner");

if(empty($songname))
  {
    echo "No song name entered\n";
    header('Location: songs.html');
  }

if($mysqli->connect_errno)
  {
    printf("Connection to database failed %s\n", $mysqli->connect_error);
    exit();
  }
else
{
  $query = "SELECT title FROM SONGS WHERE TITLE = '".$songname."'";
    if($mysqli->query($query) == TRUE)
      {
        echo "Song searched for\n";
      }
}


?>
