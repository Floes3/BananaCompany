<?php
    require_once '../../header.php';

    if ( !isset($_SESSION['user']) ) {
        header('location: ../../../views/auth/login.php');
        exit;
    }

    $clientNR = $_GET['clientnr'];
    $sql = "SELECT * FROM customer WHERE customerNR = $clientNR;";

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
            <li ><a href='<?php echo HTTP . 'public/views/departments/admin/admin.php' ?>'>Home</a></li>
            <li ><a href='<?php echo HTTP . 'public/views/departments/sales/sales.php' ?>'>Sales</a></li>
            <li ><a href='<?php echo HTTP . 'public/views/departments/finance/finance.php' ?>'>Finance</a></li>
            <li ><a href='<?php echo HTTP . 'public/views/departments/development/development.php' ?>'>Development</a></li>
            <li style='float:right!important;'><a href="../../../app/controllers/authController.php?logout=true" name="type" >Logout</a></li>
         <?php else: ?>
            <li ><a href='<?php echo HTTP . 'public/index.php' ?>'>Home</a></li>
            <li style='float:right!important;'><a href="../../../app/controllers/authController.php?logout=true" name="type" >Logout</a></li>   
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
            <h1>Client: <?php echo $result['companyName'] ?></h1>
        </div>

    	<div class="col-md-12">                    

            <table class='table table-hover'>
                <thead>
                     <tr>
                        <th>Client name</th>
                        <th>Adress</th>
                        <th>Zipcode</th>
                        <th>Place</th>
                        <th>Tel Number</th>
                        <th>Email</th>
                        <th>Contact Person</th>
                        <?php if ($_SESSION['user']['userrole'] == 4): ?>
                            <th>Delete</th>
                        <?php endif; ?>
                    </tr>
                </thead>

                
                <tbody>
                    <tr>
                        
                        <td><?php echo $result['companyName'] ?></td>
                        <td><?php echo $result['address'] ?></td>
                        <td><?php echo $result['zipCode'] ?></td>
                        <td><?php echo $result['place'] ?></td>
                        <td><?php echo $result['tel'] ?></td>
                        <td><?php echo $result['email'] ?></td>
                        <td><?php echo $result['contactPerson'] ?></td>                               
                        <?php if ($_SESSION['user']['userrole'] == 4): ?>
                            <td>
                                <form action="<?php echo HTTP . 'app/controllers/clientController.php' ?>" method='POST'>
                                    <input type="hidden" name="type" value="delete">
                                    <input type="hidden" name='clientNR' value=<?php echo $result['customerNR'] ?>>
                                    <input style='margin-top: 0'class="btn btn-primary" type="submit" id="submit" value='Delete'>
                                </form>
                            </td>
                        <?php endif; ?>   
                    </tr>
                </tbody>


                            



                     

            </table>
        </div>

        <div class="seperator"></div>
        <?php if (!($_SESSION['user']['userrole'] == 1)): ?>
        
    
		<form class="lineout" action="<?php echo HTTP . 'app/controllers/clientController.php' ?>" method='POST'>
			<input type="hidden" name="type" value="edit">
			<input type="hidden" name='clientNR' value=<?php echo $result['customerNR'] ?>>
			<div class=" col-md-3 form-group">
				<label for="clientName">Client name</label>
				<input class="form-control" type="text" name='clientName' value='<?php echo $result['companyName'] ?>'>
			</div>
			<div class=" col-md-3 form-group">
				<label for="address">Address</label>
				<input class="form-control" type="text" name='address' value='<?php echo $result['address'] ?>'>
			</div>
			<div class=" col-md-3 form-group">
				<label for="zipcode">Zipcode</label>
				<input class="form-control" type="text" name='zipcode' value='<?php echo $result['zipCode'] ?>'>
			</div>
            <div class=" col-md-3 form-group">
                <label for="place">Place</label>
                <input class="form-control" type="text" name='place' value='<?php echo $result['place'] ?>'> 
            </div>
             <div class=" col-md-3 form-group">
                <label for="tel">Tel Number</label>
                <input class="form-control" type="text" name='tel' value='<?php echo $result['tel'] ?>'> 
            </div>
             <div class=" col-md-3 form-group">
                <label for="email">email</label>
                <input class="form-control" type="text" name='email' value='<?php echo $result['email'] ?>'> 
            </div>
             <div class=" col-md-3 form-group">
                <label for="contP">Contact person</label>
                <input class="form-control" type="text" name='contP' value='<?php echo $result['contactPerson'] ?>'> 
            </div>
            <div class=" col-md-3 form-group">
                <label for="active">Active</label>
                <select class="form-control" name="active" >
                    <option value="1" selected>Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
			<div class=" col-md-12 form-group ">
				<input class="btn btn-primary pull-right" type="submit" id="submit" value='Edit'>
			</div>
        </form>
        <?php endif ?>
    <?php endforeach; ?>			
</div>

<?php require_once '../../footer.php'; ?>