# SongBase

## Overview
This application allows users to create playlists from Beatles songs.  Users can search songs and browse
other users' playlists.

## Implementation
The data used in this application can be found at http://millionsongdataset.com/pages/additional-datasets/.
To use this data, we created a python3 Jupyter notebook which parsed this data and reformatted it into a
JSON file.  This JSON data was then uploaded and stored in a MySQL database.  Data from this database is returned to
the application using PHP and AJAX.  The following link was used to reference in learning how to make PHP
and AJAX work together to execute queries of the MySQL database: https://code-boxx.com/php-mysql-search/.
