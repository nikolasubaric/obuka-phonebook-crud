<?php 

    include 'fileFunctions.php';

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $id = $_POST['id'];

    $contacts = getContactsFromFile();
    foreach($contacts as &$contact){
        if($contact['id'] == $id) {

            $contact['first_name'] = $first_name;
            $contact['last_name'] = $last_name;
            $contact['email'] = $email;

            saveContactsToFile($contacts);
            header('location:index.php');
            exit;
        }
    }
?>