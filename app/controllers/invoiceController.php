<?php
require_once '../init.php';

switch($_POST['type']){
    case 'add':
        if (add($_POST["projectNR"], $_POST["description"], $_POST["inDate"], $_POST["price"], $db, $messageBag)) {
            header('location:' . HTTP . 'public/views/departments/finance/finance.php' );
        }   else {
            header('location:' . HTTP . 'public/views/departments/finance/finance.php' );
        }
        
        break;
    case 'edit':

        
        if (edit($_POST["inNR"], $_POST["description"], $_POST["inDate"], $_POST["price"], $_POST["active"], $db, $messageBag)) {
        	header('location:' . HTTP . 'public/views/invoices/invoicePage.php?innr=' . $_POST['inNR']);
        } else {
        	header('location:' . HTTP . 'public/views/invoices/invoicePage.php?innr=' . $_POST['inNR']);
        }
        
        break;
    case 'delete';
        $id = $_POST['inNR'];
        if (remove($db,$id,$messageBag)) {
        	header('location:' . HTTP . 'public/views/departments/finance/finance.php');
        }
        break;
}

function remove($db, $id, $messageBag){

    $sql = 'DELETE FROM invoices WHERE invoiceNR = :id';
    $q = $db->prepare($sql);
    $q->bindParam(':id', $id);
    $q->execute();
    $messageBag->Add('s','The invoice is succesfully deleted'); 
    return true;
}


function edit($id, $description, $inDate, $price,  $active, $db,$messageBag ) {
    $sql = 'SELECT * FROM invoices where invoiceNR = :id';
    $q = $db->prepare($sql);
    $q->bindParam(':id', $id);
    $q->execute();




    if ($q->rowCount() > 0) {
        
    	$sql = 'UPDATE invoices 
        SET description = :description, inDate = :inDate, price = :price, active = :active WHERE invoiceNR = :id';

        $q = $db->prepare($sql);
        $q->bindParam(':description', $description);
        $q->bindParam(':inDate', $inDate);
        $q->bindParam(':price', $price);
        $q->bindParam(':active', $active);
        $q->bindParam(':id', $id);

        $q->execute();

       
        $messageBag->Add('s','Invoice updated!!');
        return true;

        

    } else {

    	$messageBag->Add('a',"Invoice doesn't exicst and can't be edited!");
        return false;
        
    }
}

function add($projectNR, $description, $inDate, $price, $db,$messageBag ) {

    if (empty($description)) {

        $messageBag->Add('a',"Description isn't filled in!");
        return false;
    } else {
        $sql = 'SELECT * FROM invoices where description = :description and projectNR = :projectNR';
        $q = $db->prepare($sql);
        $q->bindParam(':description', $description);
        $q->bindParam(':projectNR', $projectNR);
        $q->execute();

        //counts the returned rows
        if ($q->rowCount() > 0) {
            $messageBag->Add('a','invoice already exists!');
            return false;

        } else {

            $sql = 'INSERT INTO invoices (projectNR, description, inDate, price, btw, active)  VALUES (:projectNR, :description, :inDate, :price, 1.12, 1)';

            $q = $db->prepare($sql);
            $q->bindParam(':projectNR', $projectNR);
            $q->bindParam(':description', $description);
            $q->bindParam(':inDate', $inDate);
            $q->bindParam(':price', $price);
            $q->execute();
            $messageBag->Add('s','Invoice added');
            return true; 
        }
    }
}