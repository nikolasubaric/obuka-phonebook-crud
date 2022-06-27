<?php
include 'connectDB.php';
include("databaseFunctions.php");

if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  header("location:cities.php");
}


deleteCity($id);

header("location:cities.php");
