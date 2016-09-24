<?php

$keyfile = file('novaprospect/combine');
    $servername = trim($keyfile[0]);
    $username = trim($keyfile[1]);
    $password = trim($keyfile[2]);
    $dbname = trim($keyfile[3]);

    //Initialize values upon form refresh
    if (!empty($_GET['del_id'])) { $del_id = $_GET['del_id']; }

    //Get the search query
    if (!empty($_GET['q'])) { $searchQuery = $_GET['q']; }

    $con = mysqli_connect("$servername", "$username", "$password", "$dbname");
?>