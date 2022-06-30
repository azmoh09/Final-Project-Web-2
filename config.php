<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

try {
    //code...
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sites";

    /* Attempt to connect to MySQL database */
    $link = mysqli_connect($server, $username, $password, $dbname);

    // Check connection
    if ($link->connect_error) {
        die("ERROR: Could not connect. " . $link->connect_error);
    }
} catch (Exception $th) {
    //throw $th;
}
