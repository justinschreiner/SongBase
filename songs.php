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
    <script>
        /**
         * Pulls user input values from song search box and passes to AJAX to perform
         * MySQL query.  Appends results of query to results box using HTML.
         *
         * @return {Boolean} Returns False.
         */
        function fetch() {
            // find inputs from form
            var data = new FormData();
            data.append('search', document.getElementById("inputName").value);

            // find tempo comparison user provided 
            if (document.getElementById('tempoLess').checked) {
                data.append('tempoComparison', "less");
            } else if (document.getElementById('tempoGreater').checked) {
                data.append('tempoComparison', "greater");
            }

            // find length comparison user provided 
            if (document.getElementById('lengthLess').checked) {
                data.append('lengthComparison', "less");
            } else if (document.getElementById('lengthGreater').checked) {
                data.append('lengthComparison', "greater");
            }

            // Add tempo and length values or set to null if not provided
            if (!document.getElementById('tempoValue').value) {
                if (document.getElementById('tempoLess').checked) {
                    data.append('tempoValue', 9999999999);
                } else {
                    data.append('tempoValue', -1);
                }
            } else {
                data.append('tempoValue', document.getElementById('tempoValue').value);
            }

            if (!document.getElementById('lengthValue').value) {
                if (document.getElementById('lengthLess').checked) {
                    data.append('lengthValue', 9999999999);
                } else {
                    data.append('lengthValue', -1);
                }
            } else {
                data.append('lengthValue', document.getElementById('lengthValue').value);
            }

            data.append('ajax', 1);

            // use AJAX to search and return songs
            var xhr = new XMLHttpRequest();
            xhr.open('POST', "fetch_songs.php", true);
            xhr.onload = function() {
                if (this.status == 200) {
                    var results = JSON.parse(this.response),
                        wrapper = document.getElementById("results");
                    wrapper.innerHTML = "";
                    if (results.length > 0) {
                        for (var res of results) {
                            var line = document.createElement("div");
                            line.className = "one-result";
                            line.innerHTML =
                                "<div id='results'>" +
                                //this is where the song name is stored, if this is clicked, it will call getSongInfo() and pass this song's s_id
                                "<div class = 'result-title' id = " + res['s_id'] + " onclick='getSongInfo(" + "this.id" + ")'>" +
                                "<a data-toggle='modal' data-target='#songInfo' href='song.html'>" + res['title'] + "</a>" +
                                "</div>" +
                                "<div class = 'add-button' id=" + res['s_id'] + " onclick='fetchUserPlaylists(this.id)'>" +
                                "<button data-toggle='modal' data-target='#addModal' class='btn btn-primary'>Add to Playlist</button>" +
                                "</div>" +
                                "</div>";
                            wrapper.appendChild(line);
                        }
                    } else {
                        wrapper.innerHTML = "No results found";
                    }
                } else {
                    alert("ERROR LOADING FILE!");
                }
            };
            xhr.send(data);
            return false;
        }

        /**
         * Passes sid of a song to AJAX query and formats data returned by that
         * query using HTML table.
         *
         * @param {string}  sid  Song ID of the song the user clicked
         *
         * @return {Boolean}  Returns False
         */
        function getSongInfo(sid) {
            // find sid from song that was clicked
            var data = new FormData();
            data.append('search', sid);
            data.append('ajax', 1);

            // use AJAX to search and return song data
            var xhr = new XMLHttpRequest();
            xhr.open('POST', "song_info.php", true);
            xhr.onload = function() {
                if (this.status == 200) {
                    var results = JSON.parse(this.response),
                        wrapper = document.getElementById("song-modal");
                    wrapper.innerHTML = "";
                    if (results.length > 0) {
                        for (var res of results) {
                            // assign variables to use for displaying time later to format time properly
                            var dur = res['duration'];
                            var min = Math.floor(dur / 60);
                            var sec = Math.round(dur % 60);
                            if (sec == 60) {
                                min = min + 1;
                                sec = 60;
                            }
                            var zero = "";
                            if (sec < 10) {
                                zero = "0";
                            }

                            var line = document.createElement("div");
                            line.className = "one-result";
                            line.innerHTML =
                                "<table class='songInfo'>" +
                                "<thead>" +
                                "<tr>" +
                                "<th scope='col'>Title</th>" +
                                "<th scope='col'>Artist</th>" +
                                "<th scope='col'>Album</th>" +
                                "<th scope='col'>Tempo</th>" +
                                "<th scope='col'>Duration</th>" +
                                "</tr>" +
                                "</thead>" +
                                "<tbody>" +
                                "<tr>" +
                                "<th scope='row'>" + res['title'] + "</th>" +
                                "<td>" + res['artist'] + "</td>" +
                                "<td>" + res['name'] + "</td>" +
                                "<td>" + res['tempo'] + "</td>" +
                                "<td>" + min + ':' + zero + sec + "</td>" +
                                "</tr>" +
                                "</tbody>" +
                                "</table>" +
                                "<div class = 'add-button' id=" + res['s_id'] + " onclick='fetchUserPlaylists(this.id)'>" + //button's id is this song's id, stored so it can be passed to future functions for adding to playlist
                                "<button data-dismiss='modal' data-toggle='modal' data-target='#addModal' class='btn btn-primary'>Add to Playlist</button>" +
                                "</div>";
                            wrapper.appendChild(line);
                        }
                    } else {
                        wrapper.innerHTML = "No results found";
                    }
                } else {
                    alert("ERROR LOADING FILE!");
                }
            };
            xhr.send(data);
            return false;
        }

        /**
         * Gets all playlists owned by the current session's user.
         *
         * @param {string}  sid  Song ID of the song the user wants to add to playlist
         *
         * @return {Boolean} Returns False.
         */
        function fetchUserPlaylists(sid) {
            // find uid from session
            var data = new FormData();
            var uid = <?php session_start();
                        echo $_SESSION['uid']; ?>;

            data.append('uid', uid);
            data.append('ajax', 1);

            // use AJAX to search and return playlists
            var xhr = new XMLHttpRequest();
            xhr.open('POST', "fetch-user-playlists.php", true);
            xhr.onload = function() {
                if (this.status == 200) {
                    var results = JSON.parse(this.response),
                        wrapper = document.getElementById("userPlaylists");
                    wrapper.innerHTML = "";
                    if (results.length > 0) { // If the user has created one or more playlists
                        for (var res of results) { // Creates checklist of playlists for user to add songs to
                            var line = document.createElement("div");
                            line.className = "playlist-result";
                            line.innerHTML =
                                "<div class='form-check'>" +
                                "<input class='form-check-input' name ='check_list[]' type='checkbox' value=" + res['p_id'] + ">" +
                                "<label class='form-check-label' for=" + res['p_id'] + ">" +
                                res['name'] +
                                "</label>" +
                                "</div>";
                            wrapper.appendChild(line);
                        }
                        // Button for user to submit checklist selections
                        var bt = document.createElement("div")
                        bt.innerHTML = "<button id='add-btn' type='submit' class='btn btn-primary'>Add Song</button>"
                        wrapper.appendChild(bt);
                        // Hidden input value to allow song's sid to be passed to addToPlaylist() when form submits
                        var sidVal = document.createElement("div");
                        sidVal.innerHTML = "<input type='hidden' name='sid' value=" + sid + ">";
                        wrapper.appendChild(sidVal);
                    } else { // Displays this message if the user has not created any playlists yet
                        wrapper.innerHTML = "<h3>You have not created any playlists yet.<h3> <a href='new-playlist.php'>" +
                            "<button type='button' class='btn btn-primary'>Create Playlist<button></a>";
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
        <h1>Find Songs</h1>
        <br>
        <h2>Refine Search</h2>
        <form onsubmit="return fetch();">
            <div class="form-row">
                <div class="form-group col-md-8">
                    <strong><label for="name">Name</label></strong>
                    <input type="songName" name="inputName" class="form-control" id="inputName">
                </div>
            </div>
            <p>
                <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <u>Advanced Search</u>
                </a>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    <strong>Tempo</strong>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="tempoNone" name="tempoComparison" class="custom-control-input" value=1>
                                <label class="custom-control-label" for="tempoNone">All Tempos</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="tempoLess" name="tempoComparison" class="custom-control-input" value=1>
                                <label class="custom-control-label" for="tempoLess">Less than</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="tempoGreater" name="tempoComparison" class="custom-control-input" value=1>
                                <label class="custom-control-label" for="tempoGreater">Greater than</label>
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" id="tempoValue" placeholder="optional">
                            </div>
                        </div>
                    </div>
                    <strong>Length (seconds)</strong>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="lengthNone" name="lengthComparison" class="custom-control-input">
                                <label class="custom-control-label" for="lengthNone">All Lengths</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="lengthLess" name="lengthComparison" class="custom-control-input">
                                <label class="custom-control-label" for="lengthLess">Less than</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="lengthGreater" name="lengthComparison" class="custom-control-input">
                                <label class="custom-control-label" for="lengthGreater">Greater than</label>
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" id="lengthValue" placeholder="optional">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <br>
                <input type="submit" name="search" value="Find" class="btn btn-primary">
                <a href="home.php">Cancel</a>
            </div>
        </form>
    </div>
    <div class="results">
        <h2>Songs</h2>
        <div id="results"></div>
    </div>

    <div class="modal fade" id="addModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Select Playlists</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="add-to-playlist.php" method="post">
                        <div id='userPlaylists'>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="songInfo" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Song Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="song-modal">
                </div>
            </div>
        </div>
    </div>

    <!-- STRETCH GOAL: RETURN MATCHING ALBUMS HERE.  NAMES OF ABLUMS CAN BE CLICKED, WHICH WILL AUTO SEARCH SONGS IN THAT ALBUM.
        <div class = "results">
            <h2>Albums</h2>
            <div class = "one-result">
                Placeholder album
            </div>
        </div> -->
</body>

</html>