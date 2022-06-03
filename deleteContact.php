<?php 

    include("fileFunctions.php");

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }else{
        header("location:index.php");
    }

    $contacts = getContactsFromFile();
    $contactsFiltered = array_filter($contacts, function($c) use($id){
        return $c['id'] != $id;
    });

    saveContactsToFile($contactsFiltered);
    header("location:index.php");
    exit;

?>