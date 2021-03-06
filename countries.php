<?php

session_start();
include 'connectDB.php';
include 'databaseFunctions.php';

if (!$_SESSION['loggedIn']) {
  header("location:login.php");
  exit;
}

$searchTerm = "";
if (isset($_GET['searchTerm']) && $_GET['searchTerm'] != "") {
  $searchTerm = $_GET['searchTerm'];
  $countries = getCountriesByNumberOfCities($_GET['searchTerm']);
} else {
  $countries = getCountriesByNumberOfCities();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <title>Phonebook - Countries</title>
</head>

<body>



  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Da li ste sigurni da zelite da obrisete drzavu?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-footer">
          <button type="button" id="btn-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Odustani</button>
          <button type="button" id="btn-delete" class="btn btn-danger">Obrisi</button>
        </div>
      </div>
    </div>
  </div>

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
      <div class="offset-lg-2 col-lg-8 offset-sm-0 col-sm-12">
        <h3>Drzave</h3>


        <div class="disabled-notif p-1">Drzave sa gradovima ne mogu biti obrisane!</div>

        <form action="countries.php" method="GET">
          <input type="text" value="<?= $searchTerm ?>" name="searchTerm" placeholder="Pretraga" class="form-control my-3">
        </form>

        <table class="table table-hover">

          <thead>
            <tr>
              <th>Naziv</th>
              <th>Broj Gradova</th>
              <th>Izmjena</th>
              <th>Brisanje</th>
            </tr>
          </thead>

          <?php

          foreach ($countries as $country) {

            $country_name = $country['name'];
            $no_cities = $country['no_cities'];
            $id = $country['id'];
            $disabled = '';

            $canBeDeleted = 'countryDeleteModal(' . $id . ')';
            if ($no_cities > 0) {
              $disabled = "disabled";
              $canBeDeleted = '';
            }

            echo "
                                <tr class='$disabled'>
                                    <td>$country_name</td>
                                    <td>$no_cities</td>
                                    <td>
                                    <button onClick='window.location.href=\"editCountry.php?id=$id\"' >Izmjeni</button>
                                    </td>
                                    <td>
                                    <button onClick=$canBeDeleted class='$disabled' $disabled>Obrisi</button>
                                    </td>
                                </tr>";
          }

          ?>

        </table>

      </div>

    </div>
    <div class="row offset-lg-2 col-lg-8 offset-sm-0 col-sm-12">
      <button onclick="window.location.href='saveCountry.php'">Dodaj drzavu</button>

    </div>

  </div>





  <script src="app.js"></script>
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>