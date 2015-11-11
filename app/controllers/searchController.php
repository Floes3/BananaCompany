<?php 
require_once '../init.php';
  
switch($_POST['type']){
    case 'client':
        if (searchClient($_POST['term'], $db, $messageBag)) {
            header('location:' . HTTP . 'public/views/searchResults.php' );
        }   else {
            header('location:' . HTTP . 'public/index.php' );
        }
        break;

}


function searchClient($terms, $db , $messageBag){
    $term = '%'. $terms . '%';
    $sql = 'SELECT * FROM tbl_customers where companyName like :term';
    $q = $db->prepare($sql);
    $q->bindParam(':term', $term );
    $q->execute();
    
    if ($q->rowCount() > 0) {
      return true; 
    } else {
      echo 'No..'; die();
    }
}




  if (!$con)
    { 
    die ("Could not connect: " . mysql_error());
    } 
    $sql = mysql_query("SELECT * FROM Liam WHERE Description LIKE '%term%'") or die
        (mysql_error());

       while ($row = mysql_fetch_array($sql)){
    echo 'Primary key: ' .$row['PRIMARYKEY'];
    echo '<br /> Code: ' .$row['Code'];
    echo '<br /> Description: '.$row['Description'];
    echo '<br /> Category: '.$row['Category'];
    echo '<br /> Cut Size: '.$row['CutSize']; 
  }

  mysql_close($con)
   ?>
     </body>