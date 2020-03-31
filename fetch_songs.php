<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
$mysqli = new mysqli("mysql.eecs.ku.edu", "jschreiner", "pass123", "jschreiner");
$songname = $_POST['inputSong'];
$albumname = $_POST['inputAlbum'];
  if($mysqli->connect_errno)
    {
      printf("Connection to database failed %s\n", $mysqli->connect_error);
      exit();
    }



 if(!empty($songname))
  {

    $query = "SELECT title, ALBUMS.name
              FROM SONGS, ALBUMS
              WHERE (title = '".$songname."'
              OR name = '".$songname."')
              AND ALBUMS.a_id = SONGS.a_id";

    $result = $mysqli->query($query);
    if($result->num_rows > 0)
      {
        echo "<table>";
        echo "<tr>";
        echo "<th> Song title </th>";
        echo "<th> Album name </th>";
        echo "</tr>";
        while($row = $result->fetch_assoc())
          {
            $song = $row["title"];
            $album = $row["name"];
            echo "<tr> <td> $song </td> <td> $album </td> </tr>";
          }
      }
    else if($result->num_rows <= 0)
    {
      echo "No songs matching that criteria, redirecting to search page. <br>";
      $song = "
      ";
      $album = "
       ";
      header('Refresh: 3; songs.html');
    }
  }



if(!empty($albumname) && empty($songname))
  {
    $query = "SELECT name, title
              FROM ALBUMS, SONGS
              WHERE name = '".$albumname."'
              AND ALBUMS.a_id = SONGS.a_id";

    $result = $mysqli->query($query);
    if($result->num_rows > 0)
      {
        echo "<table>";
        echo "<tr>";
        echo "<th> Song title </th>";
        echo "<th> Album name </th>";
        echo "</tr>";
        while($row = $result->fetch_assoc())
          {
            $song = $row["title"];
            $album = $row["name"];
            echo "<tr> <td> $song </td> <td> $album </td> </tr>";

          }
      }
    else if($result->num_rows <= 0 || empty($songname))
    {
      echo "No songs matching that criteria, redirecting to search page. <br>";
      $song = "
      ";
      $album = "
       ";
      header('Refresh: 3; songs.html');
    }
  }



?>

<!doctype html>
  <html>
    <head>
        <Title> Search results </title>
          <style>
          body{
                background-color: white;
                border-radius: 30px;
                padding: 1.5%;
                margin-top: 50px;
                margin-left: 30%;
                margin-right: 30%;
              }

          table, th, td
          {
              border-collapse: collapse;
              border: 1px solid black;
          }
          </style>
