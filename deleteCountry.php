<?php
include 'connectDB.php';
include("databaseFunctions.php");

if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  header("location:countries.php");
}


deleteCountry($id);

header("location:countries.php");
