<?php
require_once '../init.php';

switch($_POST['type']){
    case 'add':
        if (add($_POST["customerNR"], $_POST["appdate"], $_POST["subject"], $_POST["description"], $_POST["location"], $db, $messageBag)) {
            header('location:' . HTTP . 'public/views/departments/sales/sales.php' );
        }   else {
            header('location:' . HTTP . 'public/views/departments/sales/sales.php' );
        }

        break;
    case 'edit':

        $id = $_POST['appointmentNR'];
        if (edit($_POST["subject"], $_POST["appdate"], $_POST["description"],  $_POST["location"], $_POST['active'], $id , $db, $messageBag)) {
        	header('location:' . HTTP . 'public/views/departments/sales/appointmentPage.php?appNR=' . $id );
        } else {
        	header('location:' . HTTP . 'public/views/departments/sales/appointmentPage.php?appNR=' . $id);
        }

        break;
    case 'delete';
        $id = $_POST['appointmentNR'];
        if (remove($db,$id,$messageBag)) {
        	header('location:' . HTTP . 'public/views/departments/sales/sales.php');
        }
        break;
    case 'reset':

        $id = $_POST['appointmentNR'];
        if (appReset($db,$id,$messageBag)) {
            header('location:' . HTTP . 'public/views/departments/admin/admin.php');
        }
        break;
}

function remove($db, $id, $messageBag){

    $sql = 'DELETE FROM tbl_appointments WHERE appointmentNR = :id';
    $q = $db->prepare($sql);
    $q->bindParam(':id', $id);
    $q->execute();
    $messageBag->Add('s','The appointment is succesfully deleted');
    return true;
}


function edit($subject, $appdate, $description, $location, $active,  $id, $db, $messageBag) {
    $sql = 'SELECT * FROM tbl_appointments WHERE appointmentNR = :id';
    $q = $db->prepare($sql);
    $q->bindParam(':id', $id);
    $q->execute();

    if ($q->rowCount() > 0) {
    	$sql = 'UPDATE tbl_appointments
        SET  subject = :subject, appdate = :appdate, description = :description, location = :location, active = :active WHERE appointmentNR = :id';

        $q = $db->prepare($sql);
        $q->bindParam(':subject', $subject);
        $q->bindParam(':appdate', $appdate);
        $q->bindParam(':description', $description);
        $q->bindParam(':location', $location);
        $q->bindParam(':active', $active);
        $q->bindParam(':id', $id);
        $q->execute();


        $messageBag->Add('s','Appointment updated!!');
        return true;



    } else {

    	$messageBag->Add('a',"Appointment doesn't exicst and can't be edited!");
        return false;

    }
}

function add($customerNR, $appdate, $subject, $description, $location, $db, $messageBag  ) {


    if (empty($subject)) {

        $messageBag->Add('a',"Appointment name isn't filled in!");
        return false;
    } else {
        $sql = 'SELECT * FROM tbl_appointments where appointmentNR = :appointmentNR';
        $q = $db->prepare($sql);
        $q->bindParam(':appointmentNR', $appointmentNR);
        $q->execute();

        //counts the returned rows
        if ($q->rowCount() > 0) {
            $messageBag->Add('a','Appointment already exists!');
            return false;

        } else {

            $sql = 'INSERT INTO tbl_appointments (customerNR, appdate, subject, description, location, active)  VALUES ( :customerNR, :appdate, :subject, :description, :location, 1)';

            $q = $db->prepare($sql);

            $q->bindParam(':customerNR', $customerNR);
            $q->bindParam(':appdate', $appdate);
            $q->bindParam(':subject', $subject);
            $q->bindParam(':description', $description);
            $q->bindParam(':location', $location);
            $q->execute();

            $messageBag->Add('s','Appointment added');
            return true;
        }
    }
}

function appReset($db,$id,$messageBag){
    $sql = 'SELECT * FROM tbl_appointments where appointmentNR = :id';
    $q = $db->prepare($sql);
    $q->bindParam(':id', $id);
    $q->execute();




    if ($q->rowCount() > 0) {

        $sql = 'UPDATE tbl_appointments 
        SET active = 1
        WHERE appointmentNR = :id';

        $q = $db->prepare($sql);
        
        $q->bindParam(':id', $id);

        $q->execute();

       
        $messageBag->Add('s','Appointment activated!!');
        return true;

        

    } else {

        $messageBag->Add('a',"Appointment doesn't exicst and can't be edited!");
        return false;
        
    }
}