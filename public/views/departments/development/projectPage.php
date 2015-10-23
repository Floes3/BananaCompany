<?php


require_once '../../../header.php';

if ( !isset($_SESSION['user']) ) {
    header('location: ../../../views/auth/login.php');
    exit;
}

$projectNR = $_GET['projectnr'];
$sql = "SELECT * FROM projects INNER JOIN customer ON projects.customerNR = customer.customerNR WHERE projectNR = $projectNR;";

$q= $db->query($sql);
$results = $q->fetchAll();


?>

<header>
    <div class="col-md-12">
        <h1>barroc IT</h1>
    </div>
</header>
<div id='cssmenu'>
    <ul>
        <li class='active'><a href='<?php echo HTTP . 'public/views/departments/development/development.php' ?>'>Home</a></li>
        <li><a href='#'>Projects</a></li>
        <li><a href='#'>Clients</a></li>
        <li style='float:right!important;'><a href="../../../../app/controllers/authController.php?logout=true" name="type" >Logout</a></li>
       
        
    </ul>
</div>

    
<div class="container">
    <?php foreach ($results as $result): ?>
    <div class="col-md-10 dash-title">
        <h1><?php echo $result['projectName'] ?> | Development</h1>
    </div>

	<div class="col-md-12">
    <div class="tableOut">
                

                <table class='table table-hover'>
                    <thead>
                         <tr>
                            <th>Project name</th>
                            <th>Company</th>
                            <th>Description</th>
                            <th>Delete</th>
                        </tr>
                    </thead>

                    
                        <tbody>
                            <tr>
                                
                                <td><?php echo $result['projectName'] ?></td>
                                <td><?php echo $result['companyName'] ?></td>
                                <td><?php echo $result['description'] ?></td>
                                
                                <td>
	                                <form action="<?php echo HTTP . 'app/controllers/projectController.php' ?>" method="POST">
										<input type="hidden" name="type" value="delete">
										<input type="hidden" name='projectNR' value=<?php echo $result['projectNR'] ?>>
										<input class="btn btn-primary" type="submit" value='delete'>
	                                </form>
                                </td>
                                
                                
                            </tr>
                        </tbody>


                        



                 

                </table>
            </div>
			<form class="lineout" action="<?php echo HTTP . 'app/controllers/projectController.php' ?>" method='POST'>
						<input type="hidden" name="type" value="edit">
						<input type="hidden" name='projectNR' value=<?php echo $result['projectNR'] ?>>
						<div class=" col-md-3 form-group">
							<label for="projectName">Project name</label>
							<input class="form-control" type="text" name='projectName' value='<?php echo $result['projectName'] ?>'>
						</div>
						<div class=" col-md-3 form-group">
							<label for="desc">Description</label>
							<input class="form-control" type="text" name='description' value='<?php echo $result['description'] ?>'>
						</div>
						<div class=" col-md-3 form-group">
							<label for="projectName">active</label>
							<select class="form-control" name="active" >
                        		<option value="1" selected>Yes</option>
								<option value="0">No</option>
							</select>
							
						</div>
						<div class=" col-md-3 form-group ">
							<input class="btn btn-primary pull-right" type="submit" id="submit" value='Edit'>
						</div>
              </form>
                  <?php endforeach; ?>

			<?php
		        if($messageBag->hasMsg()){
		           echo $messageBag->show();
		        }
    		?>
        </div>