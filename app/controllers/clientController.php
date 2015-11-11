<?php
require_once '../init.php';

switch($_POST['type']){
    case 'add':
        if (add($_POST["clientName"], $_POST["address"], $_POST["zipcode"], $_POST["place"], $_POST["tel"], $_POST["email"], $_POST["contP"], $db, $messageBag)) {
            header('location:' . HTTP . 'public/index.php' );
        }   else {
            header('location:' . HTTP . 'public/index.php' );
        }
        
        break;
    case 'edit':

        $id = $_POST['clientNR'];
        if (edit($_POST["clientName"], $_POST["address"], $_POST["zipcode"], $_POST["place"], $_POST["tel"], $_POST["email"], $_POST["contP"], $_POST["active"], $db, $id, $messageBag )) {
        	header('location:' . HTTP . 'public/views/clients/clientPage.php?clientnr=' . $id );
        } else {
        	header('location:' . HTTP . 'public/views/clients/clientPage.php?clientnr=' . $id);
        }
        
        break;
    case 'delete':
        $id = $_POST['clientNR'];
        if (remove($db,$id,$messageBag)) {
        	header('location:' . HTTP . 'public/index.php');
        } else {
            header('location:' . HTTP . 'public/index.php');
        }
        break;
    case 'reset':
        $id = $_POST['clientNR'];
        if (clientReset($db,$id,$messageBag)) {
            header('location:' . HTTP . 'public/views/departments/admin/admin.php');
        }
        break;
}

function remove($db, $id, $messageBag){

    $sql = "SELECT * FROM tbl_projects WHERE customerNR = :id";
    $q = $db->prepare($sql);
    $q->bindParam(':id', $id);
    $q->execute();

    if ($q->rowCount() > 0) {
        $messageBag->Add('a','This client has one or more projects'); 
        return False;
    }   else {


        $sql = 'DELETE FROM tbl_customers WHERE customerNR = :id';
        $q = $db->prepare($sql);
        $q->bindParam(':id', $id);
        $q->execute();
        $messageBag->Add('s','The Client is succesfully deleted'); 
        return true;
    }
}


function edit($clientName, $address, $zipcode, $place, $tel, $email, $contP, $active, $db, $id,$messageBag ) {
    $sql = 'SELECT * FROM tbl_customers where customerNR = :id';
    $q = $db->prepare($sql);
    $q->bindParam(':id', $id);
    $q->execute();




    if ($q->rowCount() > 0) {
        

    	$sql = 'UPDATE tbl_customers 
        SET companyName = :clientName, address = :address, zipCode = :zipcode, place = :place, tel = :tel, email = :email, contactPerson = :contP, active = :active WHERE customerNR = :id';

        $q = $db->prepare($sql);
        $q->bindParam(':clientName', $clientName);
        $q->bindParam(':address', $address);
        $q->bindParam(':zipcode', $zipcode);
        $q->bindParam(':place', $place);
        $q->bindParam(':tel', $tel);
        $q->bindParam(':email', $email);
        $q->bindParam(':contP', $contP);
        $q->bindParam(':active', $active);
        $q->bindParam(':id', $id);

        $q->execute();

       
        $messageBag->Add('s','Client updated!!');
        return true;

        

    } else {

    	$messageBag->Add('a',"Client doesn't exicst and can't be edited!");
        return false;
        
    }
}

function add($clientName, $address, $zipcode, $place, $tel, $email, $contP, $db,$messageBag ) {

    if (empty($clientName)) {

        $messageBag->Add('a',"Client name isn't filled in!");
        return false;
    } else {
        $sql = 'SELECT * FROM tbl_customers where companyName = :clientName';
        $q = $db->prepare($sql);
        $q->bindParam(':clientName', $clientName);
        $q->execute();

        //counts the returned rows
        if ($q->rowCount() > 0) {
            $messageBag->Add('a','Client already exists!');
            return false;

        } else {

            $sql = 'INSERT INTO tbl_customers (companyName, address, zipCode, place, tel, email, contactPerson, active)  VALUES (:clientName, :address, :zipcode, :place, :tel, :email, :contP, 1)';

            $q = $db->prepare($sql);
            $q->bindParam(':clientName', $clientName);
            $q->bindParam(':address', $address);
            $q->bindParam(':zipcode', $zipcode);
            $q->bindParam(':place', $place);
            $q->bindParam(':tel', $tel);
            $q->bindParam(':email', $email);
            $q->bindParam(':contP', $contP);
            
            $q->execute();
            $messageBag->Add('s','Client added');
            return true; 
        }
    }
}

function clientReset($db,$id,$messageBag){
    $sql = 'SELECT * FROM tbl_customers where customerNR = :id';
    $q = $db->prepare($sql);
    $q->bindParam(':id', $id);
    $q->execute();




    if ($q->rowCount() > 0) {

        $sql = 'UPDATE tbl_customers 
        SET active = 1
        WHERE customerNR = :id';

        $q = $db->prepare($sql);
        
        $q->bindParam(':id', $id);

        $q->execute();

       
        $messageBag->Add('s','Client activated!!');
        return true;

        

    } else {

        $messageBag->Add('a',"Client doesn't exicst and can't be edited!");
        return false;
        
    }
}