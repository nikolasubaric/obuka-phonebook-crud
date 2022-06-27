<?php

session_start();
include 'connectDB.php';
include("databaseFunctions.php");



if (!$_SESSION['loggedIn']) {
  header("location:login.php");
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Phonebook - Add City</title>
</head>

<body>

  <nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid flex-row-reverse">
      <div class="row d-flex ">
        <div class="col">
          <a href='index.php' class="navbar-brand">Kontakti</a>
        </div>
        <div class="col">
          <a href='cities.php' class="navbar-brand">Gradovi</a>
        </div>
        <div class="col">
          <a href='countries.php' class="navbar-brand">Drzave</a>
        </div>
      </div>
    </div>
  </nav>

  <div class="container">

    <div class="row mt-5">
      <div class="col-8 offset-2">
        <h3>Dodavanje grada</h3>
        <form action="saveCityToDatabase.php" method="POST">

          <input type="text" required class="mt-3 form-control" name="name" placeholder="Unesite naziv grada...">

          <select name="country_id" id="country_id" class="form-control mt-3">
            <option value="" selected disabled>- Odaberite drzavu</option>
            <?php
            $countries = getCountries();
            while ($country = mysqli_fetch_assoc($countries)) {
              $countryId = $country['id'];
              $countryName = $country['name'];
              $selected = "";
              if ($countryId == $contact['country_id']) {
                $selected = "selected";
              }
              echo "<option  value=\"$countryId \" $selected>$countryName</option>";
            }
            ?>
          </select>

          <button class="btn float-end mt-3 btn-primary">Dodaj grad</button>
        </form>
      </div>
    </div>

  </div>

  <script src="app.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>