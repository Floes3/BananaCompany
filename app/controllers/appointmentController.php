<?php
require_once '../init.php';

switch($_POST['type']){
    case 'add':
        if (add($_POST["appointmentNR"], $_POST["customerNR"], $_POST["firstname"], $_POST["lastname"], $_POST["appdate"], $_POST["time"], $_POST["subject"], $_POST["location"], $_POST["attendingPeople"], $_POST["description"], $db, $messageBag)) {
            header('location:' . HTTP . 'public/views/departments/sales/sales.php' );
        }   else {
            header('location:' . HTTP . 'public/views/departments/sales/sales.php' );
        }

        break;
    case 'edit':

        $id = $_POST['appointmentNR'];
        if (edit($_POST["appointmentNR"], $_POST["customerNR"], $_POST["company"], $_POST["firstname"], $_POST["lastname"], $_POST["appdate"], $_POST["time"], $_POST["subject"], $_POST["location"], $_POST["attendingPeople"], $_POST["description"], $db, $messageBag)) {
        	header('location:' . HTTP . 'public/views/departments/sales/appointmentPage.php?appointmentnr=' . $id );
        } else {
        	header('location:' . HTTP . 'public/views/departments/sales/appointmentPage.php?appointmentnr=' . $id);
        }

        break;
    case 'delete';
        $id = $_POST['appointmentNR'];
        if (remove($db,$id,$messageBag)) {
        	header('location:' . HTTP . 'public/views/departments/sales/sales.php');
        }
        break;
}

function remove($db, $id, $messageBag){

    $sql = 'DELETE FROM appointments WHERE appointmentNR = :id';
    $q = $db->prepare($sql);
    $q->bindParam(':id', $id);
    $q->execute();
    $messageBag->Add('s','The appointment is succesfully deleted');
    return true;
}


function edit($appointmentNR, $customerNR, $company, $firstname, $lastname, $appdate, $time, $subject, $location, $attendingpeople, $description, $db, $id, $messageBag) {
    $sql = 'SELECT * FROM appointments WHERE appointmentNR = :id';
    $q = $db->prepare($sql);
    $q->bindParam(':id', $id);
    $q->execute();




    if ($q->rowCount() > 0) {
    	$sql = 'UPDATE appointments
        SET appointmentNR = :appointmentNR, customerNR = :customerNR, company = :company, firstname = :firstname, lastname = :lastname, appdate = :appdate, time = :time, subject = :subject, location = :location, attendingPeople = :attendingPeople, description = :description, WHERE appointmentNR = :id';

        $q = $db->prepare($sql);
        $q->bindParam(':appointmentNR', $appointmentNR);
        $q->bindParam(':customerNR', $customerNR);
        $q->bindParam(':company', $company);
        $q->bindParam(':firstname', $firstname);
        $q->bindParam(':lastname', $lastname);
        $q->bindParam(':appdate', $appdate);
        $q->bindParam(':time', $time);
        $q->bindParam(':subject', $subject);
        $q->bindParam(':location', $location);
        $q->bindParam(':attendingPeople', $attendingpeople);
        $q->bindParam(':description', $description);
        $q->bindParam(':id', $id);
        $q->execute();


        $messageBag->Add('s','Appointment updated!!');
        return true;



    } else {

    	$messageBag->Add('a',"Appointment doesn't exicst and can't be edited!");
        return false;

    }
}

function add($appointmentNR, $customerNR, $firstname, $lastname, $appdate, $time, $subject, $location, $attendingpeople, $description, $db, $messageBag  ) {


    if (empty($subject)) {

        $messageBag->Add('a',"Appointment name isn't filled in!");
        return false;
    } else {
        $sql = 'SELECT * FROM appointments where appointmentNR = :appointmentNR';
        $q = $db->prepare($sql);
        $q->bindParam(':appointmentNR', $appointmentNR);
        $q->execute();

        //counts the returned rows
        if ($q->rowCount() > 0) {
            $messageBag->Add('a','Appointment already exists!');
            return false;

        } else {

            $sql = 'INSERT INTO appointments (customerNR, firstname, lastname, appdate, time, subject, location, attendingPeople, description)  VALUES ( :customerNR, :firstname, :lastname, :appdate, :time, :subject, :location, :attendingPeople, :description)';

            $q = $db->prepare($sql);

            $q->bindParam(':customerNR', $customerNR);

            $q->bindParam(':firstname', $firstname);
            $q->bindParam(':lastname', $lastname);
            $q->bindParam(':appdate', $appdate);
            $q->bindParam(':time', $time);
            $q->bindParam(':subject', $subject);
            $q->bindParam(':location', $location);
            $q->bindParam(':attendingPeople', $attendingpeople);
            $q->bindParam(':description', $description);

            $q->execute();

            $messageBag->Add('s','Appointment added');
            return true;
        }
    }
}