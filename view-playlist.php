<?php
$servername = "mysql.eecs.ku.edu";
$username = "jschreiner";
$password = "pass123";
$database = "jschreiner";

$dbc = new mysqli($servername, $username, $password, $database);

$res_arr = array();
$rows = array();
$pid = $_GET['id'];

if (isset($pid)) {
    $sql = "SELECT * FROM SONGS, ISIN, ALBUMS, PLAYLISTS WHERE SONGS.s_id = ISIN.s_id AND ISIN.p_id = $pid 
            AND ISIN.p_id = PLAYLISTS.p_id AND ALBUMS.a_id = SONGS.a_id";
    $result = mysqli_query($dbc, $sql) or die("Bad query: $sql");
    while ($row = mysqli_fetch_array($result)) {
        array_push($res_arr, $row);
    }
}
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/songs.css" />
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
                    <a id="home" class="nav-link home" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a id="login" class="nav-link" href="login.html">Login</a>
                </li>
                <li class="nav-item">
                    <a id="logout" class="nav-link" href="index.html">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="main">
        <div id='table'>
            <h3>No Songs Yet<h3>
                    <a href="songs.php"><button class='btn btn-primary'>Add Songs</button></a>
        </div>
        <table class="playlist">
        </table>
    </div>
</body>
<script type="text/javascript">
    var results = <?php echo json_encode($res_arr) ?>;
    let table = document.getElementById('table');
    var html = "<h1>" + results[0]['name'] + "<h1>" +
        "<table class='playlist'>" +
        "<thead>" +
        "<tr>" +
        "<th scope='col'>Title</th>" +
        "<th>Artist</th>" +
        "<th>Duration</th>" +
        "</tr>" +
        "</thead>" +
        "<tbody>";
    for (res of results) {
        html = html +
            "<tr>" +
            "<td>" + res['title'] + "</td>" +
            "<td>" + res['artist'] + " </td>" +
            "<td>" + res['duration'] + "</td>" +
            "</tr>";
    }
    html = html + "</tbody>" + "</table";
    table.innerHTML = html;
</script>

</html>