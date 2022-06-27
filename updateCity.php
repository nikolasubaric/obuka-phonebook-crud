<?php

include 'connectDB.php';
include 'databaseFunctions.php';


$name = $_POST['name'];
$country_id = $_POST['country_id'];
$id = $_POST['id'];

updateCity($name, $id, $country_id);

header('location:cities.php');
