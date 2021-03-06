<?php
require_once '../init.php';

switch($_POST['type']){
    case 'add':
        if (add($_POST["projectName"], $_POST["customerNR"], $_POST["description"], $db, $messageBag)) {
            header('location:' . HTTP . 'public/views/departments/development/development.php' );
        }   else {
            header('location:' . HTTP . 'public/views/departments/development/development.php' );
        }
        
        break;
    case 'edit':

        $id = $_POST['projectNR'];
        if (edit($_POST["projectName"], $_POST["description"], $_POST["active"], $db, $id, $messageBag )) {
        	header('location:' . HTTP . 'public/views/departments/development/projectPage.php?projectnr=' . $id );
        } else {
        	header('location:' . HTTP . 'public/views/departments/development/projectPage.php?projectnr=' . $id);
        }
        
        break;
    case 'delete';
        $id = $_POST['projectNR'];
        if (remove($db,$id,$messageBag)) {
        	header('location:' . HTTP . 'public/views/departments/development/development.php');
        }
        break;
    case 'reset':
        $id = $_POST['projectNR'];
        if (prReset($db,$id,$messageBag)) {
            header('location:' . HTTP . 'public/views/departments/admin/admin.php');
        }
        break;
}

function remove($db, $id, $messageBag){

    $sql = 'DELETE FROM tbl_projects WHERE projectNR = :id';
    $q = $db->prepare($sql);
    $q->bindParam(':id', $id);
    $q->execute();
    $messageBag->Add('s','The project is succesfully deleted'); 
    return true;
}


function edit($projectName, $description, $active, $db, $id,$messageBag ) {
    $sql = 'SELECT * FROM tbl_projects where projectNR = :id';
    $q = $db->prepare($sql);
    $q->bindParam(':id', $id);
    $q->execute();




    if ($q->rowCount() > 0) {
    	$sql = 'UPDATE tbl_projects 
        SET projectName = :projectName, description = :description, active = :active WHERE projectNR = :id';

        $q = $db->prepare($sql);
        $q->bindParam(':projectName', $projectName);
        $q->bindParam(':description', $description);
        $q->bindParam(':active', $active);
        $q->bindParam(':id', $id);

        $q->execute();

       
        $messageBag->Add('s','Project updated!!');
        return true;

        

    } else {

    	$messageBag->Add('a',"Project doesn't exicst and can't be edited!");
        return false;
        
    }
}

function add($projectName, $customerNR, $description, $db,$messageBag ) {

    if (empty($projectName)) {

        $messageBag->Add('a',"Project name isn't filled in!");
        return false;
    } else {
        $sql = 'SELECT * FROM tbl_projects where projectName = :projectName';
        $q = $db->prepare($sql);
        $q->bindParam(':projectName', $projectName);
        $q->execute();

        //counts the returned rows
        if ($q->rowCount() > 0) {
            $messageBag->Add('a','Project already exists!');
            return false;

        } else {

            $sql = 'INSERT INTO tbl_projects (customerNR, projectName, description, active)  VALUES (:customerNR, :projectName, :description, 1)';

            $q = $db->prepare($sql);
            $q->bindParam(':customerNR', $customerNR);
            $q->bindParam(':projectName', $projectName);
            $q->bindParam(':description', $description);
            
            $q->execute();
            $messageBag->Add('s','Project added');
            return true; 
        }
    }
}

function prReset($db,$id,$messageBag){
    $sql = 'SELECT * FROM tbl_projects where projectNR = :id';
    $q = $db->prepare($sql);
    $q->bindParam(':id', $id);
    $q->execute();




    if ($q->rowCount() > 0) {

        $sql = 'UPDATE tbl_projects 
        SET active = 1
        WHERE projectNR = :id';
         
        $q = $db->prepare($sql);
        
        $q->bindParam(':id', $id);

        $q->execute();

       
        $messageBag->Add('s','project activated!!');
        return true;

        

    } else {

        $messageBag->Add('a',"project doesn't exicst and can't be activated!");
        return false;
        
    }
}