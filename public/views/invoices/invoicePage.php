<?php
    require_once '../../header.php';

    if ( !isset($_SESSION['user']) ) {
        header('location: ../../../views/auth/login.php');
        exit;
    }
     if (!($_SESSION['user']['userrole'] == 1) && !($_SESSION['user']['userrole'] == 4) ) {
        header('location:' . HTTP . 'public/index.php');
    }

    $invoiceNR = $_GET['innr'];
    $sql = "SELECT invoices.description, invoices.invoiceNR, inDate, price, btw, companyName 
        FROM invoices 
        INNER JOIN projects ON projects.projectNR = invoices.projectNR 
        INNER JOIN customer ON customer.customerNR = projects.customerNR
        WHERE invoices.active = 1 and invoiceNR = $invoiceNR";

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
            <li><a href='<?php echo HTTP . 'public/views/departments/admin/admin.php' ?>'>Home</a></li>
            <li><a href='<?php echo HTTP . 'public/views/departments/sales/sales.php' ?>'>Sales</a></li>
            <li><a href='<?php echo HTTP . 'public/views/departments/finance/finance.php' ?>'>Finance</a></li>
            <li><a href='<?php echo HTTP . 'public/views/departments/development/development.php' ?>'>Development</a></li>
            <li style='float:right!important;'><a href="../../../app/controllers/authController.php?logout=true" name="type" >Logout</a></li>
         <?php else: ?>
            <li><a href='<?php echo HTTP . 'public/index.php' ?>'>Home</a></li>
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
            <h1>Invoice: <?php echo $result['companyName'] ?></h1>
        </div>

    	<div class="col-md-12">                    

            <table class='table table-hover'>
                <thead>
                     <tr>
                        <th>Client name</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Price</th>
                        <th>Price incl 21% btw</th>
                        <?php if ($_SESSION['user']['userrole'] == 4): ?>
                            <th>Delete</th>
                        <?php endif; ?>
                    </tr>
                </thead>

                
                <tbody>
                    <tr>
                        
                        <td><?php echo $result['companyName'] ?></td>
                        <td><?php echo $result['description'] ?></td>
                        <td><?php echo $result['inDate'] ?></td>
                        <td><?php echo $result['price'] ?></td>
                        <td><?php echo ($result['price'] * $result['btw']) ?></td>
                       
                                                      
                        <?php if ($_SESSION['user']['userrole'] == 4): ?>
                            <td>
                                <form action="<?php echo HTTP . 'app/controllers/invoiceController.php' ?>" method='POST'>
                                    <input type="hidden" name="type" value="delete">
                                    <input type="hidden" name='inNR' value=<?php echo $result['invoiceNR'] ?>>
                                    <input style='margin-top: 0'class="btn btn-primary" type="submit" id="submit" value='Delete'>
                                </form>
                            </td>
                        <?php endif; ?>   
                    </tr>
                </tbody>


                            



                     

            </table>
        </div>

        <div class="seperator"></div>
		<form class="lineout" action="<?php echo HTTP . 'app/controllers/invoiceController.php' ?>" method='POST'>
			<input type="hidden" name="type" value="edit">
			<input type="hidden" name='inNR' value=<?php echo $result['invoiceNR'] ?>>
			
			<div class=" col-md-3 form-group">
				<label for="description">Description</label>
				<input class="form-control" type="text" name='description' value='<?php echo $result['description'] ?>'>
			</div>
			<div class=" col-md-3 form-group">
				<label for="inDate">Date</label>
				<input class="form-control" type="text" name='inDate' value='<?php echo $result['inDate'] ?>'>
			</div>
            <div class=" col-md-3 form-group">
                <label for="price">Price</label>
                <input class="form-control" type="text" name='price' value='<?php echo $result['price'] ?>'> 
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
    <?php endforeach; ?>			
</div>

