<?php 

    session_start();
    include("fileFunctions.php");

    // superglobals, $_POST, $_GET, $_SERVER
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $id = uniqid();
    $user_id = $_SESSION['user']['id'];

    $contacts = getContactsFromFile();
    $newContact = [
        "id" => $id,
        "first_name" => $first_name, 
        "last_name" => $last_name, 
        "email" => $email,
        "user_id" => $user_id
    ];

    $contacts[] = $newContact; // array_push($contacts, $newContact);
    saveContactsToFile($contacts);

    header("location:./index.php");
?>