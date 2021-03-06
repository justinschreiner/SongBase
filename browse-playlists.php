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
    <link rel="stylesheet" href="./css/songs.css" />
    <script>
        /**
         * Pulls inputs from playlist search box and passes to AJAX to execute 
         * query.  Formats results using HTML.
         *
         * @return {Boolean} Returns False.
         */
        function fetchPlaylists() {
            // find inputs from form
            var data = new FormData();
            data.append('name', document.getElementById("playlistName").value);
            data.append('user', document.getElementById("playlistUser").value);
            data.append('ajax', 1);
            console.log(data);
            // Uses AJAX to search and return playlists
            var xhr = new XMLHttpRequest();
            xhr.open('POST', "fetch-playlists.php", true);
            xhr.onload = function() {
                if (this.status == 200) {
                    var results = JSON.parse(this.response),
                        wrapper = document.getElementById("results");
                    wrapper.innerHTML = "";
                    if (results.length > 0) { // Executes if at least one playlist is found
                        for (var res of results) {
                            var line = document.createElement("div");
                            line.className = "res";
                            line.innerHTML =
                                "<div id='results'>" +
                                "<div class = 'result-playlist'>" +
                                "<a href='view-playlist.php?id=" + res['p_id'] + "'>" + res['name'] + "</a>" + // If user clicks a playlist name, this directs them to view-playlist.php and passes the playlist id
                                "</div>" +
                                "</div>";
                            wrapper.appendChild(line);
                        }
                    } else { // Executes if no playlists are found.
                        wrapper.innerHTML = "No results found";
                    }
                } else {
                    alert("ERROR LOADING FILE!");
                }
            };
            xhr.send(data);
            return false;
        }
    </script>
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
        <h2>Refine Search</h2>
        <form onsubmit="return fetchPlaylists();">
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="playlistName">Name</label>
                    <input type="playlistName" class="form-control" id="playlistName">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="playlistUser">User</label>
                    <input type="playlistUser" class="form-control" id="playlistUser">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="home.php">Cancel</a>
        </form>
    </div>
    <div class="main" id="main">
        <h2>Playlists</h2>
        <div id="results"></div>
    </div>
</body>

</html>