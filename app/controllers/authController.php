<?php require_once '../init.php';

if (isset($_GET['logout'])) {
    logout($messageBag);
    header('Location: ' .HTTP . 'public/views/auth/Login.php');
}




switch($_POST['type']){

    case 'login':

        if (login($db,$_POST['username'],$_POST['password'],$messageBag)){
           header('location:' . HTTP . 'public/index.php');
        } else {
            
            header('Location: ' . HTTP . 'public/views/auth/login.php');
        }
        break;

    case 'register':
 
        if(register($db, $_POST['name'],$_POST['password'],$_POST['userrole'],$messageBag)){
            header('Location: ' .HTTP . 'public/index.php');
        } else {

            header('Location: ' .HTTP . 'public/index.php');
        }
        break;

    case 'delete':
            if (delete($_POST['userID'],$db,$messageBag)) {
                header('Location: ' .HTTP . 'public/index.php');
            }
        break;
}



function login($db, $username, $password,$messageBag){



    if(empty($username) || empty($password)){
        $messageBag->Add('a',"One or more fields aren't filled in!");
        return false;
    }

    $sql = "SELECT * FROM tbl_users WHERE name = :username";
    $q = $db->prepare($sql);
    $q->bindparam(':username', $username);
    $q->execute();


    if ($q->rowCount() > 0) {

        $user = $q->fetch();

        if(password_verify($password, $user['password'])){

            $_SESSION['user']['username'] = $user['username'];
            $_SESSION['user']['id'] = $user['id'];
            $_SESSION['user']['userrole'] = $user['userrole'];
            $messageBag->Add('s','U bent succesvol ingelogt!');
            return true;

        }

    }
    $messageBag->Add('a','wrong username or password');
    return false;
}

function logout($messageBag){
    unset($_SESSION['user']);
    $messageBag->Add('s','U bent succesvol uitgelogt!');
    return true;
}

function register($db,$username,$password, $userrole,$messageBag){
    if(empty($username) || empty($password)){
        $messageBag->Add('a',"One or more fields aren't filled in!");
        return false;
    } else {

        $sql = 'SELECT * FROM tbl_users where name = :username';
        $q = $db->prepare($sql);
        $q->bindParam(':username', $username);
        $q->execute();

        if ($q->rowCount() > 0) {
            $messageBag->Add('a', 'Username already exisct!');
            return false;

        } else {
            $hashed = password_hash($password,PASSWORD_DEFAULT);

            $sql = 'INSERT INTO tbl_users (name, password, userrole)  VALUES (:username,:hashed, :userrole)';

            $q = $db->prepare($sql);
            $q->bindParam(':username', $username);
            $q->bindParam(':hashed', $hashed);
            $q->bindParam(':userrole', $userrole);
            $q->execute();
            $messageBag->Add('a','User succesfully created!');
            return true;
        }
    }
}

function delete($id,$db,$messageBag){
    $sql = 'DELETE FROM tbl_users WHERE id = :id';
    $q = $db->prepare($sql);
    $q->bindParam(':id', $id);
    $q->execute();
    $messageBag->Add('s','The User is succesfully deleted'); 
    return true;
}




