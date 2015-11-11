<?php 
require_once '../header.php';


switch($_POST['type']){
    case 'client':
        if (searchClient($db, $messageBag)) {
            
        }   else {
            header('location:' . HTTP . 'public/index.php' );
        }
        break;

    case 'project':
        if (searchProject($db, $messageBag)) {
            
        }   else {
            header('location:' . HTTP . 'public/index.php' );
        }
        break;

      case 'invoice':
        if (searchInvoice($db, $messageBag)) {
            
        }   else {
            header('location:' . HTTP . 'public/index.php' );
        }
        break;
}



function searchClient($db , $messageBag){
    $term = '%'. $_POST['term'] . '%';

    $sql = 'SELECT * FROM tbl_customers where companyName like :term';
    $q = $db->prepare($sql);
    $q->bindParam(':term', $term );
    $q->execute();
    $searchResult = $q->fetch();
 
    if ($q->rowCount() == 1) {
      header('location:' . HTTP . 'public/views/clients/clientPage.php?clientnr=' . $searchResult['customerNR']);
      break;
    } else { 
      $messageBag->Add('a',"The Client you are searching for isn't found");
      return false;
    } 
}

function searchProject($db , $messageBag){
    $term = '%'. $_POST['term'] . '%';
    $sql = 'SELECT * FROM tbl_projects where projectName like :term';
    $q = $db->prepare($sql);
    $q->bindParam(':term', $term );
    $q->execute();
    $searchResult = $q->fetch();
    
    if ($q->rowCount() == 1) {
      header('location:' . HTTP . 'public/views/departments/development/projectPage.php?projectnr=' . $searchResult['projectNR']);
      break;
    } else { 
      $messageBag->Add('a',"The project you are searching for isn't found");
      return false;
    } 
}

function searchInvoice($db , $messageBag){
    $term = '%'. $_POST['term'] . '%';
    $sql = 'SELECT * FROM tbl_invoices where description like :term';
    $q = $db->prepare($sql);
    $q->bindParam(':term', $term );
    $q->execute();
    $searchResult = $q->fetch();
    
    if ($q->rowCount() == 1) {
      header('location:' . HTTP . 'public/views/invoices/invoicePage.php?innr=' . $searchResult['invoiceNR']);
      break;
    } else { 
      $messageBag->Add('a',"The invoice you are searching for isn't found");
      return false;
    } 
}