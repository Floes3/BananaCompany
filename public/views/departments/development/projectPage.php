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
          <?php if ($_SESSION['user']['userrole'] == 4): ?>
        <h1>Barroc IT | Admin</h1>
    <?php endif ?>
    <?php if ($_SESSION['user']['userrole'] == 1): ?>
        <h1>Barroc IT | Finance</h1>
    <?php endif ?>
    <?php if ($_SESSION['user']['userrole'] == 2): ?>
        <h1>Barroc IT | Development</h1>
    <?php endif ?>
    <?php if ($_SESSION['user']['userrole'] == 3): ?>
        <h1>Barroc IT | Sales</h1>
    <?php endif ?>
    </div>
</header>
<div id='cssmenu'>
    <ul>
        <?php if ($_SESSION['user']['userrole'] == 4): ?>
            <li class='active'><a href='<?php echo HTTP . 'public/views/departments/admin/admin.php' ?>'>Home</a></li>
            <li class='active'><a href='<?php echo HTTP . 'public/views/departments/sales/sales.php' ?>'>Sales</a></li>
            <li class='active'><a href='<?php echo HTTP . 'public/views/departments/finance/finance.php' ?>'>Finance</a></li>
            <li class='active'><a href='<?php echo HTTP . 'public/views/departments/development/development.php' ?>'>Development</a></li>
            <li style='float:right!important;'><a href="../../../../app/controllers/authController.php?logout=true" name="type" >Logout</a></li>
         <?php else: ?>
            <li class='active'><a href='<?php echo HTTP . 'public/index.php' ?>'>Home</a></li>
            <li style='float:right!important;'><a href="../../../../app/controllers/authController.php?logout=true" name="type" >Logout</a></li>   
        <?php endif ?>
    </ul>
</div>
<?php
    if($messageBag->hasMsg()){
        echo $messageBag->show();
    }
?>
    
<div class="container">
    <?php foreach ($results as $result): ?>
        <div class="col-md-10 dash-title">
            <h1>Project: <?php echo $result['projectName'] ?></h1>
        </div>

    	<div class="col-md-12">
       
            <table class='table table-hover'>
                <thead>
                     <tr>
                        <th>Project name</th>
                        <th>Company</th>
                        <th>Description</th>
                        <?php if ($_SESSION['user']['userrole'] == 4): ?>
                            <th>Delete</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                        
                <tbody>
                    <tr>
                        <td><?php echo $result['projectName'] ?></td>
                        <td><?php echo $result['companyName'] ?></td>
                        <td><?php echo $result['description'] ?></td> 
                        <?php if ($_SESSION['user']['userrole'] == 4): ?>
                            <td>
                                <form action="<?php echo HTTP . 'app/controllers/projectController.php' ?>" method='POST'>
                                    <input type="hidden" name="type" value="delete">
                                    <input type="hidden" name='projectNR' value=<?php echo $result['projectNR'] ?>>
                                    <input style='margin-top: 0'class="btn btn-primary" type="submit" id="submit" value='Delete'>
                                </form>
                            </td>
                        <?php endif; ?>                         
                    </tr>
                </tbody>


            </table>
        </div>

        <div class="seperator"></div>

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
</div>