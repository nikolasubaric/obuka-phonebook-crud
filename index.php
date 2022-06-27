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
    $contacts = getContactsFromDatabase($_GET['searchTerm']);
} else {
    $contacts = getContactsFromDatabase();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Phonebook</title>
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
            <div class="col-sm-12 col-lg-9 col-12">

                <form action="index.php" method="GET">
                    <input type="text" value="<?= $searchTerm ?>" name="searchTerm" placeholder="Pretraga" class="form-control my-3">
                </form>

                <table class="table table-hover">

                    <thead>
                        <tr>
                            <th>Ime</th>
                            <th>Prezime</th>
                            <th>Email</th>
                            <th>Drzava</th>
                            <th>Grad</th>
                            <th>Izmjena</th>
                            <th>Brisanje</th>
                        </tr>
                    </thead>

                    <?php

                    foreach ($contacts as $contact) {

                        $first_name = $contact['first_name'];
                        $last_name = $contact['last_name'];
                        $email = $contact['email'];
                        $city_name = $contact['city_name'];
                        $country_name = $contact['country_name'];
                        $id = $contact['id'];

                        echo "
                                <tr>
                                    <td>$first_name</td>
                                    <td>$last_name</td>
                                    <td>$email</td>
                                    <td>$city_name</td>
                                    <td>$country_name</td>
                                    <td>
                                        <a href='edit.php?id=$id' >Izmjeni</a>
                                    </td>
                                    <td>
                                        <a href='deleteContact.php?id=$id' >Obrisi</a>
                                    </td>
                                </tr>";
                    }

                    ?>
                </table>
            </div>
            <div class="col-sm-12 col-lg-3 col-12">
                <h3>Dodavanje novog kontakta</h3>
                <form action="saveContact.php" method="POST">
                    <input type="text" required class="mt-3 form-control" name="first_name" placeholder="Unesite ime...">
                    <input type="text" required class="mt-3 form-control" name="last_name" placeholder="Unesite prezime...">
                    <input type="email" required class="mt-3 form-control" name="email" placeholder="Unesite email...">

                    <select name="country_id" id="country_id" class="form-control mt-3" onchange="displayCities()">
                        <option value="" selected disabled>- odaberite drzavu</option>
                        <?php
                        $countries = getCountries();
                        while ($country = mysqli_fetch_assoc($countries)) {
                            $countryId = $country['id'];
                            $countryName = $country['name'];
                            echo "<option  value=\"$countryId \">$countryName</option>";
                        }
                        ?>
                    </select>

                    <select name="city_id" id="city_id" class="form-control mt-3">
                    </select>

                    <button class="btn float-end mt-3 btn-primary">Dodaj kontakt</button>
                </form>
            </div>
        </div>

    </div>

    <script src="app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>