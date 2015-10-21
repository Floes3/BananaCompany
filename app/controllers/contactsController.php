<?php
require_once '../init.php';

switch($_POST['type']){

    case 'add':
        add($_POST["firstname"], $_POST["lastname"], $_POST["username"], $_POST["phone"], $db, $messageBag);
        break;
    case 'edit':

        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        edit($_POST["firstname"], $_POST["lastname"], $_POST["username"], $_POST["phone"], $db, $id,$messageBag );
        break;
    case 'delete';
        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        remove($db,$id,$messageBag);
        break;
}


function remove($db, $id, $messageBag){
    $sql = 'DELETE FROM contacts WHERE id = :id';
    $q = $db->prepare($sql);
    $q->bindParam(':id', $id);
    $q->execute();
    $messageBag->Add('s','U heeft de contact succesvol verwijderd!');
    header('location:' . HTTP . 'public/index.php?');
}

function add($firstname, $lastname, $username, $phone, $db,$messageBag ) {

    if (empty($username)) {

        $messageBag->Add('a','Username niet ingevoerd!');
        header('location: ../../public/views/contacts/add.php');

    } else {
        $sql = 'SELECT * FROM contacts where username = :username';
        $q = $db->prepare($sql);
        $q->bindParam(':username', $username);
        $q->execute();

        //counts the returned rows
        if ($q->rowCount() > 0) {
            $messageBag->Add('a','Username bestaat al!');
            header('location: ../../public/views/contacts/add.php');

        } else {

            $sql = 'INSERT INTO contacts (firstname, lastname, username, phone)  VALUES (:firstname,:lastname,:username,:phone)';

            $q = $db->prepare($sql);
            $q->bindParam(':firstname', $firstname);
            $q->bindParam(':lastname', $lastname);
            $q->bindParam(':username', $username);
            $q->bindParam(':phone', $phone);
            $q->execute();
            $messageBag->Add('a','contact succesvol toegevoegd!');
            header('location: ../../public/index.php');
        }
    }
}

function edit($firstname, $lastname, $username, $phone, $db, $id,$messageBag ) {
    $sql = 'SELECT * FROM contacts where username = :username';
    $q = $db->prepare($sql);
    $q->bindParam(':username', $username);
    $q->execute();


    if ($q->rowCount() > 0) {

        $sql = 'SELECT username FROM contacts where id = :id';
        $q = $db->prepare($sql);
        $q->bindParam(':id', $id);
        $q->execute();
        $db_username = $q->fetch();

        if ($db_username['username'] == $username){
            $messageBag->Add('a','Ingevoerde username is het zelfde!');
            header('location: ../../public/index.php');
        } else {
            $messageBag->Add('a','Username bestaat al!');
            header('location: ../../public/index.php?msg=Username bestaat al!');
        }

    } else {

        $sql = 'UPDATE contacts SET firstname = :firstname,lastname = :lastname,username = :username,phone = :phone WHERE id = :id';

        $q = $db->prepare($sql);
        $q->bindParam(':firstname', $firstname);
        $q->bindParam(':lastname', $lastname);
        $q->bindParam(':username', $username);
        $q->bindParam(':phone', $phone);
        $q->bindParam(':id', $id);
        $q->execute();

        //counts the returned rows
        $messageBag->Add('a','User aangepast!');
        header('location: ../../public/index.php');

    }
}


