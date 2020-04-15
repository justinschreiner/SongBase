<?php
    $servername = "mysql.eecs.ku.edu";
    $username = "jschreiner";
    $password = "pass123";
    $database = "jschreiner";

    $dbc = new mysqli($servername, $username, $password, $database);

    $res_arr = array();
    $rows = array();

    if (isset($_GET['id'])){
        $sql = "SELECT * FROM SONGS, ISIN, ALBUMS, PLAYLISTS WHERE SONGS.s_id = ISIN.s_id AND ISIN.p_id = 1
            AND ISIN.p_id = PLAYLISTS.p_id AND ALBUMS.a_id = SONGS.a_id";
        $result = mysqli_query($dbc, $sql) or die("Bad query: $sql");
        while($row = mysqli_fetch_array($result)){
            array_push($res_arr, $row);
            echo $row['title'];
        }
    }
?>


<html>
    <head>
        <meta charset="utf-8" />
        <title>SongBase</title>
        <link rel="icon" type="image/png"  href="image.png">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" user-scalable="no">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,800|Roboto&display=swap" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="./css/style.css" />
        <link rel="stylesheet" href="./css/songs.css" />
    </head>
    <body>
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand nav-logo" href="home.html"><i class="fas fa-music"></i>  SongBase</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto my-2 my-lg-0">
                    <li>
                        <a id = "home" class="nav-link home" href="home.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a id = "login" class="nav-link" href="login.html">Login</a>
                    </li>
                    <li class="nav-item">
                        <a id = "logout" class="nav-link" href="index.html">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class = "main">
            <h1>
                Playlist
            </h1>
            <div id = 'table'>

            </div>
            <table class="playlist">
                <h3>Songs</h3>
                <thead>
                    <tr>
                    <th scope="col">Title</th>
                    <th>Artist</th>
                    <th>Duration</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td scope="row"><?php echo $row['title'] ?></td>
                    <td><?php echo $row['artist'] ?></td>
                    <td><?php echo round($row['duration']/60, 0), ":"; if($row['duration']%60 < 10) {echo 0;} echo $row['duration']%60; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
    <script type="text/javascript">
        let table = document.getElementById('table');
        table.innerHTML = "<table class='playlist'>"+
                "<h3>Songs</h3>"+
                "<thead>"+
                    "<tr>"+
                    "<th scope='col'>Title</th>"+
                    "<th>Artist</th>"+
                    "<th>Duration</th>"+
                    "</tr>"+
                "</thead>"+
                "<tbody>"+
                    "<tr>"+
                    "<td scope='row'><?php echo $row['title'] ?></td>"+
                    "<td><?php echo $row['artist'] ?></td>"+
                    "<td><?php echo round($row['duration']/60, 0), ":"; if($row['duration']%60 < 10) {echo 0;} echo $row['duration']%60; ?></td>"+
                    "</tr>"+
                "</tbody>"+
            "</table>";
    </script>
</html>