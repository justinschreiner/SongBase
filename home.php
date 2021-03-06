<?php
session_start();
?>
<html>

<head>
    <meta charset="utf-8" />
    <title>SongBase</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" user-scalable="no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,800|Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/home.css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand nav-logo" href="home.php"><i class="fas fa-music"></i> SongBase</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto my-2 my-lg-0">
                <li>
                    <a id="home" class="nav-link home" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a id="login" class="nav-link" href="login.html">Login</a>
                </li>
                <li class="nav-item">
                    <a id="logout" class="nav-link" href="index.html">Logout</a>
                </li>
                <li class="nav-item">
                    <a id="user" class="nav-link"> Welcome, <?php echo $_SESSION['username']; ?>!</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="main">
        <a href="#">
            <h1><i class="fas fa-music"></i> SongBase</h1>
        </a>
        <br>
        <div class="options">
            <div class="choice"><a href="songs.php">Browse songs</a></div>
            <div class="choice"><a href="browse-playlists.php">Browse playlists</a></div>
            <div class="choice"><a href="my-playlists.php">My playlists</a></div>
            <div class="choice"><a href="new-playlist.php">Create playlist</a></div>
        </div>
    </div>
</body>

</html>