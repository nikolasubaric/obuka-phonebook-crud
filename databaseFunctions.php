<?php

// CRUD methods for phonebook

function getContactsFromDatabase($searchTerm = '')
{
  global $db_connection;
  $user_id = $_SESSION['user']['id'];
  $sql = "SELECT 
                contacts.id, 
                contacts.first_name, 
                contacts.last_name, 
                contacts.email,
                cities.name as city_name, 
                countries.name as country_name 
                FROM contacts, cities, countries 
                WHERE contacts.city_id = cities.id 
                AND cities.country_id = countries.id 
                AND user_id = $user_id";

  if ($searchTerm != "") {
    $term = strtolower($searchTerm);
    $sql .= " AND  lower(first_name) like '%$term%' OR lower(last_name) like '%$term%' ";
  }

  $res = mysqli_query($db_connection, $sql);

  $contacts = [];
  while ($contact = mysqli_fetch_assoc($res)) {
    $contacts[] = $contact;
  }
  return $contacts;
}

function saveContactToDatabase($first_name, $last_name, $email, $user_id, $city_id)
{
  global $db_connection;
  $sql = "INSERT INTO contacts (first_name, last_name, email, user_id, city_id) VALUES ('$first_name', '$last_name', '$email', $user_id, $city_id)";
  return mysqli_query($db_connection, $sql);
}

function findContactById($id)
{
  global $db_connection;
  $sql = "SELECT 
                contacts.*, 
                countries.id as country_id 
                FROM contacts, cities, countries 
                WHERE contacts.id = $id 
                AND contacts.city_id = cities.id 
                AND countries.id = cities.country_id";
  $res = mysqli_query($db_connection, $sql);

  return mysqli_fetch_assoc($res);
}

function updateContact($first_name, $last_name, $email, $id, $city_id)
{
  global $db_connection;
  $sql = "UPDATE contacts SET first_name = '$first_name', last_name = '$last_name', email = '$email', city_id = '$city_id' WHERE id = $id";
  return mysqli_query($db_connection, $sql);
}

function deleteContact($id)
{
  global $db_connection;
  $sql = "DELETE FROM contacts WHERE id = $id";
  return mysqli_query($db_connection, $sql);
}

function findUserByUsernameAndPassword($username, $password)
{
  global $db_connection;
  $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
  $res = mysqli_query($db_connection, $sql);

  return mysqli_fetch_assoc($res);
}


function getCountries()
{
  global $db_connection;
  $sql = "SELECT * FROM countries ORDER BY name";
  return mysqli_query($db_connection, $sql);
}


function getCitiesByCountry($country_id)
{
  global $db_connection;
  $sql = "SELECT * FROM cities WHERE country_id = $country_id ORDER BY name";
  return mysqli_query($db_connection, $sql);
}

function getCities()
{
  global $db_connection;
  $sql = "SELECT * FROM cities ORDER BY name";
  return mysqli_query($db_connection, $sql);
}

function getCitiesByNumberOfContacts()
{
  global $db_connection;
  $sql = "SELECT t1.*, IFNULL(num, 0) AS no_contacts, countries.name AS country_name FROM cities as t1 LEFT JOIN (SELECT cities.* ,count(contacts.city_id) as num FROM contacts INNER JOIN cities ON contacts.city_id = cities.id JOIN countries ON cities.country_id = countries.id GROUP BY contacts.city_id) as t2 on t1.id = t2.id JOIN countries ON t1.country_id = countries.id;";
  return mysqli_query($db_connection, $sql);
}

function getCountriesByNumberOfCities()
{
  global $db_connection;
  $sql = "SELECT countries.*, COUNT(cities.id) AS no_cities FROM countries LEFT JOIN cities ON countries.id = cities.country_id GROUP BY countries.id;";
  return mysqli_query($db_connection, $sql);
}

function saveCityToDatabase($name, $country_id)
{
  global $db_connection;
  $sql = "INSERT INTO cities (name, country_id) VALUES ('$name', $country_id)";
  return mysqli_query($db_connection, $sql);
}

function deleteCity($id)
{
  global $db_connection;
  $sql = "DELETE FROM cities WHERE id = $id";
  return mysqli_query($db_connection, $sql);
}

function findCityById($id)
{
  global $db_connection;
  $sql = "SELECT 
                cities.*, 
                countries.id as country_id 
                FROM cities, countries 
                WHERE cities.id = $id 
                AND cities.country_id = countries.id";
  $res = mysqli_query($db_connection, $sql);

  return mysqli_fetch_assoc($res);
}

function updateCity($name, $id, $country_id)
{
  global $db_connection;
  $sql = "UPDATE cities SET name = '$name', country_id = '$country_id' WHERE id = $id";
  return mysqli_query($db_connection, $sql);
}

function findCountryById($id)
{
  global $db_connection;
  $sql = "SELECT 
                countries.* 
                FROM countries 
                WHERE countries.id = $id";
  $res = mysqli_query($db_connection, $sql);

  return mysqli_fetch_assoc($res);
}

function updateCountry($name, $id)
{
  global $db_connection;
  $sql = "UPDATE countries SET name = '$name' WHERE id = $id";
  return mysqli_query($db_connection, $sql);
}

function deleteCountry($id)
{
  global $db_connection;
  $sql = "DELETE FROM countries WHERE id = $id";
  return mysqli_query($db_connection, $sql);
}

function saveCountryToDatabase($name)
{
  global $db_connection;
  $sql = "INSERT INTO countries (name) VALUES ('$name')";
  return mysqli_query($db_connection, $sql);
}
